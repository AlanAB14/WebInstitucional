<?php
require_once get_template_directory() . '/api/api.php';

// Funcion para comprimir imagenes
function compress_image($source_url, $destination_url, $quality) {
  $info = getimagesize($source_url);
   
  if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
  elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
  elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
  elseif ($info['mime'] == 'image/jpg') $image = imagecreatefromjpeg($source_url);
   
  //Guarda
  imagejpeg($image, $destination_url, $quality);
       
  //retorna URL
  return $destination_url;    
}



// Array de datos generales
$success = false;
$params =  array();
$descripciones = array();

if (!empty($_POST) && isset($_POST['reclamante-nombre']) && isset($_POST['reclamante-apellido']) && isset($_POST['reclamante-documento-numero'])) {

  // Datos del siniestro
  $params['FechaHoraSiniestro'] = date('m-d-Y', strtotime($_POST['fecha'])) . ' ' . $_POST['hora'];
  $params['IdTipoDamnificado'] = $_POST['damnificado-tipo'];
  $params['EsReclamoFranquicia'] = ($_POST['franquicia'] == "1") ? 'true' : 'false';
  $params['IdTipoPersonaReclamante'] = $_POST['tipo-persona'];

  // Reclamante
  $params['ApellidoReclamante'] = $_POST['reclamante-apellido'];
  $params['NombreReclamante'] = $_POST['reclamante-nombre'];
  $params['IdTipoDocumentoReclamante'] = $_POST['reclamante-documento-tipo'];
  $params['NroDocumentoReclamante'] = $_POST['reclamante-documento-numero'];
  $params['GeneroReclamante'] = $_POST['reclamante-genero'];
  $params['IdEstadoCivilReclamante'] = $_POST['reclamante-estado-civil'];
  $params['ActividadReclamante'] = $_POST['reclamante-ocupacion'];
  $params['CalleReclamante'] = $_POST['reclamante-calle'];
  $params['NroCalleReclamante'] = $_POST['reclamante-numero'];
  $params['IdLocalidadReclamante'] = $_POST['reclamante-localidad'];
  $params['TelefonoReclamante'] = $_POST['reclamante-telefono'];
  $params['EmailReclamante'] = $_POST['reclamante-email'];

  // "Otro"
  $params['ApellidoOtro'] = isset($_POST['otro-apellido']) ? $_POST['otro-apellido'] : '';
  $params['NombreOtro'] = isset($_POST['otro-nombre']) ? $_POST['otro-nombre'] : '';
  $params['IdTipoDocumentoOtro'] = isset($_POST['otro-documento-tipo']) ? $_POST['otro-documento-tipo'] : '';
  $params['NroDocumentoOtro'] = isset($_POST['otro-documento-numero']) ? $_POST['otro-documento-numero'] : '';
  $params['TelefonoOtro'] = isset($_POST['otro-telefono']) ? $_POST['otro-telefono'] : '';
  $params['EmailOtro'] = isset($_POST['otro-email']) ? $_POST['otro-email'] : '';
  $params['VinculoOtro'] = isset($_POST['otro-vinculo']) ? $_POST['otro-vinculo'] : '';

  // Lugar
  $params['IdLugarSiniestro'] = $_POST['dano-lugar'];
  $params['IdLocalidadSiniestro'] = $_POST['dano-lugar-localidad'];
  $params['DescripcionLugarSiniestro'] = $_POST['dano-lugar-descripcion'];

  // Patente
  $params['PatenteAsegurado'] = $_POST['patente-vehiculo-asegurado'];

  // Contar tipos de siniestro
  $tiposDeSiniestro = 0;

  /**
   * Si hay reclamo de vehículos
   */

  if (isset($_POST['tipoDeSiniestroVehiculos'])) {

    $params['IdTipoSiniestro'] = 1;
    $tiposDeSiniestro++;

    // Incluir item como un array
    $params['Vehiculos'][] = array(
      'ApellidoDamnificado' => $_POST['dano-apellido'],
      'NombreDamnificado' =>  $_POST['dano-nombre'],
      'IdTipoDocumentoDamnificado' =>  $_POST['dano-documento-tipo'],
      'NroDocumentoDamnificado' =>  $_POST['dano-documento-numero'],
      'GeneroDamnificado' => $_POST['dano-genero'],
      'IdTipoVehiculo' => $_POST['dano-vehiculo-tipo'],
      'Patente' =>  $_POST['patente-vehiculo-propio'],
      'Anio' =>  $_POST['dano-vehiculo-ano'],
      'Codval' => (isset($_POST['dano-vehiculo-version'])) ? $_POST['dano-vehiculo-version'] : '',
      'VehiculoEstacionado' => ($_POST['dano-vehiculo-estacionado'] == "si") ? 'true' : 'false',
      'ApellidoConductor' => ($_POST['conductor-apellido']) ? $_POST['conductor-apellido'] : '',
      'NombreConductor' => ($_POST['conductor-nombre']) ? $_POST['conductor-nombre'] : '',
      'IdTipoDocumentoConductor' => ($_POST['conductor-documento-tipo']) ? $_POST['conductor-documento-tipo'] : '',
      'NroDocumentoConductor' => ($_POST['conductor-documento-numero']) ? $_POST['conductor-documento-numero'] : '',
      'CompaniaAseguradora' => (isset($_POST['dano-vehiculo-aseguradora-nombre'])) ? $_POST['dano-vehiculo-aseguradora-nombre'] : '',
      'PolizaTercero' => (isset($_POST['dano-vehiculo-aseguradora-poliza'])) ? $_POST['dano-vehiculo-aseguradora-poliza'] : '',
      'PolizaTercero' =>  '', // TODO
      'Franquicia' => (isset($_POST['dano-franquicia-valor'])) ? $_POST['dano-franquicia-valor'] : '',
      'DescripcionSiniestro' =>  $_POST['dano-vehiculos-descripcion']
    );

    // Agregar a array de descripciones
    $descripciones[] = $_POST['dano-vehiculos-descripcion'];
  }

  /**
   * Si hay reclamo de Lesiones
   */
  if (isset($_POST['tipoDeSiniestroLesiones'])) {

    $params['IdTipoSiniestro'] = 2;
    $tiposDeSiniestro++;

    // Incluir item como un array
    $params['Lesiones'][] = array(
      'ApellidoDamnificado' => $_POST['dano-apellido'],
      'NombreDamnificado' =>  $_POST['dano-nombre'],
      'IdTipoDocumentoDamnificado' =>  $_POST['dano-documento-tipo'],
      'NroDocumentoDamnificado' =>  $_POST['dano-documento-numero'],
      'GeneroDamnificado' =>  $_POST['dano-genero'],
      'TipoLesion' =>  $_POST['dano-tipo-lesion'],
      'NombreCentroSalud' =>  $_POST['dano-centro-nombre'],
      'IdLocalidadCentroSalud' =>  $_POST['dano-centro-ubicacion'],
      'NombreART' => (isset($_POST['dano-art-nombre'])) ? $_POST['dano-art-nombre'] : '',
      'DescripcionSiniestro' => $_POST['dano-lesiones-descripcion']
    );

    // Agregar a array de descripciones
    $descripciones[] = $_POST['dano-lesiones-descripcion'];
  }

  /**
   * Si hay reclamo de Daños materiales
   */
  if (isset($_POST['tipoDeSiniestroMateriales'])) {

    $params['IdTipoSiniestro'] = 3;
    $tiposDeSiniestro++;

    // Incluir item como un array
    $params['DaniosMateriales'][] = array(
      'ApellidoDamnificado' => $_POST['dano-apellido'],
      'NombreDamnificado' => $_POST['dano-nombre'],
      'IdTipoDocumentoDamnificado' => $_POST['dano-documento-tipo'],
      'NroDocumentoDamnificado' => $_POST['dano-documento-numero'],
      'GeneroDamnificado' => $_POST['dano-genero'],
      'CalleDanioMaterial' => $_POST['dano-calle'],
      'NroDanioMaterial' => $_POST['dano-numero'],
      'IdLocalidadDanioMaterial' => $_POST['dano-localidad'],
      'NombreAseguradora' => (isset($_POST['dano-seguro-aseguradora'])) ? $_POST['dano-seguro-aseguradora'] : '',
      'DescripcionSiniestro' => $_POST['dano-materiales-descripcion']
    );

    // Agregar a array de descripciones
    $descripciones[] = $_POST['dano-materiales-descripcion'];
  }

  // Si hay más de 1 tipo de siniestro...
  if ($tiposDeSiniestro > 1) {
    $params['IdTipoSiniestro'] = 4;
  }

  //print_r($params);

  /**
   * Enviar datos
   */

  //print_r($params);
  $result = coopseg_terceros_agregar($tokenTerceros, $params);
  //print_r($result);

  if ($result && ($result != '"Error no controlado."')) {

    $code = preg_replace('/[^0-9]/', '', $result);

    // Enviar archivos
    $upload_dir = get_template_directory() . '/' . COOPSEG_QUOTE_IMAGES_DIR;

    $files = array();
    $files['NroReclamoTercero'] = $code;
    $files['FechaHora'] = date('m-d-Y H:m');
    $files['Archivos'] = array();

    foreach ($_FILES as $k => $v) {

      $file_name = $code . '-' . $v['name'];
      $new_path = $upload_dir . '/' . $file_name;

      $allowTypes = array('jpg','png','jpeg','gif');

      if (in_array(pathinfo($v['name'], PATHINFO_EXTENSION), $allowTypes)) {
        $compressed = compress_image($v['tmp_name'], $v['tmp_name'], 50);
        if ($compressed) {
          echo 'Se comprimió';
        }
      }

      if (move_uploaded_file($v['tmp_name'], $new_path)) {
        $base64 = base64_encode(file_get_contents($new_path));
        $file  = array(
          'ContenidoArchivo' => $base64,
          'NombreArchivo' => $code . '-' . $k,
          'ExtensionArchivo' => pathinfo($v['name'], PATHINFO_EXTENSION)
        );
        $files['Archivos'][] = $file;
      }
    echo '<pre>'; print_r($files); echo '</pre>';

    }


    $inspeccion = coopseg_terceros_inspeccion($tokenTerceros, $files);
    //print_r($inspeccion);

    if ($inspeccion = '""') {
      $success = true;
    } else {
      ErrorLog::new_error('reclamos-agregar-inspeccion', $inspeccion, $files);
    }
  } else {
    ErrorLog::new_error('reclamos-agregar', $result, $params);
  }
} else {
  ErrorLog::new_error('reclamos-agregar', 'Invalid POST', $_POST);
}

