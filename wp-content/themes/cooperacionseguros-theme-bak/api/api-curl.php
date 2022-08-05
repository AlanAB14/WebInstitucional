<?php

/**
 * Función genérica para interactuar con los servicios de Cooperación, via cURL
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * cURL genérico
 */
function coopseg_curl($token, $url, $method = 'GET', $params = array(), $authorization = 'Bearer')
{

  // Si el método es GET, los parámetros van en el URL, sino en JSON
  if (!empty($params)) {
    if ($method == 'GET') {
      $addparams = http_build_query($params, '', '&');
      $url = $url . '?' . $addparams;
    } else {
      $addparams = json_encode($params);
    }
  } else {
    $addparams = '';
  }

  // Iniciar cURL
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "" . $url . "",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "" . $method . "",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      "Authorization: " . $authorization . " " . $token . "",
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Content-Type: application/json",
      //"Host: " . COOPSEG_CONFIG_HOST_URL . "",
      "User-Agent: " . COOPSEG_CONFIG_CLIENT_ID . "",
      "accept-encoding: gzip, deflate",
      "cache-control: no-cache"
    ),
  ));

  // Si el método es POST, se suman los parámetros por acá
  if ($method == 'POST') {
    curl_setopt($curl, CURLOPT_POST, count($params));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $addparams);
  }

  if (WP_DEBUG && isset($_GET['debug'])) {
    // if(array_key_exists('idLead',$params)) {
    // if(1 == 1) {
    echo "Params:\n";
    print_r($addparams);
    echo "\n\n";
    print_r(curl_getinfo($curl));
  }

  // Obtener respuesta
  $response = curl_exec($curl);
  $err = curl_errno($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // Obtener respuesta
    if (is_string($response) && is_array(json_decode($response, true))) {
      $response = json_decode($response);
    }

    // Devolvemos la respuesta
    return $response;
  }
}
