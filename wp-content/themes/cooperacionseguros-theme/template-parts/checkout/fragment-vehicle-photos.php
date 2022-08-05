<fieldset>
  <legend>Ahora, necesitamos que adjuntes algunas imágenes importantes para crear tu póliza.</legend>
  <div id="missing-images-error" class="alert alert-danger d-none">Por favor sube todas las imágenes necesarias para continuar.</div>
  <div id="repeated-images-error" class="alert alert-danger d-none">Las imágenes deben ser distintas.</div>

  <?php if ($args['quote']['product'] == 'seguro-de-autos-y-pick-ups') : ?>
    <div class="row">
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-frente" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-frente">
            <input type="hidden" name="image_item" value="1">
            <label class="custom-file-label" for="foto-frente">Foto parte frontal*</label>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-izquierda" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-izquierda">
            <input type="hidden" name="image_item" value="2">
            <label class="custom-file-label" for="foto-izquierda">Foto lateral izquierdo*</label>
          </form>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-atras" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-atras">
            <input type="hidden" name="image_item" value="3">
            <label class="custom-file-label" for="foto-atras">Foto parte posterior*</label>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-derecha" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-derecha">
            <input type="hidden" name="image_item" value="4">
            <label class="custom-file-label" for="foto-derecha">Foto lateral derecho*</label>
          </form>
        </div>
      </div>
    </div>

    <!-- Imagenes adicionales -->
    <div id="images-adicionales" class="d-none">
      <hr />

      <div class="row">
        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-parabrisas" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-parabrisas">
              <input type="hidden" name="image_item" value="5">
              <label class="custom-file-label" for="foto-parabrisas">Foto parabrisas</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-interior" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-interior">
              <input type="hidden" name="image_item" value="6">
              <label class="custom-file-label" for="foto-interior">Foto interior</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-tablero" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-tablero">
              <input type="hidden" name="image_item" value="7">
              <label class="custom-file-label" for="foto-tablero">Foto tablero</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-techo-panoramico" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-techo-panoramico">
              <input type="hidden" name="image_item" value="8">
              <label class="custom-file-label" for="foto-techo-panoramico">Foto techo panorámico</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-cubiertas" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-cubiertas">
              <input type="hidden" name="image_item" value="9">
              <label class="custom-file-label" for="foto-cubiertas">Foto cubiertas</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-kilometraje" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-kilometraje">
              <input type="hidden" name="image_item" value="10">
              <label class="custom-file-label" for="foto-kilometraje">Foto kilometraje</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-equipo-gnc" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-equipo-gnc">
              <input type="hidden" name="image_item" value="11">
              <label class="custom-file-label" for="foto-equipo-gnc">Foto equipo GNC</label>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php elseif ($args['quote']['product'] == 'seguro-de-motos') : ?>
    <div class="row">
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-frente-derecha" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-frente-derecha">
            <input type="hidden" name="image_item" value="1">
            <label class="custom-file-label" for="foto-frente-derecha">Diagonal frente derecha*</label>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-izquierda-atras" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-izquierda-atras">
            <input type="hidden" name="image_item" value="2">
            <label class="custom-file-label" for="foto-izquierda">Diagonal izquierda atrás*</label>
          </form>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-numero-motor" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-numero-motor">
            <input type="hidden" name="image_item" value="3">
            <label class="custom-file-label" for="foto-numero-motor">Número motor*</label>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="input-group mb-3">
          <form class="custom-file ajax-upload">
            <input type="file" class="custom-file-input" id="foto-numero-chasis" name="image" accept="image/*">
            <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
            <input type="hidden" name="image_name" value="foto-numero-chasis">
            <input type="hidden" name="image_item" value="4">
            <label class="custom-file-label" for="foto-numero-chasis">Número chasis*</label>
          </form>
        </div>
      </div>
    </div>

    <!-- Imagenes adicionales -->
    <div id="images-adicionales" class="d-none">
      <hr />

      <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
              <form class="custom-file ajax-upload">
                <input type="file" class="custom-file-input" id="foto-accesorios" name="image" accept="image/*">
                <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
                <input type="hidden" name="image_name" value="foto-accesorios">
                <input type="hidden" name="image_item" value="5">
                <label class="custom-file-label" for="foto-accesorios">Foto accesorios</label>
              </form>
            </div>
          </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-cubiertas" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-cubiertas">
              <input type="hidden" name="image_item" value="6">
              <label class="custom-file-label" for="foto-cubiertas">Foto cubiertas</label>
            </form>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group mb-3">
            <form class="custom-file ajax-upload">
              <input type="file" class="custom-file-input" id="foto-tablero" name="image" accept="image/*">
              <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
              <input type="hidden" name="image_name" value="foto-tablero">
              <input type="hidden" name="image_item" value="7">
              <label class="custom-file-label" for="foto-tablero">Foto tablero</label>
            </form>
          </div>
        </div>
      </div>
    </div>

  <?php endif; ?>

  <div class="row" id="imagenes-adicionales-section">
    <div class="col-md-6 ml-auto">
      <div class="btn-group" role="group">
        <button id="imagen-adicional" type="button" class="btn secundario btn-outline-secondary">
          Añadir imagenes adicionales
        </button>
      </div>
    </div>
  </div>

  <hr />

  <div class="row">
    <div class="col-md-6">
      <div class="input-group mb-3">
        <form class="custom-file ajax-upload">
          <input type="file" class="custom-file-input" id="foto-cedula-frente" name="image" accept="image/*">
          <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
          <input type="hidden" name="image_name" value="foto-cedula-frente">
          <input type="hidden" name="image_item" value="8">
          <label class="custom-file-label" for="foto-cedula-frente">Cédula "verde" frente</label>
        </form>
      </div>
    </div>
    <div class="col-md-6">
      <div class="input-group mb-3">
        <form class="custom-file ajax-upload">
          <input type="file" class="custom-file-input" id="foto-cedula-atras" name="image" accept="image/*">
          <input type="hidden" name="guid" value="<?php echo $args['quote']['guid'] ?>">
          <input type="hidden" name="image_name" value="foto-cedula-atras">
          <input type="hidden" name="image_item" value="9">
          <label class="custom-file-label" for="foto-cedula-atras">Cédula "verde" atras</label>
        </form>
      </div>
    </div>
  </div>

  <form action="" method="POST" id="vehicle-photos">
    <div id="hidden-fields"></div>
    <input type="hidden" id="product-type" name="product-type" value="<?php echo $args['quote']['product'] ?>">
    <p class="continue">
      <button class="btn btn-primary">Continuar</button>
    </p>
  </form>
</fieldset>
