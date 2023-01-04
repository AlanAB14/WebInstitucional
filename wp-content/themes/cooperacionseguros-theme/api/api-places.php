<?php

/**
 * Funciones de acceso a web services de lugares de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Obtener ubicaciones a través de archivo
 * $token: token de autentificación
 */
function coopseg_places_get_places_file($token)
{
  // Chequear si tenemos un archivo con las ubicaciones
  if (
    file_exists(COOPSEG_PLACES_ZIPCODES_FILE) && (time() - filemtime(COOPSEG_PLACES_ZIPCODES_FILE) < 24 * 3600)
  ) {
    $result = file_get_contents(COOPSEG_PLACES_ZIPCODES_FILE);
  } else {
    $result = json_encode(coopseg_curl($token, COOPSEG_PLACES_ZIPCODES_URL, 'GET'));
    file_put_contents(COOPSEG_PLACES_ZIPCODES_FILE, $result);
  }
  return $result;
}

/**
 * Guardar lugares en la base de datos
 * $places: lugares a guardar
 */
function coopseg_places_save_places($token)
{
  // Conectar a la base de datos usando los datos de wp-config.php
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Si la conexión falla, imprimimos el error
  if ($conn->connect_errno > 0) {
    die('Connection failed [' . $conn->connect_error . ']');
  }

  // Confirmamos si la tabla existe
  $query = "SELECT ID FROM " . COOPSEG_PLACES_DB_TABLE;
  $checkdb = mysqli_query($conn, $query);

  // Si la tabla no existe, hay que crearla
  if (empty($checkdb)) {
    $query = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS " . COOPSEG_PLACES_DB_TABLE . " (
        id INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(id),
        idcity INT NOT NULL,
        city VARCHAR(160) NOT NULL,
        altName VARCHAR(160) NOT NULL DEFAULT '',
        idstate INT NOT NULL,
        state VARCHAR(160) NOT NULL,
        zipcode INT NOT NULL,
        search VARCHAR(400) NOT NULL DEFAULT '',
        quote BOOL DEFAULT 0,
        emit BOOL DEFAULT 0,
        producers BOOL DEFAULT 0
    )");
  } else {
    // Si ya existe, hay que vaciarla
    $query = mysqli_query($conn, "TRUNCATE TABLE " . COOPSEG_PLACES_DB_TABLE . "");
  }

  // Obtenemos los datos via web service
  $result = coopseg_curl($token, COOPSEG_PLACES_ZIPCODES_URL, 'GET');

  // Definimos los inserts y los errores en 0
  $inserts = 0;
  $errors = 0;
  $updates = 0;

  // Hacemos un insert
  foreach ($result as $r) {

    // Convertimos cotiza y emite en bool
    $cotizaEnLocalidad = ($r->cotizaEnLocalidad) ? 1 : 0;
    $emiteEnLocalidad = ($r->emiteEnLocalidad) ? 1 : 0;

    // Crear el query
    $query = "INSERT INTO " . COOPSEG_PLACES_DB_TABLE . " (idcity,city,idstate,state,zipcode,search,quote,emit) VALUES (
      '" . $r->idLocalidad . "',
      '" . ucwords(mb_strtolower($r->localidad)) . "',
      '" . $r->idProvincia . "',
      '" . ucwords(mb_strtolower($r->provincia)) . "',
      '" . $r->codigoPostal . "',
      '" . ucwords(mb_strtolower($r->localidad)) . " " . ucwords(mb_strtolower($r->provincia)) . " " . $r->codigoPostal . "',
      '" . $cotizaEnLocalidad . "',
      '" . $emiteEnLocalidad . "'
    )";

    // Ejecutar el query y confirmar si funcionó
    if (mysqli_query($conn, $query)) {
      if (isset($_GET['debug'])) echo '<p>' . $r->localidad . ' se agregó a la base de datos.</p>';
      $inserts++;
    } else {
      if (isset($_GET['debug'])) echo '<p>Error en el query <code>' . $query . '</code><br />Error: ' . mysqli_error($conn) . '</p>';
      $errors++;
    }
  }

  // Localidades de productores, con web service específico
  $updates = 0;
  $resultProductores = coopseg_curl('d3NXZWJDb3JwOldlYkNvcnAkMzE0MSU=', 'https://wstest.cooperacionseguros.com.ar/cmpservicest/api/ObtenerLocalidadesDeProductoresWebCorp', 'GET', '', 'Basic');

  // Hacemos un update con los datos de lugares de producción
  foreach ($resultProductores as $r) {
    // Crear el query
    $query = "UPDATE " . COOPSEG_PLACES_DB_TABLE . " SET
    `altName` = '" . ucwords(mb_strtolower($r->localidad)) . "',
    `producers` = 1
    WHERE idcity = " . $r->idLocalidad . "";

    // Ejecutar el query y confirmar si funcionó
    if (mysqli_query($conn, $query)) {
      if (isset($_GET['debug'])) echo '<p>Se actualizó la información de productores en ' . $r->localidad . '.</p>';

      if (mysqli_affected_rows($conn)) {
        $updates++;
      } else {
        if (isset($_GET['debug'])) echo '<p>No se pudo hacer un update en  ' . $r->localidad . ' con el query <code>' . $query . '</code></p>';
        $errors++;
      }
    } else {
      if (isset($_GET['debug'])) echo '<p>Error en el query <code>' . $query . '</code><br />Error: ' . mysqli_error($conn) . '</p>';
      $errors++;
    }
  }


  // Cuántos errores hubo?
  echo '<h3>Actualización de ubicaciones</h3>';
  echo '<p>Se insertaron <strong>' . $inserts . '</strong> filas en total.</p>';
  echo '<p>Se produjeron <strong>' . $errors . '</strong> errores en total.</p>';
  echo '<p>Se agregaron <strong>' . $updates . '</strong> datos de producción.</p>';
  echo '<hr />';

  // Cerrar conexión
  mysqli_close($conn);
}

