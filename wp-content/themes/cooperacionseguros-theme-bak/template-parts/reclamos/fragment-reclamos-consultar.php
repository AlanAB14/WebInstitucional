<div class="consultar wrap">

  <header class="header">
    <h2><a href="/reclamos-de-terceros/"><i class="fas fa-arrow-left"></i> Reclamos de terceros</a></h2>
    <h1>Consultar reclamo</h1>
    <p>Revisá el estado de tu reclamo a partir del DNI del reclamante y del número de reclamo que recibiste al confirmar su carga. Si tenés alguna duda, podés consultar <a href="/ayuda/">nuestra sección de ayuda</a>.</p>
  </header>

  <form class="form" id="reclamos-de-terceros-form">

    <div id="consultar-estado" class="paso active">

      <div class="content">

        <fieldset>
          <legend>Datos del reclamo</legend>
          <div class="cols cols2">
            <p>
              <label for="consulta-documento">Ingresá tu DNI</label>
              <input type="text" name="consulta-documento" id="consulta-documento" required />
              <?php // 12073179 ?>
            </p>
            <p>
              <label for="consulta-reclamo">Número de reclamo</label>
              <input type="text" name="consulta-reclamo" id="consulta-reclamo" required />
            </p>
          </div>

          <p class="action">
            <a href="#" class="btn consultar">Consultar</a>
          </p>

        </fieldset>

      </div>

    </div>
  </form>
</div>
