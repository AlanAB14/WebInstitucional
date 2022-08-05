<form action="" method="POST" id="validarIdentidad" <?php if (isset($_COOKIE['clientDNI']) && isset($_COOKIE['clientSex'])) echo ' class="validando"'; ?>>
  <fieldset>
    <legend>A continuación, ingresá tus datos</legend>

    <?php if ($args['options']['naturalPerson'] && $args['options']['legalPerson']) : ?>
      <div class="form-group">
          <label for="numeroDni">Tipo de persona</label>
          <div class="radios persona">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="persona" value="fisica" id="personaFisica" required checked />
              <label class="form-check-label" for="personaFisica">Persona Física</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="persona" value="juridica" id="personaJuridica" required />
              <label class="form-check-label personaJuridica" for="personaJuridica">Persona Jurídica</label>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($args['options']['naturalPerson']) : ?>
      <?php if (!$args['options']['legalPerson']) : ?>
        <input class="form-check-input" type="radio" name="persona" value="fisica" id="personaFisica" style="display: none" required checked />
      <?php endif; ?>

      <div class="formPersonaFisica">
        <div class="form-group">
          <label for="numeroDni">DNI</label>
          <input class="form-control validar-dni" type="number" name="numeroDni" id="numeroDni" required autofocus
            placeholder="Ingresá tu DNI"
            <?php if (isset($_COOKIE['clientDNI'])) {
              echo ' value="' .  coopseg_decode_dni($_COOKIE['clientDNI']) . '"';
            } ?> />
        </div>

        <div class="form-group">
          <label>Sexo</label>
          <div class="radios">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="sexo" value="masculino" id="sexoMasculino" required <?php if (!isset($_COOKIE['clientSex']) || (isset($_COOKIE['clientSex']) && $_COOKIE['clientSex'] == 'm')) echo 'checked';?>>
              <label class="form-check-label" for="sexoMasculino">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="sexo" value="femenino" id="sexoFemenino" required <?php if (isset($_COOKIE['clientSex']) && $_COOKIE['clientSex'] == 'f') echo 'checked'; ?>>
              <label class="form-check-label" for="sexoFemenino">Femenino</label>
            </div>
          </div>
        </div>

        <button class="btn btn-secondary" type="submit">Verificar identidad</button>
      </div>
    <?php endif; ?>

    <?php if ($args['options']['legalPerson']) : ?>
      <?php if (!$args['options']['naturalPerson']) : ?>
        <input class="form-check-input" type="radio" name="persona" value="juridica" id="personaJuridica" style="display: none" required checked />
      <?php endif; ?>

      <div class="formPersonaJuridica" style="<?php if ($args['options']['naturalPerson']) echo 'display: none'; ?>">
        <div class="form-group">
          <label for="numeroCUIT">CUIT</label>
          <input class="form-control validar-cuit" type="text" name="numeroCUIT" id="numeroCUIT" placeholder="Ingresá tu CUIT" autofocus required />
        </div>

        <button class="btn btn-secondary" type="submit">Confirmar</button>
      </div>
    <?php endif; ?>
  </fieldset>

  <div id="error-no-verificado" class="alert alert-danger d-none">Hubo un problema al validar tus datos y no podemos
    continuar con el proceso. Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunicate con nuestro
    Departamento de atención al Cliente.
    <?php if (get_theme_mod('custom_option_phone')) echo 'Líneas rotativas ' . get_theme_mod('custom_option_phone'); ?>.
  </div>

</form>

