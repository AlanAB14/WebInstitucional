<?php
// Forzar zona horaria Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Definir si estamos en el sitio de desarrollo o en producción
$currentEnvironment = (get_site_url() == 'http://cooperacion.shakeagain.net' || get_site_url() == 'http://cooperacion.test') ? 'dev' : 'prod';

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/custom-pages.php';
require_once get_template_directory() . '/inc/custom-blocks.php';
require_once get_template_directory() . '/inc/shortcodes.php';

require_once get_template_directory() . '/classes/lead.php';
require_once get_template_directory() . '/classes/quote.php';
require_once get_template_directory() . '/classes/checkout.php';
require_once get_template_directory() . '/classes/errorlog.php';
require_once get_template_directory() . '/classes/cotizador.php';

// Do theme setup
if (!function_exists('custom_theme_setup')) :

  function custom_theme_setup()
  {

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Wordpress title tag
    add_theme_support('title-tag');

    // Support for post thumbnails
    add_theme_support('post-thumbnails');

    // Support for responsive embeds
    add_theme_support('responsive-embeds');

    // Theme thumbnail sizes
    add_image_size('cover', 1100, 550, true);
    add_image_size('preview', 500, 250, true);


    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(array(
      'menu-1' => esc_html__('Primary', 'custom-theme'),
      'menu-usuarios' => esc_html__('Usuarios', 'custom-theme'),
      'menu-productores' => esc_html__('Productores', 'custom-theme'),
    ));

    /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ));

    // Core custom logo
    add_theme_support('custom-logo', array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
    ));

    // Remove emoji scripts and styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
  }
endif;
add_action('after_setup_theme', 'custom_theme_setup');

// Get current environment
function get_environment() {
  global $currentEnvironment;

  return $currentEnvironment;
}

// Get coopseg auth token
function get_token()
{
  return encrypt_decrypt('decrypt', coopseg_get_local_token());
}

// Add tag and category support to pages
function tags_categories_support_all()
{
  register_taxonomy_for_object_type('post_tag', 'page');
  register_taxonomy_for_object_type('category', 'page');
}

// Ensure all tags and categories are included in queries
function tags_categories_support_query($wp_query)
{
  if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
  if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
}

// Tag and category hooks
add_action('init', 'tags_categories_support_all');
add_action('pre_get_posts', 'tags_categories_support_query');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function custom_theme_content_width()
{
  $GLOBALS['content_width'] = apply_filters('custom_theme_content_width', 1100);
}
add_action('after_setup_theme', 'custom_theme_content_width', 0);


/**
 * Enqueue scripts and styles.
 */
function custom_theme_scripts()
{
  global $currentEnvironment;
  // Quitamos el jQuery de Wordpress para usar el propio
  wp_deregister_script('jquery');
  // Incluimos el javascript unificado, según entorno
  $javascriptFile = ($currentEnvironment == 'prod') ? 'main.min.js' : 'main.js';
  $jstime = filemtime(get_template_directory() . '/assets/js/' . $javascriptFile);
  wp_enqueue_script('javascript', get_template_directory_uri() . '/assets/js/' . $javascriptFile, array(), $jstime);

  // Assets requeridos Checkout
  if (is_page('checkout') || is_page('contratar')) {
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
  }

  // Assets requeridos Cotizador
  if (is_page('cotizador')) {
    wp_enqueue_script('cotizador', get_template_directory_uri() . '/assets/js/own/cotiza2.js', NULL, '1.0', true);
  }
  // Incluimos el CSS unificado, siempre minificado
  $csstime = filemtime(get_template_directory() . '/assets/css/main.css');
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), $csstime);
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');

/**
 * Extra functions
 */

// Get custom logo
function theme_get_custom_logo()
{
  if (function_exists('the_custom_logo')) {
    $custom_logo_id = get_theme_mod('custom_logo');
    $custom_logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    return $custom_logo[0];
  } else {
    return null;
  }
}

// Add slug to body classes
function add_slug_body_class($classes)
{
  global $post;
  if (isset($post)) $classes[] = $post->post_type . '-' . $post->post_name;
  if (isset($_GET['landing'])) $classes[] = 'landing';
  return $classes;
}
add_filter('body_class', 'add_slug_body_class');

/**
 * Funciones para lidiar con GUIDs y los quotes relacionados
 */

