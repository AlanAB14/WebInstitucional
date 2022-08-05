<?php

/**
 * Funciones de acceso a web services de socios de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Obtener información del socio o de la persona en base a su número de DNI y sexo
 * $token: token de autentificación (va fijo para este caso)
 * $num_dni: Número de DNI
 * $sexo: Sexo de la persona (M/F)
 */
function coopseg_customers_get_by_dni_and_sexo($token, $num_dni = null, $sexo = null)
{
  if (!$num_dni || !$sexo) {
    return false;
  }
  $params = array('nroDni' => $num_dni, 'sexo' => $sexo);
  $result = json_encode(coopseg_curl($token, COOPSEG_CUSTOMER_URL, 'GET', $params));
  return $result;
}

/**
 * Decodear DNI para comunicación entre sitios
 * Ejemplo con DNI de Marcos: TWpjMU16ZzROVFE9
 */
function coopseg_decode_dni($dni)
{
  $result = base64_decode(base64_decode($dni));
  return $result;
}
