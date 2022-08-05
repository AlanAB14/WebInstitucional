<?php
/**
 * Funciones de acceso a web services de pagos Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Crear preferencia de pago
 * $token: token de autentificación (va fijo para este caso)
 * $params: Clase con los datos del pago
 */
function coopseg_create_payment_preference($token, $params)
{
  $result = coopseg_curl($token, COOPSEG_CREAR_PREFERENCIA_PAGO, 'POST', $params);
  return $result;
}
