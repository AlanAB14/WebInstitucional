<?php

/**
 * Funciones de acceso a web services de productores Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/cooperacion_local/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Obtener lista de marcas
 * $token: token de autentificación (va fijo para este caso)
 * $idcity: Id de la localidad
 */
function coopseg_producers_get_by_city($idcity)
{

  // IP del usuario
  $userIp = get_user_ip();

  // Variables para mostrar datos
  $countErrors = 0;

  // Conectar a la base de datos usando los datos de wp-config.php
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Buscar registros según el IP del usuario
  $query = "SELECT * from " . COOPSEG_PRODUCERS_DB_LOGGER . " WHERE ip='" . $userIp . "' order by time DESC limit 10";
  if ($result = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
      $savedTime = strtotime($row['time']);
      $currentTime = time();
      if (($currentTime - $savedTime) < 86400) {
        $countErrors++;
      }
    }
  }

  // Mostrar resultados
  if ($countErrors >= 5) {
    $result = '{"error":"limit"}';
  } else {
    // Loguear acceso
    $query = "INSERT INTO " . COOPSEG_PRODUCERS_DB_LOGGER . "(ip) VALUES ('" . $userIp . "')";

    // Si se logueó el acceso...
    if (mysqli_query($conn, $query)) {
      $token = 'd3NXZWJDb3JwOldlYkNvcnAkMzE0MSU=';
      $params = array('idLocalidad' => $idcity);
      $result = json_encode(coopseg_curl($token, COOPSEG_PRODUCERS_URL, 'GET', $params, 'Basic'));
    }
  }
  return $result;
}

/**
 * Obtener lista de productores
 * $token: token de autentificación (va fijo para este caso)
 * $dni: Número de DNI
 * $sexo M/F
 */
function coopseg_producers_get_by_dni($token, $dni, $sexo, $IdLocalidad = '')
{
  $params = array('nroDni' => $dni, 'sexo' => $sexo, 'IdLocalidad' => $IdLocalidad);
  $result = json_encode(coopseg_curl($token, COOPSEG_SUGGEST_PRODUCERS_URL, 'GET', $params));
  return $result;
}

/**
 * Crear logger en la base de datos
 */

function coopseg_producers_setup_logger()
{
  // Conectar a la base de datos usando los datos de wp-config.php
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Si la conexión falla, imprimimos el error
  if ($conn->connect_errno > 0) {
    die('Connection failed [' . $conn->connect_error . ']');
  }

  // Confirmamos si la tabla existe
  $query = "SELECT ID FROM " . COOPSEG_PRODUCERS_DB_LOGGER;
  $checkdb = mysqli_query($conn, $query);

  // Si la tabla no existe, hay que crearla
  if (empty($checkdb)) {
    $query = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS " . COOPSEG_PRODUCERS_DB_LOGGER . " (
          id BIGINT NOT NULL AUTO_INCREMENT,
          PRIMARY KEY(id),
          ip TEXT NOT NULL,
          time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
      )");

    if ($query) {
      echo '<p>Se creó la tabla de logs para el mapa en la base de datos.</p>';
    } else {
      echo '<p>Error al crear la tabla de logs para el mapa con el query <code>' . $query . '</code><br />Error: ' . mysqli_error($conn) . '</p>';
    }
  }
}
