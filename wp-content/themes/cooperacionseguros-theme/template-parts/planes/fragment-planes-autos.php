<?php

$guid = $_REQUEST['guid'] ?? get_query_var('guid');
$quote = Quote::get_quote($guid);

if (!$quote || (isset($quote['product']) && $quote['product'] != 'seguro-de-autos-y-pick-ups')) : ?>
  <div class="block block-cotizar">
    <h4>Partiendo de una cobertura básica como la obligatoria de Responsabilidad Civil, hasta cubrir los daños totales y parciales que pueda sufrir tu vehículo, nuestros planes están pensados para proteger a tu vehículo de acuerdo a tus necesidades.</h4>
    <h2 class="title centered">Beneficios exclusivos</h2>
    <ul class="beneficios">
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/mundo.png" alt="" /> Cobertura en países limítrofes</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/granizo.png" alt="" />  Cobertura de daños por granizo</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/grua.png" alt="" /> Servicio de auxilio mecánico con la mayor cantidad de kilómetros</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/reposicion.png" alt="" /> Reposición de parabrisas, lunetas o cristales</li>
    </ul>

    <p class="submit"><a href="#" class="btn big productLauncher" data-slug="seguro-de-autos-y-pick-ups">Cotizá un seguro a tu medida</a></p>
  </div>
<?php elseif (isset($quote['idPropuesta'])) : ?>
  <div class="entry-content">
    <h2 class="title">¡Hola <strong><?php echo $quote['nombre']; ?></strong>!</h2>
    <p>Tu vehículo <strong><?php echo $quote['vehiculos'][0]['marca'] . ' ' . $quote['vehiculos'][0]['modelo'] ?></strong> ya tiene asignada una propuesta.</p>
    <p>Te pedimos por favor que te contactes con Atención al Cliente para confirmar la compra y realizar el pago: <strong>0800-777-7070, de lunes a viernes de 7.00 a 20 hs</strong>.</p>
    <p>¡Muchas gracias!</p>
    <p class="block block-contratar"><a href="/" class="btn">Volver al inicio</a></p>
  </div>
