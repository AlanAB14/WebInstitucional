<?php  
    $urlImg="/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_asesor.css">

<?php

include get_template_directory() . '/template-parts/cotizador/fragments/parts/barra_ingreso.php' ;
include get_template_directory() . '/template-parts/cotizador/fragments/parts/menu_bar.php' ;

?>

<?php include dirname(__FILE__) . '/parts/datos_checkout_asesores.php'; ?>


