<?php
  $guid = $_REQUEST['guid'] ?? get_query_var('guid');
  $quote = Quote::get_quote($guid);

  /**
   * Planes de seguros de vida
   */

if ((!$quote || (isset($quote['product']) && $quote['product'] != 'seguro-de-vida-individual'))) : ?>
  <div class="block block-cotizar">
    <h4>Un seguro que contempla los perjuicios económicos que puedan surgir ante la muerte de un miembro de la familia o sostén del hogar, permitiendo que aquellos designados puedan mantener su nivel de vida, proteger la inversión de un negocio, o cancelar deudas.</h4>
    <h2 class="title centered">Beneficios exclusivos</h2>
    <ul class="beneficios">
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/renovacion.png" alt="" /> Renovación automática</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/internacional.png" alt="" /> Cobertura nacional e internacional</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/deductible.png" alt="" /> Cuotas deducibles del impuesto a las ganancias</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/chanchito.png" alt="" /> Flexibilidad en la elección de la suma asegurada</li>
    </ul>
    <p class="submit"><a href="#" class="btn big productLauncher" data-slug="seguro-de-vida-individual">Cotizá un seguro a tu medida</a></p>
  </div>
<?php else :
    $rates = Quote::get_life_insurance_rates($quote);

      $value = $quote['answers']['sumaAsegurada'];

      if (!$rates) {

        echo '<p>Lo sentimos, en este momento no tenemos coberturas disponibles para ofrecerte. Si tenés alguna duda, podés <a href="/contacto">ponerte en contacto con nosotros</a>. </p>';
      } else {
        /**
         * Ahora sí, acá se muestran los planes
         */
        echo '<section id="cobertura" class="seleccion-de-planes vida transaccional">';

        // Todo va contenido en un form, para enviar
        echo '<form id="seleccion-de-planes-vida" action="/checkout" method="post">';

        /**
         * Versión desktop
         */

        echo '<div class="desktop">';

        // Encabezado de los planes
        echo '<div class="opciones header wrap">';

        echo '<div class="detail"><h2>Seleccioná un plan <small>para tu seguro de vida</small></h2></div>';

        echo '<div class="plan basic"><h1>Esencial</h1> <h2 class="price"><sup>$</sup><strong>' . number_format(($rates[0]->premio / 12), 0, ',', '.')  . '</strong> <small>por mes</small></h2> <a href="#" class="btn enviar" data-plan="esencial">Contratar</a></div>';

        echo '<div class="plan medium"><h3>Recomendado</h3><h1>Plus</h1> <h2 class="price"><sup>$</sup><strong>' . number_format(($rates[1]->premio / 12), 0, ',', '.')  . '</strong> <small>por mes</small></h2><a href="#" class="btn enviar" data-plan="plus">Contratar</a></div>';

        echo '</div>';

        // Coberturas
        echo '<h2 class="title">Coberturas disponibles</h2>';

        echo '<div class="opciones coberturas wrap">';
        echo '<div class="detail">Fallecimiento por enfermedad o accidente</div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '</div>';

        echo '<div class="opciones coberturas wrap">';
        echo '<div class="detail">Incapacidad total y permanente por enfermedad o accidente</div>';
        echo '<div><span class="off">Incluido</span></div>';
        echo '<div><span class="on">No incluido</span></div>';
        echo '</div>';

        echo '<div class="opciones coberturas wrap">';
        echo '<div class="detail">Cobertura asegurada</div>';
        echo '<div>$' . number_format($value, 0, ',', '.')  . '</div>';
        echo '<div>$' . number_format($value, 0, ',', '.')  . '</div>';
        echo '</div>';

        echo '<div class="opciones coberturas wrap">';
        echo '<div class="detail">Premio anual</div>';
        echo '<div>$' . number_format($rates[0]->premio, 0, ',', '.')  . '</div>';
        echo '<div>$' . number_format($rates[1]->premio, 0, ',', '.')  . '</div>';
        echo '</div>';

        // Beneficios
        echo '<h2 class="title">Beneficios exclusivos</h2>';

        echo '<div class="opciones beneficios wrap">';
        echo '<div class="detail">Renovación automática</div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '</div>';

        echo '<div class="opciones beneficios wrap">';
        echo '<div class="detail">Cobertura nacional e internacional las 24 horas, los 365 días del año</div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '</div>';

        echo '<div class="opciones beneficios wrap">';
        echo '<div class="detail">Cuotas deducibles del impuesto a las ganancias</div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '<div><span class="on">Incluido</span></div>';
        echo '</div>';

        // Footer de los planes
        echo '<div class="opciones footer wrap">';
        echo '<div class="detail"> </div>';
        echo '<div class="plan basic"><h2 class="price"><sup>$</sup><strong>' . number_format(($rates[0]->premio / 12), 0, ',', '.')  . '</strong> <small>por mes</small></h2> <a href="#" class="btn enviar" data-plan="esencial">Contratar</a></div>';
        echo '<div class="plan medium"><h2 class="price"><sup>$</sup><strong>' . number_format(($rates[1]->premio / 12), 0, ',', '.')  . '</strong> <small>por mes</small></h2><a href="#" class="btn enviar" data-plan="plus">Contratar</a></div>';
        echo '</div>';

        // Close Desktop
        echo '</div class="desktop">';

        /**
         * Versión mobile
         */

        echo '<div class="mobile">';


        echo '<ul class="planesmobile">';

        // Plan eencial
        echo '<li class="opciones header basic">';

        echo '<div class="intro">';
        echo '<h1>Esencial</h1> <h2 class="price"><sup>$</sup><strong>' . number_format(($rates[0]->premio / 12), 0, ',', '.')  . '</strong> <small>por mes</small></h2> <a href="#" class="btn enviar" data-plan="esencial">Contratar</a>';
        echo '</div>';

        // Más detalles
        echo '<ul class="masdetalles ampliado">';
        echo '<li>Fallecimiento por enfermedad o accidente</li>';
        echo '<li>Cobertura asegurada de $' . number_format($value, 0, ',', '.')  . '</li>';
        echo '<li>Premio anual $' . number_format($rates[0]->premio, 0, ',', '.')  . '</li>';
        echo '<li>Cobertura nacional e internacional las 24 horas, los 365 días del año</li>';
        echo '<li>Deducible del Impuesto a las Ganancias</li>';
        echo '</ul>';

        echo '</li>';

        // Plan Plus
        echo '<li class="opciones header medium">';

        echo '<div class="intro">';
        echo '<h3>Recomendado</h3><h1>Plus</h1> <h2 class="price"><sup>$</sup><strong>' . number_format(($rates[1]->premio / 12), 0, ',', '.')  . '</strong> <small>por mes</small></h2><a href="#" class="btn enviar" data-plan="plus">Contratar</a>';
        echo '</div>';

        // Más detalles
        echo '<ul class="masdetalles ampliado">';
        echo '<li>Fallecimiento por enfermedad o accidente</li>';
        echo '<li>Incapacidad total y permanente por enfermedad o accidente</li>';
        echo '<li>Cobertura asegurada de $' . number_format($value, 0, ',', '.')  . '</li>';
        echo '<li>Premio anual $' . number_format($rates[1]->premio, 0, ',', '.')  . '</li>';
        echo '<li>Cobertura nacional e internacional las 24 horas, los 365 días del año</li>';
        echo '<li>Deducible del Impuesto a las Ganancias</li>';
        echo '</ul>';

        echo '</li>';

        echo '</ul>';

        // Close Mobile
        echo '</div>';

        // Inputs ocultos con la data que falta
        echo '<input type="hidden" name="guid" value="' . $quote['guid'] . '" />';

        // Plan
        echo '<input type="hidden" name="planCobertura" value="0" />';

        echo '</form>';

        echo '</section>';

        // Incluir tracking
        track_script($quote['guid']);
      }

  endif; ?>
