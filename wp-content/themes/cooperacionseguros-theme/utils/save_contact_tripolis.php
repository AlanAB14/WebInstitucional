<?php
require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php';
require_once get_template_directory() . '/functions.php';
header('Content-Type: text/plain');

$data = $_POST['data'];
print_r($data);
tripolis_add($data);