/**
 * Devuelve un listado de ubicaciones prefijadas para agregar a la respuesta de la API
 */
function fixed_places()
{
  // Empezamos con un resultado vacío
  $result = array();

  // Conectar a la base de datos usando los datos de wp-config.php
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // IDs de ciudades preseleccionadas
  $ids = array('1184', '885', '1237', '1120', '1003', '135', '534', '847', '1202', '105', '641', '839', '991', '328', '62', '967', '1031', '944', '349', '1154', '1083', '1087', '985', '411', '830', '688', '317', '481', '136', '57', '724', '1016', '539', '498', '1156', '3', '1247', '302', '81', '530');

  // Query
  $query = "SELECT * FROM " . COOPSEG_PLACES_DB_TABLE . " WHERE idcity IN (" . implode(",", $ids) . ") ORDER BY FIELD(idcity," . implode(",", $ids) . ")";

  // Ejecutar query
  if ($cities = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($cities)) {
      $result[] = $row;
    }
  } else {
    // Si está activado el WP_DEBUG, mostramos el error
    if (WP_DEBUG) {
      echo '<p>Error en el query <code>' . $query . '</code><br />Error: ' . mysqli_error($conn) . '</p>';
    }
  }

  // Devolvemos el resultado sin encodear, porque luego se une al array general
  return $result;
}

/**
 * Obtener ubicaciones desde la base de datos
 * $q: query para buscar por ciudad, provincia o persona
 * $limit: límite de resultados
 * $allowed: mostrar sólo resultados si emiten y cotizan (1) o mostrar todos (0)
 */
function coopseg_places_get_places_db($q = '', $limit = '', $allowed = 0, $producers = 0)
{
  // Empezamos con un resultado vacío
  $result = array();

  // Conectar a la base de datos usando los datos de wp-config.php
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Filtrar query si hay un parámetro, sino devolver todas las ubicaciones
  if ($q) {
    $q = mysqli_real_escape_string($conn, $q);
    $query = "SELECT * FROM " . COOPSEG_PLACES_DB_TABLE . " WHERE search LIKE '%" . $q . "%'";
  } else {
    $query = "SELECT * FROM " . COOPSEG_PLACES_DB_TABLE . "";
  }

  // Si mostramos sólo los que pueden emitir y cotizar
  if ($allowed) {
    $query .= ($q) ? " AND" : " WHERE";
    //$query .= " (quote = 1 AND emit = 1)";
    $query .= " quote = 1";
  }

  // Si mostramos sólo los que son de productores
  if ($producers) {
    $query .= ($q || $allowed) ? " AND" : " WHERE";
    $query .= " producers = 1";
  }

  // Orden de los resultados
  // $query .=  ($producers) ? " ORDER BY zipcode ASC" : " ORDER BY city ASC";
  if ($q) {
    $query .= "
      ORDER BY
        CASE
          WHEN city LIKE '". $q ."' THEN 1
          WHEN city LIKE '". $q ."%' THEN 2
          WHEN city LIKE '%". $q ."' THEN 4
          ELSE 3
        END,
      zipcode ASC
    ";
  } else {
    $query .= " ORDER BY zipcode ASC";
  }


  // Si hay límite, sumarlo al query
  if ($limit) {
    $query .= " LIMIT " . intval($limit);
  }

  // Ejecutar query
  if ($places = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($places)) {
      // Sumamos el item entero al resultado
      $result[] = $row;
    }
  } else {
    // Si está activado el WP_DEBUG, mostramos el error
    if (WP_DEBUG) {
      echo '<p>Error en el query <code>' . $query . '</code><br />Error: ' . mysqli_error($conn) . '</p>';
    }
  }

  // Buscamos ubicaciones destacadas
  $fixed_places = fixed_places();

  // Resultados + Ubicaciones destacadas
  if (!$q && $limit) {
    $merged_places = array_merge($fixed_places, $result);
    $all_places = array_slice($merged_places, 0, $limit);
  } else {
    $all_places = array_merge($fixed_places, $result);
  }

  // Convertimos a JSON y devolvemos el resultado
  return json_encode($all_places);
}

/**
 * Obtener ubicación de la base de datos por ID
 * $id: id de la ubicación
 */
function coopseg_places_get_places_db_by_id($id)
{
  // Empezamos con un resultado vacío
  $result = array();

  // Conectar a la base de datos usando los datos de wp-config.php
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query
  $query = "SELECT * FROM " . COOPSEG_PLACES_DB_TABLE . " WHERE idcity = $id";

  // Ejecutar query
  if ($city = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($city)) {
      $result = $row;
    }
  } else {
    // Si está activado el WP_DEBUG, mostramos el error
    if (WP_DEBUG) {
      echo '<p>Error en el query <code>' . $query . '</code><br />Error: ' . mysqli_error($conn) . '</p>';
    }
  }

  // Convertimos a JSON y devolvemos el resultado
  return json_encode($result);
}
