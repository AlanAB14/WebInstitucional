    <form action="" method="POST" id="advisors">
      <fieldset>
        <legend>¡Ya casi! Seleccioná un asesor personalizado</legend>
        <p>El asesor será tu contacto directo para aclarar cualquier duda que tengas sobre la póliza que vas a suscribir. Seleccionamos especialmente una lista de asesores de tu zona para que elijas a uno de ellos.</p>

        <div class="card-columns productores" style="margin-bottom:30px">
          <?php foreach ($args['advisors'] as $prod) : ?>
            <div class="card">
              <div class="card-body">
                <input class="form-check-input" type="radio" name="cod_productor" id="prod-<?php echo sanitize_title($prod['codigoProductor']) ?>" value="<?php echo $prod['codigoProductor'] ?>" required>
                <label class="form-check-label" for="prod-<?php echo sanitize_title($prod['codigoProductor']) ?>">
                  <strong><?php echo $prod['productor'] ?></strong>
                  <br /><?php echo $prod['direccion'] ?>, <?php echo $prod['localidad'] ?>
                </label>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <p class="continue">
        <button class="btn btn-primary" type="submit">Continuar</button>
      </p>
    </form>

    <script>
      var advisors = <?php echo json_encode($args['advisors']); ?>;
    </script>
