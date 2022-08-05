<?php
if (!isset($_POST)) exit;

// Incluir Wordpress para acceder a sus funciones y variables
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php');

// Popular los campos a enviar con los valores del POST
if (!isset($_POST['tipo'])) {
  exit;
} else {

  // Variables
  $tipo = filter_var($_POST['tipo'], FILTER_SANITIZE_STRING);

  $message = '';

  if ($tipo == 'llamenme') {
    $nombre = filter_var($_POST['llamenNombre'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['llamenTelefono'], FILTER_SANITIZE_STRING);
    $subject = 'Quiero que me llamen - CooperacionSeguros.com.ar';

    $message .= '<p><strong>Nombre:</strong> ' . $nombre . '</p>';
    $message .= '<p><strong>Teléfono:</strong> ' . $telefono . '</p>';
  }

  // Enviar correo
  $headers = array('Content-Type: text/html; charset=UTF-8');
  wp_mail("clientes@cooperacionseguros.com.ar", $subject, $message, $headers);
  echo 'true';
}
