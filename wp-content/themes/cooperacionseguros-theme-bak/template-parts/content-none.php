<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grupo_Upgrade
 */

?>

<section class="no-results not-found">

<div class="wrap">
  <header class="page-header">
    <h1 class="page-title">No se ha encontrado el contenido</h1>
  </header><!-- .page-header -->

  <div class="page-content">
    <?php if (is_search()) : ?>
      <p>Lo sentimos, no hay contenidos que coincidan con tu búsqueda.</p>
    <?php else : ?>
      <p>Lo sentimos, el contenido solicitado no existe o ha sido movido.</p>
    <?php endif; ?>
      <p><a class="btn" href="/">Volver al inicio</a></p>
  </div><!-- .page-content -->
</div>

</section><!-- .no-results -->
