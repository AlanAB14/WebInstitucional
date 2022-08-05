<div id="quiero-que-me-llamen" class="entry-content">
  <div class="wrap">
    <?php /*
    <h4>¿Necesitas ayuda? ¿Tenés alguna duda acerca de nuestros productos y servicios?
      Dejanos tu teléfono y un asesor se pondrá en contacto a la brevedad</h4>

    <form id="llamenme">
      <p>
        <label for="llamenNombre">Tu nombre</label>
        <input type="text" name="llamenNombre" id="llamenNombre" />
      </p>
      <p>
        <label for="llamenTelefono">Tu teléfono</label>
        <input type="text" name="llamenTelefono" id="llamenTelefono" />
      </p>

      <p class="submit">
        <button class="btn">Enviar</button>
        <input type="hidden" name="tipo" value="llamenme" />
      </p>

    </form>

    <div class="extra">
      <p>También podés contactarnos por teléfono: <strong><?php echo get_theme_mod('custom_option_phone'); ?></strong></p>
      <p>E-mail: <a href="mailto:<?php echo get_theme_mod('custom_option_email'); ?>"><?php echo get_theme_mod('custom_option_email'); ?></a></p>
      <p>Horario de atención: Lunes a Viernes de 7 a 20 hs.</p>
    </div>
    */ ?>

    <iframe src="https://s07.ysocial.net:8090/a94d7b957412f94d9bd4e3db26f0b38082a5b1aa/a409826a-4d2e-423f-b5ce-78f19b6c57da/chat" frameborder="0" scrolling="no"></iframe>

    <div class="closeModal toggleLlamen"></div>
  </div>
</div>

</main>

<footer id="footer">

  <div class="wrap">

    <?php if ((basename(get_permalink()) != 'checkout') && (basename(get_permalink()) != 'contratar')) { ?>
      <div class="productos">
        <h4>Nuestros seguros</h4>
        <ul id="product-menu">
          <li>
            <strong>Personas</strong>
            <?php show_product_linked_list('personas'); ?>
            <strong>Agro</strong>
            <?php show_product_linked_list('agro'); ?>
          </li>
          <li>
            <strong>Grandes Empresas</strong>
            <?php show_product_linked_list('grandes-empresas'); ?>
            <strong>PYMEs y Comercios</strong>
            <?php show_product_linked_list('pymes-y-comercios'); ?>
            <strong>Trabajadores Autónomos</strong>
            <?php show_product_linked_list('trabajadores-autonomos'); ?>
          </li>
        </ul>
      </div>

      <div class="usuarios">
        <h4>Usuarios</h4>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'menu-usuarios',
          'menu_id'        => 'menu-usuarios',
          'container_id' => 'menu-usuarios-container'
        ));
        ?>
        <h4>Productores</h4>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'menu-productores',
          'menu_id'        => 'menu-productores',
          'container_id' => 'menu-productores-container'
        ));
        ?>

      </div>

    <?php } ?>

    <div class="contacto">
      <?php

      if (theme_get_custom_logo()) echo '<img src="' . theme_get_custom_logo() . '" class="site-logo" alt="' . htmlspecialchars(get_bloginfo('name')) . '" />';

      echo '<div>';
      if (get_theme_mod('custom_option_address')) echo '<p>' . get_theme_mod('custom_option_address') . '</p>';
      if (get_theme_mod('custom_option_phone')) echo '<p>Atención al cliente: ' . get_theme_mod('custom_option_phone') . '</p>';
      // if (get_theme_mod('custom_option_email')) echo '<p><a href="mailto:' . get_theme_mod('custom_option_email') . '">' . get_theme_mod('custom_option_email') . '</a></p>';

      echo '<p class="copyright"> &copy; ' . date('Y') . ' ' . get_bloginfo('name') . '</p>';
      echo '</div>';

      echo '<p class="qr"><a href="https://www.argentina.gob.ar/aaip/datospersonales/reclama/30500047174--RL-2019-54637857-APN-DNPDP#AAIP"> <img src="https://www.argentina.gob.ar/sites/default/files/aaip-isologo.png" alt="AAIP RNBD"></a></p>';

      echo '<p class="social">';
      if (get_theme_mod('custom_option_whatsapp')) echo '<a target="_blank" href="https://wa.me/' . get_theme_mod('custom_option_whatsapp') . '"><i class="fab fa-whatsapp"></i></a>';
      if (get_theme_mod('custom_option_facebook')) echo '<a target="_blank" href="' . get_theme_mod('custom_option_facebook') . '"><i class="fab fa-facebook-square"></i></a>';
      if (get_theme_mod('custom_option_instagram')) echo '<a target="_blank" href="' . get_theme_mod('custom_option_instagram') . '"><i class="fab fa-instagram"></i></a>';
      if (get_theme_mod('custom_option_twitter')) echo '<a target="_blank" href="' . get_theme_mod('custom_option_twitter') . '"><i class="fab fa-twitter"></i></a>';
      if (get_theme_mod('custom_option_linkedin')) echo '<a target="_blank" href="' . get_theme_mod('custom_option_linkedin') . '"><i class="fab fa-linkedin"></i></a>';
      if (get_theme_mod('custom_option_youtube')) echo '<a target="_blank" href="' . get_theme_mod('custom_option_youtube') . '"><i class="fab fa-youtube"></i></a>';
      echo '</p>';


      ?>
    </div>

  </div>

