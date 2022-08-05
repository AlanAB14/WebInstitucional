<?php

/**
 * Funciones estáticas para devolver datos de vehículos de agro
 */

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Obtener tipos de vehículos de agro
 */
function coopseg_agro_get_types()
{
  $types = array();
  $types['Cosechadora'] = 'Cosechadora';
  $types['Tractor'] = 'Tractor';
  $types['Pulverizadora'] = 'Pulverizadora';
  $types['PickUp'] = 'Pick-up';
  $types['Camion'] = 'Camión';
  $types['Otro'] = 'Otro';

  $result = json_encode($types);
  return $result;
}

/**
 * Obtener modelos de vehículos de agro
 * $type: el tipo de vehículo
 */
function coopseg_agro_get_models($type)
{
  $models = null;
  if ($type == 'Cosechadora') {
    $models = array('John Deere', 'Case', 'New Holland', 'Claas', 'Vassalli', 'Otro');
  } else if ($type == 'Tractor') {
    $models = array('John Deere', 'Pauny', 'Case', 'Massey Ferguson', 'New Holland', 'Otro');
  } else if ($type == 'Pulverizadora') {
    $models = array('Metalfort', 'Pla', 'John Deere', 'Caiman', 'Praba', 'Otro');
  } else if ($type == 'PickUp') {
    $models = array('Toyota', 'Volkswagen', 'Chevrolet', 'Fiat', 'Ford', 'Otro');
  } else if ($type == 'Camion') {
    $models = array('Iveco', 'Mercedez Benz', 'Volkswagen', 'Ford', 'Scania', 'Otro');
  } else if ($type == 'Otro') {
    $models = array('');
  }

  $result = json_encode($models);
  return $result;
}
