<?php

/**
 * Funciones de acceso a web services de vehículos de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Funcion auxiliar para ordenar alfabeticamente el resultado de coopseg_vehicles_get_brands()
 */
function cmp($a, $b)
{
  if ($a->marca == $b->marca) {
    return 0;
  }
  return ($a->marca < $b->marca) ? -1 : 1;
}

/**
 * Obtener lista de marcas
 * $token: token de autentificaciÃ³n
 * $category: 1 para autos (por defecto), 2 para motos.
 */
function coopseg_vehicles_get_brands($token, $category = 1)
{
  $params = array('categoria' => $category);
  $result = coopseg_curl($token, COOPSEG_VEHICLES_BRANDS_URL, 'GET', $params);

  
  // Ordenamos alfabeticamente la respuesta antes de devolverla
  usort($result, "cmp");

  // Buscamos marcas destacadas
  $fixed_brands = fixed_brands($category);

  /*
  // Revisamos si alguna marca destacada existe y la quitamos del array original antes de unir ambos arrays
  foreach ($result as $k => $v) {
    if (array_search($v->marca, array_column($fixed_brands, 'marca')) !== false) {
      unset($result[$k]);
    }
  };
  */

  // Unimos arrays de destacados y general
  $result = json_encode(array_merge($fixed_brands, $result));

  return $result;
}

/**
 * Da un listado de marcas prefijadas para agregar precio a las respuesta de la API
 * $category: 1 para autos (por defecto), 2 para motos
 */
function fixed_brands($category = 1)
{
  if ($category == 1) {
    // Autos
    return [
      (object) ['idMarca' => '0046', 'marca' => 'VOLKSWAGEN'],
      (object) ['idMarca' => '0018', 'marca' => 'FORD'],
      (object) ['idMarca' => '0012', 'marca' => 'CHEVROLET'],
      (object) ['idMarca' => '0036', 'marca' => 'RENAULT'],
      (object) ['idMarca' => '0017', 'marca' => 'FIAT'],
      (object) ['idMarca' => '0032', 'marca' => 'PEUGEOT'],
      (object) ['idMarca' => '0045', 'marca' => 'TOYOTA'],
      (object) ['idMarca' => '0011', 'marca' => 'CITROEN'],
      (object) ['idMarca' => '0019', 'marca' => 'HONDA'],
      (object) ['idMarca' => '0030', 'marca' => 'NISSAN']
    ];
  }
  if ($category == 2) {
    // Motos
    return [
      (object) ['idMarca' => '0019', 'marca' => 'HONDA'],
      (object) ['idMarca' => '0707', 'marca' => 'GUERRERO'],
      (object) ['idMarca' => '0162', 'marca' => 'YAMAHA'],
      (object) ['idMarca' => '1543', 'marca' => 'CORVEN MOTORS'],
      (object) ['idMarca' => '0163', 'marca' => 'ZANELLA'],
      (object) ['idMarca' => '0480', 'marca' => 'MOTOMEL'],
      (object) ['idMarca' => '0342', 'marca' => 'MONDIAL'],
      (object) ['idMarca' => '0156', 'marca' => 'GILERA'],
      (object) ['idMarca' => '0912', 'marca' => 'BAJAJ'],
      (object) ['idMarca' => '1550', 'marca' => 'KELLER'],
      (object) ['idMarca' => '0043', 'marca' => 'SUZUKI']
    ];
  }
}

/**
 * Obtener lista de marcas a través de archivo cacheado
 * $token: token de autentificación
 *  * $category: 1 para autos (por defecto), 2 para motos.

 */
function coopseg_vehicles_get_brands_file($token, $category = 1)
{

  // Definir si usamos el archivo de coches o motos
  $file = ($category == 2) ? COOPSEG_VEHICLES_BRANDS_FILE_BIKES : COOPSEG_VEHICLES_BRANDS_FILE_CARS;

  // Chequear si tenemos un archivo
  if (
    file_exists(dirname(__FILE__) . '/' . $file) && (time() - filemtime(dirname(__FILE__) . '/' . $file) < 24 * 3600)
  ) {
    $cachedResult = file_get_contents(dirname(__FILE__) . '/' . $file);
    $check = json_decode($cachedResult, true);
    if ($check == NULL) {
      $result = coopseg_vehicles_get_brands($token, $category);
      file_put_contents(dirname(__FILE__) . '/' . $file, $result);
    } else {
      $result = $cachedResult;
    }
  } else {
    $result = coopseg_vehicles_get_brands($token, $category);
    file_put_contents(dirname(__FILE__) . '/' . $file, $result);
  }
  return $result;
}