</footer>

<div class="privacidad">
  <p class="fraude wrap">
    <a href="/prevencion-del-fraude/">Prevención del fraude</a>
    <a href="/prevencion-de-lavados-de-activos-y-financiacion-del-terrorismo/">Prevención de lavados de activos y financiación del terrorismo</a>
  </p>
  <p class="wrap">El titular de los datos personales tiene la facultad de ejercer el derecho de acceso a los mismos en forma gratuita a intervalos no inferiores a seis meses, salvo que se acredite un interés legítimo al efecto conforme lo establecido en el artículo 14, inciso 3 de la Ley Nº 25.326. La AGENCIA DE ACCESO A LA INFORMACIÓN PÚBLICA, Órgano de Control de la Ley Nº 25.326, tiene la atribución de atender las denuncias y reclamos que se interpongan con relación al cumplimiento de las normas sobre protección de datos personales. La ley 25.326 tiene por objeto la protección integral de los datos personales asentados en archivos, registros, bancos de datos, u otros medios técnicos de tratamiento de datos, sean éstos públicos, o privados destinados a dar informes, para garantizar el derecho al honor y a la intimidad de las personas, así como también el acceso a la información que sobre las mismas se registre, de conformidad a lo establecido en el artículo 43, párrafo tercero de la Constitución Nacional.</p>
  <p class="wrap"><a href="<?php echo get_privacy_policy_url(); ?>">Política de Privacidad & Condiciones Generales de Uso</a></p>
</div>

<div id="ssn" class="nuevo-footer" style="display: flex;flex-direction: column;">

  <div class="cols footer-ssn">
    <p style="display: flex;flex-direction: column;justify-content: center;">N° de Inscripción de SSN <br> <span style="font-weight: bold">Rubro 0196</span></p>
    <p class="border-none">Departamento de Orientación<br />y Asistencia al Asegurado</p>
    <p><span class="ssn-color-bold">0800-666-8400</span></p>
    <p class="ssn-color-bold">www.argentina.gob.ar/ssn</p>
    <p class="border-none logo-ssn-nuevo-footer"><img src="<?= get_template_directory_uri(); ?>/assets/img/logo-ssn.png" class="img-logo-ssn" alt="SSN" /></p>
  </div>

  <div class="end footer-nuevo-end">
    <div class="end-box-1">
        <p class="end-box-1-text">La entidad aseguradora dispone de un <span style="font-weight: bold;">Servicio de Atención al Asegurado</span> que atenderá las consultas y reclamos que
        presenten los tomadores de seguros, asegurados, beneficiarios y/o derechohabientes. <br><br>
        En caso de que existiera un reclamo ante la entidad aseguradora y que el mismo no haya sido resuelto o haya sido
        desestimado, total o parcialmente, o que haya sido denegada su admisión, podrá comunicarse con la
        Superintendencia de Seguros de la Nación por teléfono al 0800-666-8400, correo electrónico a <span style="font-weight: bold;">consultas@ssn.gob.ar</span>
        o formulario disponible en la página <span style="font-weight: bold;">www.argentina.gob.ar/ssn</span></p>
    </div>
    <div class="end-box-2">
        <p><span style="font-weight: bold;">El Servicio de Atención al Asegurado está integrado por:</span>
          <br><br>
        RESPONSABLE  <span style="font-weight: bold;">Sr. Barrios, Alejandro Daniel</span>
        TELÉFONO 03462-435100 / 435200 INTERNO 1251
        <br><br>
        SUPLENTE <span style="font-weight: bold;">Sra. Fatila, Valeria Graciela</span>
        TELÉFONO 03462-435100 / 435200 INTERNO 1574</p>
    </div>
  </div>

</div>

<?php wp_footer(); ?>

</div>

<p id="llamenButton">
  <a class="btn toggleLlamen" href="#"><span>Chateá con nosotros</span><i class="fas fa-comment-alt"></i></a>
</p>

<?php if (get_theme_mod('custom_option_whatsapp')) { ?>
  <p id="whatsappButton">
    <a class="btn" target="_blank" href="https://wa.me/<?php echo get_theme_mod('custom_option_whatsapp'); ?>"><i class="fab fa-whatsapp"></i></a>
  </p>
<?php } ?>

</body>

</html>
