<?php
// Incluir Wordpress para acceder a sus funciones y variables
require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wp-load.php';

// Verificar que el usuario es un admin (sólo admins y superadmins pueden editar plugins)
if (current_user_can('activate_plugins')) {

  echo '<h1>Instalación</h1>';

  /**
   * Crear y/o actualizar ubicaciones
   */
  if (isset($_GET['debug'])) echo '<h2>Ubicaciones</h2>';

  // Incluir API interna
  require_once __DIR__ . '/api/api.php';

  // Agregar o actualizar ubicaciones
  $ubicaciones = coopseg_places_save_places($token);
  echo $ubicaciones;

  /**
   * Crear y/o actualizar categorías
   */

  if (isset($_GET['debug'])) echo '<h2>Categorías</h2>';

  // Definimos los inserts y los errores en 0
  $inserts = 0;
  $errors = 0;

  // Lista de categorías necesarias
  $categorias = array(
    // Parent
    'Productos',
    // Categorías generales
    'Personas',
    'Empresas',
    'Agro',
    // Categorías fancy, del preguntador, todas hijas de personas
    'Vehículos',
    'Hogar',
    'Tiempo Libre',
    // Categorías Extra de empresas
    'Grandes Empresas',
    'PYMEs y Comercios',
    'Trabajadores Autónomos'

  );
  $categoriasIds = array();

  // Repasar todas las categorías
  foreach ($categorias as $c) {

    // Existe la categoría?
    if (term_exists($c, 'category')) {
      // Devolver el ID para usarlo como parent
      $categoriasIds[$c] = get_cat_ID($c);

      // Info para el debug
      if (isset($_GET['debug'])) echo '<p>La categoría <strong>' . $c . '</strong> ya existe.</p>';
    } else {
      // Si no existe, crear categoría comno hija de PRoductos
      $parent = ($c == 'Productos') ? '' : $categoriasIds['Productos'];
      $insert = wp_insert_term($c, 'category', array('parent' => $parent));

      if (!isset($insert->errors)) {
        // Info para el debug
        if (isset($_GET['debug'])) echo '<p>Categoría <strong>' . $c . '</strong> agregada.</p>';

        // Sumamos el ID al array
        $categoriasIds[$c] = $insert['term_id'];

        $inserts++;
      } else {
        // Info para el debug
        if (isset($_GET['debug'])) {
          echo '<p>Error con la categoría <strong>' . $c . '</strong>:<br />';
          print_r($insert->errors);
          echo '</p>';
        }
        $errors++;
      }
    }
  }

  // Status de categorías
  echo '<h3>Actualización de categorías</h3>';
  echo '<p>Se insertaron <strong>' . $inserts . '</strong> categorías en total.</p>';
  echo '<p>Se produjeron <strong>' . $errors . '</strong> errores en total.</p>';
  echo '<hr />';

  /**
   * Crear páginas de productos
   */

  // Definimos los inserts y los errores en 0
  $inserts = 0;
  $errors = 0;

  // Iteramos sobre los productos
  $productos = json_decode(file_get_contents(get_template_directory() . '/data/products.json'));
  $paginasProductos = array();
  foreach ($productos->products as $key => $val) {

    // Iteramos sobre los sub-productos
    foreach ($val->products as $k => $v) {

      if (isset($v->products)) {
        foreach ($v->products as $w) {
          $paginasProductos[$w->slug] = $w;
          $paginasProductos[$w->slug]->category = $val->title;
          $paginasProductos[$w->slug]->subcategory = $v->title;
        }
      } else {
        $paginasProductos[$v->slug] = $v;
        $paginasProductos[$v->slug]->category = $val->title;
      }
    }
  }

  // Iteramos sobre todas las páginas
  foreach ($paginasProductos as $v) {
    // Si no hay slug, sumamos un error
    if (!isset($v->slug)) {
      if (isset($_GET['debug'])) echo '<p>El producto <strong>' . $v->title . '</strong>no tiene slug.</p>';
      $errors++;
    } else {
      // Existe la página?
      // $page = get_page_by_path($v->slug);

      $args = array(
        'name' => $v->slug,
        'post_type' => 'page',
        'post_status' => 'any'
      );
      $query = new WP_Query($args);

      if ($query->have_posts()) {
        // Si la página ya existe, info para el debug
        if (isset($_GET['debug'])) echo '<p>La página <strong>' . $v->title . '</strong> ya existe.</p>';
      } else {

        // Si la página no existe, definimos sus categorías
        $categories = array($categoriasIds['Productos']);

        // Categorías específicas
        if (isset($v->category)) $categories[] = $categoriasIds[$v->category];
        if (isset($v->subcategory)) $categories[] = $categoriasIds[$v->subcategory];

        // Info para crear la página
        $pageInfo = array(
          'post_title' => wp_strip_all_tags($v->pagetitle),
          'post_name' => $v->slug,
          'post_content' => '',
          'post_status' => 'draft',
          'post_type' => 'page',
          'post_category' => $categories
        );

        // Insertar la página como draft
        $newPage = wp_insert_post($pageInfo);

        if ($newPage) {
          // Info para el debug
          if (isset($_GET['debug'])) echo '<p>Página <strong>' . $v->title . '</strong> agregada.</p>';
          $inserts++;
        } else {
          if (isset($_GET['debug'])) echo '<p>Hubo un error al insertar la página <strong>' . $v->title . '</strong>.</p>';
          $errors++;
        }
      }
    }
  }



  /**
   * Crear páginas necesarias manejadas por el template
   */

  $staticPages = array();
  $staticPages[] = array('title' => 'Home', 'slug' => 'home');
  $staticPages[] = array('title' => 'Ayuda', 'slug' => 'ayuda');
  $staticPages[] = array('title' => 'Nosotros', 'slug' => 'nosotros');
  $staticPages[] = array('title' => 'Novedades', 'slug' => 'novedades');
  $staticPages[] = array('title' => 'Contacto', 'slug' => 'contacto');
  $staticPages[] = array('title' => 'Red Comercial', 'slug' => 'red-comercial');
  $staticPages[] = array('title' => 'Quiero ser Productor', 'slug' => 'quiero-ser-productor');
  $staticPages[] = array('title' => 'Siniestros', 'slug' => 'siniestros');
  $staticPages[] = array('title' => 'Denuncias de asegurados', 'slug' => 'denuncias-de-asegurados');
  $staticPages[] = array('title' => 'Reclamos de terceros', 'slug' => 'reclamos-de-terceros');
  $staticPages[] = array('title' => 'No Disponible', 'slug' => 'no-disponible');
  $staticPages[] = array('title' => 'Hubo un problema', 'slug' => 'hubo-un-problema');
  $staticPages[] = array('title' => 'Checkout', 'slug' => 'checkout');
  $staticPages[] = array('title' => 'Contratar', 'slug' => 'contratar');
  $staticPages[] = array('title' => 'Términos y condiciones', 'slug' => 'terminos-y-condiciones');
  $staticPages[] = array('title' => 'Prevención del fraude', 'slug' => 'prevencion-del-fraude');
  $staticPages[] = array('title' => 'Prevención de lavados de activos y financiación del terrorismo', 'slug' =>  'prevencion-de-lavados-de-activos-y-financiacion-del-terrorismo');

  // Iteramos sobre páginas necesarias
  foreach ($staticPages as $v) {
    // Existe la página?
    $page = get_page_by_path($v['slug']);

    if ($page) {
      // Si la página ya existe, info para el debug
      if (isset($_GET['debug'])) echo '<p>La página <strong>' . $v['title'] . '</strong> ya existe.</p>';
    } else {
      // Info para crear la página
      $pageInfo = array(
        'post_title' => wp_strip_all_tags($v['title']),
        'post_name' => $v['slug'],
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
      );

      // Insertar la página como draft
      $newPage = wp_insert_post($pageInfo);

      if ($newPage) {
        // Info para el debug
        if (isset($_GET['debug'])) echo '<p>Página <strong>' . $v['title'] . '</strong> agregada.</p>';
        $inserts++;
      } else {
        if (isset($_GET['debug'])) echo '<p>Hubo un error al insertar la página <strong>' . $v['title'] . '</strong>.</p>';
        $errors++;
      }
    }
  }

  // Status de páginas
  echo '<h3>Actualización de páginas</h3>';
  echo '<p>Se insertaron <strong>' . $inserts . '</strong> páginas en total.</p>';
  echo '<p>Se produjeron <strong>' . $errors . '</strong> errores en total.</p>';
  echo '<hr />';


  // Creación de tabla de logs para productores
  $logger = coopseg_producers_setup_logger();
  echo $logger;
} else {
  // El usuario no es admin
  echo 'No tenés permiso para ver esta página.';
}


// Agregar constantes necesarias al wp-config.php
/*
$current_wp_config = file_get_contents(ABSPATH . 'wp-config.php');

        $coop_constants =\r\n" .
        "define('CONSTANT', $val); \r\n" .


    $current_wp_config = str_replace("/* That's all, stop editing", $coop_constants . "/* That's all, stop editing", $current_wp_config);
    file_put_contents(ABSPATH . 'wp-config.php', $current_wp_config);
    ?*

*/
