<?php

$datos = json_decode(file_get_contents("php://input"), true);
print_r($datos);

$data = array(
    'database' => 'reclamoterceros',
    'contactGroup' => 'terceros',
    'contactFields' => array(
      'guid' => 'test-123',
      'email' => 'alanbersia@gmail.com',
      'nombreyapellido' => 'Alan Bersia',
      'numerodereclamo' => '4113232',
      'detalle' => 'asdasd'
    )
);
print_r($data);

require_once "./api/api-tripolis.php";
$resultado = tripolis_add($datos);
echo json_encode($resultado);

?>