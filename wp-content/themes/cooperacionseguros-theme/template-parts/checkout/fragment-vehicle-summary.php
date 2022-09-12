    <form action="" method="POST" id="vehicle-summary">

      <legend>Si todos los datos que registramos son correctos, ya podés contratar tu póliza.</legend>

      <div class="row">

        <div class="col-md-4">
          <h3>Datos sobre vos</h3>
          <dl>
            <dt>DNI</dt>
            <dd><?php echo number_format($args['quote']['datos-solicitante']['num_dni'], 0, ',', '.') ?></dd>

            <dt>Nombre</dt>
            <dd><?php echo $args['quote']['datos-solicitante']['customerNombre'] ?></dd>

            <dt>Apellido</dt>
            <dd><?php echo $args['quote']['datos-solicitante']['customerApellido'] ?></dd>

            <dt>Nacido el </dt>
            <dd><?php echo implode('/', $args['quote']['datos-solicitante']['customerFechaNacimiento']) ?></dd>

            <dt>Email</dt>
            <dd><?php echo $args['quote']['datos-solicitante']['customerEmail'] ?></dd>

            <dt>Teléfono</dt>
            <dd>(<?php echo $args['quote']['datos-solicitante']['customerPhonePrefix'] ?>) <?php echo $args['quote']['datos-solicitante']['customerPhoneNumber'] ?></dd>
          </dl>
        </div><!-- /.col-md-6 -->

        <div class="col-md-4">
          <h3>Datos del vehículo</h3>
          <dl>
            <dt>Vehículo</dt>
            <dd>
              <?php
              echo $args['quote']['answers']['vehicleBrand'] . ' ';
              if (isset($args['quote']['answers']['vehicleModel'])) echo $args['quote']['answers']['vehicleModel'] . ' ';
              echo $args['quote']['answers']['vehicleVersion'] . ' ';
              echo $args['quote']['answers']['vehicleYear']
              ?>
            </dd>

            <dt>Circula en</dt>
            <dd><?php echo $args['quote']['datos-vehiculo']['circulaEn'] ?></dd>

            <dt>Patente</dt>
            <dd><?php echo strtoupper($args['quote']['datos-vehiculo']['numeroPatente']) ?></dd>

            <dt>Chasis</dt>
            <dd><?php echo strtoupper($args['quote']['datos-vehiculo']['numeroChasis']) ?></dd>

            <dt>Motor</dt>
            <dd><?php echo strtoupper($args['quote']['datos-vehiculo']['numeroMotor']) ?></dd>

            <dt>Suma asegurada</dt>
            <dd>$<?php echo number_format(($args['quote']['answers']['vehicleValue'] + ($args['quote']['answers']['vehicleGncValue'] ?? '0')), 2, ',', '.') ?></dd>
          </dl>
        </div><!-- /.col-md-6 -->

        <div class="col-md-4">
          <h3>Fotos</h3>
          <div class="fotos">
            <?php
            foreach ($args['quote']['fotos-vehiculo'] as $key => $image) {
              //if ($key != 'step' && $key != 'guid') {
              if (strpos($key, 'foto') === 0) {
                echo '<img src="' . COOPSEG_QUOTE_IMAGES_URL . $image . '">';
              }
            }
            ?>
          </div>
        </div>

      </div>

      <p class="terminos-y-condiciones">
        <input name="terminos-y-condiciones" id="terminos-y-condiciones" type="checkbox" value="1" required />
        <label for="terminos-y-condiciones">Expreso mi consentimiento para suscribir esta póliza y acepto los <a href="#" class="toggleTerminos">Términos y Condiciones</a></label>.
      </p>

      <p class="continue">
        <button class="btn btn-primary" type="submit" disabled>Confirmar</button>
      </p>
    </form>

    <?php get_template_part('template-parts/checkout/block-terminos'); ?>
