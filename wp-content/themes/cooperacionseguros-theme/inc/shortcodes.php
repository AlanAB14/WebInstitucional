<?php

/**
 * Custom shortcodes
 */

//nuevo Cotizador
function shortcode_cotizador($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/nuevo_cotizador');
  return ob_get_clean();
}
add_shortcode('cotizador', 'shortcode_cotizador');

function shortcode_datos_personales($attr)
{
  return get_template_part('template-parts/cotizador/datos_personales');
}
add_shortcode('datos_personales', 'shortcode_datos_personales');

function shortcode_datos_del_auto($attr)
{
  return get_template_part('template-parts/cotizador/datos_auto');
}
add_shortcode('cotizador_datos_auto', 'shortcode_datos_del_auto');

function shortcode_cotizador_precios($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/cotizador_precios');
  return ob_get_clean();
}
add_shortcode('cotizador_precios', 'shortcode_cotizador_precios');

function shortcode_cotizador_datos_personales($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/cotizador_datos_personales');
  return ob_get_clean();
}
add_shortcode('cotizador_datos_personales', 'shortcode_cotizador_datos_personales');

function shortcode_cotizador_datos_del_auto($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/cotizador_datos_del_auto');
  return ob_get_clean();
}
add_shortcode('cotizador_datos_del_auto', 'shortcode_cotizador_datos_del_auto');

function shortcode_cotizador_datos_asesor($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/cotizador_datos_asesor');
  return ob_get_clean();
}
add_shortcode('cotizador_datos_asesor', 'shortcode_cotizador_datos_asesor');

function shortcode_cotizador_resumen($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/cotizador_resumen');
  return ob_get_clean();
}
add_shortcode('cotizador_resumen', 'shortcode_cotizador_resumen');

function shortcode_cotizador_pago($attr)
{
  ob_start();
  get_template_part('template-parts/cotizador/cotizador_pago');
  return ob_get_clean();
}
add_shortcode('cotizador_pago', 'shortcode_cotizador_pago');

// Selección de productos
function shortcode_productos($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-productos');
  return ob_get_clean();
}
add_shortcode('productos', 'shortcode_productos');

// Siniestros
function shortcode_siniestros($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-siniestros');
  return ob_get_clean();
}
add_shortcode('siniestros', 'shortcode_siniestros');

// Reclamos de terceros
function shortcode_reclamos_de_terceros($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-reclamos-de-terceros');
  return ob_get_clean();
}
add_shortcode('reclamos-de-terceros', 'shortcode_reclamos_de_terceros');

// Planes de productos
function shortcode_planes($attr)
{
  ob_start();

  if (basename(get_permalink()) == 'seguro-de-vida-individual') {
    get_template_part('template-parts/planes/fragment-planes-vida');
  } else if (basename(get_permalink()) == 'seguro-de-autos-y-pick-ups') {
    get_template_part('template-parts/planes/fragment-planes-autos');
  } else if (basename(get_permalink()) == 'seguro-de-motos') {
    get_template_part('template-parts/planes/fragment-planes-motos');
  }

  return ob_get_clean();
}
add_shortcode('planes', 'shortcode_planes');

// Contratar de productos
function shortcode_contratar($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-contratar');
  return ob_get_clean();
}
add_shortcode('contratar', 'shortcode_contratar');

// Mapa de productores
function shortcode_mapa_de_productores($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-mapa-de-productores');
  return ob_get_clean();
}
add_shortcode('mapa-de-productores', 'shortcode_mapa_de_productores');

// Mapa de oficinas
function shortcode_mapa_de_oficinas($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-mapa-de-oficinas');
  return ob_get_clean();
}
add_shortcode('mapa-de-oficinas', 'shortcode_mapa_de_oficinas');

// Tabla de entidades representantes
function shortcode_entidades_representantes($attr)
{
  ob_start();
  get_template_part('template-parts/blocks/block-entidades-representantes');
  return ob_get_clean();
}
add_shortcode('entidades-representantes-cono-sur', 'shortcode_entidades_representantes');

// Posts recientes

function postsrecientes_shortcode($atts, $content = NULL)
{
  $atts = shortcode_atts(
    [
      'orderby' => 'date',
      'type' => 'post',
	  'cat' => '1',
      'posts_per_page' => '6'
    ],
    $atts,
    'recent-posts'
  );

  $query = new WP_Query($atts);

  $output = '<section class="posts recent-posts">';
  $output .= '<h1 class="titular">Novedades</h1>';
  $output .= '<div class="wrap">';

  while ($query->have_posts()) : $query->the_post();

    global $post;
    $output .= '<article>';
    $output .= '<a href="' . get_permalink() . '">';
    if (has_post_thumbnail($post->ID)) {
      $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'preview');
      $output .= '<img src="' . $image[0] . '" alt="" width="500" height="250" />';
    } else {
      $output .= '<img src="' . get_template_directory_uri() . '/assets/img/default-preview.jpg" alt="" />';
    }
    $output .= '<header>';
    $output .= '<h1>' . get_the_title() . '</h1>';
    $output .= (has_excerpt()) ? '<p class="intro">' . get_the_excerpt() . '</p>' : '';
    $output .= '<p class="leermas">Leer más</p>';
    $output .= '</header>';
    $output .= '</a>';
    $output .= '</article>';

  endwhile;

  wp_reset_query();
  $output .= '</div>';

  $output .= '<div class="posts-navigation"><div class="nav-links centered"><a class="btn" href="/nosotros/">Conoce más de nosotros</a></div></div>';
  $output .= '</section>';

  return $output;
}
add_shortcode('posts-recientes', 'postsrecientes_shortcode');

function shortcode_ab_testing_button() {
  return '<a href="#" class="btn big productLauncher" data-slug="'.basename(get_permalink()).'">Cotizá un seguro a tu medida</a>';
}
add_shortcode('ab-testing-button', 'shortcode_ab_testing_button');
