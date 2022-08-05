<form action="" method="POST" id="vehicle-details">
  <fieldset>
    <legend>Primero, confirma los datos del auto que querés asegurar:</legend>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="circulaEn">Circula en:</label>
          <input class="form-control" type="text" name="circulaEn" id="circulaEn"
            value="<?php echo $args['quote']['answers']['userCity'] ?>, <?php echo $args['quote']['answers']['userState'] ?> (<?php echo $args['quote']['answers']['userZip'] ?>)"
            readonly>
        </div>
        <div class="form-group">
          <label>¿El vehículo es de uso particular?</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="usoParticular" value="0" id="noUsoParticular" required>
            <label class="form-check-label" for="noUsoParticular">No</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="usoParticular" value="1" id="siUsoParticular" required
              checked>
            <label class="form-check-label" for="siUsoParticular">Sí</label>
          </div>
        </div>
        <div class="form-group">
          <label>¿El vehículo está dañado?</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estaDanado" value="0" id="noEstaDanado" required checked>
            <label class="form-check-label" for="noEstaDanado">No</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estaDanado" value="1" id="siEstaDanado" required>
            <label class="form-check-label" for="siEstaDanado">Sí</label>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="numeroPatente">Número de patente</label>
          <input
            class="form-control validar-patente-<?php echo $args['quote']['product'] == 'seguro-de-autos-y-pick-ups' ? 'auto' : 'moto'; ?>"
            type="text" name="numeroPatente" id="numeroPatente" required maxLength="7"
            style="text-transform:uppercase" />
        </div>
        <div class="form-group">
          <label for="numeroChasis">Número de chasis</label>
          <input class="form-control" type="text" name="numeroChasis" id="numeroChasis" required
            style="text-transform:uppercase" />
        </div>
        <div class="form-group">
          <label for="numeroMotor">Número de motor</label>
          <input class="form-control" type="text" name="numeroMotor" id="numeroMotor" required
            style="text-transform:uppercase" />
        </div>
      </div>

      <div class="alert alert-info d-none errorUsoParticular"><strong>Lo sentimos</strong>: Para asegurar un vehículo de
        uso comercial, comunicate con nuestro Departamento de Atención al cliente y recibí asesoramiento personalizado.
        <?php if (get_theme_mod('custom_option_phone')) echo 'Líneas rotativas: ' . get_theme_mod('custom_option_phone') . '.'; ?>
      </div>

      <div class="alert alert-info d-none errorEstaDanado"><strong>Lo sentimos</strong>: Si el vehículo tiene daños
        previos, deberás agendar una verificación previa con nuestro Departamento de Atención al cliente antes de poder
        contratar tu póliza.
        <?php if (get_theme_mod('custom_option_phone')) echo 'Líneas rotativas: ' . get_theme_mod('custom_option_phone') . '.'; ?>
      </div>

    </div>
  </fieldset>

  <p class="continue">
    <button class="btn btn-primary" type="submit">Continuar</button>
    <a href="/">O empezar de nuevo y cotizar otro vehículo</a>
  </p>
</form>
