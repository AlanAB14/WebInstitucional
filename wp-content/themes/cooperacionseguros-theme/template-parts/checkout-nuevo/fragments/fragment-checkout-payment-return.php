<?php  
    $urlImg="/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_asesor.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_resumen.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/new_cotizador.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/checkout_payment_return.css">

<?php

include get_template_directory() . '/template-parts/cotizador/fragments/parts/barra_ingreso.php' ;
include get_template_directory() . '/template-parts/cotizador/fragments/parts/menu_bar.php' ;

?>


<?php 
    include dirname(__FILE__) . '/parts/datos_checkout_payment_return.php'; 
?>

<div style="margin: 200px 0;" class="loader-checkout-vehiculo-cedula" id="loader-payment">
    <p>Espere un momento...</p>
    <img src="<?php echo get_template_directory_uri() . '/assets/img/checkout/loader.gif'  ?>" alt="">
</div>

<?php
include get_template_directory() . '/template-parts/cotizador/fragments/parts/nuevo_footer.php' ; ?>