<?php
get_header();
?>
<div id="primary" class="content-area">

  <?php

  if (have_posts()) :
    echo '<section class="posts recent-posts archive entry-content">';

    echo '<div class="wp-block-cover has-background-dim has-parallax" style="background-image:url(' . get_template_directory_uri() . '/assets/img/header-novedades.jpg)">';
    echo '<div class="wp-block-cover__inner-container">';
    echo '<h1>';

    // Título según tipo de contenido
    if (is_tag()) {
      echo single_tag_title('', 0);
    } elseif (is_category()) {
      echo single_cat_title('', 0);
    } elseif (is_day()) {
      echo 'Archivo: ' . get_the_time('d \d\e m \d\e Y');
    } elseif (is_month()) {
      echo 'Archivo: ' . get_the_time('F \d\e Y');
    } elseif (is_year()) {
      echo 'Archivo: ' . get_the_time('Y');
    } elseif (is_search()) {
      echo 'Búsqueda: ' . get_search_query();
    } else {
      echo 'Novedades';
    }

    // Hace falta sumar el número de página al título?
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if ($paged > 1) echo ' &mdash; Página ' . $paged;

    echo '</h1>';

    echo '</div>';
    echo '</div>';

    echo '<div class="wrap">';

    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content', get_post_type());
    endwhile;
    echo '</div>';
    the_posts_navigation();
    echo '</section>';

  else :
    get_template_part('template-parts/content', 'none');
  endif;
  ?>

</div>

<?php
//get_sidebar();
get_footer();
