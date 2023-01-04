<?php
require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php';
require_once get_template_directory() . '/functions.php';
header('Content-Type: text/plain');

$data = $_POST['data'];
// print_r($data);


$guid = strtoupper($data['guid']);

$quote = quote_get($guid);

if ($data['tag'] === 'creoQuote') {
    if(isset($_COOKIE['datosVehiculo'])){
        $datosVehiculo = stripslashes($_COOKIE['datosVehiculo']);;
        $datosVehiculo = json_decode($datosVehiculo, true);
        
        $idMarca = $datosVehiculo['idMarca'];
        $marca = $datosVehiculo['marca'];
        $idModelo = $datosVehiculo['idModelo'];
        $modelo = $datosVehiculo['modelo'];
        $anio = $datosVehiculo['agno'];
        $idVersion = $datosVehiculo['idVersion'];
        $arrayVersion = explode(",", $idVersion);
        $codval = $arrayVersion[0];
        $codia = $arrayVersion[1];
        $zipCode = $datosVehiculo['zipCode'];
        $gncDecimal = $datosVehiculo['idGnc'];
        $version = $datosVehiculo['version'];
        $gncOpcion = $datosVehiculo['gnc'];
        $localidad = $datosVehiculo['localidad'];

        $leyenda = $marca." ".$modelo." DE ".$anio;
        
        $seleccionLocalidad = explode(",", $localidad);
        
        $userZipCode = $seleccionLocalidad[2];
        $userCity = $seleccionLocalidad[0];
        $userState = $seleccionLocalidad[1];           
    }

    $token = encrypt_decrypt('decrypt', coopseg_get_local_token());
    $precio_vehiculo = coopseg_vehicles_get_quotes($token, $anio, $codia, $codval, $zipCode, $gncDecimal);
    
    if ($precio_vehiculo) {
        $precio_vehiculo = json_decode($precio_vehiculo, JSON_PRETTY_PRINT);
        $precio_vehiculo = intval($precio_vehiculo["planes"]["A"]["suma"]);
    }

    

    if(isset($_COOKIE['datosPersonales'])){
        $datosPersonales = stripslashes($_COOKIE['datosPersonales']);;
        $datosPersonales = json_decode($datosPersonales, true);
        $nombre = $datosPersonales['nombreCompleto'];
        $mail = $datosPersonales['mail'];
        $telefono = $datosPersonales['telefono'];
    }

    $data = [
        'userName' => $nombre,
        'userEmail' => $mail,
        'userZip' => $userZipCode,
        'userIdCity' => $zipCode,
        'userCity' => $userCity,
        'userState' => $userState,
        'vehicleBrand' => $marca,
        'vehicleBrandId' => $idMarca,
        'vehicleModel' => $modelo,
        'vehicleModelId' => $idModelo,
        'vehicleGnc' => $gncOpcion,
        'vehicleGncId' => $gncDecimal,
        'vehicleGncValue' => $gncDecimal,
        'vehicleYear' => $anio,
        'codInfoAuto' => $codia,
        'codval' => $codval,
        'vehicleValue' => $precio_vehiculo ? $precio_vehiculo : 0,
        'vehicleVersion' => $version,
    ];

    $quote = Quote::create_quote("seguro-de-autos-y-pick-ups", $data, $guid);
    $rates = Quote::get_vehicle_rates($quote);

    $quote['instanciaAlcanzada'] = 12;
    $quote['descripcionInstancia'] = 'Selección de plan';


    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $quote['guid'] . '.json';
    file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));

    print_r($quote['guid']);
}else if ($data['tag'] === 'codint') {
    $quote[$data['tag']] = $data['dataObject'][$data['tag']];

    $quote['instanciaAlcanzada'] = 16;
    $quote['descripcionInstancia'] = 'Selección del PAS';

    
    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
    file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));

}else if($data['tag'] === 'idPropuesta') {
    if (array_key_exists('idPropuesta', $quote)) {
        $quote[$data['tag']] = $data['dataObject'][$data['tag']];
    
        $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
        
        file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));
    }
}else if($data['tag'] === 'idPoliza') {
    if (array_key_exists('idPoliza', $quote)) {
        $quote[$data['tag']] = $data['dataObject'][$data['tag']];

        $quote['descripcionInstancia'] = 'Genera preferencia de pago';
    
        $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
        
        file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));
    }else {
        $quote['idPoliza'] = $data['dataObject']['idPoliza'];

        $quote['descripcionInstancia'] = 'Genera preferencia de pago';

        $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
        
        file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));
    }
}else if($data['tag'] === 'personalData') {
    $quote['nombre']          = $data['dataObject']['nombre'];
    $quote['apellido']        = $data['dataObject']['apellido'];
    $quote['fechaNacimiento'] = $data['dataObject']['fechaNacimiento'];
    $quote['dni']             = $data['dataObject']['dni'];
    $quote['genero']          = $data['dataObject']['genero'];
    $quote['telefono']        = $data['dataObject']['telefono'];
    $quote['email']           = $data['dataObject']['email'];
    $quote['idNacionalidad']  = $data['dataObject']['idNacionalidad'];
    $quote['idEstadoCivil']   = $data['dataObject']['idEstadoCivil'];
    $quote['idActividad']     = $data['dataObject']['idActividad'];
    $quote['calle']           = $data['dataObject']['calle'];
    $quote['nro']             = $data['dataObject']['nro'];
    $quote['piso']            = $data['dataObject']['piso'];
    $quote['depto']           = $data['dataObject']['depto'];
    $quote['idLocalidad']     = $data['dataObject']['idLocalidad'];
    $quote['localidad']       = $data['dataObject']['localidad'];
    $quote['codigoPostal']    = $data['dataObject']['codigoPostal'];
    $quote['idProvincia']     = $data['dataObject']['idProvincia'];
    $quote['provincia']       = $data['dataObject']['provincia'];
    $quote['fechaNacimiento'] = $data['dataObject']['fechaNacimiento'];
    $quote['lugarNacimiento'] = $data['dataObject']['lugarNacimiento'];
    $quote['codcli']          = $data['dataObject']['codcli'];


    $quote['instanciaAlcanzada'] = 13;
    $quote['descripcionInstancia'] = 'Datos personales';



    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
    
    file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));

}else if($data['tag'] === 'vehiculoData'){
    $quote['vehiculos'] =  array_merge($quote['vehiculos'], $data['dataObject']);

    $quote['instanciaAlcanzada'] = 14;
    $quote['descripcionInstancia'] = 'Datos vehiculo';


    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
    file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));

}else if($data['tag'] === 'instanciaAlcanzada'){
    $quote['instanciaAlcanzada'] = $data['dataObject']['instanciaAlcanzada'];
    $quote['descripcionInstancia'] = $data['dataObject']['descripcionInstancia'];
    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
    file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));

}else if($data['tag'] === 'answers'){
    $quote[$data['tag']] = array_merge($quote[$data['tag']], $data['dataObject']);
    // $quote[$data['tag']] + $data['dataObject'];
    print_r($quote);
    $file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
    file_put_contents($file_path, json_encode($quote, JSON_UNESCAPED_SLASHES));

}

?>