<?php
require_once('api-curl.php');
require_once('api-token.php');
require_once('api-vehicles.php');
require_once('api-places.php');
require_once('api-life.php');
require_once('api-producers.php');
require_once('api-customer.php');
require_once('api-subscribe.php');
require_once('api-payment.php');
require_once('api-inspeccion.php');
require_once('api-lead.php');
require_once('api-agro.php');
require_once('api-terceros.php');
require_once('api-tripolis.php');
require_once('api-cedula.php');
require_once('api-quote.php');

/**
 * Simple helper to debug to the console
 *
 * @param $data object, array, string $data
 * @param $context string  Optional a description.
 *
 * @return string
 */
function debug_to_console($data, $context = 'Debug in Console') {

  // Buffering to solve problems frameworks, like header() in this and not a solid return.
  ob_start();

  $output  = 'console.info(\'' . $context . ':\');';
  $output .= 'console.log(' . json_encode($data) . ');';
  $output  = sprintf('<script>%s</script>', $output);

  echo $output;
}

/**
 * Obtenemos un token para usar con el resto de las funciones
 */
$token = encrypt_decrypt('decrypt', coopseg_get_local_token());
$tokenTerceros = encrypt_decrypt('decrypt', coopseg_get_local_token(1));

/** Forzar nuevo token */
if (isset($_GET['update']) && ($_GET['update'] == 'token')) {
  $token = coopseg_get_remote_token();
}

/**
 * Servicios de ubicaciones
 */

/** Actualizar ubicaciones en la base de datos */
if (isset($_GET['update']) && ($_GET['update'] == 'save_places')) {
  $data = coopseg_places_save_places($token);
  echo $data;
}

/** Obtener ubicaciones de la base de datos */
if (isset($_GET['get']) && ($_GET['get'] == 'places')) {
  $q = (isset($_GET['q'])) ? $_GET['q'] : '';
  $limit = (isset($_GET['limit'])) ? $_GET['limit'] : '';
  $allowed = (isset($_GET['allowed'])) ? $_GET['allowed'] : 0;
  $producers = (isset($_GET['producers'])) ? $_GET['producers'] : 0;
  $data = coopseg_places_get_places_db($q, $limit, $allowed, $producers);

  if ($data) {

    if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
      $q = filter_var($_GET['q'], FILTER_SANITIZE_STRING);

      // Quitar duplicados
      $nodupes = array_unique(array_column(json_decode($data), 'search'));

      // Filtrar por búsqueda
      $filtered = array();
      foreach ($nodupes as $k => $v) {
        if (strpos(strtolower($v), strtolower($q)) !== false) {
          $filtered[$k] = $v;
        }
      }

      // Rearmar array
      $result = array_intersect_key(json_decode($data), $filtered);

      $data = json_encode($result);
    }
    

    header('Content-Type: application/json');
    echo $data;
  }
  else{echo "no encontro resultados" . $data; }
}

