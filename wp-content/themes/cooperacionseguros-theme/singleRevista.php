<?php
get_header();
if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    echo '<div class="wp-block-cover has-parallax"';
    if (has_post_thumbnail($post->ID)) {
      echo ' style="background-image:url('.get_template_directory_uri().'/assets/img/fondos/entrevistas.jpg); background-size: cover"';
    }
    echo ' >';
    echo '<div class="wp-block-cover__inner-container">';
    echo '<h1>'. get_the_title() .'</h1>';
    echo '</div>';
    echo '</div>';

    echo '<div class="postinfo">';
      echo '<div class="wrap">';
        echo '<time>Publicado el '. get_the_date() .'</time>';
        the_category(', ');
      echo '</div>';
    echo '</div>';

    
    echo '<div class="grid-entrevistas">';
      echo '<div class="entry-content">';
        echo '<div class="img_dentro_entrevista">';
        if (class_exists('MultiPostThumbnails')):
        MultiPostThumbnails::the_post_thumbnail(get_post_type(),'secondary-image');
        endif;
        echo '</div>';
        the_content();
      echo '</div>';
      echo '<div class="noticias-relacionadas">';
        echo '<p class="title-block">Notas relacionadas</p>';
        if ( function_exists( 'wpsp_display' ) ) wpsp_display( $shortcode );
      echo '</div>';
    echo '</div>';
  endwhile;
endif;
get_footer();