/**
 * Obtener modelos por marca
 * $token: token de autentificación
 * $category: 1 para autos (por defecto), 2 para motos.
 * $brand: id de marca
 */
function coopseg_vehicles_get_models($token, $category = '1', $brand)
{
  $params = array('categoria' => $category, 'idMarca' => $brand);
  $result = json_encode(coopseg_curl($token, COOPSEG_VEHICLES_MODELS_URL, 'GET', $params));
  return $result;
}

/**
 * Obtener años por modelo
 * $token: token de autentificación
 * $model: id del modelo
 */
function coopseg_vehicles_get_years($token, $model)
{
  $params = array('idModelo' => $model);
  $result = array_reverse(coopseg_curl($token, COOPSEG_VEHICLES_YEARS_URL, 'GET', $params));

  // Ocultando el año que viene de los resultados, porue parece que aparece antes de fin de año...
  if (!empty($result)) {
    $nextYear = date('Y') + 1;
    $pos = array_search($nextYear, $result);
    if ($pos !== false) unset($result[$pos]);
  }

  $result = json_encode($result);
  return $result;
}

/**
 * Obtener versiones por modelo y año
 * $token: token de autentificación
 * $model: id del modelo
 * $year: año del modelo
 */
function coopseg_vehicles_get_versions($token, $model, $year)
{
  $params = array('idModelo' => $model, 'anio' => $year);
  $result = json_encode(coopseg_curl($token, COOPSEG_VEHICLES_VERSIONS_URL, 'GET', $params));
  return $result;
}


/**
 * Obtener versiones por categoría, marca y año
 * $category: 1 para autos, 2 para motos (por defecto).
 * $token: token de autentificación
 * $brand: id de la marca
 * $year: año del modelo
 */
function coopseg_vehicles_get_versions_catbrandyear($token, $category = 2, $brand, $year)
{
  $params = array('Categoria' => $category, 'IdMarca' => $brand, 'Anio' => $year);
  $result = json_encode(coopseg_curl($token, COOPSEG_VEHICLES_VERSIONS_CATBRANDYEAR_URL, 'GET', $params));
  return $result;
}

/**
 * Obtener accesorios de vehículos (incluye un parámetro fijo, "VisibleWeb")
 * $token: token de autentificación
 * $query: búsqueda en el detalle del accesorio
 * $accesory: true/false
 */
function coopseg_vehicles_get_accesories($token, $query, $accesory = 'false')
{
  $params = array('detalle' => $query, 'esAccesorio' => $accesory, 'VisibleWeb' => 'true');
  $result = json_encode(coopseg_curl($token, COOPSEG_VEHICLES_ACCESORIES_URL, 'GET', $params));
  return $result;
}

/**
 * Obtener Cotización de un Vehículo
 * $token: token de autentificación
 * $year: año del vehículo
 * $codInfoAuto: código de Info Auto de la versión
 * $codval: código de valor de la versión
 * $zipcode: código postal de la ubicación
 * $gnc: valor decimal del equipo de GNC
 */
function coopseg_vehicles_get_quotes($token, $year, $codInfoAuto, $codval, $idCity, $gnc)
{
  $params = array('anio' => $year, 'codInfoAuto' => $codInfoAuto, 'codval' => $codval, 'idLocalidad' => $idCity, 'sumaGNC' => $gnc);

  /**
   * Parámetros que se envían con un valor fijo
   */
  $params['coduso'] = '1'; // Tipo de uso. Sólo usamos el caso de vehículo particular
  $params['codint'] = ''; // Código de productor para venta directa. Por defecto, vacío
  $params['fecTarifa'] = date('Y-m-d'); // Fecha de la cotización. Por defecto, ahora
  $params['cantidadMeses'] = '4'; // Duración en meses de la cotización. Por defecto, 4
  $params['condiva'] = '45'; // Condición de IVA. Por defecto, 45 (consiumidor final)
  $params['cotizaAP'] = 'true'; // Marca para cotizar Accidentes a Pasajeros. Enviar True
  $params['idAplicacion'] = 'webinstitucional'; // Aplicación que invoca al servicio.

  $quotes = coopseg_curl($token, COOPSEG_VEHICLES_QUOTES_URL, 'POST', $params);

  // Creamos un resultado personalizado
  $result = array();

  if (is_object($quotes)) {
    $result['planes'] = array();
    $result['ap'] = $quotes->cotizacionesAP;

    // Creamos planes con el nombre de plan como key
    foreach ($quotes->cotizacionesAutomotor as $q) {
      $result['planes'][$q->cobertura] = $q;
    }

    // Devolvemos el resultado en JSON
    $result = json_encode($result);
  }
  return $result;
}
