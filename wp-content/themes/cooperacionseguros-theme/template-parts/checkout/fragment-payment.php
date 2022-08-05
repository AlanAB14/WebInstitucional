<?php

echo '<div class="final ' . $args['quote']['pago']['status'] . '">';

$nombreCliente = $args['quote']['datos-solicitante']['customerNombre'] ?? $args['quote']['answers']['userName'];

if ($args['quote']['pago']['status'] == 'success') {
  $hora = (int) date('G');

  if ($hora >= 0 && $hora <= 3) {
    echo '<h1>' . $nombreCliente . ', tu póliza se emitirá en breve</h1>';
    echo '<ul>';
    echo '<li>En este momento estamos realizando tareas diarias de mantenimiento en nuestros servidores y no podremos emitirte la póliza online. ¡Pero no te preocupes! Tu solicitud ha sido recibida bajo el nro. <strong>' . $args['quote']['step_5']['idPoliza'] . '</strong> y a la brevedad te estaremos enviando la póliza a tu e-mail.</li>';
    echo '<li>Te pedimos disculpas por la molestia ocasionada.</li>';
    echo '<li>Ante cualquier duda o consulta, por favor comunícate con nuestro equipo de Atención al Cliente: <a href="mailto:' .  get_theme_mod('custom_option_email') . '">' .  get_theme_mod('custom_option_email') . '</a> –  Teléfono: <strong>' .  get_theme_mod('custom_option_phone') . '</strong>, de lunes a viernes en el horario de 7 a 20hs.</li>';
    echo '</ul>';
  } else {
    echo '<h1>' . $nombreCliente . ', tu póliza fue emitida correctamente</h1>';
    echo '<ul>';
    echo '<li>En los próximos minutos vas a recibir una confirmación de la transacción en tu e-mail.</li>';
    echo '<li>También vas a recibir un e-mail con todos los detalles y una copia digital de tu póliza.</li>';
    echo '<li>Tu productor está disponible para asesorarte y aclarar cualquier duda que tengas sobre la póliza contratada.</li>';
    echo '<li>Podrás consultar y administrar tus pólizas, obtener certificados de cobertura, imprimir comprobantes, pagar online e imprimir copias desde nuestra página de autogestión: <a href="https://asegurados.cooperacionseguros.com.ar" target="_blank">asegurados.cooperacionseguros.com.ar</a></li>';
    echo '</ul>';
  }

  // Redirect después de confirmación
?>
  <script type="text/javascript">
    $(function () {
      setTimeout(function() {
        window.location = "https://www.cooperacionseguros.com.ar/";
      }, 10000);
    });
  </script>
<?php

} else if ($args['quote']['pago']['status'] == 'pending') {
  echo '<h1>' . $nombreCliente . ', tu póliza está siendo procesada</h1>';

  echo '<ul>';
    echo '<li>La emisión de tu póliza está en proceso, cuando el pago se confirme recibirás una notificación con todos los detalles.</li>';
    echo '<li>Si tenés alguna duda, podés comunicarte con nuestro call center: <strong>' .  get_theme_mod('custom_option_phone') . ' y líneas rotativas</strong></li>';
  echo '</ul>';
} else {
  echo '<h1>' . $nombreCliente . ', se produjo un error al intentar emitir tu póliza</h1>';

  echo '<ul>';
    echo '<li>Nuestro sistema encontró un error en tus datos y tu póliza quedó en estado pendiente. <strong>No te preocupes, todavía no se hizo ningún cargo en tu tarjeta.</strong></li>';
    echo '<li>Para continuar con este proceso, podés comunicarte con nuestro call center: <strong>' .  get_theme_mod('custom_option_phone') . ' y líneas rotativas</strong></li>';
  echo '</ul>';
}

echo '</div>';

?>

<script>
  $(function () {
    const eventData = {
      'event': '<?php echo ($args['quote']['pago']['status'] == 'pending' || $args['quote']['pago']['status'] == 'success') ? 'trackEcommercePurchase' : 'trackEcommercePurchaseFail' ?>',
      'purchaseId': '<?php echo $args['quote']['guid']; ?>',
      ...commonEvent,
    };

    pushDataLayer(eventData);
  });
</script>
