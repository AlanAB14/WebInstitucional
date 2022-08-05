<?php

/**
 * Funciones de acceso a web services de vida de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/cooperacion_local/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Obtener Cotización de un seguro de vida
 * $token: token de autentificación
 * $value: Suma asegurada, debería ser entre $100.000 y $2.000.000
 * $birthDate: Fecha de nacimiento, MM-DD-YYYY, el resultado debería ser entre 18 y 75 años
 */
function coopseg_life_get_quotes($token, $value, $birthDate)
{
  $params = array('suma' => $value, 'fecNacimiento' => $birthDate);
  $result = json_encode(coopseg_curl($token, COOPSEG_LIFE_QUOTES_URL, 'GET', $params));
  return $result;
}
