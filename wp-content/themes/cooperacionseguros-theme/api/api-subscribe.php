<?php
/**
 * Funciones de acceso a web services de suscribir Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Suscribir
 * $token: token de autentificación (va fijo para este caso)
 * Variables referirse al documento WS_CMP_ValidarPropuesta.pdf v 1.0
 */
function coopseg_subscribe( $token, $id_rama, $cod_productor, $inicio_vigencia, $cantidad_meses, $suma_asegurada, $premio, $premioReferencia, $prima, $persona, $vehiculo, $accidentePasajeros, $guid )
{
  $params = [
    'idRama' => $id_rama,
    'codigoProductor' => $cod_productor,
    'InicioVigencia' => $inicio_vigencia,
    'CantidadMeses' => $cantidad_meses,
    'SumaAsegurada' => $suma_asegurada,
    'premio' => $premio,
    'premioReferencia' => $premioReferencia,
    'prima' => $prima,
    'idLead' => $guid,
    'persona' => $persona,
    'vehiculo' => $vehiculo,
    'accidentePasajeros' => $accidentePasajeros
  ];

  //print_r($params);
  $result = json_encode(coopseg_curl($token, COOPSEG_SUSCRIBIR_URL, 'POST', $params));
  return str_replace('"', '', $result);
}

/**
 * Validar propuesta
 * $token: token de autentificación (va fijo para este caso)
 * $idPropuesta: dato obtenido de coopseg_subscribe
 */
function coopseg_validate_proposal($token, $idPropuesta)
{
  $params = [
    'idPropuesta' => $idPropuesta
  ];

  $result = coopseg_curl($token, COOPSEG_VALIDAR_URL.'?idPropuesta='.$idPropuesta, 'POST', $params);
  return $result;
}
