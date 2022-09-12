<?php
$post = $wp_query->post;
 
if (in_category('54')) { //Categoria Entrevistas Relacionadas
    $shortcode = 1335;
    include(TEMPLATEPATH.'/singleRevista.php');
} else if(in_category('58')) { //Categoria Novedades Comerciales Relacionadas
    $shortcode = 1334;
    $path_img = 'novedes-comerciales.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('53')) { //Categoria Capital Humano Relacionadas
    $shortcode = 1333;
    $path_img = 'capital-humano.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('56')){ //Categoria Instalaciones Relacionadas
    $shortcode = 1332;
    $path_img = 'instalaciones.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('61')) { //Categoria RSE Relacionadas
    $shortcode = 1331;
    $path_img = 'resp-social-empresaria.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('55')) { //Categoria Inovación Relacionada
    $shortcode = 1330;
    $path_img = 'innovacion.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('60')) { //Categoria Red Comercial Relacionada
    $shortcode = 1329;
    $path_img = 'red-comercial.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('62')) { //Categoria Socio Estratégio Relacionada
    $shortcode = 1328;
    $path_img = 'socios-estrategicos.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('59')) { //Categoria Novedades Institucionales Relacionada
    $shortcode = 1327;
    $path_img = 'novedades-institucionales.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else if(in_category('52')) { //Categoria Atención al Cliente Relacionada
    $shortcode = 1326;
    $path_img = 'atencion-cliente.jpg';
    include(TEMPLATEPATH.'/singleOthersCategories.php');
}else{
    include(TEMPLATEPATH.'/singleDefault.php'); // Single de la web.
}
?>