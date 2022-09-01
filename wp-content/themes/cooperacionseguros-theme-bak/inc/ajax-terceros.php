<?php
// Incluir Wordpress para acceder a sus funciones y variables
require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php';
require_once get_template_directory() . '/functions.php';
require_once get_template_directory() . '/api/api.php';

if (!isset($_POST['consulta'])) {
  exit;
} else {

  // Tipo de consulta
  $consulta = htmlspecialchars($_POST['consulta']);

  if ($consulta == 'patente') {
    /**
     * Validar patente
     */
    if (isset($_POST['patente']) && !empty($_POST['patente'])) {
      $fecha = date('Y-m-d', strtotime($_POST['fecha']));
      $data = coopseg_terceros_patentes($tokenTerceros, htmlspecialchars($_POST['patente']), $fecha);
      if ($data) {
        $result = json_decode($data);
        echo (isset($result->codigo)) ? $result->codigo : 'null';
      }
    } else {
      return false;
    }
  } else if ($consulta == 'verificar') {
    /**
     * Enviar datos para verificar
     */

    $data = array();
    parse_str($_POST['data'], $data);

    // Datos básicos
    echo '<h3>Datos del siniestro</h3>';
    echo '<dl>';

    echo '<dt>Fecha y hora</dt>';
    echo '<dd>' . date('d-m-Y', strtotime($data['fecha'])) . ' - ' . $data['hora'] . '</dd>';

    echo '<dt>Vehículo asegurado</dt>';
    echo '<dd>' . $data['patente-vehiculo-asegurado'] . '</dd>';

    echo '<dt>Dirección</dt>';
    echo '<dd>' . $data['dano-lugar-descripcion'] . '</dd>';

    echo '</dl>';

    // Datos del "otro", si existen
    if ($data['otro-apellido'] && $data['otro-nombre']) {
      echo '<h3>Datos del tercero que hace el reclamo</h3>';
      echo '<dl>';

      echo '<dt>Apellido y nombre</dt>';
      echo '<dd>' . $data['otro-apellido'] . ', ' . $data['otro-nombre'] . '</dd>';

      echo '<dt>Documento</dt>';
      echo '<dd>' . $data['otro-documento-numero'] . '</dd>';

      echo '<dt>Teléfono</dt>';
      echo '<dd>' . $data['otro-telefono'] . '</dd>';

      echo '<dt>E-mail</dt>';
      echo '<dd>' . $data['otro-email'] . '</dd>';

      echo '<dt>Vínculo con el reclamante</dt>';
      echo '<dd>' . $data['otro-vinculo'] . '</dd>';

      echo '</dl>';
    }

    // Datos del reclamante
    echo '<h3>Datos del reclamante</h3>';
    echo '<dl>';

    echo '<dt>Apellido y nombre</dt>';
    echo '<dd>' . $data['reclamante-apellido'] . ', ' . $data['reclamante-nombre'] . '</dd>';

    echo '<dt>Documento</dt>';
    echo '<dd>' . $data['reclamante-documento-numero'] . '</dd>';

    echo '<dt>Género</dt>';
    echo '<dd>' . $data['reclamante-genero'] . '</dd>';

    echo '<dt>Dirección</dt>';
    echo '<dd>' . $data['reclamante-calle'] . ', ' . $data['reclamante-numero'];
    if ($data['reclamante-piso']) echo ', Piso ' . $data['reclamante-piso'];
    if ($data['reclamante-puerta']) echo ', Puerta/Depto ' . $data['reclamante-puerta'];
    echo '</dd>';

    echo '<dt>Teléfono</dt>';
    echo '<dd>' . $data['reclamante-telefono'] . '</dd>';

    echo '<dt>E-mail</dt>';
    echo '<dd>' . $data['reclamante-email'] . '</dd>';

    echo '</dl>';

    // Reclamo de vehículos
    if (isset($data['tipoDeSiniestroVehiculos'])) {

      echo '<h3>Datos del reclamo de Vehículos</h3>';
      echo '<dl>';

      echo '<dt>Patente</dt>';
      echo '<dd>' . $data['patente-vehiculo-propio'] . '</dd>';

      echo '<dt>Apellido y nombre del damnificado</dt>';
      echo '<dd>' . $data['dano-apellido'] . ', ' . $data['dano-nombre'] . '</dd>';

      echo '<dt>Documento del damnificado</dt>';
      echo '<dd>' . $data['dano-documento-numero'] . '</dd>';

      if ($data['conductor-apellido'] && $data['conductor-nombre']) {

        echo '<dt>Apellido y nombre del conductor</dt>';
        echo '<dd>' . $data['conductor-apellido'] . ', ' . $data['conductor-nombre'] . '</dd>';

        echo '<dt>Documento del conductor</dt>';
        echo '<dd>' . $data['conductor-documento-numero'] . '</dd>';
      }

      if ($data['dano-vehiculo-aseguradora-nombre']) {
        echo '<dt>Aseguradora</dt>';
        echo '<dd>' . $data['dano-vehiculo-aseguradora-nombre'] . '</dd>';
      }

      if ($data['dano-vehiculo-aseguradora-poliza']) {
        echo '<dt>Póliza</dt>';
        echo '<dd>' . $data['dano-vehiculo-aseguradora-poliza'] . '</dd>';
      }

      if ($data['dano-franquicia-valor']) {
        echo '<dt>Franquicia</dt>';
        echo '<dd>' . $data['dano-franquicia-valor'] . '</dd>';
      }

      echo '<dt>Descripción</dt>';
      echo '<dd>' . $data['dano-vehiculos-descripcion'] . '</dd>';

      echo '</dl>';
    }

    // Reclamo de Lesiones
    if (isset($data['tipoDeSiniestroLesiones'])) {

      echo '<h3>Datos del reclamo de Lesiones</h3>';
      echo '<dl>';

      echo '<dt>Apellido y nombre del damnificado</dt>';
      echo '<dd>' . $data['dano-apellido'] . ', ' . $data['dano-nombre'] . '</dd>';

      echo '<dt>Documento del damnificado</dt>';
      echo '<dd>' . $data['dano-documento-numero'] . '</dd>';

      echo '<dt>Centro de salud que realizó la atención</dt>';
      echo '<dd>' . $data['dano-centro-nombre'] . '</dd>';

      if ($data['dano-art-nombre']) {
        echo '<dt>ART</dt>';
        echo '<dd>' . $data['dano-art-nombre'] . '</dd>';
      }

      echo '<dt>Descripción</dt>';
      echo '<dd>' . $data['dano-lesiones-descripcion'] . '</dd>';

      echo '</dl>';
    }

    // Reclamo de Daños Materiales
    if (isset($data['tipoDeSiniestroMateriales'])) {

      echo '<h3>Datos del reclamo de Daños Materiales</h3>';
      echo '<dl>';

      echo '<dt>Apellido y nombre del damnificado</dt>';
      echo '<dd>' . $data['dano-apellido'] . ', ' . $data['dano-nombre'] . '</dd>';

      echo '<dt>Documento del damnificado</dt>';
      echo '<dd>' . $data['dano-documento-numero'] . '</dd>';

      echo '<dt>Dirección</dt>';
      echo '<dd>' . $data['dano-calle'] . ', ' . $data['dano-numero'] . '</dd>';

      if ($data['dano-seguro-aseguradora']) {
        echo '<dt>Aseguradora</dt>';
        echo '<dd>' . $data['dano-seguro-aseguradora'] . '</dd>';
      }

      echo '<dt>Descripción</dt>';
      echo '<dd>' . $data['dano-materiales-descripcion'] . '</dd>';

      echo '</dl>';
    }
  } else if ($consulta == 'estado') {
    /**
     * Consultar estado de un reclamo
     */
    if (isset($_POST['reclamo'])) {
      $data = coopseg_terceros_consultar($tokenTerceros, htmlspecialchars($_POST['documento']), htmlspecialchars($_POST['reclamo']));
      if ($data) {
        $result = json_decode($data);
        if (isset($result->estadoReclamoTercero)) {
          $filtered = array(
            'Estado del reclamo' => $result->estadoReclamoTercero,
            'Tipo de reclamo' => $result->tipoSiniestro,
            'Reclamante' => $result->reclamante,
            'Fecha de ocurrencia' => date('d/m/Y', strtotime($result->fechaHoraSiniestro)),
            'Descripción del reclamo' => $result->descripcionReclamoTercero,
          );
          header('Content-Type: application/json');
          echo json_encode($filtered);
        } else {
          echo 'null';
        }
      } else {
        echo 'null';
      }
    } else {
      return false;
    }
  }
}
