<!-- <title>Seguro para Autos y Pick-ups – Cooperación Seguros</title>
<meta name="msapplication-TileImage" content="/wordpress/wp-content/uploads/2019/10/cropped-icon-270x270.png">
<link rel="stylesheet" href="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/css/new_cotizador.css">
<?php   
  $guid = trim($_REQUEST['guid'] ?? get_query_var('guid'));
  setcookie("nroGuid",$guid,time() + 30*24*60*60);
       
    require_once get_template_directory() . '/api/api.php';
    require_once get_template_directory() . '/classes/cotizador.php';

    get_header();

    include get_template_directory() . '/template-parts/cotizador/barra_ingreso.php' ;
    include get_template_directory() . '/template-parts/cotizador/menu_bar.php' ;
   
    if(isset($_COOKIE['nroGuid'])){
        $guid = $_COOKIE['nroGuid'];
    }
    

    $label = '';
    $paso = isset($_POST['paso'])? $_POST['paso']: 1;
    switch($paso){
      case 1:
        $label = 'Inicio';
        break;
      case 2:
        $label = 'Datos del Solicitante';
        break;
      case 3:
        $label = 'Datos del Vehículo';
        break;
    }


    $checkout = new Cotizador($paso, $guid, $label);
    $checkout->get_template();
  //get_footer() ;
?>


<?php  
  echo '<script>
    var guid = "'.$guid.'";
    var paso = "'.$paso.'";
    
    </script>';

    echo '<script src="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/js/own/cotiza2.js"></script>';
        
?>
 -->


