<?php
get_header();
if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    echo '<div class="wp-block-cover has-background-dim has-parallax"';
    if (has_post_thumbnail($post->ID)) {
      $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'cover');
      echo ' style="background-image:url(' . $image[0] . ')"';
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


    echo '<div class="entry-content">';
    the_content();
    echo '</div>';

  endwhile;
endif;
get_footer();
