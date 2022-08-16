<?php
require_once get_template_directory() . '/api/api.php';

// // Funcion para comprimir imagenes
// function compress_image($source_url, $destination_url, $quality) {
//   $info = getimagesize($source_url);
   
//   if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
//   elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
//   elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
//   elseif ($info['mime'] == 'image/jpg') $image = imagecreatefromjpeg($source_url);
   
//   //Guarda
//   imagejpeg($image, $destination_url, $quality);
       
//   //retorna URL
//   return $destination_url;    
// }


// if (isset($_POST['vehiculos-denuncia-interna'])) {
//   $allowTypes = array('jpg','png','jpeg','gif');

//   if (in_array(pathinfo($v['name'], PATHINFO_EXTENSION), $allowTypes)) {
//     $compressed = compress_image($v['tmp_name'], $v['tmp_name'], 50);
//     if ($compressed) {
//       echo 'Se comprimió';
//     }
//   }
// }

?>

<div class="agregar wrap">

  <header class="header">
    <h2><a href="/reclamos-de-terceros/"><i class="fas fa-arrow-left"></i> Reclamos de terceros</a></h2>
    <h1>Agregar reclamo</h1>
    <p>Completá todos los pasos del siguiente formulario para <strong>agregar un reclamo nuevo</strong>. Si tenés alguna duda, podés consultar <a href="/ayuda/">nuestra sección de ayuda</a>.</p>
  </header>

  <form class="form" enctype="multipart/form-data" id="reclamos-de-terceros-form" method="post" action="/cooperacion_local/reclamos-de-terceros/?accion=procesar">
    <input type="hidden" name="guid" value="<?php echo GUID(); ?>" />
    <?php
    /**
     * Paso 1
     */
    ?>
    <div id="paso1" class="paso active">
      <h2><span>1</span> Seleccioná el tipo de siniestro</h2>
      <div class="content">

        <div class="checkboxes cols cols3">
          <p>
            <input type="checkbox" name="tipoDeSiniestroVehiculos" value="true" id="vehiculos" />
            <label class="checkbox" for="vehiculos">
              <i class="fas fa-car"></i>
              Vehículo
              <small>Daños producidos a vehículos, como consecuencia directa de un siniestro</small>
            </label>
          </p>
          <p>
            <input type="checkbox" name="tipoDeSiniestroLesiones" value="true" id="lesiones" />
            <label class="checkbox" for="lesiones">
              <i class="fas fa-user-injured"></i>
              Lesiones
              <small>Daños corporales sufridos por el Damnificado.</small>
            </label>
          </p>
          <p>
            <input type="checkbox" name="tipoDeSiniestroMateriales" value="true" id="materiales" />
            <label class="checkbox" for="materiales">
              <i class="fas fa-house-damage"></i>
              Daños Materiales
              <small>Daños producidos a bienes inmuebles (paredes, tapiales, carteles, alambrados, etc.).</small>
            </label>
          </p>
        </div>
        <p class="action continuar"><button class="btn" disabled>Continuar</button></p>

      </div>

    </div>

    <?php
    /**
     * Paso 2
     */
    ?>
    <div id="paso2" class="paso">
      <h2><span>2</span> Revisar documentación</h2>

      <div class="content">

        <p>Por favor, <strong>revisá detenidamente los documentos necesarios para el tipo de siniestro seleccionado y tenelos disponibles</strong>, ya que será necesario adjuntarlos para poder completar este proceso.</p>

        <div class="documentacion">
          <div class="showconditional tipo vehiculos">
            <h3>Documentación para siniestros de autos o motos:</h3>
            <ul>
              <li class="options">
                Si poseé cobertura de seguro:
                <ul>
                  <li>Denuncia interna</li>
                  <li>Certificado de cobertura</li>
                </ul>
              <li class="options">Si posee franquicia:
                <ul>
                  <li>Nota de franquicia emitida por su aseguradora.</li>
                </ul>
              <li class="options">
                Para todos los casos:
                <ul>
                  <li>Licencia de conducir</li>
                  <li>Tarjeta verde (en caso de no poseer, boleto de compra-venta de la unidad)</li>
                  <li>Fotos del vehículo</li>
                  <li>Presupuestos de reparación (mano de obra y repuestos)</li>
                </ul>
              </li>
            </ul>
          </div>

          <div class="showconditional tipo lesiones">
            <h3>Documentación para siniestros de lesiones:</h3>
            <ul>
              <li class="options">
                Si poseé cobertura de seguro:
                <ul>
                  <li>Denuncia interna</li>
                  <li>Certificado de cobertura</li>
                </ul>
              </li>
              <li class="options">
                Para todos los casos:
                <ul>
                  <li>DNI del lesionado</li>
                  <li>Informe / certificado de centro de salud que realizó la atención</li>
                </ul>
              </li>
            </ul>
          </div>

          <div class="showconditional tipo materiales">
            <h3>Documentación para siniestros de daños materiales:</h3>

            <h4>Bienes inmuebles (Viviendas, estructuras, edificios, etc.)</h4>

            <ul>
              <li class="options">
                Si poseé cobertura de seguro:
                <ul>
                  <li>Denuncia interna</li>
                  <li>Certificado de cobertura</li>
                </ul>
              </li>
              <li class="options">
                Para todos los casos:
                <ul>
                  <li>Impuesto donde se describa el domicilio del bien dañado y el nombre de su propietario</li>
                  <li>DNI del propietario del bien dañado</li>
                  <li>Fotos</li>
                  <li>Presupuestos de reparación</li>
                </ul>
              </li>
            </ul>

            <h4>Bienes muebles (Maquinarias no rodantes, herramientas, bicicletas, etc.)</h4>

            <ul>
              <li class="options">
                Si poseé cobertura de seguro:
                <ul>
                  <li>Denuncia interna</li>
                  <li>Certificado de cobertura</li>
                </ul>
              </li>
              <li class="options">
                En caso de no poseer seguro:
                <ul>
                  <li>Nota donde se describa el incidente</li>
                </ul>
              </li>
              <li class="options">
                Para todos los casos:
                <ul>
                  <li>Factura / título donde se describa bien dañado y el nombre de su propietario.</li>
                  <li>DNI del propietario del bien dañado</li>
                  <li>Fotos</li>
                  <li>Presupuestos de reparación o reposición</li>
                </ul>
              </li>
            </ul>

          </div>
        </div>

        <p class="action continuar"><button class="btn">Continuar</button></p>

      </div>
    </div>

    <?php
    /**
     * Paso 3
     */
    ?>
    <div id="paso3" class="paso">
      <h2><span>3</span> Datos del vehículo</h2>

      <div class="content">

        <fieldset class="fechayhora">
          <legend>Primero, indicá la fecha y hora del siniestro</legend>

          <div class="cols cols2">
            <p>
              <label for="fecha">Fecha</label>
              <input type="text" name="fecha" id="fecha" class="fecha validar-fecha" required />
            </p>

            <p>
              <label for="hora">Hora</label>
              <input type="text" name="hora" id="hora" class="hora" minlength="4" maxlength="5" required />
            </p>
          </div>

        </fieldset>

        <fieldset class="hidden showconditional vehiculos">
          <legend>Datos de tu vehículo</legend>

          <p>
            <label for="patente-vehiculo-propio">Patente de tu vehículo</label>
            <input type="text" name="patente-vehiculo-propio" id="patente-vehiculo-propio" class="validar-patente" minlength="6" maxlength="10" required />
            <a href="#" class="btn validar">Validar</a>
          </p>

        </fieldset>

        <fieldset class="hidden showconditional lesiones materiales">
          <legend>Vehículo asegurado</legend>

          <p>
            <label for="patente-vehiculo-asegurado">Patente del vehículo asegurado en Cooperación Seguros</label>
            <input type="text" name="patente-vehiculo-asegurado" id="patente-vehiculo-asegurado" class="validar-patente" minlength="6" maxlength="10" required />
            <a href="#" class="btn validar">Validar</a>
          </p>

        </fieldset>

        <p class="action continuar"><button class="btn" disabled>Continuar</button></p>

      </div>
    </div>


    <?php
    /**
     * Paso 4
     */
    ?>
    <div id="paso4" class="paso">
      <h2><span>4</span> Datos del reclamo</h2>

      <div class="content">

        <fieldset class="tipo-damnificado">
          <legend>Elegí el tipo de reclamante que sos</legend>

          <div class="checkboxes rows">
            <p>
              <input type="radio" name="damnificado-tipo" value="1" id="damnificado-tipo-titular" required />
              <label class="radio" for="damnificado-tipo-titular"><span class="tooltip" title="Propietario del bien que sufrió el daño">Titular</span></label>
            </p>
            <p>
              <input type="radio" name="damnificado-tipo" value="2" id="damnificado-tipo-tercero" />
              <label class="radio" for="damnificado-tipo-tercero"><span class="tooltip" title="Es quien sufrió el daño">Tercero damnificado</span></label>
            </p>
            <p>
              <input type="radio" name="damnificado-tipo" value="3" id="damnificado-tipo-beneficiario" />
              <label class="radio" for="damnificado-tipo-beneficiario"><span class="tooltip" title="Es quien recibirá la indemnización en el caso de que ocurriera el siniestro, designado por el Titular y/o Tercero damnificado.">Beneficiario designado</span></label>
            </p>
            <?php /*
            <p>
              <input type="radio" name="damnificado-tipo" value="4" id="damnificado-tipo-cesionario" />
              <label class="radio" for="damnificado-tipo-cesionario">Cesionario</label>
            </p>
            */ ?>
            <p>
              <input type="radio" name="damnificado-tipo" value="5" id="damnificado-tipo-otro" />
              <label class="radio" for="damnificado-tipo-otro">Otro</label>
            </p>
          </div>

          <?php /*
          <p>
            <select name="damnificado-tipo" id="damnificado-tipo" required>
              <option value=""> </option>
              <option value="1">Titular</option>
              <option value="2">Tercero damnificado</option>
              <option value="3">Beneficiario designado</option>
              <option value="4">Cesionario</option>
              <option value="5">Otro</option>
            </select>
          </p>
*/ ?>

        </fieldset>

        <fieldset class="hidden damnificado-otro">
          <legend>Ingresá tus propios datos y específica tu vínculo con el reclamante</legend>

          <div class="cols cols2">
            <p>
              <label for="otro-apellido">Tu apellido</label>
              <input type="text" name="otro-apellido" id="otro-apellido" minlenght="4" maxlength="50" required />
            </p>
            <p>
              <label for="otro-nombre">Tu nombre</label>
              <input type="text" name="otro-nombre" id="otro-nombre" minlenght="4" maxlength="50" required />
            </p>
          </div>

          <div class="cols cols2 shorted">
            <p>
              <label for="otro-documento-tipo">Tipo de documento</label>
              <select name="otro-documento-tipo" id="otro-documento-tipo" required>
                <option value="3">DNI</option>
                <option value="6">Pasaporte</option>
                <option value="10">CUIL</option>
              </select>
            </p>
            <p>
              <label for="otro-documento-numero">Tu número de documento</label>
              <input type="number" name="otro-documento-numero" id="otro-documento-numero" minlength="6" maxlength="13" required />
            </p>
          </div>

          <p>
            <label for="otro-telefono">Tu teléfono</label>
            <input type="text" name="otro-telefono" id="otro-telefono" minlength="6" maxlength="14" required />
          </p>

          <p>
            <label for="otro-email">Tu e-mail</label>
            <input type="email" name="otro-email" id="otro-email" minlength="9" maxlength="60" required />
          </p>

          <p>
            <label for="otro-vinculo">Tu vínculo con el reclamante</label>
            <input type="text" name="otro-vinculo" id="otro-vinculo" minlenght="3" required />
          </p>

        </fieldset>


        <fieldset class="datos-reclamante hidden">
          <legend>Ingresá los datos del reclamante</legend>


          <label>¿El reclamo corresponde a una persona física o jurídica?</label>
          <div class="checkboxes cols cols2">
            <p>
              <input type="radio" name="tipo-persona" value="1" id="tipo-persona-fisica" required checked />
              <label class="radio" for="tipo-persona-fisica">Persona Física</label>
            </p>
            <p>
              <input type="radio" name="tipo-persona" value="2" id="tipo-persona-juridica" />
              <label class="radio" for="tipo-persona-juridica">Persona Jurídica</label>
            </p>
          </div>

          <h3>
            ¿El reclamo corresponde a una franquicia?
            <small class="help">Es la cantidad de dinero que le corresponde abonar al reclamante por la pérdida o daño ocasionados en el siniestro.</small>
          </h3>

          <div class="cols cols2 shorted">
            <p>
              <select name="franquicia" id="franquicia" class="toggleNext" required>
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </p>
            <p>
              <label for="dano-franquicia-valor">Valor de la franquicia</label>
              <input type="number" name="dano-franquicia-valor" id="dano-franquicia-valor" class="disabled" readonly="readonly" />
            </p>
          </div>

          <h3>Datos personales</h3>

          <div class="cols cols2">
            <p>
              <label for="reclamante-apellido">Apellido del reclamante</label>
              <input type="text" name="reclamante-apellido" id="reclamante-apellido" minlenght="4" maxlength="50" required />
            </p>
            <p>
              <label for="reclamante-nombre">Nombre del reclamante</label>
              <input type="text" name="reclamante-nombre" id="reclamante-nombre" minlenght="4" maxlength="50" required />
            </p>
          </div>

          <div class="cols cols2 shorted">
            <p>
              <label for="reclamante-documento-tipo">Tipo de documento</label>
              <select name="reclamante-documento-tipo" id="reclamante-documento-tipo" required>
                <option value="3">DNI</option>
                <option value="6">Pasaporte</option>
                <option value="10">CUIL</option>
              </select>
            </p>
            <p>
              <label for="reclamante-documento-numero">Número de documento</label>
              <input type="text" name="reclamante-documento-numero" id="reclamante-documento-numero" minlength="6" maxlength="13" required />
            </p>
          </div>

          <div class="cols cols3">
            <p>
              <select name="reclamante-genero" id="reclamante-genero" required>
                <option value="">Sexo</option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
              </select>
            </p>
            <p>
              <select name="reclamante-estado-civil" id="reclamante-estado-civil" required>
                <option value="">Estado civil</option>
                <?php
                $estados = coopseg_lead_get_civil_states();
                foreach ($estados as $k => $v) {
                  echo '<option value="' . $k . '">' . $v . '</option>';
                }
                ?>
              </select>
            </p>
            <p>
              <label for="reclamante-ocupacion">Ocupación</label>
              <input type="text" name="reclamante-ocupacion" id="reclamante-ocupacion" minlength="6" maxlength="150" required />
            </p>
          </div>

          <p>
            <label for="reclamante-telefono">Teléfono</label>
            <input type="text" name="reclamante-telefono" id="reclamante-telefono" minlength="6" maxlength="14" required />
          </p>

          <p>
            <label for="reclamante-email">E-mail</label>
            <input type="email" name="reclamante-email" id="reclamante-email" minlength="9" maxlength="60" required />
          </p>

          <h3>Domicilio</h3>

          <p>
            <select name="reclamante-localidad" id="reclamante-localidad" class="localidad" required>
              <option value="">Localidad</option>
            </select>
          </p>

          <div class="cols cols2">
            <p>
              <label for="reclamante-calle">Calle</label>
              <input type="text" name="reclamante-calle" id="reclamante-calle" minlength="4" maxlength="80" required />
            </p>

            <p>
              <label for="reclamante-numero">Número</label>
              <input type="text" name="reclamante-numero" id="reclamante-numero" minlength="1" maxlength="5" required />
            </p>
          </div>

          <div class="cols cols2">
            <p>
              <label for="reclamante-piso">Piso</label>
              <input type="text" name="reclamante-piso" maxlength="5" id="reclamante-piso" />
            </p>

            <p>
              <label for="reclamante-puerta">Puerta/Depto</label>
              <input type="text" name="reclamante-puerta" maxlength="5" id="reclamante-puerta" />
            </p>
          </div>


        </fieldset>

        <p class="action continuar"><button class="btn" disabled>Continuar</button></p>

      </div>
    </div>


    <?php
    /**
     * Paso 5
     */
    ?>
    <div id="paso5" class="paso">
      <h2><span>5</span> Datos del damnificado y del bien dañado</h2>

      <div class="content">

        <fieldset>
          <legend>Seleccioná el lugar donde ocurrió el daño</legend>
          <p>
            <select name="dano-lugar" id="dano-lugar" required>
              <option value="">Lugar del daño</option>
              <option value="32">Calle</option>
              <option value="33">Avenida</option>
              <option value="219">Ruta</option>
              <option value="253">Autopista</option>
              <option value="1955">Intersección</option>
              <option value="38">Otro</option>
            </select>
          </p>

          <p>
            <label for="dano-lugar-localidad">Localidad donde ocurrió el daño</label>
            <select name="dano-lugar-localidad" id="dano-lugar-localidad" class="localidad" required>
              <option value="">Localidad dónde ocurrió el daño</option>
            </select>
          </p>

          <p class="flexWrap">
            <label for="dano-lugar-descripcion">Dirección del lugar donde ocurrió el daño</label>
            <input type="text" name="dano-lugar-descripcion" id="dano-lugar-descripcion" minlenght="4" maxlength="150" required />
            <small class="help">Escribí la dirección o la ubicación de la forma más clara posible. Por ejemplo "Av. Libertad 124", o "Rivadavia y Francia", o "Ruta 56 – km 832"</small>
          </p>

          <h3>
            Datos del damnificado
            <small class="help">Es quién sufrió el daño.</small>
          </h3>

          <p class="note alert hidden showconditional lesiones"><span>El lesionado no debe ser el asegurado y/o conductor de Cooperación Seguros</span></p>

          <p>
            <span class="reusar" data-destino="dano" data-origen="reclamante">El damnificado es el reclamante, copiar datos</span>
          </p>

          <div class="cols cols2">
            <p>
              <label for="dano-apellido">Apellido del damnificado</label>
              <input type="text" name="dano-apellido" id="dano-apellido" minlenght="4" maxlength="50" required />
            </p>
            <p>
              <label for="dano-nombre">Nombre del damnificado</label>
              <input type="text" name="dano-nombre" id="dano-nombre" minlenght="4" maxlength="50" required />
            </p>
          </div>

          <div class="cols cols3">
            <p>
              <select name="dano-documento-tipo" id="dano-documento-tipo" required>
                <option value="">Tipo de documento</option>
                <option value="3">DNI</option>
                <option value="6">Pasaporte</option>
                <option value="10">CUIL</option>
                <option value="9">CUIT</option>
              </select>
            </p>
            <p>
              <label for="dano-documento-numero">Número de documento</label>
              <input type="text" name="dano-documento-numero" id="dano-documento-numero" minlength="6" maxlength="13" required />
            </p>
            <p>
              <select name="dano-genero" id="dano-genero" required>
                <option value="">Sexo</option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
              </select>
            </p>
          </div>

        </fieldset>

        <?php
        /**
         * Siniestros de vehículos
         */
        ?>

        <fieldset class="hidden showconditional vehiculos">
          <legend>Datos de siniestro de un vehículo</legend>

          <p>
            <label for="dano-vehiculo-patente">Patente</label>
            <input type="text" name="dano-vehiculo-patente" id="dano-vehiculo-patente" class="disabled" readonly="readonly" />
          </p>

          <p class="flexWrap">
            <select name="dano-vehiculo-tipo" id="dano-vehiculo-tipo" required>
              <option value="">Tipo de vehículo</option>
              <option value="1">Autos y Pick-ups</option>
              <option value="2">Motos</option>
            </select>
            <small class="help">Para reclamos de otros tipos de vehículos, <a href="/contacto/">contactá a nuestro centro de Atención al Cliente</a>.</small>
          </p>


          <p>
            <select name="dano-vehiculo-marca" id="dano-vehiculo-marca" disabled required>
              <option value="">Marca del vehículo</option>
            </select>
          </p>

          <p>
            <select name="dano-vehiculo-modelo" id="dano-vehiculo-modelo" disabled required>
              <option value="">Modelo del vehículo</option>
            </select>
          </p>

          <p>
            <select name="dano-vehiculo-ano" id="dano-vehiculo-ano" disabled required>
              <option value="">Año</option>
            </select>
          </p>

          <p>
            <select name="dano-vehiculo-version" id="dano-vehiculo-version" disabled required>
              <option value="">Versión del vehículo</option>
            </select>
          </p>

          <h3>Datos del conductor</h3>

          <label>¿El vehículo se encontraba estacionado?</label>
          <div class="checkboxes cols cols2">
            <p>
              <input type="radio" name="dano-vehiculo-estacionado" value="si" id="dano-vehiculo-estacionado-si" required />
              <label class="radio" for="dano-vehiculo-estacionado-si">Sí</label>
            </p>
            <p>
              <input type="radio" name="dano-vehiculo-estacionado" value="no" id="dano-vehiculo-estacionado-no" />
              <label class="radio" for="dano-vehiculo-estacionado-no">No</label>
            </p>
          </div>

          <div class="hidden container conductor">

            <p>
              <span class="reusar" data-destino="conductor" data-origen="reclamante">El conductor es el reclamante, copiar datos</span>
            </p>

            <div class="cols cols2">
              <p>
                <label for="conductor-apellido">Apellido del conductor</label>
                <input type="text" name="conductor-apellido" id="conductor-apellido" minlenght="4" maxlength="50" required />
              </p>
              <p>
                <label for="conductor-nombre">Nombre del conductor</label>
                <input type="text" name="conductor-nombre" id="conductor-nombre" minlenght="4" maxlength="50" required />
              </p>
            </div>

            <div class="cols cols2 shorted">
              <p>
                <label for="conductor-documento-tipo">Tipo de documento</label>
                <select name="conductor-documento-tipo" id="conductor-documento-tipo" required>
                  <option value="">Tipo de documento</option>
                  <option value="3">DNI</option>
                  <option value="6">Pasaporte</option>
                </select>
              </p>
              <p>
                <label for="conductor-documento-numero">Número de documento del conductor</label>
                <input type="number" name="conductor-documento-numero" id="conductor-documento-numero" minlength="6" maxlength="13" required />
              </p>
            </div>

          </div>

          <h3>¿Posee compañía aseguradora?</h3>

          <div class="cols cols2 shorted">
            <p>
              <select name="dano-vehiculo-aseguradora" id="dano-vehiculo-aseguradora" class="toggleNext" required>
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </p>
            <p>
              <label for="dano-vehiculo-aseguradora-nombre">Nombre de la aseguradora</label>
              <input type="text" name="dano-vehiculo-aseguradora-nombre" id="dano-vehiculo-aseguradora-nombre" class="disabled" readonly="readonly" />
            </p>
            <p class="spacer">&nbsp;</p>
            <p class="innercol">
              <label for="dano-vehiculo-aseguradora-poliza">Número de póliza del vehículo dañado</label>
              <input type="text" name="dano-vehiculo-aseguradora-poliza" id="dano-vehiculo-aseguradora-poliza" class="disabled" readonly="readonly" maxlength="40" />
            </p>
          </div>

          <h3>Descripción del siniestro</h3>

          <p>
            <label for="dano-vehiculos-descripcion">Ingresar la descripción del siniestro </label>
            <textarea name="dano-vehiculos-descripcion" id="dano-vehiculos-descripcion" required></textarea>
          </p>

        </fieldset>

        <?php
        /**
         * Siniestros de lesiones
         */
        ?>

        <fieldset class="hidden showconditional lesiones">
          <legend>Datos de siniestro de lesiones</legend>

          <p>
            <select name="dano-tipo-lesion" id="dano-tipo-lesion" required>
              <option value="">Tipo de lesión</option>
              <option value="L">Leve</option>
              <option value="G">Grave</option>
              <option value="M">Mortal</option>
            </select>
          </p>

          <h3>Centro de salud que realizó la atención</h3>

          <div class="cols cols2">
            <p>
              <label for="dano-centro-nombre">Nombre del centro de salud</label>
              <input type="text" name="dano-centro-nombre" id="dano-centro-nombre" />
            </p>
            <p>
              <select name="dano-centro-ubicacion" id="dano-centro-ubicacion" class="localidad">
                <option value="">Localidad</option>
              </select>
            </p>
          </div>

          <h3>¿Posee ART?</h3>

          <div class="cols cols2 shorted">
            <p>
              <select name="dano-art" id="dano-art" class="toggleNext" required>
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </p>
            <p>
              <label for="dano-art-nombre">Nombre de la ART</label>
              <input type="text" name="dano-art-nombre" id="dano-art-nombre" class="disabled" readonly="readonly" />
            </p>
          </div>

          <h3>Descripción del siniestro</h3>

          <p>
            <label for="dano-lesiones-descripcion">Ingresar la descripción del siniestro </label>
            <textarea name="dano-lesiones-descripcion" id="dano-lesiones-descripcion" required></textarea>
          </p>

        </fieldset>

        <?php
        /**
         * Siniestros de daños materiales
         */
        ?>

        <fieldset class="hidden showconditional materiales">
          <legend>Datos de siniestro de daños materiales</legend>

          <h3>Ubicación del daño</h3>

          <p>
            <select name="dano-localidad" id="dano-localidad" class="localidad" required>
              <option value="">Localidad</option>
            </select>
          </p>

          <div class="cols cols2">
            <p>
              <label for="dano-calle">Calle</label>
              <input type="text" name="dano-calle" id="dano-calle" minlength="4" maxlength="80" required />
            </p>

            <p>
              <label for="dano-numero">Número</label>
              <input type="text" name="dano-numero" id="dano-numero" minlength="1" maxlength="5" required />
            </p>
          </div>

          <h3>¿Posee seguro?</h3>

          <div class="cols cols2 shorted">
            <p>
              <select name="dano-seguro" id="dano-seguro" class="toggleNext" required>
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </p>

            <p>
              <label for="dano-seguro-aseguradora">Nombre de la Aseguradora</label>
              <input type="text" name="dano-seguro-aseguradora" id="dano-seguro-aseguradora" class="disabled" readonly="readonly" />
            </p>
          </div>

          <p>
            <label for="dano-materiales-descripcion">Ingresar la descripción del siniestro </label>
            <textarea name="dano-materiales-descripcion" id="dano-materiales-descripcion" required></textarea>
          </p>

        </fieldset>

        <p class="action continuar"><button class="btn">Continuar</button></p>

      </div>
    </div>


    <?php
    /**
     * Paso 6
     */
    ?>
    <div id="paso6" class="paso">
      <h2><span>6</span> Adjuntar documentación requerida</h2>

      <div class="content">

        <fieldset>
          <legend>Estos son los documentos necesarios para presentar la denuncia:</legend>

          <p class="note"><span>El formato de los archivos adjuntos puede ser: JPEG / JPG / JFIF / BMP / PNG / PDF / DOC / XLS, con un tamaño máximo de 6 MB</span></p>

          <div id="documentos"></div>

          <?php /*
          <p>
            <label for="archivo" class="fileUpload"><span>Denuncia Interna</span></label>
            <input type="file" id="archivo" name="archivo" accept="image/*,.jfif,application/pdf" required />
          </p>
          */ ?>

        </fieldset>

        <p class="action continuar"><button class="btn" disabled>Continuar</button></p>
      </div>

    </div>


    <?php
    /**
     * Paso 7
     */
    ?>
    <div id="paso7" class="paso">
      <h2><span>7</span> Revisar y confirmar datos</h2>

      <div class="content">
        <fieldset></fieldset>
        <p class="action continuar"><button class="btn" disabled>Continuar</button></p>
        <p class="action cancelar"><button class="btn">Cancelar</button></p>
      </div>

    </div>

    <?php
    /**
     * Paso 8
     */
    ?>
    <div id="paso8" class="paso">
      <h2><span>8</span> ¡Listo!</h2>

      <div class="content">
      </div>
    </div>

    <?php
    //require_once __DIR__ . '/../inc/ajax-terceros.php';
    ?>

  </form>
</div>
