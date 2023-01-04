<?php

/**
 * Funciones de envío de Cédula
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

$upload_dir = get_template_directory() . COOPSEG_QUOTE_IMAGES_DIR;

/**
 * Envia una cédula al servicio de reconocimiennto de Cooperación Seguros
 * $token: token de autentificación (va fijo para este caso)
 * $image: Imagen a analizar
 */
function coopseg_send_cedula($token, $image, $guid) {
  global $upload_dir;
  $params = array('image' => base64_encode($image));
  $result = coopseg_curl($token, COOPSEG_VEHICLES_CEDULA_URL, 'POST', $params);

  if (!is_string($result)) {
    $file_name = $guid . '-foto-cedula-frente.' . get_extension($_FILES['image']['name']);
    $new_path = $upload_dir . '/' . $file_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $new_path)) {
      $result->image = $file_name;
    }
  }

  return $result;
}
