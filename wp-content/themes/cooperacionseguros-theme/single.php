<?php
$post = $wp_query->post;
 
if (in_category('30')) {
    $shortcode = 1376;
    include(TEMPLATEPATH.'/singleRevista.php');
} else if(in_category('31')) {
    $shortcode = 1379;
    $path_img = 'novedes-comerciales.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('32')) {
    $shortcode = 1380;
    $path_img = 'capital-humano.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('33')){
    $shortcode = 1381;
    $path_img = 'instalaciones.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('34')) {
    $shortcode = 1383;
    $path_img = 'resp-social-empresaria.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('35')) {
    $shortcode = 1384;
    $path_img = 'innovacion.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('36')) {
    $shortcode = 1385;
    $path_img = 'red-comercial.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('37')) {
    $shortcode = 1386;
    $path_img = 'socios-estrategicos.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('39')) {
    $shortcode = 1526;
    $path_img = 'novedades-institucionales.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('40')) {
    $shortcode = 1527;
    $path_img = 'atencion-cliente.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else{
    include(TEMPLATEPATH.'/singleDefault.php');
}
?>