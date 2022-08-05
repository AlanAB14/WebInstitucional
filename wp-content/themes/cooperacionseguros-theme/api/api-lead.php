<?php

/**
 * Funciones de acceso a web services de leads de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/cooperacion_local/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);


/**
 * Obtener info de un lead
 * $token: token de autentificación
 * $guid: el guid del lead
 */
function coopseg_lead_get($token, $guid)
{
  $params = array('IdLead' => $guid);
  $result = json_encode(coopseg_curl($token, COOPSEG_LEADS_GET_URL, 'GET', $params));
  return $result;
}

/**
 * Enviar lead
 * $token: token de autentificación
 * $params: array con parámetros, pueden ser diversos (revisar documentación)
 */
function coopseg_lead_send($token, $params = array())
{
  $result = json_encode(coopseg_curl($token, COOPSEG_LEADS_URL, 'POST', $params));
  return $result;
}

/**
 * Obtener lista de estados civiles (hardcodeada)
 */

function coopseg_lead_get_civil_states()
{
  $result = array();
  $result['1'] = 'Soltero';
  $result['2'] = 'Casado';
  $result['3'] = 'Divorciado';
  $result['4'] = 'Concubinato';
  $result['6'] = 'Viudo';
  $result['7'] = 'Separado';

  return $result;
}

/**
 * Obtener lista de ocupaciones (hardcodeada)
 */

function coopseg_lead_get_jobs()
{
  $result = array();

  $result['2342'] = 'Jubilado/Pensionado';
  $result['2343'] = 'Desocupado';
  $result['2344'] = 'Ama de casa';
  $result['2345'] = 'Estudiante';
  $result['2346'] = 'Empleado en relación de dependencia';
  $result['2347'] = 'Comerciante';
  $result['2348'] = 'Profesional autónomo';
  $result['2349'] = 'Socio/accionista';
  $result['2350'] = 'Servicio/oficio';
  $result['2351'] = 'Agropecuario';
  $result['2341']  = 'Otra';

  return $result;
}


/**
 * Obtener lista de nacionalidades (importada y luego hardcodeada)
 */

function coopseg_lead_get_nations()
{
  $result = array();

  // Obtener las definiciones de productos del JSON
  $nations = json_decode(file_get_contents(get_template_directory() . '/data/nations.json'));

  // Ordenar por país
  function ordenarpaises($a, $b)
  {
    if ($a->pais > $b->pais) {
      return 1;
    } else if ($a->pais < $b->pais) {
      return -1;
    } else {
      return 0;
    }
  }

  usort($nations, 'ordenarpaises');

  foreach ($nations as $n) {
    $result[$n->id] = ucfirst(strtolower($n->pais));
  }

  return $result;
}
