<?php
class Checkout {
  public $guid;
  public $quote;
  public $product;
  public $step;
  public $steps;

  public function __construct() {
    $this->guid = trim($_REQUEST['guid'] ?? get_query_var('guid'));
    $this->quote = Quote::get_quote($this->guid);
    $this->product = get_product_from_slug($this->quote['product'] ?? trim($_REQUEST['product'] ?? get_query_var('product')));
    if (!$this->product) $this->redirect_home();
    $this->steps = $this->product->steps;
    $this->step = $this->get_current_step();

    if (!$this->quote) {
      if (!empty($this->product->questions)) {
        header('Location: /' . $this->product->slug);
      } else {
        $this->quote = Quote::create_quote($this->product->slug);
        header('Location: /checkout/' . $this->product->slug . '/' . $this->steps[0]->slug . '/' . $this->quote['guid']);
      }
      exit;
    }

    if (isset($quote['idPropuesta']) && $this->step->slug == 'finalizado') {
      header('Location: /' . $this->product->slug . '/' . $this->quote['guid']);
      exit;
    }

    if ($this->quote['product'] != $this->product->slug) $this->redirect_error();

    if (isset($this->quote['answers']['planFechaFin'])) {
      if ((strtotime("now") > strtotime($this->quote['answers']['planFechaFin'])) && ($this->step->slug !== $this->steps[0]->slug)) {
        header('Location: /' . $this->product->slug . '/' . $this->guid);
        exit;
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' || $this->step->slug == 'pago') {
      $this->parse_post();
    }

    $lead = new Lead($this->quote, $this->step->id);
    $lead->send_lead();
  }

  public function parse_post() {
    global $token;
    $slug = $this->step->slug;

    switch($slug) {
      case 'inicio':
        $this->quote['answers'] = array_merge($this->quote['answers'], $_POST);
        break;

      case 'datos-vehiculo':
        $this->quote['datos-vehiculo'] = $_POST;
        break;

      case 'fotos-vehiculo':
        $this->quote['fotos-vehiculo'] = $_POST;
        $upload_dir = get_template_directory() . '/' . COOPSEG_QUOTE_IMAGES_DIR;
        $fotos = array();
        $i = 1;

        foreach ($this->quote['fotos-vehiculo'] as $key => $image) {
          if (strpos($key, 'foto') === 0) {
            $fotos[] = [
              'idFoto' => $i,
              'imagenData' => base64_encode(file_get_contents($upload_dir . '/' . $image)),
              'imagenNombre' => str_replace('.' . get_extension($image), '', $image),
              'imagenExtension' => get_extension($image)
            ];
          }

          $i++;
        }

        // Enviar inspección
        coopseg_send_inspeccion($token, $this->guid, 1, $fotos);

        break;

      case 'datos-solicitante':
        $this->quote['datos-solicitante'] = $_POST;
        break;

      case 'asesores':
        $this->quote['asesor'] = $_POST;
        break;

      case 'resumen':
        $this->quote['resumen'] = $_POST;

        $persona = [
          'codcli' => $this->quote['datos-solicitante']['codcli'] ?? '',
          'nombre' => $this->quote['datos-solicitante']['customerNombre'],
          'apellido' => $this->quote['datos-solicitante']['customerApellido'],
          'fechaNacimiento' => $this->quote['datos-solicitante']['customerFechaNacimiento']['month'] . '-' . $this->quote['datos-solicitante']['customerFechaNacimiento']['day'] . '-' . $this->quote['datos-solicitante']['customerFechaNacimiento']['year'],
          'nroDni' => $this->quote['datos-solicitante']['num_dni'],
          'idLocalidad' => $this->quote['datos-solicitante']['customerLocalidadActual'],
          'calle' => $this->quote['datos-solicitante']['customerCalle'],
          'nro' => $this->quote['datos-solicitante']['customerNumero'],
          'piso' => $this->quote['datos-solicitante']['customerPiso'],
          'departamento' => $this->quote['datos-solicitante']['customerPuerta'],
          'genero' => $this->quote['datos-solicitante']['sexo'],
          'idNacionalidad' => $this->quote['datos-solicitante']['customerNacionalidad'],
          'lugarNacimiento' => $this->quote['datos-solicitante']['customerLugarNacimiento'],
          'email' => $this->quote['datos-solicitante']['customerEmail'],
          'idActividad' => $this->quote['datos-solicitante']['customerOcupacion'],
          'idEstadoCivil' => $this->quote['datos-solicitante']['customerEstadoCivil'],
          'telefono' => $this->quote['datos-solicitante']['customerPhonePrefix'] . $this->quote['datos-solicitante']['customerPhoneNumber']
          /*
            'Localidad' => $this->quote['datos-solicitante']['customerLocalidad'],
            'idProvincia' => $this->quote['datos-solicitante']['customerProvinciaId'],
            'Provincia' => $this->quote['datos-solicitante']['customerProvincia'],

            'phone' =>  $this->quote['datos-solicitante']['customerPhonePrefix'] . $this->quote['datos-solicitante']['customerPhoneNumber'],
            */
        ];

        // Sumamos guión a las patentes de 6 caracteres antes de enviarlo, sólo para suscribir
        if (strlen($this->quote['datos-vehiculo']['numeroPatente']) == 6) {
          $numeroPatente = substr_replace($this->quote['datos-vehiculo']['numeroPatente'], '-', 3, 0);
        } else {
          $numeroPatente = $this->quote['datos-vehiculo']['numeroPatente'];
        }

        $vehiculo = [
          'Codval' => $this->quote['answers']['codVal'],
          'anio' => $this->quote['answers']['vehicleYear'],
          'Cobertura' => $this->quote['answers']['planCobertura'],
          'IdLocalidad' => $this->quote['answers']['userIdCity'],
          'Franquicia' => $this->quote['answers']['planFranquicia'],
          'NroChasis' => $this->quote['datos-vehiculo']['numeroChasis'],
          'NroMotor' => $this->quote['datos-vehiculo']['numeroMotor'],
          'Patente' => $numeroPatente,
          //'valorAccesorio' => $valorAccesorio
          'usaGNC' => (isset($this->quote['answers']['vehicleGncID']) && ($this->quote['answers']['vehicleGncID'] != 0)) ? 'true' : 'false',
          'codigoAccesorio' => (isset($this->quote['answers']['vehicleGncID']) && ($this->quote['answers']['vehicleGncID'] != 0)) ? $this->quote['answers']['vehicleGncID'] : null,
          'codigoConvenio' => $this->quote['answers']['codigoConvenio'],
          'bonusMaxConvenio' => $this->quote['answers']['bonusMaxConvenio'],
          'bonusMaxAntiguedad' => $this->quote['answers']['bonusMaxAntiguedad'],
          'bonusMaxSuma' => $this->quote['answers']['bonusMaxSuma']
        ];

        $accidentePasajeros = [
          'idProducto' => isset($this->quote['answers']['apIdProducto']) ? $this->quote['answers']['apIdProducto'] : '',
          'idPlantSuscWebCab' => isset($this->quote['answers']['apIdPlantSuscWebCab']) ? $this->quote['answers']['apIdPlantSuscWebCab'] : '',
          'premio' => isset($this->quote['answers']['apPremio']) ? $this->quote['answers']['apPremio'] : '0',
          'prima' => isset($this->quote['answers']['apPrima']) ? $this->quote['answers']['apPrima'] : '0'
        ];

        $rama = ($this->quote['product'] == 'seguro-de-autos-y-pick-ups') ? '3' : '27';

        $idPropuesta = intval(coopseg_subscribe($token, $rama, $this->quote['asesor']['cod_productor'], date('m-d-Y'), 4, $this->quote['answers']['planSuma'], $this->quote['answers']['planPremio'], $this->quote['answers']['planPremioReferencia'], $this->quote['answers']['planPrima'], $persona, $vehiculo, $accidentePasajeros, $this->guid));

        if ($idPropuesta >= 1) {

          // Validar propuesta
          $idPoliza = coopseg_validate_proposal($token, $idPropuesta);

          if ($idPoliza >= 1) {

            if (isset($this->quote['datos-solicitante']['codcli']) && $this->quote['datos-solicitante']['codcli'] != '') {
              $userId = $this->quote['datos-solicitante']['codcli'];
            } else {
              $userId = $this->quote['datos-solicitante']['num_dni'];
            }

            $payment = [
              'ApplicationId'           => COOPSEG_PAGOS_USUARIO,
              'UserId'                  => $userId,
              'UserEmail'               => $this->quote['datos-solicitante']['customerEmail'],
              'ExternalReference'       => $idPoliza,
              'ExpirationDateFrom'      => date('Y-m-d 00:00:00.000'),
              'ExpirationDateTo'        => date('Y-m-d 00:00:00.000', strtotime('+30 day')),
              'Expires'                 => true,
              'BackUrlSuccess'          => get_site_url() . "/checkout/". $this->product->slug . "/pago/$this->guid/?status=success",
              'BackUrlPending'          => get_site_url() . "/checkout/". $this->product->slug . "/pago/$this->guid/?status=pending",
              'BackUrlFailure'          => get_site_url() . "/checkout/". $this->product->slug . "/pago/$this->guid/?status=failure",
              'PaymentTitle'            => 'Póliza de seguro',
              'PaymentDescription'      => 'Referencia de pago: ' . $idPoliza,
              'PaymentAmount'           => floatval($this->quote['answers']['planPremioMensual'] + $this->quote['answers']['apPremioMensual']),
              'HabilitaRecurrencia'     => 'F'
            ];

            $data = coopseg_create_payment_preference($token, $payment);

            // Si volvió la preferencia de pago, redirigimos a pagar
            if ($data) {
              $lead = new Lead($this->quote, $this->steps[$this->step->id]->id);
              $lead->send_lead();

              header('Location: ' . str_replace('"', '', $data));
            } else {
              // Si no, a no-disponible
              header('Location: /no-disponible');
            }

            exit;
          } else {
            // No hay id de póliza, no se puede continuar
            $this->redirect_error();
          }
        } else {
          // No hay id de propuesta, no se puede continuar
            $this->redirect_error();
        }
        break;

      case 'pago':
        $this->quote['pago'] = $_POST;
        $this->quote['pago']['status'] = trim($_GET['status']);
        break;
    }

    quote_put($this->guid, $this->quote);
    $next_step = $this->steps[$this->step->id] ?? null;

    if(!empty($next_step)) {
      unset($_POST);
      header("Location: /checkout/". $this->product->slug ."/$next_step->slug/$this->guid");
    }
    exit;
  }

  private function redirect_home() {
    header('Location: /');
    exit;
  }

  private function redirect_error() {
    header('Location: /hubo-un-problema');
    exit;
  }

  public function get_current_step() {
    if (empty($this->steps)) $this->redirect_error();
    $step = array_filter($this->steps, function ($step) {
      return ($step->slug == get_query_var('step'));
    });

    if (!empty(get_query_var('step')) && empty($step)) $this->redirect_error();

    return array_shift($step) ?? $this->steps[0];
  }

  public function get_advisors() {
    global $token;

    return json_decode(coopseg_producers_get_by_dni($token, $this->quote['datos-solicitante']['num_dni'], $this->quote['datos-solicitante']['sexo'], $this->quote['datos-solicitante']['customerLocalidadId']), true);
  }

  public function get_template() {
    $slug = $this->step->slug;
    $args = [
      'quote' => $this->quote,
      'options' => (array) ($this->step->options ?? []),
    ];

    switch($slug) {
      case 'datos-vehiculo':
        get_template_part('template-parts/checkout/fragment-vehicle-details', null, $args);
        break;

      case 'fotos-vehiculo':
        get_template_part('template-parts/checkout/fragment-vehicle-photos', null, $args);
        break;

      case 'datos-solicitante':
        get_template_part('template-parts/checkout/fragment-consumer-details', null, $args);
        break;

      case 'asesores':
        $advisors = $this->get_advisors();
        shuffle($advisors);
        $args['advisors'] = $advisors;
        get_template_part('template-parts/checkout/fragment-advisors', null, $args);
        break;

      case 'resumen':
        get_template_part('template-parts/checkout/fragment-vehicle-summary', null, $args);
        break;

      case 'finalizado':
        if ($this->product->slug == 'seguro-de-motos' || $this->product->slug == 'seguro-de-autos-y-pick-ups') {
          get_template_part('template-parts/checkout/fragment-payment', null, $args);
        } else {
          get_template_part('template-parts/checkout/fragment-finalizado', null, $args);
        }

        track_script($this->guid, 'delete');
        break;
    }
  }
}
