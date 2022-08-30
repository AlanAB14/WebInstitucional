<?php

$datos = json_decode(file_get_contents("php://input"), true);
print_r($datos);


require_once "./api/api-tripolis.php";
$resultado = tripolis_add($datos);
echo json_encode($resultado);

?>