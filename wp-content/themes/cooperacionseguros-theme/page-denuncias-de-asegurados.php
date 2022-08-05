<?php
get_header();
$accion = (isset($_GET['accion'])) ? $_GET['accion'] : null;
?>

<section id="denuncias-de-asegurados">
  <?php
  if (have_posts()) :
    while (have_posts()) :
      the_post();
      echo '<div class="introduccion">';
      echo '<header class="header">';
      echo '<h1>' . get_the_title() . '</h1>';
      echo '</header>';
      get_template_part('template-parts/content', get_post_type());
      echo '</div>';
    endwhile;
  endif;
  ?>
</section>

<?php
get_footer();