/** Obtener ubicación de la base de datos */
if (isset($_GET['get']) && ($_GET['get'] == 'place')) {
  $id = (isset($_GET['id'])) ? $_GET['id'] : '';
  $data = coopseg_places_get_places_db_by_id($id);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/**
 * Servicios de vehículos
 */

/** Obtener marcas de vehículos via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'vehicle_brands')) {
  $category = (isset($_GET['category'])) ? $_GET['category'] : '';
  $data = coopseg_vehicles_get_brands_file($token, $category);

  if ($data) {

    // Remover duplicados si hay una búsqueda
    if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
      $q = filter_var($_GET['q'], FILTER_SANITIZE_STRING);

      // Quitar duplicados
      $nodupes = array_unique(array_column(json_decode($data), 'marca'));

      // Filtrar por búsqueda
      $filtered = array();
      foreach ($nodupes as $k => $v) {
        if (strpos(strtolower($v), strtolower($q)) !== false) {
          $filtered[$k] = $v;
        }
      }

      // Rearmar array
      $result = array_intersect_key(json_decode($data), $filtered);

      $data = json_encode($result);
    }

    header('Content-Type: application/json');
    echo $data;
  }
}

/** Obtener modelos de vehículos via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'vehicle_models')) {
  $category = (isset($_GET['category'])) ? $_GET['category'] : '';
  $brand = (isset($_GET['brand'])) ? $_GET['brand'] : '';
  $data = coopseg_vehicles_get_models($token, $category, $brand);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/** Obtener años de modelos via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'vehicle_years')) {
  $model = (isset($_GET['model'])) ? $_GET['model'] : '';
  $fillEmpty = (isset($_GET['fillEmpty'])) ? $_GET['fillEmpty'] : false;

  if ($model == 'agro') {
    $data = json_encode(range(date('Y'), (date('Y') - 20)));
  } else if (($model == 'undefined') || ($model == '')) {
    $data = json_encode(range(date('Y'), (date('Y') - 15)));
  } else {
    $data = coopseg_vehicles_get_years($token, $model);
  }

  if ($data) {
    header('Content-Type: application/json');
    if (($data == '[]') && $fillEmpty) {
      echo json_encode(range(date('Y'), (date('Y') - 60)));
    } else {
      echo $data;
    }
  }
}

/** Obtener versión de modelos via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'vehicle_versions')) {
  $model = (isset($_GET['model'])) ? $_GET['model'] : '';
  $year = (isset($_GET['year'])) ? $_GET['year'] : '';
  $data = coopseg_vehicles_get_versions($token, $model, $year);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/** Obtener versión de modelos por categoría, marca y año via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'vehicle_versions_catbrandyear')) {
  $category = (isset($_GET['category'])) ? $_GET['category'] : '2';
  $brand = (isset($_GET['brand'])) ? $_GET['brand'] : '';
  $year = (isset($_GET['year'])) ? $_GET['year'] : '';
  $data = coopseg_vehicles_get_versions_catbrandyear($token, $category, $brand, $year);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/** Obtener accesorios via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'vehicle_accesories')) {
  $query = (isset($_GET['query'])) ? $_GET['query'] : '';
  $accesory = (isset($_GET['accesory'])) ? $_GET['accesory'] : 'false';
  $data = coopseg_vehicles_get_accesories($token, $query, $accesory);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/**
 * Servicios de agro
 */

/** Obtener tipos de vehículos via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'agro_types')) {
  $data = coopseg_agro_get_types();

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/** Obtener marcas de vehículos de agro via webservice */
if (isset($_GET['get']) && ($_GET['get'] == 'agro_brands')) {

  $type = (isset($_GET['type'])) ? $_GET['type'] : '';
  $data = coopseg_agro_get_models($type);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/**
 * Servicios de productores
 */

/** Obtener ubicaciones de la base de datos */
if (isset($_GET['get']) && ($_GET['get'] == 'producers')) {
  $idcity = (isset($_GET['idcity'])) ? $_GET['idcity'] : '';
  $data = coopseg_producers_get_by_city($idcity);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/** Obtener productores sugeridos */
if (isset($_GET['get']) && ($_GET['get'] == 'suggest_producers')) {
  $dni = (isset($_GET['dni'])) ? $_GET['dni'] : '';
  $sexo = (isset($_GET['sexo'])) ? $_GET['sexo'] : '';
  $data = coopseg_producers_get_by_dni($token, $dni, $sexo);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/**
 * Obtener datos del socio con su número de DNI y sexo
 */
if (isset($_GET['get']) && ($_GET['get'] == 'customer')) {
  $num_dni = (isset($_GET['num_dni'])) ? $_GET['num_dni'] : '';
  $sexo = (isset($_GET['sexo'])) ? $_GET['sexo'] : '';
  $data = coopseg_customers_get_by_dni_and_sexo($token, $num_dni, $sexo);

  if ($data) {
    header('Content-Type: application/json');
    echo $data;
  }
}

/**
 * Iniciar cotización
 */
if (isset($_GET['get']) && $_GET['get'] == 'quote') {
  $url;

  try {
    $product = get_product_from_slug(trim($_REQUEST['currentProduct']) ?? '');
    if (!$product) throw new Error();

    $url = get_permalink(get_page_by_path($product->slug)->ID);

    if (!empty($product->questions)) {
      $guid = init_quote($_POST['currentProduct'], $_POST);
      $url .= $guid;
    }
  } catch (\Throwable $e) {
    $page = get_permalink(get_page_by_path('no-disponible')->ID);
  }

  header('Content-Type: application/json');

  echo json_encode([
    "url" => $url,
  ]);

  exit;
}


/**
 * Obtener datos de cédula verde
 */
if (isset($_GET['get']) && $_GET['get'] == 'cedula') {
  if (isset($_FILES['image']) && isset($_GET['guid'])) {
    $result = coopseg_send_cedula(get_token(), file_get_contents($_FILES['image']['tmp_name']), $_GET['guid']);

    header('Content-Type: application/json');
    echo json_encode($result);
  } else {
    http_response_code(500);
  }

  exit;
}
