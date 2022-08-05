<?php
/**
 * Funciones de acceso a web services de inspección Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/cooperacion_local/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Envia las fotos de inespección a Cooperación Seguros
 * $token: token de autentificación (va fijo para este caso)
 * $guid: Id de la cotización
 * $item: Relativo a la unidad
 * $fotos: Colección de fotos { idFoto, ImagenData, ImagenNombre, ImagenExtension }
 */
function coopseg_send_inspeccion( $token, $guid, $item, $fotos )
{
  $params = array( 'idLead' => $guid, 'item' => $item, 'fotos' => $fotos);
  $result = json_encode(coopseg_curl($token, COOPSEG_VEHICLES_CARGAR_INSPECCION_URL, 'POST', $params));
  return $result;
}