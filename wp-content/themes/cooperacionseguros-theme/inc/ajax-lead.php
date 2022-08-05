<?php
// Incluir Wordpress para acceder a sus funciones y variables
require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php';
require_once get_template_directory() . '/functions.php';
require_once get_template_directory() . '/api/api.php';

// Verificar guid
if (!isset($_POST['guid'])) {

  exit;
} else {

  // Obtener GUID
  $guid = trim($_POST['guid']);

  // Conseguir quote
  $quote = quote_get($guid);

  // Verificar quote
  if (!$quote) {

    exit;
  } else {

    // Crear datos de lead
    $lead = array();

    // Producto
    if (isset($quote['product'])) {
      $currentProduct = get_product_from_slug($quote['product']);
      $lead['producto'] = $currentProduct->coopid;
      $lead['subProducto'] = $currentProduct->coopname;
    }

    // ID lead
    $lead['idLead'] = $quote['guid'];

    // Si hay datos de campañas, los sumamos
    $lead['utmSource'] = (isset($_COOKIE['utmSource'])) ? $_COOKIE['utmSource'] : '';
    $lead['utmMedium'] = (isset($_COOKIE['utmMedium'])) ? $_COOKIE['utmMedium'] : '';
    $lead['utmCampaign'] = (isset($_COOKIE['utmCampaign'])) ? $_COOKIE['utmCampaign'] : '';

    // Vehículos
    $leadVehiculo = array();

    // Si hay datos de Agro...
    if (isset($quote['answers']['agroBrand'])) {
      if (isset($quote['answers']['agroBrand'])) $leadVehiculo['idLead'] = $quote['guid'];
      if (isset($quote['answers']['agroBrand'])) $leadVehiculo['marca'] = $quote['answers']['agroBrand'];
      if (isset($quote['answers']['agroType'])) $leadVehiculo['modelo'] = $quote['answers']['agroType'] . ' ' . $quote['answers']['agroModel'];
      if (isset($quote['answers']['agroYear'])) $leadVehiculo['anio'] = $quote['answers']['agroYear'];
    }

    // Agregamos al lead el array de vehículos, si hay datos
    if (!empty($leadVehiculo)) {
      $lead['vehiculos'] = array($leadVehiculo);
    }

    // Datos de la persona
    $nombre = null;
    if (isset($quote['step_1']['customerNombre'])) {
      $nombre = $quote['step_1']['customerNombre'];
    } else if (isset($quote['datos-solicitante']['customerNombre'])) {
      $nombre = $quote['datos-solicitante']['customerNombre'];
    } else if (isset($quote['answers']['userName'])) {
      $nombre = $quote['answers']['userName'];
    }

    $email = null;
    if (isset($quote['step_1']['customerEmail'])) {
      $email = $quote['step_1']['customerEmail'];
    } else if (isset($quote['datos-solicitante']['customerEmail'])) {
      $email = $quote['datos-solicitante']['customerEmail'];
    } else if (isset($quote['answers']['userName'])) {
      $email = $quote['answers']['userEmail'];
    }

    $zip = null;
    if (isset($quote['step_1']['customerLocalidadZip'])) {
      $zip = $quote['step_1']['customerLocalidadZip'];
    } else if (isset($quote['datos-solicitante']['customerLocalidadZip'])) {
      $zip = $quote['datos-solicitante']['customerLocalidadZip'];
    } else if (isset($quote['answers']['userZip'])) {
      $zip = $quote['answers']['userZip'];
    }

    $dni = null;
    if (isset($quote['step_1']['num_dni'])) {
      $dni = $quote['step_1']['num_dni'];
    } else if (isset($quote['step_1']['num_cuit'])) {
      $dni = $quote['step_1']['num_cuit'];
    } else if (isset($quote['datos-solicitante']['num_dni'])) {
      $dni = $quote['datos-solicitante']['num_dni'];
    } else if (isset($_POST['dni'])) {
      $dni = $_POST['dni'];
    }

    $genero = null;
    if (isset($quote['step_1']['sexo'])) {
      $genero = $quote['step_1']['sexo'];
    } else if (isset($quote['datos-solicitante']['sexo'])) {
      $genero = $quote['datos-solicitante']['sexo'];
    } else if (isset($_POST['genero'])) {
      $genero = $_POST['genero'];
    }

    $localidad = null;
    if (isset($quote['step_1']['customerLocalidad'])) {
      $localidad = $quote['step_1']['customerLocalidad'];
    } else if (isset($quote['datos-solicitante']['customerLocalidad'])) {
      $localidad = $quote['datos-solicitante']['customerLocalidad'];
    } else if (isset($quote['answers']['userCity'])) {
      $localidad = $quote['answers']['userCity'];
    }

    $idlocalidad = null;
    if (isset($quote['step_1']['customerLocalidadActual'])) {
      $idlocalidad = $quote['step_1']['customerLocalidadActual'];
    } else if (isset($quote['datos-solicitante']['customerLocalidadActual'])) {
      $idlocalidad = $quote['datos-solicitante']['customerLocalidadActual'];
    } else if (isset($quote['answers']['userIdCity'])) {
      $idlocalidad = $quote['answers']['userIdCity'];
    }

    if ($nombre) $lead['nombre'] = $nombre;
    if ($email) $lead['email'] = $email;
    if ($dni) $lead['dni'] = $dni;
    if ($genero) $lead['genero'] = $genero;
    if ($localidad) $lead['localidad'] = $localidad;
    if ($idlocalidad) $lead['idLocalidad'] = $idlocalidad;
    if ($zip) $lead['codigoPostal'] = $zip;

    // Instancia
    if (isset($_POST['instancia'])) $lead['instanciaAlcanzada'] = $_POST['instancia'];

    // Grabar lead
    coopseg_lead_send($token, $lead);
  }
}