function GUID()
{
  if (function_exists('com_create_guid') === true) {
    return trim(com_create_guid(), '{}');
  }

  return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function quote_put($guid = null, $data = [])
{
  if (!$guid) {
    return false;
  }
  $file_path = dirname(__FILE__) . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';
  if (file_put_contents($file_path, json_encode($data))) {
    return $data;
  }
}

function quote_get($guid = null)
{
  // Revisar GUID remoto
  require_once get_template_directory() . '/api/api.php';
  $token = get_token();
  $remoteLead = json_decode(coopseg_lead_get($token, $guid), true);

  $file_path = dirname(__FILE__) . '/' . COOPSEG_QUOTE_DIR . '/' . $guid . '.json';

  $response = array();
  if (isset($remoteLead['idLead'])) {
    $response = array_merge($response, $remoteLead);
  }

  if (file_exists($file_path)) {
    $response = array_merge($response, json_decode(file_get_contents($file_path), true));
  }

  return (empty($response)) ? null : $response;
}

function get_extension($file)
{
  $file = explode(".", $file);
  $extension = end($file);
  return $extension ? $extension : false;
}

// Aplastar (?) un array
function flatten_products($products)
{
  $result = array();
  foreach ($products->products as $parent) {
    foreach ($parent->products as $p) {
      if (isset($p->products)) {
        foreach ($p->products as $pp) {
          $result[] = $pp;
        }
      } else {
        $result[] = $p;
      }
    }
  }
  return $result;
}

// Obtener un producto del JSON via slug
function get_product_from_slug($slug)
{
  if (!$slug) return;
  // Obtener las definiciones de productos del JSON
  $products = json_decode(file_get_contents(get_template_directory() . '/data/products.json'));
  $flatProducts = flatten_products($products);

  // Buscamos en el JSON cuál es el producto, según el slug (no usamos post porque puede no venir del preguntador)
  $currentProduct = array_search($slug, array_column($flatProducts, 'slug'));

  return $flatProducts[$currentProduct];
}

// Incluir script para suscripciones via GUID
function track_script($guid, $action = '')
{
  $url =  get_template_directory_uri() . '/utils/track.php';
  $url .= '?guid=' . $guid;
  if ($action) $url .= '&' . $action;

  echo '<script src="' .  $url . '"></script>';
}

// Mostrar lista de productos en el footer
function show_product_linked_list($category)
{
  remove_all_filters('posts_orderby');
  $productos_args = array(
    'post_type' => 'page',
    'showposts' => -1,
    //'post_status' => 'any',
    'tax_query' => array(
      array(
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => $category,
      ),
    ),
    'orderby' => 'title',
    'order' => 'ASC'
  );
  $productos = new WP_Query($productos_args);
  echo '<ul class="items">';
  while ($productos->have_posts()) : $productos->the_post();
    echo '<li><a href="' . get_permalink() . '">' . str_replace(array('Seguro para ', 'Seguro de ', 'Seguro '), '', get_the_title()) . '</a></li>';
  endwhile;
  echo '</ul>';
}


// Obtener IP del usuario
function get_user_ip()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

// Agregar SMTP al phpmailer
/*
add_action('phpmailer_init', 'send_smtp_email');
function send_smtp_email($phpmailer)
{
  $phpmailer->isSMTP();
  $phpmailer->Host       = '10.20.128.10';
  $phpmailer->SMTPAuth   = true;
  $phpmailer->Port       = '587';
  $phpmailer->SMTPSecure = 'tls';
  $phpmailer->Username   = 'smtp_wp';
  $phpmailer->Password   = 'H?Hqy\'71!$=Dh$n';
  $phpmailer->From       = 'info@cooperacionseguros.com.ar';
  $phpmailer->FromName   = 'CooperacionSeguros.com.ar';
}
*/


// Campañas: Si hay utms los guardamos en cookies para poder usarlos luego en leads
if (isset($_GET['utm_source'])) {
  $_COOKIE['utmSource'] = filter_var($_GET['utm_source'], FILTER_SANITIZE_STRING);
  setcookie("utmSource", filter_var($_GET['utm_source'], FILTER_SANITIZE_STRING), strtotime('+7 day'), '/');
}

if (isset($_GET['utm_medium'])) {
  $_COOKIE['utmMedium'] = filter_var($_GET['utm_medium'], FILTER_SANITIZE_STRING);
  setcookie("utmMedium", filter_var($_GET['utm_medium'], FILTER_SANITIZE_STRING), strtotime('+7 day'), '/');
}

if (isset($_GET['utm_campaign'])) {
  $_COOKIE['utmCampaign'] = filter_var($_GET['utm_campaign'], FILTER_SANITIZE_STRING);
  setcookie("utmCampaign", filter_var($_GET['utm_campaign'], FILTER_SANITIZE_STRING), strtotime('+7 day'), '/');
}

// Datos de cliente para compra desde AOL
if (isset($_GET['clientDNI']) && (isset($_GET['clientSex']))) {


  // Marcos: ?clientDNI=TWpjMU16ZzROVFE9&clientSex=m
  // Celina: ?clientDNI=TWpnME1qQTVOVGM9&clientSex=f
  // Valeria Fátila: ?clientDNI=TXpJeU1qYzROVGs9&clientSex=f
  $_COOKIE['clientDNI'] = filter_var($_GET['clientDNI'], FILTER_SANITIZE_STRING);
  setcookie("clientDNI", filter_var($_GET['clientDNI'], FILTER_SANITIZE_STRING), strtotime('+1 day'), '/');

  $_COOKIE['clientSex'] = filter_var($_GET['clientSex'], FILTER_SANITIZE_STRING);
  setcookie("clientSex", filter_var($_GET['clientSex'], FILTER_SANITIZE_STRING), strtotime('+1 day'), '/');

  // Validar cliente
  require_once get_template_directory() . '/api/api.php';
  $cliente = json_decode(coopseg_customers_get_by_dni_and_sexo($token, coopseg_decode_dni($_GET['clientDNI']), $_GET['clientSex']));

  // Generar array de datos que sabemos
  $userData = array();

  if (isset($cliente->nombre) && isset($cliente->apellido)) {
    $userData['userName'] = ucwords(strtolower($cliente->nombre . ' ' . $cliente->apellido));
  }

  if (isset($cliente->fechaNacimiento)) {
    $userData['userBirthDay'] = date('j', strtotime($cliente->fechaNacimiento));
    $userData['userBirthMonth'] = date('n', strtotime($cliente->fechaNacimiento));
    $userData['userBirthYear'] = date('Y', strtotime($cliente->fechaNacimiento));
  }

  if (isset($cliente->emailAOL)) {
    $userData['userEmail'] = $cliente->emailAOL;
  }

  if (isset($cliente->codigoPostal)) {
    $userData['userZip'] = $cliente->codigoPostal;
    $userData['userCity'] = ucwords(strtolower($cliente->localidad));
    $userData['userState'] = ucwords(strtolower($cliente->provincia));
  }

  // Guardar la cookie
  $userData = json_encode($userData);
  $_COOKIE['userData'] = $userData;
  setrawcookie("userData", rawurlencode($userData), strtotime('+1 day'), '/');
}

// CSS REVISTA
//https://developer.wordpress.org/reference/functions/is_single/ 
 
add_action( 'wp_enqueue_scripts', 'custom_enqueue_styles');

function custom_enqueue_styles() {
  if (is_page(1340) || is_single()) {
    wp_enqueue_style( 'custom-style', 
    get_stylesheet_directory_uri() . '/assets/css/revista.css', 
    array(), 
    wp_get_theme()->get('Version')
  );
  }

  // if (is_page(1210) || is_page(1187) || is_page(1191) ||     is_page(1056) || is_page(1058) || is_page(1077) || is_page(1086) || is_page(1090) || is_page(1093) || is_page(1139)) {
  //   wp_enqueue_style( 'custom-style', 
  //   get_stylesheet_directory_uri() . '/assets/css/new_cotizador.css',
  //   array(), 
  //   wp_get_theme()->get('Version')
  // );
  // }
  
}

//add_action('wp_enqueue_scripts', 'custom_cotizador_styles');
//function custom_cotizador_styles(){
//  wp_enqueue_style('cotizador_style', get_stylesheet_directory_uri() . '/assets/css/new_cotizador.css' )
//}

// ANIMATE CSS MIN
add_action( 'wp_enqueue_scripts', 'animate_css');

function animate_css() {
  if (is_page(1340) || is_single()) {
    wp_enqueue_style( 'animate-style', 
    get_stylesheet_directory_uri() . '/assets/css/animate.min.css', 
    array(), 
    wp_get_theme()->get('Version')
  );
  }
}

// JS REVISTA
add_action('wp_enqueue_scripts', 'collectiveray_load_js_script');

function collectiveray_load_js_script() {
  if( is_page(1340) || is_single()) {
    wp_enqueue_script( 'js-file', get_template_directory_uri() . '/assets/js/own-for-pages/revista.js');
  }
  // if( is_page(1019) || is_page(1058) || is_single()) {
  //   wp_enqueue_script( 'js-file', get_template_directory_uri() . '/assets/js/cotizador.js');
  // }
  
}



// FONT TITILIUM DIFERENTES WEIGHTS
add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

function wpb_add_google_fonts() {
  if (is_page(1340) || is_single()) {
    wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700&display=swap', false );
  }
}

  // FONT POPPINS DIFERENTES WEIGHTS
  add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts_poppins' );

function wpb_add_google_fonts_poppins() {
  if (is_page(1340) || is_single()) {
    wp_enqueue_style( 'wpb-google-fonts_poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', false );
  }
}
  
// PLUGIN 2 IMAGENES DESTACADAS
if (class_exists('MultiPostThumbnails')) {
  new MultiPostThumbnails(array(
    'label' => 'Secondary Image',
    'id' => 'secondary-image',
    'post_type' => 'post'
  ));
}


// JS RECLAMOS DE TERCEROS
add_action('wp_enqueue_scripts', 'reclamos_de_terceros_js');

function reclamos_de_terceros_js() {
  if( is_page('reclamos-de-terceros')) {
      wp_enqueue_script( 'js-file-reclamos-terceros', get_template_directory_uri() . '/assets/js/own-for-pages/fragment-reclamos-procesar.js');
  } 
}


// -----------------------------
// -----------COTIZADOR---------
// -----------------------------

// PASAR VARIABLES A ARCHIVO JS
function myprefix_variables_enqueue_scripts() {
  wp_enqueue_script( 
    'variables-script',
    get_stylesheet_directory_uri() . '/assets/js/own/fragment-reclamos-procesar.js'
  );
  wp_localize_script( 'variables-script', 'php_data', array(
        'templateUrl' => get_template_directory(),
        'NuevaUrl' => get_template_directory_uri(),
        'homeUrl' => home_url(),

        // VARIABLES TOKEN
        'COOPSEG_TOKEN_URL' => COOPSEG_TOKEN_URL,
        'COOPSEG_CONFIG_GRANT_TYPE' => COOPSEG_CONFIG_GRANT_TYPE,
        'COOPSEG_CONFIG_CLIENT_ID' => COOPSEG_CONFIG_CLIENT_ID,
        'COOPSEG_CONFIG_CLIENT_SECRET' => COOPSEG_CONFIG_CLIENT_SECRET,

        'COOPSEG_CONFIG_GRANT_TYPE' => COOPSEG_CONFIG_GRANT_TYPE,
        'COOPSEG_CONFIG_TERCEROS_CLIENT_ID' => COOPSEG_CONFIG_TERCEROS_CLIENT_ID,
        'COOPSEG_CONFIG_TERCEROS_CLIENT_SECRET' => COOPSEG_CONFIG_TERCEROS_CLIENT_SECRET,
        'COOPSEG_LEADS_URL' => COOPSEG_LEADS_URL,
        'COOPSEG_LEADS_GET_URL' => COOPSEG_LEADS_GET_URL,

        'COOPSEG_RECLAMOS_AGREGAR' => COOPSEG_RECLAMOS_AGREGAR,
        
        'COOPSEG_QUOTE_IMAGES_URL' => COOPSEG_QUOTE_IMAGES_URL,
        'COOPSEG_QUOTE_IMAGES_DIR' => COOPSEG_QUOTE_IMAGES_DIR,
        'COOPSEG_RECLAMOS_INSPECCION' => COOPSEG_RECLAMOS_INSPECCION,
        'COOPSEG_VEHICLES_CEDULA_URL' => COOPSEG_VEHICLES_CEDULA_URL,
        'COOPSEG_VEHICLES_CARGAR_INSPECCION_URL' => COOPSEG_VEHICLES_CARGAR_INSPECCION_URL,
        'COOPSEG_SUGGEST_PRODUCERS_URL' => COOPSEG_SUGGEST_PRODUCERS_URL,
        'COOPSEG_SUSCRIBIR_URL' => COOPSEG_SUSCRIBIR_URL,
        'COOPSEG_VALIDAR_URL' => COOPSEG_VALIDAR_URL,
        'COOPSEG_CREAR_PREFERENCIA_PAGO' => COOPSEG_CREAR_PREFERENCIA_PAGO
    )
  );
  }

  add_action('wp_enqueue_scripts', 'myprefix_variables_enqueue_scripts');


// JS SOLO COTIZADOR
add_action('wp_enqueue_scripts', 'cotizador_solo_js');

function cotizador_solo_js() {
  if( is_page('cotizador-personal-autos-y-pick-ups')) {
      wp_enqueue_script( 'js-file-cotizador-vehiculo', get_template_directory_uri() . '/assets/js/own-for-pages/cotizador/cotizador.js');
  } 
}


// JS COTIZADOR VEHICULO

add_action('wp_enqueue_scripts', 'cotizador_vehiculo_js');

function cotizador_vehiculo_js() {
  if( is_page('vehiculo')) {
      wp_enqueue_script( 'js-file-cotizador-vehiculo', get_template_directory_uri() . '/assets/js/own-for-pages/cotizador/cotizadorVehiculo.js');
      wp_enqueue_script( 'js-file-select2-fields', get_template_directory_uri() . '/assets/js/own-for-pages/select2Fields.js');
  } 
}

// JS COTIZADOR PERSONA

add_action('wp_enqueue_scripts', 'cotizador_persona_js');

function cotizador_persona_js() {
  if(is_page('persona')) {
      wp_enqueue_script( 'js-file-cotizador-persona', get_template_directory_uri() . '/assets/js/own-for-pages/cotizador/cotizadorPersona.js');
  } 
}

// JS COTIZADOR COTIZACION

add_action('wp_enqueue_scripts', 'cotizador_cotizacion_js');

function cotizador_cotizacion_js() {
  if(is_page('cotizacion')) {
      wp_enqueue_script( 'js-file-cotizador-cotizacion', get_template_directory_uri() . '/assets/js/own-for-pages/cotizador/cotizadorCotizacion.js');
  } 
}

// JS CHEKCOUT SOLICITANTE

add_action('wp_enqueue_scripts', 'checkout_solicitante_js');

function checkout_solicitante_js() {
  if(is_page('datos-solicitante')) {
      wp_enqueue_script( 'js-file-cotizador-checkout', get_template_directory_uri() . '/assets/js/own-for-pages/checkout/checkoutDatosSolicitante.js');
  } 
}

// JS CHEKCOUT VEHICULO

add_action('wp_enqueue_scripts', 'checkout_vehiculo_js');

function checkout_vehiculo_js() {
  if(is_page('datos-vehiculo')) {
      wp_enqueue_script( 'js-file-cotizador-checkout-vehiculo', get_template_directory_uri() . '/assets/js/own-for-pages/checkout/checkoutDatosVehiculo.js');
  } 
}

// JS CHEKCOUT ASESORES

add_action('wp_enqueue_scripts', 'checkout_asesores_js');

function checkout_asesores_js() {
  if(is_page('asesores')) {
      wp_enqueue_script( 'js-file-cotizador-checkout-asesores', get_template_directory_uri() . '/assets/js/own-for-pages/checkout/checkoutDatosAsesores.js');
  } 
}

// JS CHEKCOUT RESUMEN

add_action('wp_enqueue_scripts', 'checkout_resumen_js');

function checkout_resumen_js() {
  if( is_page('resumen')) {
      wp_enqueue_script( 'js-file-cotizador-checkout-resumen', get_template_directory_uri() . '/assets/js/own-for-pages/checkout/checkoutDatosResumen.js');
  } 
}

// JS CHEKCOUT PAYMENT RETURN

add_action('wp_enqueue_scripts', 'checkout_payment_return_js');

function checkout_payment_return_js() {
  if( is_page('payment')) {
      wp_enqueue_script( 'js-file-cotizador-checkout-payment_return', get_template_directory_uri() . '/assets/js/own-for-pages/checkout/checkoutDatosPaymentReturn.js');
  } 
}
