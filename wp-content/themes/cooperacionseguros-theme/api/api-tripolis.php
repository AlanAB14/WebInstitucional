<?php
// Constantes
// TODO mover a wp-config.php?
define('TRIPOLIS_CLIENT', 'cooperacion seguros');
define('TRIPOLIS_USER', 'diego.gonzalez@shakeagain.com');
define('TRIPOLIS_PASS', 'G6X5yugS!');

/**
 * Agregar contacto a Trípolis
 * $data: array de datos a pasar
 * $data['database']: Base de datos
 * $data['contactGroup']: Grupo de contactos
 * $data['contactFields']: Array con campos del contacto
 * Constantes definidas ya en track.php
 */

function tripolis_add($data)
{

  $body = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ser="http://services.tripolis.com/" xmlns:sub="http://subscription.services.tripolis.com/">';

  // Header
  $body .= '
  <soap:Header>
    <ser:authInfo>
      <client>' . TRIPOLIS_CLIENT . '</client>
      <username>' . TRIPOLIS_USER . '</username>
      <password>' . TRIPOLIS_PASS . '</password>
    </ser:authInfo>
    <ser:responseLanguage></ser:responseLanguage>
  </soap:Header>';

  // Body
  $body .= '
  <soap:Body>
    <sub:subscribeContact>
      <subscribeContactRequest>
          <contactDatabase>
            <name>' . $data['database'] . '</name>
          </contactDatabase>';

  // Contact Fields
  $body .= '<contactFields>';
  foreach ($data['contactFields'] as $k => $v) {
    $body .= '<contactField>';
    $body .= '<name>' . $k . '</name>';
    $body .= '<value>' . $v . '</value>';
    $body .= '</contactField>';
  };
  $body .= '</contactFields>';

  // Contact Group
  $body .= '<contactGroupSubscriptions>
  <contactGroupSubscription>
    <contactGroup>
      <name>' . $data['contactGroup'] . '</name>
    </contactGroup>
    <confirmed>1</confirmed>
  </contactGroupSubscription>
</contactGroupSubscriptions>';

  // Body
  $body .= '
             <ip>' . $_SERVER['REMOTE_ADDR'] . '</ip>
             <reference>contact created via SubscriptionService.subscribeContact call</reference>
          </subscribeContactRequest>
       </sub:subscribeContact>
    </soap:Body>
 </soap:Envelope>';

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://td45.tripolis.com/api2/soap/SubscriptionService/subscribeContact",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      "Accept-Encoding: gzip, deflate",
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Content-Type: text/html; charset=UTF-8",
      "Host: td45.tripolis.com",
      "cache-control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  echo $response;

  curl_close($curl);

  if ($response != '') {
    $doc = new DOMDocument();
    $doc->loadXML($response);
    //print_r($response);
    $subscriberId = $doc->getElementsByTagName('response')->item(0)->nodeValue;

    if ($subscriberId != '') {
      return $subscriberId;
    }
  }
  return false;
}
