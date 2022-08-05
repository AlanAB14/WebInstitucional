<?php

/**
 * Funciones de acceso al web service de tokens de Cooperación Seguros
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Función custom para encriptar/decriptar el token y poder guardarlo localmente
 */

function encrypt_decrypt($action, $string)
{
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $secret_key = COOPSEG_CONFIG_CLIENT_SECRET;
  $secret_iv = COOPSEG_CONFIG_CLIENT_ID;
  // hash
  $key = hash('sha256', $secret_key);

  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  if ($action == 'encrypt') {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
  } else if ($action == 'decrypt') {
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}

/**
 * Obtener un token desde el servidor remoto
 */
function coopseg_get_remote_token($terceros = false)
{

  $client_id = ($terceros) ? COOPSEG_CONFIG_TERCEROS_CLIENT_ID : COOPSEG_CONFIG_CLIENT_ID;
  $client_secret = ($terceros) ? COOPSEG_CONFIG_TERCEROS_CLIENT_SECRET : COOPSEG_CONFIG_CLIENT_SECRET;

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => COOPSEG_TOKEN_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "grant_type=" . COOPSEG_CONFIG_GRANT_TYPE . "&client_id=" . $client_id . "&client_secret=" . $client_secret,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/x-www-form-urlencoded"
    ),
  ));

  if (WP_DEBUG && isset($_GET['debug'])) {
    //if(1 == 1) {
    print_r(curl_getinfo($curl));
  }

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // Obtener respuesta
    $response = json_decode($response);

    // Encodear token
    $token = encrypt_decrypt('encrypt', $response->access_token);

    // Guardar token encodeado en un archivo
    $file = ($terceros) ? COOPSEG_TOKEN_TERCEROS_FILE : COOPSEG_TOKEN_FILE;
    file_put_contents(dirname(__FILE__) . '/' . $file, $token);

    // Devolvemos el token encodeado si se necesita usar luego de generar uno nuevo
    return $token;
  }
}

/**
 * Chequear si tenemos un token válido guardado
 */
function coopseg_get_local_token($terceros = false)
{
  $file = ($terceros) ? COOPSEG_TOKEN_TERCEROS_FILE : COOPSEG_TOKEN_FILE;
  // Chequear si tenemos un archivo de token
  if (file_exists(dirname(__FILE__) . '/' . $file)) {
    // Chequear si el archivo existe hace menos que las 24 horas que el token tiene validez
    if (time() - filemtime(dirname(__FILE__) . '/' . $file) > 24 * 3600) {
      // El archivo tiene más de 24 horas, buscamos un token nuevo
      $token = coopseg_get_remote_token($terceros);
    } else {
      // El archivo tiene menos de 24 horas, usamos su contenido
      $content = file_get_contents(dirname(__FILE__) . '/' . $file);
      if ($content) {
        // Si el contenido del archivo es válido, lo usamos de token
        $token = $content;
      } else {
        // Si el contenido no es válido, generamos un token nuevo
        $token = coopseg_get_remote_token($terceros);
      }
    }
  } else {
    // Si no tenemos un archivo de token, buscamos un token nuevo
    $token = coopseg_get_remote_token($terceros);
  }

  // Devolvemos el token encodeado, ya sea el que existía o el nuevo
  return $token;
}
