<?php
  $nombre = $args['quote']['datos-solicitante']['customerNombre'] ?? $args['quote']['datos-solicitante']['customerRazonSocial'];
?>

<div class="final success">
  <h1><?php echo $nombre; ?>, ya estamos listos para contratar tu póliza</h1>

  <ul>
    <li>En breve serás contactado por nuestros asesores para confirmarte todos los detalles necesarios para abonar y confirmar tu póliza.</li>

    <?php if (isset($args['quote']['asesor'])) : ?>
      <li>Tu productor está disponible para asesorarte y aclarar cualquier duda que tengas sobre la póliza contratada.</li>
    <?php endif; ?>

    <li>Si tenés alguna duda, podés comunicarte con nuestro call center: <strong><?php echo get_theme_mod('custom_option_phone'); ?> y líneas rotativas</strong></li>
  </ul>
</div>
