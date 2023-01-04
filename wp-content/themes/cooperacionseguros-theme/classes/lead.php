<?php

class Lead {
  public $lead = [];

  public function __construct($quote, int $instance = 1, string $instance_name = 'Inicio') {
    $product = get_product_from_slug($quote['product']);

    $this->lead['producto'] = $product->coopid;
    $this->lead['subProducto'] = $product->coopname;

    $this->lead['idLead'] = $quote['guid'];
    $this->lead['instanciaAlcanzada'] = $instance;
    $this->lead['descripcionInstancia'] = $instance_name;

    $this->lead['utmSource'] = $quote['utmSource'];
    $this->lead['utmMedium'] = $quote['utmMedium'];
    $this->lead['utmCampaign'] = $quote['utmCampaign'];

    if (isset($quote['datos-solicitante'])) {
      if ($quote['datos-solicitante']['num_dni']) {
        $this->lead['codcli'] = $quote['datos-solicitante']['codcli'];
        $this->lead['nombre'] = $quote['datos-solicitante']['customerNombre'];
        $this->lead['apellido'] = $quote['datos-solicitante']['customerApellido'];
        $this->lead['dni'] = $quote['datos-solicitante']['num_dni'];
        $this->lead['genero'] = $quote['datos-solicitante']['sexo'];
        $this->lead['lugarNacimiento'] = $quote['datos-solicitante']['customerLugarNacimiento'];
        $this->lead['idNacionalidad'] = $quote['datos-solicitante']['customerNacionalidad'];
        $this->lead['idEstadoCivil'] = $quote['datos-solicitante']['customerEstadoCivil'];
        $this->lead['idActividad'] = $quote['datos-solicitante']['customerOcupacion'];
        $this->lead['fechaNacimiento'] = $quote['datos-solicitante']['customerFechaNacimiento']['month'] . '-' . $quote['datos-solicitante']['customerFechaNacimiento']['day'] . '-' . $quote['datos-solicitante']['customerFechaNacimiento']['year'];
      } else {
        $this->lead['nombre'] = $quote['datos-solicitante']['customerRazonSocial'];
        $this->lead['dni'] = $quote['datos-solicitante']['num_cuit'];
      }

      $this->lead['email'] = $quote['datos-solicitante']['customerEmail'];
      $this->lead['telefono'] = $quote['datos-solicitante']['customerPhonePrefix'] . $quote['datos-solicitante']['customerPhoneNumber'];

      $this->lead['calle'] = $quote['datos-solicitante']['customerCalle'];
      $this->lead['nro'] = $quote['datos-solicitante']['customerNumero'];
      $this->lead['piso'] = $quote['datos-solicitante']['customerPiso'];
      $this->lead['depto'] = $quote['datos-solicitante']['customerPuerta'];
      $this->lead['idLocalidad'] = $quote['datos-solicitante']['customerLocalidadActual'];
      $this->lead['Localidad'] =  $quote['datos-solicitante']['customerLocalidad'];
      $this->lead['idProvincia'] =  $quote['datos-solicitante']['customerProvinciaId'];
      $this->lead['Provincia'] =  $quote['datos-solicitante']['customerProvincia'];
      $this->lead['codigoPostal'] =  $quote['datos-solicitante']['customerLocalidadZip'];
    } else {
      $this->lead['nombre'] = $quote['answers']['userName'] ?? null;
      $this->lead['email'] = $quote['answers']['userEmail'] ?? null;
      $this->lead['codigoPostal'] = $quote['answers']['userZip'] ?? null;
      $this->lead['localidad'] = $quote['answers']['userCity'] ?? null;
      $this->lead['idLocalidad'] = $quote['answers']['userIdCity'] ?? null;
      $this->lead['fechaNacimiento'] = $quote['answers']['userBirthDate'] ?? null;
    }

    $this->lead['codint'] = $quote['asesor']['cod_productor'] ?? null;

    if ($quote['product'] == 'seguro-de-motos' || $quote['product'] == 'seguro-de-autos-y-pick-ups') {
      $leadVehiculo = [];
      $leadVehiculo['idLead'] = $quote['guid'];
      $leadVehiculo['idLeadVehiculo'] = '1';
      $leadVehiculo['codval'] = $quote['answers']['codVal'];
      $leadVehiculo['codia'] = $quote['answers']['codInfoAuto'];
      $leadVehiculo['idMarca'] = $quote['answers']['vehicleBrandId'] ?? '';
      $leadVehiculo['marca'] = $quote['answers']['vehicleBrand'];
      $leadVehiculo['idModelo'] = $quote['answers']['vehicleModelId'] ?? '';
      $leadVehiculo['IdAccesorioGNC'] = $quote['answers']['vehicleGncID'] ?? '';
      $leadVehiculo['modelo'] = $quote['answers']['vehicleModel'] ?? '';
      $leadVehiculo['version'] = $quote['answers']['vehicleVersion'] ?? '';
      $leadVehiculo['anio'] = $quote['answers']['vehicleYear'];
      $leadVehiculo['cobertura'] = $quote['answers']['planCobertura'] ?? '';
      $leadVehiculo['GuardaHabitual'] = $quote['answers']['userCity'];
      $leadVehiculo['IdLocalidadGuardaHabitual'] = $quote['answers']['userIdCity'];

      if ($quote['product'] == 'seguro-de-autos-y-pick-ups') {
        $leadVehiculo['ValorVehiculo'] = $quote['answers']['vehicleValue'] + $quote['answers']['vehicleGncValue'];
      } else {
        $leadVehiculo['ValorVehiculo'] = $quote['answers']['vehicleValue'];
      }

      if (isset($quote['datos-vehiculo'])) {
        $leadVehiculo['NroChasis'] = $quote['datos-vehiculo']['numeroChasis'];
        $leadVehiculo['NroMotor'] = $quote['datos-vehiculo']['numeroMotor'];
        $leadVehiculo['Patente'] = $quote['datos-vehiculo']['numeroPatente'];
        $leadVehiculo['DaniosPreExistentes'] = 0;
      }

      // Creamos array de vehículos sumando el vehículo
      $this->lead['vehiculos'] = [$leadVehiculo];
    } else if ($quote['product'] == 'seguro-de-maquinaria-e-implementos') {
      $leadVehiculo = [];

      $leadVehiculo['idLead'] = $quote['guid'];
      $leadVehiculo['marca'] = $quote['answers']['agroBrand'];
      $leadVehiculo['modelo'] = $quote['answers']['agroType'] . ' ' . $quote['answers']['agroModel'];
      $leadVehiculo['anio'] = $quote['answers']['agroYear'];

      $this->lead['vehiculos'] = [$leadVehiculo];
    }
  }

  public function send_lead() {
    $token = get_token();
    return coopseg_lead_send($token, $this->lead);
  }
}
