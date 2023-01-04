<?php

require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php';
require_once get_template_directory() . '/functions.php';
require_once get_template_directory() . '/api/api.php';


$upload_dir = get_template_directory() . COOPSEG_QUOTE_IMAGES_DIR;

if( is_array($_FILES) )
{
    if( is_uploaded_file($_FILES['image']['tmp_name']) )
    {
        $file_name = $_POST['guid'].'-'.$_POST['image_name'].'.'.get_extension($_FILES['image']['name']);
        $new_path = $upload_dir.'/'.$file_name;
        if( move_uploaded_file($_FILES['image']['tmp_name'],$new_path) )
        {
            echo json_encode(['guid'=>$_POST['guid'], 'image_name'=>$_POST['image_name'], 'path'=>$file_name]);
        }
        // Enviamos al webservice de inspeccion
        /*
        $fotos[] = [
            'item' => $_POST['image_item'],
            'imagenData' => base64_encode(file_get_contents($upload_dir . '/' . $file_name)),
            'imagenNombre' => str_replace('.' . get_extension($file_name), '', $file_name),
            'imagenExtension' => get_extension($file_name)
        ];

        coopseg_send_inspeccion($token, $_POST['guid'], 1, $fotos);
        */
    }

}else {
    $data = $_POST['cedulaFrenteData'];
    print_r($data);
}

$guid = trim($_POST['guid']);


$quote = quote_get($guid);

$imagen_subida = [];

switch ($_POST['image_name']) {
    case 'foto-cedula-frente':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-cedula-dorso':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-izquierda':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-derecha':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-frente':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-delantera':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-trasera':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-parabrisas':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-interior':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-tablero':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-techo-panoramico':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-cubiertas':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-kilometraje':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;
    case 'foto-equipo-gnc':
        $quote['fotos-vehiculo'][$_POST['image_name']] = $file_name;
        break;

    default:
        break;
}

$quote['instanciaAlcanzada'] = 15;
$quote['descripcionInstancia'] = 'Fotos vehículo';


$file_path = get_template_directory() . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';

$fotos = array();
$i = 1;



file_put_contents($file_path, json_encode($quote));


// // GUARDO PLAN SI EXISTE EN COOKIE
// if (isset($_COOKIE['planElejido'])) {
//     $seleccion = $_COOKIE['planElejido'];
//     $seleccion = str_replace("\\", "",$seleccion);
//     $seleccion = json_decode($seleccion);
// }