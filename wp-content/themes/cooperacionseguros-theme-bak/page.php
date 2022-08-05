<?php
get_header();
?>
<div id="primary" class="content-area">
  <?php
  if (have_posts()) :
    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content', get_post_type());
    endwhile;
  endif;

  ?>
</div>

<?php
//get_sidebar();
get_footer();
