<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <a href="<?php echo get_permalink(); ?>">
    <?php
    if (has_post_thumbnail($post->ID)) {
      $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'preview');
      echo '<img src="' . $image[0] . '" alt="" />';
    } else {
      echo '<img src="' . get_template_directory_uri() . '/assets/img/default-preview.jpg" alt="" />';
    }
    ?>

    <header class="entry-header">
      <?php
      echo '<h1>' . get_the_title() . '</h1>';
      echo (has_excerpt()) ? '<p class="intro">' . get_the_excerpt() . '</p>' : '';
      echo '<p class="leermas">Leer más</p>';
      ?>
    </header>

  </a>
</article><!-- #post-<?php the_ID(); ?> -->