// Respuesta según el resultado
if ($success) {
  echo '<div class="confirmacion wrap">';
  echo '<header class="header">';
  echo '<h1>Tu reclamo fue ingresado</h1>';
  echo '<p class="aviso">Número de reclamo: <strong>' . $code . '</strong></p>
  <p>Tu reclamo fue ingresado correctamente. En breve recibirás por e-mail tu número de reclamo para que puedas hacer seguimiento online de su estado. Si te queda alguna duda podés <a href="/contacto/">contactarnos</a> o consultar <a href="/ayuda/">nuestra sección de ayuda</a>.</p>
  <p class="action"><a href="/" class="btn">Volver al inicio</a></p>';
  echo '</header>';
  echo '</div>';

  // Agregar a Tripolis
  $data = array(
    'database' => 'reclamoterceros',
    'contactGroup' => 'terceros',
    'contactFields' => array(
      'guid' => $code,
      'email' => $params['EmailReclamante'],
      'nombreyapellido' => $_POST['reclamante-nombre'] . ' ' . $_POST['reclamante-apellido'],
      'numerodereclamo' => $code,
      'detalle' => substr('Patente: ' . $params['PatenteAsegurado'] . ' - ' . $descripciones[0], 0, 255)
    )
  );
  //print_r($data);
  $tripolis = tripolis_add($data);
} else {
  echo '<div class="wrap">';
  echo '<header class="header">';
  echo '<h1>Hubo un problema</h1>';
  echo '<p>Se produjo un problema al enviar tu reclamo. Por favor comunicate con nuestro equipo de Atención al Cliente: <a href="mailto:' .  get_theme_mod('custom_option_email') . '">' .  get_theme_mod('custom_option_email') . '</a> –  Teléfono: <strong>' .  get_theme_mod('custom_option_phone') . '</strong>, de lunes a viernes en el horario de 7 a 20hs.</p>';
  echo '</header>';
  echo '</div>';
}