<form action="" method="POST" id="datos-solicitante" class="d-none">
  <div class="row">
    <fieldset class="col-md-6">

      <legend>Datos de la persona</legend>

      <?php if ($args['options']['naturalPerson']) : ?>
        <div class="form-group personaFisica">
          <label for="customerNombre">Nombre y apellido</label>
          <div class="input-group">
            <input class="form-control" type="text" name="customerNombre" id="customerNombre" value="" readonly="readonly">
            <input class="form-control" type="text" name="customerApellido" id="customerApellido" value="" readonly="readonly">
          </div>
        </div>
      <?php endif; ?>

      <?php if ($args['options']['legalPerson']) : ?>
        <div class="form-group personaJuridica">
          <label for="customerRazonSocial">Razón Social</label>
          <div class="input-group">
            <input class="form-control" type="text" name="customerRazonSocial" id="customerRazonSocial" value="" required />
          </div>
        </div>
      <?php endif; ?>

      <?php if ($args['options']['naturalPerson']) : ?>
        <div class="form-group personaFisica">
          <label for="customerFechaNacimientoDia">Fecha de nacimiento</label>
          <?php
              // Mínimos y máximos
              $minBirthYear = date('Y') - 70;
              $maxBirthYear = ($args['quote']['product'] == 'seguro-de-motos') ? date('Y') - 16 : date('Y') - 17;
              ?>

          <div class="input-group">
            <input type="number" aria-label="Día" placeholder="DD" class="form-control" name="customerFechaNacimiento[day]" id="customerFechaNacimientoDia" required min="1" max="31" maxlength="2" oninput="maxLengthCheck(this)">
            <div class="input-group-append input-group-prepend"><span class="input-group-text">/</span></div>
            <input type="number" aria-label="Mes" placeholder="MM" class="form-control" name="customerFechaNacimiento[month]" id="customerFechaNacimientoMes" required min="1" max="12" maxlength="2" oninput="maxLengthCheck(this)">
            <div class="input-group-append input-group-prepend"><span class="input-group-text">/</span></div>
            <input type="number" aria-label="Año" placeholder="AAAA" class="form-control" name="customerFechaNacimiento[year]" id="customerFechaNacimientoAno" required min="<?php echo $minBirthYear ?>" max="<?php echo $maxBirthYear ?>" maxlength="4" oninput="maxLengthCheck(this)">
          </div>
        </div>
      <?php endif; ?>

      <?php if ($args['options']['naturalPerson']) : ?>
        <div class="form-group personaFisica">
          <label for="customerLugarNacimiento">Lugar de nacimiento</label>
          <input class="form-control" type="text" name="customerLugarNacimiento" id="customerLugarNacimiento" required
            maxlength="100" />
        </div>

        <div class="row personaFisica">
          <div class="form-group col-md-4">
            <label for="customerNacionalidad">Nacionalidad</label>
            <select class="form-control" name="customerNacionalidad" id="customerNacionalidad" required>
              <option value="">Seleccionar</option>
              <?php
                $nacionalidades = coopseg_lead_get_nations();
                foreach ($nacionalidades as $k => $v) {
                  $selected = ($v == 'Argentina') ? 'selected' : '';
                  echo '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
                }
              ?>
            </select>
          </div>

          <div class="form-group col-md-4">
            <label for="customerOcupacion">Ocupación</label>
            <select class="form-control" name="customerOcupacion" id="customerOcupacion" required>
              <option value="">Seleccionar</option>
              <?php
                $ocupaciones = coopseg_lead_get_jobs();
                foreach ($ocupaciones as $k => $v) {
                  echo '<option value="' . $k . '">' . $v . '</option>';
                }
              ?>
            </select>
          </div>

          <div class="form-group col-md-4">
            <label for="customerEstadoCivil">Estado Civil</label>
            <select class="form-control" name="customerEstadoCivil" id="customerEstadoCivil" required>
              <option value="">Seleccionar</option>
              <?php
                $estados = coopseg_lead_get_civil_states();
                foreach ($estados as $k => $v) {
                  echo '<option value="' . $k . '">' . $v . '</option>';
                }
              ?>
            </select>
          </div>
        </div>
      <?php endif; ?>

      <div class="form-group">
        <label for="customerEmail">Email</label>
        <input class="form-control" type="email" name="customerEmail" id="customerEmail" required
          value="<?php echo $args['quote']['answers']['userEmail'] ?? '' ?>" style="text-transform:lowercase" maxlength="60" />
      </div>

      <div class="form-group">
        <label for="customerPhone">Teléfono, ej: (03462) 1512 4456</label>
        <div class="input-group">
          <div class="input-group-append input-group-prepend"><span class="input-group-text">(</span></div>
          <div class="input-group-prepend" style="width: 25%">
            <input class="form-control" type="number" name="customerPhonePrefix" id="customerPhonePrefix" minlenght="2"
              maxlength="5" required />
          </div>
          <div class="input-group-append input-group-prepend"><span class="input-group-text">)</span></div>
          <input class="form-control" type="number" name="customerPhoneNumber" id="customerPhoneNumber" minlenght="6"
            maxlength="9" required />
        </div>
      </div>

    </fieldset>

    <fieldset class="col-md-6">

      <legend>Dirección</legend>

      <div class="form-group">
        <label for="customerLocalidadActual">Localidad</label>
        <select class="form-control" name="customerLocalidadActual" id="customerLocalidadActual" required></select>
      </div>

      <div id="no-emit" class="alert alert-danger d-none">Lo sentimos <?php echo $args['quote']['answers']['userName'] ?? '' ?>,
        actualmente no estamos suscribiendo nuevas pólizas en tu localidad. Si necesitás más información, contactá a
        nuestro departamento de Atención al Cliente a los siguientes teléfonos:
        <?php if (get_theme_mod('custom_option_phone')) echo get_theme_mod('custom_option_phone'); ?>.</div>
      <div id="address-data" class="d-none">

        <input class="form-control" type="hidden" name="customerProvincia" id="customerProvincia" readonly>
        <input class="form-control" type="hidden" name="customerProvinciaId" id="customerProvinciaId" readonly>
        <input class="form-control" type="hidden" name="customerLocalidad" id="customerLocalidad" readonly>
        <input class="form-control" type="hidden" name="customerLocalidadId" id="customerLocalidadId" readonly>
        <input class="form-control" type="hidden" name="customerLocalidadZip" id="customerLocalidadZip" readonly>

        <div class="form-group">
          <label for="customerCalle">Dirección</label>
          <input type="text" aria-label="Calle" placeholder="Calle" class="form-control" name="customerCalle"
            id="customerCalle" maxlength="50" required>
        </div>

        <div class="form-group">
          <div class="input-group">
            <input type="number" aria-label="Número" placeholder="Número" class="form-control" name="customerNumero"
              id="customerNumero" required min="1" max="999999" maxlength="6" oninput="maxLengthCheck(this)">
            <input type="number" aria-label="Piso" placeholder="Piso" class="form-control" name="customerPiso"
              id="customerPiso" min="1" max="200" maxlength="3" oninput="maxLengthCheck(this)">
            <input type="text" aria-label="Puerta" placeholder="Puerta" class="form-control" name="customerPuerta"
              id="customerPuerta">
          </div>
        </div>
      </div>

    </fieldset>
  </div>

  <input type="hidden" name="num_dni" id="num_dni_hidden" value="">
  <input type="hidden" name="num_cuit" id="num_cuit_hidden" value="">
  <input type="hidden" name="sexo" id="sexo_hidden" value="">
  <input type="hidden" name="codcli" id="codcli" value="">
  <p class="continue">
    <button class="btn btn-primary" type="submit" disabled>Continuar</button>
  </p>
</form>

<script>
  $(function () {
    <?php if (isset($_COOKIE['clientDNI']) && isset($_COOKIE['clientSex'])) {?>
      validarIdentidad();
    <?php } ?>
  });
</script>
