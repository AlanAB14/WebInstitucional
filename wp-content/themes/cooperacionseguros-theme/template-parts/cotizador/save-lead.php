<?php   
/** Este archivo graba paso a paso el Lead 
 * para eso busca quote con el  guid, guarda la info en quote,
 * y luego guarda el lead en la base de datos usando el mismo servicio
 */
 // Incluir Wordpress para acceder a sus funciones y variables
    require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php';
    require_once get_template_directory() . '/functions.php';
    require_once get_template_directory() . '/api/api.php';

    // Verificar guid
    if (!isset($_POST['guid'])) {

        exit;
    }else{
        $guid = trim($_POST['guid']);

        $token = encrypt_decrypt('decrypt', coopseg_get_local_token());
      

        $quote = quote_get($guid);

        $paso = $_POST['paso'];
        if($paso == '1'){

          $lead = array();
          $lead['idLead'] = $quote['guid'];
          if (isset($quote['product'])) {
            $currentProduct = get_product_from_slug($quote['product']);
            $lead['producto'] = $currentProduct->coopid;
            $lead['subProducto'] = $currentProduct->coopname;
          }
          $lead['utmSource'] = (isset($_COOKIE['utmSource'])) ? $_COOKIE['utmSource'] : '';
          $lead['utmMedium'] = (isset($_COOKIE['utmMedium'])) ? $_COOKIE['utmMedium'] : '';
          $lead['utmCampaign'] = (isset($_COOKIE['utmCampaign'])) ? $_COOKIE['utmCampaign'] : '';
  
          $leadVehiculo = array();
          if (!empty($leadVehiculo)) {
            $lead['vehiculos'] = array($leadVehiculo);
          }
  
          $lead['dni'] = trim($_POST['dni']);
          $lead['genero'] = trim($_POST['genero']);
  
          if (isset($_POST['instancia'])) $lead['instanciaAlcanzada'] = $_POST['instancia'];
          if (isset($_POST['descripcion'])) $lead['descripcionInstancia'] = $_POST['descripcion'];
          coopseg_lead_send($token, $lead);
        }
        elseif($paso=='2'){

          $datos_solicitante=[];
          $datos_solicitante['codcli']='0';
          $datos_solicitante['customerNombre']=trim($_POST['nombre']);
          $datos_solicitante['customerApellido']=trim($_POST['apellido']);
          $datos_solicitante['num_dni']=trim($_POST['dni']);
          $datos_solicitante['sexo']=trim($_POST['genero']);
          $datos_solicitante['customerLugarNacimiento']=trim($_POST['lugarNacimiento']);
          $datos_solicitante['customerNacionalidad']=trim($_POST['nacionalidadId']);
          $datos_solicitante['customerEstadoCivil']=trim($_POST['estadoCivil']);
          $datos_solicitante['customerOcupacion']= trim($_POST['ocupacion']);
          $datos_solicitante['customerFechaNacimiento']['month']=trim($_POST['mes']);
          $datos_solicitante['customerFechaNacimiento']['day']=trim($_POST['dia']);
          $datos_solicitante['customerFechaNacimiento']['year']=trim($_POST['anio']);
          $datos_solicitante['customerCalle']=trim($_POST['calle']);
          $datos_solicitante['customerNumero']=trim($_POST['numero']);
          $datos_solicitante['customerPiso']=trim($_POST['piso']);
          $datos_solicitante['customerPuerta']=trim($_POST['depto']);
          $datos_solicitante['customerLocalidadActual']='';
          $datos_solicitante['customerLocalidad']=trim($_POST['localidad']);
          $datos_solicitante['customerProvinciaId']='';
          $datos_solicitante['customerProvincia']='';
          $datos_solicitante['customerLocalidadZip']='';
          $datos_solicitante['customerPhonePrefix']='';
          $datos_solicitante['customerEmail']= trim($_POST['email']);
          $datos_solicitante['customerPhoneNumber']= trim($_POST['telefono']);
  
          $quote['datos-solicitante'] = $datos_solicitante;
          $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
          file_put_contents($file_path, json_encode($quote));
  
          echo '<script>console.log('.json_encode($quote).')</script>';
        }

  }
        
    

?>