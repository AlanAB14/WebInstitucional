<?php

/**
 * Custom shortcodes
 */

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
  get_template_part('template-parts/blocks/block-planes');
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

  $output .= '<div class="posts-navigation"><div class="nav-links centered"><a class="btn" href="/novedades/">Ver todas las novedades</a></div></div>';
  $output .= '</section>';

  return $output;
}
add_shortcode('posts-recientes', 'postsrecientes_shortcode');