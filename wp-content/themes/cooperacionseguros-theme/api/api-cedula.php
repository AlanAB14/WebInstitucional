<?php

/**
 * Funciones de envío de
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Envia una cédula al servicio de reconocimiennto de Cooperación Seguros
 * $token: token de autentificación (va fijo para este caso)
 * $image: Imagen a analizar
 */
function coopseg_send_cedula($token, $image)
{
  $params = array('image' => $image);
  $result = json_encode(coopseg_curl($token, COOPSEG_VEHICLES_CEDULA_URL, 'POST', $params));
  return $result;
}
