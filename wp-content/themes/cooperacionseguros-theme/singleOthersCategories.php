<?php
get_header();
if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    echo '<div class="wp-block-cover has-parallax"';
    if (has_post_thumbnail($post->ID)) {
      echo ' style="background-image:url(../../../../wp-content/themes/cooperacionseguros-theme/assets/img/fondos/'. $path_img .'); background-size: cover"';
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
        the_content();
        echo '<div class="box_button">';
          echo '<a class="link_button" href="./../../../../revista"><img class="img_button_return" src="../../../../wp-content/themes/cooperacionseguros-theme/assets/img/button-back/boton-back-02.png"/></a>';
        echo '</div>';
      echo '</div>';
      echo '<div class="noticias-relacionadas">';
        echo '<p class="title-block">Notas relacionadas</p>';
        if ( function_exists( 'wpsp_display' ) ) wpsp_display( $shortcode );
      echo '</div>';
    echo '</div>';
  endwhile;
endif;
get_footer();
