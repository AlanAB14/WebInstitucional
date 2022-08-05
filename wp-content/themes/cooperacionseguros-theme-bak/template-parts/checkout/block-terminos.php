<div id="terminos" class="entry-content">
  <div class="wrap">

    <h2>Términos y Condiciones del Sitio Web de contratación de Pólizas de Automóviles con Cooperación Mutual Patronal S.M.S.G</h2>

    <div class="content">

      <?php
        $contenido = get_posts(array('name' => 'terminos-y-condiciones', 'post_type' => 'page'));
        if ($contenido) {
          echo $contenido[0]->post_content;
        }
      ?>

      <p class="end"><a class="btn toggleTerminos" href="#">Cerrar</a></p>

    </div>

    <div class="closeModal toggleTerminos"></div>
  </div>
</div>
