<?php

/**
 * Funciones de acceso a web services de Reclamos de Terceros de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Validar patente
 * $tokenterceros: token de autentificación (va fijo para este caso)
 * $patente: Patente a validar
 */
function coopseg_terceros_patentes($tokenterceros, $patente, $fecha)
{
  $params = array('patente' => $patente, 'fechaSiniestro' => $fecha);
  $result = json_encode(coopseg_curl($tokenterceros, COOPSEG_RECLAMOS_PATENTES, 'GET', $params));
  return $result;
}

/**
 * Consultar reclamo
 * tokenterceros: token de autentificación (va fijo para este caso)
 * $nroDocumento: DNI
 * $nroReclamo: Número de reclamo
 */
function coopseg_terceros_consultar($tokenterceros, $nroDocumento, $nroReclamo)
{
  $params = array('nroDocumento' => $nroDocumento, 'nroReclamo' => $nroReclamo);
  $result = json_encode(coopseg_curl($tokenterceros, COOPSEG_RECLAMOS_CONSULTA, 'GET', $params));
  return $result;
}

/**
 * Agregar reclamo
 * tokenterceros: token de autentificación (va fijo para este caso)
 * $params: Array de todos los parámetros posibles
 */
function coopseg_terceros_agregar($tokenterceros, $params)
{
  $result = json_encode(coopseg_curl($tokenterceros, COOPSEG_RECLAMOS_AGREGAR, 'POST', $params));
  return $result;
}

/**
 * Agregar archivos
 * tokenterceros: token de autentificación (va fijo para este caso)
 * $params: Array de todos los parámetros posibles
 */
function coopseg_terceros_inspeccion($tokenterceros, $params)
{
  $result = json_encode(coopseg_curl($tokenterceros, COOPSEG_RECLAMOS_INSPECCION, 'POST', $params));
  return $result;
}
