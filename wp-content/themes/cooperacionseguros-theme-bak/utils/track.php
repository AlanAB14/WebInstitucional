<?php

/** Espera recibir un parámetro guid
 * $guid
 */

require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php';
require_once get_template_directory() . '/functions.php';
require_once get_template_directory() . '/api/api.php';

function subscribe_to_tripolis($data)
{

    $contactDatabaseName = 'leads';

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://td45.tripolis.com/api2/soap/SubscriptionService/subscribeContact",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:ser=\"http://services.tripolis.com/\" xmlns:sub=\"http://subscription.services.tripolis.com/\">\n   <soap:Header>\n      <ser:authInfo>\n         <client>".TRIPOLIS_CLIENT."</client>\n         <username>".TRIPOLIS_USER."</username>\n         <password>".TRIPOLIS_PASS."</password>\n      </ser:authInfo>\n      <ser:responseLanguage></ser:responseLanguage>\n   </soap:Header>\n   <soap:Body>\n      <sub:subscribeContact>         \n         <subscribeContactRequest>\n            <contactDatabase>\n               <name>".$contactDatabaseName."</name>\n            </contactDatabase>\n            <contactFields>\n               <contactField>\n                  <id>hm7fwfEXad1k1GNn_s4YVg</id>\n                  <name>email</name>\n                  <value>".$data['email']."</value>\n               </contactField>\n               <contactField>\n                  <id>FMlmQUlMUTgZkuvdtFtbAA</id>\n                  <value>".$data['nombre']."</value>\n               </contactField>\n               <contactField>\n                  <id>CeLdn7IxwXDU_wBiHHFYwQ</id>\n                  <value></value>\n               </contactField>\n               <contactField>\n                  <id>JqDdVdD1CkIM2Sw889J5pw</id>\n                  <value>".$data['guid']."</value>\n               </contactField>\n               <contactField>\n                  <id>wUXj4S8Qr_XP4pk5Gvtz0w</id>\n                  <value>".$data['producto']."</value>\n               </contactField>\n            </contactFields>\n            <!-- 1 or more contactGroups to assign the contact-->\n            <contactGroupSubscriptions>\n               <contactGroupSubscription>\n\t\t\t\t\t<!-- Determine contact group by contactGroupName OR encrypted contactGroupId -->\t\t\t\n                  <contactGroup>\n                     <id>e2AGvTX34x3mePo2dly0Fg</id>\n                  </contactGroup>\n                  <confirmed>1</confirmed>\n               </contactGroupSubscription>\n            </contactGroupSubscriptions>\n            <ip>".$_SERVER['REMOTE_ADDR']."</ip>\n            <reference>contact created via SubscriptionService.subscribeContact call</reference>\n         </subscribeContactRequest>\n      </sub:subscribeContact>\n   </soap:Body>\n</soap:Envelope>",
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

    curl_close($curl);

    if ($response != '')
    {
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $subscriberId = $doc->getElementsByTagName('response')->item(0)->nodeValue;

        if ($subscriberId != '')
        {
            return $subscriberId;
        }
    }
    return false;
}

function delete_from_tripolis($tripolis_id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://td45.tripolis.com/api2/soap/ContactService/delete",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:ser=\"http://services.tripolis.com/\" xmlns:con=\"http://contact.services.tripolis.com/\">\n   <soap:Header>\n      <ser:authInfo>\n         <client>".TRIPOLIS_CLIENT."</client>\n         <username>".TRIPOLIS_USER."</username>\n         <password>".TRIPOLIS_PASS."</password>\n      </ser:authInfo>\n      <ser:responseLanguage></ser:responseLanguage>\n   </soap:Header>\n   <soap:Body>\n\t\t<con:delete>\n\t\t\t<deleteRequest>\n\t\t\t\t<id>".$tripolis_id."</id>\n\t\t\t</deleteRequest>\n\t\t</con:delete>\n\t</soap:Body>\n</soap:Envelope>",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: text/html",
        "cache-control: no-cache"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
}

if (isset($_GET['guid']))
{
    $guid = trim($_GET['guid']);
    $quote_file_name = $guid.'.json';
    $quote_file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' .$quote_file_name;
    if (file_exists($quote_file_path))
    {
        $quote = json_decode(file_get_contents($quote_file_path));
        if ($quote!=null && isset($quote->answers->userEmail) && isset($quote->answers->userName))
        {

            if (isset($_GET['delete']))
            {
                delete_from_tripolis($quote->tripolis);
            } else
            {
                $data = [
                    'guid' => $quote->guid,
                    'nombre' => $quote->answers->userName,
                    'producto' => $quote->product,
                    'email' => $quote->answers->userEmail
                ];
                $subscriberId = subscribe_to_tripolis($data);
                if ($subscriberId)
                {
                    $quote->tripolis = $subscriberId;
                    file_put_contents($quote_file_path, json_encode($quote));
                    echo '// OK';
                }
                }
        }
    }
}
