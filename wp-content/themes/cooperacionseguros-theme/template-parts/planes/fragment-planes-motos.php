<?php

$guid = $_REQUEST['guid'] ?? get_query_var('guid');
$quote = Quote::get_quote($guid);

if ((!$quote || (isset($quote['product']) && $quote['product'] != 'seguro-de-motos'))) : ?>
  <div class="block block-cotizar">
    <h4>Pensamos en personas como vos, que quieren disfrutar del placer de conducir sin pensar en otra cosa que el camino. Te ofrecemos pólizas especialmente diseñadas para motos de distintas cilindradas.</h4>

    <h2 class="title centered">Beneficios exclusivos</h2>
    <ul class="beneficios">
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/mundo.png" alt="" /> Cobertura en el MERCOSUR</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/moto-alta-gama.png" alt="" /> Coberturas Alta Gama</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/moto.png" alt="" /> Cobertura exclusiva para motos de más de 400cc</li>
      <li><img src="<?php echo get_template_directory_uri(); ?>/assets/img/iconos/features/grua.png" alt="" /> Servicio de auxilio mecánico con la mayor cantidad de kilómetros</li>
    </ul>

    <p class="submit"><a href="#" class="btn big productLauncher" data-slug="seguro-de-motos">Cotizá un seguro a tu medida</a></p>
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
    <?php else : ?>
      <?php
        $file = 'plans-motorbikes.json';
        ['coverages' => $coverages, 'benefits' => $benefits, 'plans' => $plansData] = json_decode(file_get_contents(get_template_directory() . '/data/' . $file), true);
        ['ap' => $ap, 'plans' => $plans, 'recommended' => $recommended] = $rates;

        $priceBasic = number_format(($plans->{$recommended['basic']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');

        if (isset($recommended['medium'])) {
          $priceMedium = number_format(($plans->{$recommended['medium']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
        }

        if (isset($recommended['full'])) {
          $priceFull = number_format(($plans->{$recommended['full']}->premioMensual) + ($ap->premioMensual ?? 0), 0, ',', '.');
        }

        $class = '';
        if (!isset($recommended['full'])) {
          $class = (!isset($recommended['medium'])) ? 'simple' : 'doble';
        }
      ?>

        <section id="cobertura" class="seleccion-de-planes vehiculos transaccional <?php echo $class; ?>">
          <form id="seleccion-de-planes-vehiculos" action="/wordpress/checkout" method="post">
            <div class="desktop"> <!-- START DESKTOP -->
              <div class="opciones header wrap">
                <div class="detail">
                  <h2>Seleccioná un plan <small>para tu <?php echo $quote['answers']['vehicleBrand']; ?> <?php echo $quote['answers']['vehicleVersion']; ?> de <?php echo $quote['answers']['vehicleYear']; ?></small></h2>
                </div>
                <div class="plan basic">
                  <h1>Esencial</h1>
                  <h2 class="price"><sup>$</sup><strong><?php echo $priceBasic; ?></strong> <small>por mes</small></h2>
                  <a href="#" class="btn basic enviar" data-plan="<?php echo $recommended['basic']; ?>">Contratar</a>
                </div>

                <?php if (isset($recommended['medium'])) : ?>
                  <div class="plan medium">
                    <?php if (!isset($recommended['full'])) echo '<h3>Recomendado</h3>'; ?>
                    <h1>Superior</h1>
                    <h2 class="price"><sup>$</sup><strong><?php echo $priceMedium; ?></strong> <small>por mes</small></h2>
                    <a href="#" class="btn medium enviar" data-plan="<?php echo $recommended['medium']; ?>">Contratar</a>
                  </div>
                <?php endif; ?>

                <?php if (isset($recommended['full'])) : ?>
                  <div class="plan full">
                    <h3>Recomendado</h3>
                    <h1>Exclusivo</h1>
                    <h2 class="price"><sup>$</sup><strong><?php echo $priceFull; ?></strong> <small>por mes</small></h2>
                    <a href="#" class="btn full enviar" data-plan="<?php echo $recommended['full']; ?>">Contratar</a>
                  </div>
                <?php endif; ?>
              </div>

              <h2 class="title">Coberturas</h2>
              <?php foreach ($coverages as $coverage) : ?>
                <div class="opciones coberturas wrap">
                  <div class="detail"><?php echo $coverage; ?></div>

                  <?php if (isset($plansData[$recommended['basic']]['coverages'][$coverage])) : ?>
                    <div><span class="on">Incluida</span></div>
                  <?php else : ?>
                    <div><span class="off">No incluida</span></div>
                  <?php endif; ?>


                  <?php if (isset($recommended['medium'])) : ?>
                    <?php if (isset($plansData[$recommended['medium']]['coverages'][$coverage])) : ?>
                      <div><span class="on">Incluida</span></div>
                    <?php else : ?>
                      <div><span class="off">No incluida</span></div>
                    <?php endif; ?>
                  <?php endif; ?>

                  <?php if (isset($recommended['full'])) : ?>
                    <?php if (isset($plansData[$recommended['full']]['coverages'][$coverage])) : ?>
                      <div><span class="on">Incluida</span></div>
                    <?php else : ?>
                      <div><span class="off">No incluida</span></div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>


              <h2 class="title">Beneficios exclusivos</h2>
              <?php foreach ($benefits as $benefit) : ?>
                <div class="opciones beneficios wrap">
                  <?php if ($benefit == "Servicio de auxilio mecánico") : ?>

                    <div class="detail"><?php echo $benefit; ?></div>

                    <?php if (isset($plansData[$recommended['basic']]['benefits'][$benefit]) && $quote['answers']['codRC'] == '73') : ?>
                      <div><?php echo $plansData[$recommended['basic']]['benefits'][$benefit]; ?>km <small>(<?php echo $plansData[$recommended['basic']]['benefits'][$benefit] * 2; ?>km efectivos)</small></div>
                    <?php else : ?>
                      <div><span class="off">No incluida</span></div>
                    <?php endif; ?>

                    <?php if (isset($recommended['medium'])) : ?>
                      <?php if (isset($plansData[$recommended['medium']]['benefits'][$benefit]) && $quote['answers']['codRC'] == '73') : ?>
                        <div><?php echo $plansData[$recommended['medium']]['benefits'][$benefit]; ?>km <small>(<?php echo $plansData[$recommended['medium']]['benefits'][$benefit] * 2; ?>km efectivos)</small></div>
                      <?php else: ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($recommended['full'])) : ?>
                      <?php if (isset($plansData[$recommended['full']]['benefits'][$benefit]) && $quote['answers']['codRC'] == '73') : ?>
                        <div><?php echo $plansData[$recommended['full']]['benefits'][$benefit]; ?>km <small>(<?php echo $plansData[$recommended['full']]['benefits'][$benefit] * 2; ?>km efectivos)</small></div>
                      <?php else: ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                  <?php elseif ($benefit == 'Cobertura en Mercosur') : ?>

                    <div class="detail"><?php echo $benefit; ?></div>

                    <?php if (isset($plansData[$recommended['basic']]['benefits'][$benefit]) && $quote['answers']['codRC'] == '73') : ?>
                      <div><span class="on">Incluida</span></div>
                    <?php else : ?>
                      <div><span class="off">No incluida</span></div>
                    <?php endif; ?>

                    <?php if (isset($recommended['medium'])) : ?>
                      <?php if (isset($plansData[$recommended['medium']]['benefits'][$benefit]) && $quote['answers']['codRC'] == '73') : ?>
                        <div><span class="on">Incluida</span></div>
                      <?php else : ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($recommended['full'])) : ?>
                      <?php if (isset($plansData[$recommended['full']]['benefits'][$benefit]) && $quote['answers']['codRC'] == '73') : ?>
                        <div><span class="on">Incluida</span></div>
                      <?php else : ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                  <?php elseif ($benefit == 'Reposición a nuevo de la unidad') : ?>
                    <div class="detail">
                      <span class="tooltip" title="Para unidades del año en curso"><?php echo $benefit; ?></span>
                    </div>

                    <?php if (isset($plansData[$recommended['basic']]['benefits'][$benefit]) && $quote['answers']['vehicleYear'] == date("Y")) : ?>
                      <div><span class="on">Incluida</span></div>
                    <?php else : ?>
                      <div><span class="off">No incluida</span></div>
                    <?php endif; ?>

                    <?php if (isset($recommended['medium'])) : ?>
                      <?php if (isset($plansData[$recommended['medium']]['benefits'][$benefit]) && $quote['answers']['vehicleYear'] == date("Y")) : ?>
                        <div><span class="on">Incluida</span></div>
                      <?php else : ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($recommended['full'])) : ?>
                      <?php if (isset($plansData[$recommended['full']]['benefits'][$benefit]) && $quote['answers']['vehicleYear'] == date("Y")) : ?>
                        <div><span class="on">Incluida</span></div>
                      <?php else : ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                  <?php else : ?>

                    <div class="detail"><?php echo $benefit; ?></div>

                    <?php if (isset($plansData[$recommended['basic']]['benefits'][$benefit])) : ?>
                      <div><span class="on">Incluida</span></div>
                    <?php else : ?>
                      <div><span class="off">No incluida</span></div>
                    <?php endif; ?>

                    <?php if (isset($recommended['medium'])) : ?>
                      <?php if (isset($plansData[$recommended['medium']]['benefits'][$benefit])) : ?>
                        <div><span class="on">Incluida</span></div>
                      <?php else : ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($recommended['full'])) : ?>
                      <?php if (isset($plansData[$recommended['full']]['benefits'][$benefit])) : ?>
                        <div><span class="on">Incluida</span></div>
                      <?php else : ?>
                        <div><span class="off">No incluida</span></div>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>

          <?php if ($ap->premioMensual) : ?>
            <h2 class="title">Protegé a tu familia</h2>
            <div class="opciones ap wrap">
              <div class="detail">
                <input id="coberturaap" class="togglecoberturaap" name="coberturaap" type="checkbox" value="<?php echo $ap->premioMensual; ?>" checked />
                <label class="checklabel tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de mi familia hasta el tercer grado de consanguinidad que sean transportados eneste vehículo" for="coberturaap">Incluir cobertura para pasajeros</label>
              </div>

              <div><span class="on">Incluir</span></div>

              <?php if (isset($recommended['medium'])) : ?>
                <div><span class="on">Incluir</span></div>
              <?php endif; ?>

              <?php if (isset($recommended['full'])) : ?>
                <div><span class="on">Incluir</span></div>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <div class="opciones footer wrap">
            <div class="detail"> </div>
            <div class="plan basic">
              <h2 class="price"><sup>$</sup><strong><?php echo $priceBasic; ?></strong> <small>por mes</small></h2>
              <a href="#" class="btn basic enviar" data-plan="<?php echo $recommended['basic']; ?>">Contratar</a>
            </div>

            <?php if (isset($recommended['medium'])) : ?>
              <div class="plan medium">
                <h2 class="price"><sup>$</sup><strong><?php echo $priceMedium; ?></strong> <small>por mes</small></h2>
                <a href="#" class="btn medium enviar" data-plan="<?php echo $recommended['medium']; ?>">Contratar</a>
              </div>
            <?php endif; ?>

            <?php if (isset($recommended['full'])) : ?>
              <div class="plan full">
                <h2 class="price"><sup>$</sup><strong><?php echo $priceFull; ?></strong> <small>por mes</small></h2>
                <a href="#" class="btn full enviar" data-plan="<?php echo $recommended['full']; ?>">Contratar</a>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="mobile">
          <ul class="planesmobile">
            <li class="opciones header basic">
              <div class="intro">
                <h1>Plan Esencial</h1>
                <h2 class="price"><sup>$</sup><strong><?php echo $priceBasic; ?></strong> <small>por mes</small></h2>
                <a href="#" class="btn basic enviar" data-plan="<?php echo $recommended['basic']; ?>">Contratar</a>
              </div>

              <?php if ($ap->premioMensual) : ?>
                <div class="checkbox">
                  <input class="togglecoberturaap" name="coberturaap" type="checkbox" value="' . $ap->premioMensual . '" checked />
                  <label class="checklabel" for="coberturaap">Incluir cobertura para pasajeros transportados</label>
                  <i class="fas fa-question-circle tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de mi familia hasta el tercer grado de consanguinidad que sean transportados eneste vehículo"></i>
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

            <?php if (isset($recommended['medium'])) : ?>
              <li class="opciones header medium">
                <div class="intro">
                  <h1>Plan Superior</h1>
                  <h2 class="price"><sup>$</sup><strong><?php echo $priceMedium; ?></strong> <small>por mes</small></h2>
                  <a href="#" class="btn medium enviar" data-plan="<?php $recommended['medium']; ?>">Contratar</a>
                </div>

                <?php if ($ap->premioMensual) : ?>
                  <div class="checkbox">
                    <input class="togglecoberturaap" name="coberturaap" type="checkbox" value="<?php echo $ap->premioMensual; ?>" checked />
                    <label class="checklabel" for="coberturaap">Incluir cobertura para pasajeros</label>
                    <i class="fas fa-question-circle tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de mi familia hasta el tercer grado de consanguinidad que sean transportados eneste vehículo"></i>
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
            <?php endif; ?>

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
                    <input class="togglecoberturaap" name="coberturaap" type="checkbox" value="' . $ap->premioMensual . '" checked />
                    <label class="checklabel" for="coberturaap">Incluir cobertura para pasajeros</label>
                    <i class="fas fa-question-circle tooltip" title="Cobertura adicional de invalidez, muerte y asistencia médico-farmacéutica por accidente para los integrantes de mi familia hasta el tercer grado de consanguinidad que sean transportados eneste vehículo"></i>
                  </div>
                <?php endif; ?>

                <a href="#" class="vermasdetalles">Ver más detalles <i class="fas fa-caret-down"></i></a>

                <ul class="masdetalles">
                  <?php foreach ($coverages as $coverage) : ?>
                    <?php if (isset($plansData[$recommended['full']]['coverages'][$coverage])) : ?>
                      <li><?php echo $coverage; ?></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </li>
            <?php endif; ?>

          </ul>
        </div>

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
      var product = 'seguro-de-motos';
      var commonEvent = {
        'category': category,
        'product': product,
        'vehicleBrand': '<?php echo $quote['answers']['vehicleBrand']; ?>',
        'vehicleYear': '<?php echo $quote['answers']['vehicleYear']; ?>',
        'vehicleVersion': '<?php echo $quote['answers']['vehicleVersion']; ?>',
      };
      var recommended = <?php echo json_encode($recommended) ?>;
      var plans = <?php echo json_encode($plans); ?>;
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

  <?php endif; ?>
<?php endif; ?>
