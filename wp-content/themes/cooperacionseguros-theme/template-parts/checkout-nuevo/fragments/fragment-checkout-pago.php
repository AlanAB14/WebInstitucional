<?php  
    $urlImg="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_pago.css">


<?php 
    include dirname(__FILE__) . '/parts/datos_checkout_pago.php'; 
?>

<?php  include 'nuevo_footer.php' ;?>