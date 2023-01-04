<?php 
require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php';
require_once get_template_directory() . '/functions.php';
require_once get_template_directory() . '/api/api.php';

$token = coopseg_get_local_token();

$tokenDecriptado = encrypt_decrypt('decrypt', $token);

echo json_encode($tokenDecriptado);


?>