<?php else :
  $rates = Quote::get_vehicle_rates($quote);

  if (!$rates) : ?>
    <p>Lo sentimos, en este momento no tenemos coberturas disponibles para tu <strong><?php echo $quote['answers']['vehicleBrand'] . ' ' . $quote['answers']['vehicleVersion']; ?></strong> de <strong><?php echo $quote['answers']['vehicleYear'] ?></strong>. Si tenés alguna duda, podés <a href="/contacto">ponerte en contacto con nosotros</a>. </p>
  <?php else :
      $file = 'plans-cars.json';
      ['assistances' => $assistances, 'coverages' => $coverages, 'benefits' => $benefits, 'plans' => $plansData] = json_decode(file_get_contents(get_template_directory() . '/data/' . $file), true);
      ['ap' => $ap, 'plans' => $plans, 'recommended' => $recommended, 'full' => $full] = $rates;

      $priceBasic = number_format(($plans->{$recommended['basic']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
      $priceMedium = number_format(($plans->{$recommended['medium']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
      if (isset($recommended['full'])) {
        $priceFull = number_format(($plans->{$recommended['full']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
      }
    ?>

    <section id="cobertura" class="seleccion-de-planes vehiculos transaccional <?php echo !isset($recommended['full']) ? 'doble' : null; ?>">
      <form id="seleccion-de-planes-vehiculos" action="/wordpress/checkout/" method="post">
        <div class="desktop"> <!-- START DESKTOP -->
          <div class="opciones header wrap">
            <div class="detail">
              <h2>Seleccioná un plan <small>para tu <?php echo $quote['answers']['vehicleBrand'] . ' ' . $quote['answers']['vehicleModel'] . ' de ' . $quote['answers']['vehicleYear']; ?></small></h2>
            </div>

            <div class="plan basic">
              <h1>Esencial</h1>
              <h2 class="price"><sup>$</sup><strong><?php echo $priceBasic; ?></strong> <small>por mes</small></h2>
              <a href="#" class="btn basic enviar" data-plan="<?php echo $recommended['basic']; ?>">Contratar</a>
            </div>

            <div class="plan medium">
              <?php if (!isset($recommended['full'])) echo '<h3>Recomendado</h3>'; ?>
              <h1>Superior</h1>
              <h2 class="price"><sup>$</sup><strong><?php echo $priceMedium; ?></strong> <small>por mes</small></h2>
              <a href="#" class="btn medium enviar" data-plan="<?php echo $recommended['medium']; ?>">Contratar</a>
            </div>

            <?php if (isset($recommended['full'])): ?>
              <div class="plan full">
                <h3>Recomendado</h3>
                <h1>Exclusivo</h1>
                <h2 class="price"><sup>$</sup><strong><?php echo $priceFull; ?></strong> <small>por mes</small></h2>
                <a href="#" class="btn full enviar" data-plan="<?php echo $recommended['full']; ?>">Contratar</a>
              </div>
            <?php endif; ?>
          </div>

          <h2 class="title">Auxilio Mecánico</h2>
          <?php foreach ($assistances as $asistance) : ?>
            <div class="opciones beneficios wrap">
              <?php if ($asistance == "Servicio de grúa") : ?>
                <div class="detail"><?php echo $asistance; ?></div>

                <div><?php echo $plansData[$recommended['basic']]['assistances'][$asistance]; ?> km <small>(<?php echo $plansData[$recommended['basic']]['assistances'][$asistance] * 2; ?> km efectivos)</small></div>

                <div><?php echo $plansData[$recommended['medium']]['assistances'][$asistance]; ?> km <small>(<?php echo $plansData[$recommended['medium']]['assistances'][$asistance] * 2; ?> km efectivos)</small></div>

                <?php if (isset($recommended['full'])) : ?>
                  <div class="selectdiv">
                    <select id="coberturagrua" class="coberturagrua" name="coberturagrua">
                      <?php if (!empty($full['limited300'])) : ?>
                        <option name="fulltier" value="limited300">300km (600km efectivos)</option>
                      <?php endif; ?>
                      <?php if (!empty($full['limited400'])) : ?>
                        <option name="fulltier" value="limited400" selected>400km (800km efectivos)</option>
                      <?php endif; ?>
                      <?php if (!empty($full['unlimited'])) : ?>
                        <option name="fulltier" value="unlimited">Ilimitada</option>
                      <?php endif; ?>
                    </select>
                  </div>
                <?php endif; ?>

              <?php endif; ?>
            </div>
          <?php endforeach; ?>

          <h2 class="title">Coberturas</h2>

          <?php foreach ($coverages as $coverage) : ?>
            <div class="opciones coberturas wrap">
              <div class="detail"><?php echo $coverage; ?></div>

              <?php if (isset($plansData[$recommended['basic']]['coverages'][$coverage])) : ?>
                <div><span class="on">Incluida</span></div>
              <?php else : ?>
                <div><span class="off">No incluida</span></div>
              <?php endif; ?>

              <?php if (isset($plansData[$recommended['medium']]['coverages'][$coverage])) : ?>
                <div><span class="on">Incluida</span></div>
              <?php else : ?>
                <div><span class="off">No incluida</span></div>
              <?php endif; ?>

              <?php if (isset($recommended['full'])) : ?>
                <div><span class="on">Incluida</span></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>


          <h2 class="title">Beneficios exclusivos</h2>

          <?php foreach ($benefits as $benefit) : ?>
            <div class="opciones beneficios wrap">

            <?php if ($benefit == "Franquicia para daños parciales") : ?>
              <div class="detail"><span class="tooltip" title="En caso de daños parciales por accidente, el importe detallado queda a cargo del asegurado y el resto a cargo de la Compañía"><?php echo $benefit; ?></span></div>

              <div><span class="off">No disponible</span></div>

              <div><span class="off">No disponible</span></div>

              <?php if (isset($recommended['full'])) : ?>
                <div class="selectdiv">
                  <select id="coberturafranquicia" name="coberturafranquicia">
                    <option value="">Cargando...</option>
                  </select>
                </div>
              <?php endif; ?>
            <?php else : ?>
              <div class="detail"><?php echo $benefit; ?></div>

              <?php if (isset($plansData[$recommended['basic']]['benefit'][$benefit])) : ?>
                <div><span class="on">Incluida</span></div>
              <?php else : ?>
                <div><span class="off">No incluida</span></div>
              <?php endif; ?>

              <?php if (isset($plansData[$recommended['medium']]['benefits'][$benefit])) : ?>
                <div><span class="on">Incluida</span></div>
              <?php else : ?>
                <div><span class="off">No incluida</span></div>
              <?php endif; ?>

              <?php if (isset($recommended['full'])) : ?>
                <div><span class="on">Incluido</span></div>
              <?php endif; ?>
            <?php endif; ?>

            </div>
          <?php endforeach; ?>

          <?php if ($ap->premioMensual) : ?>
            <h2 class="title">Protegé a tu familia</h2>
            <div class="opciones ap wrap">

            <div class="detail"><input id="coberturaap" class="togglecoberturaap" name="coberturaap" type="checkbox" value="<?php echo $ap->premioMensual; ?>" checked /><label class="checklabel tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de la familia hasta el tercer grado de consanguinidad que sean transportados en el vehículo." for="coberturaap">Incluir cobertura para pasajeros transportados</label></div>

            <div><span class="on">Incluir</span></div>
            <div><span class="on">Incluir</span></div>

            <?php if (isset($recommended['full'])) : ?>
              <div><span class="on">Incluir</span></div>
            <?php endif; ?>
            </div>
          <?php endif; ?>

          <div class="opciones footer wrap">
            <div class="detail"> </div>
            <div class="plan basic"><h2 class="price"><sup>$</sup><strong><?php echo $priceBasic; ?></strong> <small>por mes</small></h2> <a href="#" class="btn basic enviar" data-plan="<?php echo $recommended['basic']; ?>">Contratar</a></div>
            <div class="plan medium"><h2 class="price"><sup>$</sup><strong><?php echo $priceMedium; ?></strong> <small>por mes</small></h2><a href="#" class="btn medium enviar" data-plan="<?php echo $recommended['medium']; ?>">Contratar</a></div>
            <?php if (isset($recommended['full'])) : ?>
              <div class="plan full"><h2 class="price"><sup>$</sup><strong><?php echo $priceFull; ?></strong> <small>por mes</small></h2> <a href="#" class="btn full enviar" data-plan="<?php echo $recommended['full']; ?>">Contratar</a></div>
            <?php endif; ?>
          </div>

        </div> <!-- END DESKTOP -->


        <div class="mobile"> <!-- START MOBILE -->
          <ul class="planesmobile">
            <li class="opciones header basic">
              <div class="intro">
                <h1>Plan Esencial</h1> <h2 class="price"><sup>$</sup><strong><?php echo $priceBasic; ?></strong> <small>por mes</small></h2> <a href="#" class="btn basic enviar" data-plan="<?php echo $recommended['basic']; ?>">Contratar</a>
              </div>

              <?php if ($ap->premioMensual) : ?>
                <div class="checkbox">
                  <input class="togglecoberturaap" name="coberturaap" type="checkbox" value="<?php echo $ap->premioMensual; ?>" checked />
                  <label class="checklabel" for="coberturaap">Incluir cobertura para pasajeros transportados</label>
                  <span class="tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de la familia hasta el tercer grado de consanguinidad que sean transportados en el vehículo."><i class="fas fa-question-circle"></i></span>
                </div>
              <?php endif; ?>

              <a href="#" class="vermasdetalles">Ver más detalles <i class="fas fa-caret-down"></i></a>
              <ul class="masdetalles">
                <?php foreach ($coverages as $coverage) : ?>
                  <?php if (isset($plansData[$recommended['basic']]['coverages'][$coverage])) : ?>
                    <li><?php echo $coverage; ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </li>

            <li class="opciones header medium">
              <div class="intro">
                <h1>Plan Superior</h1>
                <h2 class="price"><sup>$</sup><strong><?php echo $priceMedium; ?></strong> <small>por mes</small></h2>
                <a href="#" class="btn medium enviar" data-plan="<?php echo $recommended['medium']; ?>">Contratar</a>
              </div>

              <?php if ($ap->premioMensual) : ?>
                <div class="checkbox">
                  <input class="togglecoberturaap" name="coberturaap" type="checkbox" value="<?php echo $ap->premioMensual; ?>" checked />
                  <label class="checklabel" for="coberturaap">Incluir cobertura para pasajeros transportados</label>
                  <span class="tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de la familia hasta el tercer grado de consanguinidad que sean transportados en el vehículo."><i class="fas fa-question-circle"></i></span>
                </div>
              <?php endif; ?>

              <a href="#" class="vermasdetalles">Ver más detalles <i class="fas fa-caret-down"></i></a>
              <ul class="masdetalles">
                <?php foreach ($coverages as $coverage) : ?>
                  <?php if (isset($plansData[$recommended['medium']]['coverages'][$coverage])) : ?>
                    <li><?php echo $coverage; ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </li>

            <?php if (isset($recommended['full'])) : ?>
              <li class="opciones header full">

              <div class="intro">
                <h3>Recomendado</h3>
                <h1>Plan Exclusivo</h1>
                <h2 class="price"><sup>$</sup><strong><?php echo $priceFull; ?></strong> <small>por mes</small></h2>
                <a href="#" class="btn full enviar" data-plan="<?php echo $recommended['full']; ?>">Contratar</a>
              </div>

              <?php if ($ap->premioMensual) : ?>
                <div class="checkbox">
                  <input class="togglecoberturaap" name="coberturaap" type="checkbox" value="<?php echo $ap->premioMensual; ?>" checked />
                  <label class="checklabel" for="coberturaap">Incluir cobertura para pasajeros transportados</label>
                  <span class="tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de la familia hasta el tercer grado de consanguinidad que sean transportados en el vehículo."><i class="fas fa-question-circle"></i></span>
                </div>
              <?php endif; ?>

              <label class="label">Servicio de grúa</label>
              <div class="selectdiv">
                <select id="coberturagruaMobile" name="coberturagrua">
                  <?php if (!empty($full)) : ?>
                    <?php if (!empty($full['limited300'])) : ?>
                      <option name="fulltier" value="limited300">300km (600km efectivos)</option>
                    <?php endif; ?>
                    <?php if (!empty($full['limited400'])) : ?>
                      <option name="fulltier" value="limited400" selected>400km (800km efectivos)</option>
                    <?php endif; ?>
                    <?php if (!empty($full['unlimited'])) : ?>
                      <option name="fulltier" value="unlimited">Ilimitada</option>
                    <?php endif; ?>
                  <?php endif; ?>
                </select>
              </div>

              <label class="label">Franquicia para daños parciales</label>
              <div class="selectdiv">
                <select id="coberturafranquiciaMobile" name="coberturafranquicia">
                  <option value="">Cargando...</option>
                </select>
              </div>


              <a href="#" class="vermasdetalles">Ver más detalles <i class="fas fa-caret-down"></i></a>
              <ul class="masdetalles">
                <?php foreach ($coverages as $coverage) : ?>
                  <li><?php echo $coverage; ?></li>
                <?php endforeach; ?>
              </ul>

              </li>
            <?php endif; ?>
          </ul>
        </div> <!-- END MOBILE -->

        <input type="hidden" name="product" value="<?php echo $quote['product']; ?>" />
        <input type="hidden" name="guid" value="<?php echo $quote['guid']; ?>" />

        <input type="hidden" name="planCobertura" value="0" />
        <input type="hidden" name="planSuma" value="0" />
        <input type="hidden" name="planPremio" value="0" />
        <input type="hidden" name="planPrima" value="0" />
        <input type="hidden" name="planFechaInicio" value="0" />
        <input type="hidden" name="planFechaFin" value="0" />
        <input type="hidden" name="planPremioMensual" value="0" />
        <input type="hidden" name="planPremioReferencia" value="0" />
        <input type="hidden" name="planFranquicia" value="0" />

        <input type="hidden" name="codigoConvenio" value="0" />
        <input type="hidden" name="bonusMaxConvenio" value="0" />
        <input type="hidden" name="bonusMaxAntiguedad" value="0" />
        <input type="hidden" name="bonusMaxSuma" value="0" />

        <?php if ($ap->premioMensual) : ?>
          <input type="hidden" class="dataAp" name="apOnOff" value="on" />
          <input type="hidden" class="dataAp" name="apIdProducto" value="<?php echo $ap->idProducto; ?>" />
          <input type="hidden" class="dataAp" name="apIdPlantSuscWebCab" value="<?php echo $ap->idPlantSuscWebCab; ?>" />
          <input type="hidden" class="dataAp" name="apPremio" value="<?php echo $ap->premio; ?>" />
          <input type="hidden" class="dataAp" name="apPremioMensual" value="<?php echo $ap->premioMensual; ?>" />
          <input type="hidden" class="dataAp" name="apPrima" value="<?php echo $ap->prima; ?>" />
        <?php endif; ?>

        <div class="recordatorio">Recordá que para contratar tu seguro vas a necesitar tener a mano tu cédula azul o verde, además de tener acceso a fotos actuales del vehículo.</div>
      </form>
    </section>

    <script>
      var category = 'vehiculos';
      var product = 'seguro-de-autos-y-pick-ups';
      var commonEvent = {
        'category': category,
        'product': product,
        'vehicleBrand': '<?php echo $quote['answers']['vehicleBrand']; ?>',
        'vehicleModel': '<?php echo $quote['answers']['vehicleModel']; ?>',
        'vehicleYear': '<?php echo $quote['answers']['vehicleYear']; ?>',
        'vehicleVersion': '<?php echo $quote['answers']['vehicleVersion']; ?>',
      };
      var recommended = <?php echo json_encode($recommended) ?>;
      var plans = <?php echo json_encode($plans); ?>;
      var full = <?php echo json_encode($full) ?>;
      var ap = <?php echo json_encode($ap); ?>;

      pushDataLayer({
        'event': 'trackEcommerceCheckPricing',
        ...commonEvent,
      });
    </script>

    <?php echo track_script($quote['guid']); ?>

    <script>
      gtag("event", "enviar", {
        event_category: "page-load",
        event_label: "pimer-paso",
        value: "0",
      });
    </script>
  <?php endif;
endif; ?>
