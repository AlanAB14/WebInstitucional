<title>Seguro para Autos y Pick-ups – Cooperación Seguros</title>

<meta name="msapplication-TileImage" content="/wp-content/uploads/2019/10/cropped-icon-270x270.png">
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/css/cotizador/new_cotizador.css">

<!-- SWEETALERT -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php   

       
    require_once get_template_directory() . '/api/api.php';
    require_once get_template_directory() . '/classes/cotizador.php';


    include get_template_directory() . '/template-parts/cotizador/fragments/parts/barra_ingreso.php' ;
    include get_template_directory() . '/template-parts/cotizador/fragments/parts/menu_bar.php' ;
   
    if(isset($_COOKIE['guid'])){
        $guid = $_COOKIE['guid'];
    }
    

    include dirname(__FILE__) . '/parts/datos_checkout_vehiculo.php'; 
    
    
    //get_footer() ;
    ?>