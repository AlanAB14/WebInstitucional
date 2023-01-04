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

}
