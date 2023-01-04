<?php  
    $urlImg="/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="/wp-content/themes/cooperacionseguros-theme/assets/css/cotizador/cotizador_datos_personales.css">

<!-- ANIMATE -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>



<?php  
    $seleccion = $_COOKIE['planElejido'];
    $seleccion = str_replace("\\", "",$seleccion);
    $seleccion = json_decode($seleccion);
    $plan = $seleccion->plan;  
    $plan = str_replace(" ", "",$plan);  
    $planDatos = $_COOKIE['datosPlan'];
    $planDatos = str_replace("\\", "",$planDatos);
    $planDatos = json_decode($planDatos);
    
    $commonEvent = $_COOKIE['commonEvent'];
    $commonEvent = str_replace("\\", "",$commonEvent);
    $commonEvent = json_decode($commonEvent);

    $vehiculo = $commonEvent->vehicleBrand . " " . $commonEvent->vehicleModel . " DE " . $commonEvent->vehicleYear;
    $suma_asegurada = $planDatos->suma;
    $cuota = $seleccion->precio;
?>

<section class="main-container">
    <div class="sup">
    <div class="pasos">
            <div class="paso-1 paso-seleccionado" id="checkout-paso-1">1</div>
            <div class="paso-2" id="checkout-paso-2">2</div>
            <div class="paso-3" id="checkout-paso-3">3</div>
            <div class="paso-4" id="checkout-paso-4">4</div>
            <!-- TODO: <div class="paso-5" id="checkout-paso-5">5</div> -->
        </div>
        <div class="titData">
            Estás contratando un <?php echo $seleccion->nombrePlan ?>
        </div>
        <div class="caja">
            <div class="auto-data">
                <div>PARA TU <?php  echo $vehiculo ;?></div>
                <div>Suma asegurada: $<?php  echo number_format($suma_asegurada,0,".","."); ;?> | Cuota mensual: <?php  echo $cuota ;?> | Cobertura: <?php echo $plan ?></div>
            </div>
        </div>
    </div>
    <div class="container container-gris">
        <div class="container">
            <label class="text-container-gris">A continuación, ingresá tus datos</label>
        </div>
    </div>
    <!-- Sección: container dni - genero -->
    <div class="container pl-5 pt-5" id="container-ingresar-dni">

        <!-- <form action=""  id='formDNI'> -->
            <div class="container">
                <div class="dni">

                    <label><strong>DNI</strong>
                        <input  onchange="hiddenDniData()"
                                class="input-t margin-dni pl-3" 
                                type="text" 
                                name="dni"
                                id="dni-dato-solicitante" 
                                placeholder="Ingresa los 8 dígitos de tu DNI, sin puntos" 
                                maxlength="8"
                                >
                    </label>
                </div>
                <div class="genero">
                    <label class="mr-4"><strong>Género:</strong></label>
                    <label for="femenino"><strong>Femenino</strong>
                        <input type="radio" class="input-r mr-4" name="genero" id="femenino" value="F" >
                    </label>

                    <label for="masculino"><strong>Masculino</strong>
                        <input type="radio" class="input-r" name="genero" id="masculino" value="M">
                    </label>
                </div>
                <label class="genero-p">Como figura en tu DNI</label>
            </div>

            <div class="container error-validar-dni text-center animate__animated animate__bounceIn" id="msnDNI" hidden>
                <p>Hubo un problema al validar tus datos y no podemos continuar el proceso. <br>
                    Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunícate con nuestro Departamento de Atención al Cliente. <br>
                    0800-777-7070 de Lunes a Viernes 7.00 a 20.00 hs.</p>
            </div>


            <div class="text-center mt-5 mb-5">
                <button 
                    class="btn-continuar dniBoton" 
                    value="btn-continuar" 
                    id="buttonDni" 
                    disabled
                    >
                    CONTINUAR
                </button>
            </div>
        <!-- </form> -->
    </div>

    
    <!-- Sección: container inputs datos personales -->
    <div class="container mt-5" id="form-datos-personal" hidden>

        <!-- TODO: le quito el form para porder manejar los links como anclas y no como botones -->

        <form onsubmit="submitDatosPersonales(event)" method="POST"> 
            
            <div class="caja-grande animate__animated animate__fadeIn">

                <div class="caja-grande-izq">

                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre y apellido</label>
                        <input 
                            type="text" 
                            class="form-control oscuro" 
                            name="nombre_apellido" 
                            id="nombre_apellido"
                            required
                            disabled
                        >
                    </div>
                    <div class="form-group" style="height: 79px;" >
                        <label for="formGroupExampleInput">Fecha de nacimiento</label>
                        <!-- <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento"> -->
                        <div >
                            <input type="text" id="fecha_nacimiento" hidden>
                            <input type="text" class="cuadro_fecha" id="dia" required disabled>
                            <input type="text" class="cuadro_barra" value="/">
                            <input type="text" class="cuadro_fecha" id="mes" required disabled>
                            <input type="text" class="cuadro_barra" value="/">
                            <input type="text" class="cuadro_fecha" id="anio" required disabled>
                            
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Lugar de nacimiento</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="lugar_nac"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3 mr-2">
                                <label for="formGroupExampleInput">Nacionalidad</label>
                                <select class="form-control ancho-input" name="nacionalidad" id="nac" required>
                                    <option value="0">Seleccionar</option>
                                    <?php
                                        $nacionalidades = coopseg_lead_get_nations();
                                        foreach ($nacionalidades as $k => $v) {
                                        $selected = ($v == 'Argentina') ? 'selected' : '';
                                        echo '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3 mr-2">
                                <label for="formGroupExampleInput">Ocupación</label>
                                <select class="form-control ancho-input" name="ocupacion" id="ocupacion" required>
                                    <option value="0">Seleccionar</option>
                                    <?php
                                        $ocupaciones = coopseg_lead_get_jobs();
                                        foreach ($ocupaciones as $k => $v) {
                                        echo '<option value="' . $k . '">' . $v . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="formGroupExampleInput" style="white-space: nowrap">Estado Civil</label>
                                <select class="form-control ancho-input" name="estado_civil" required id="estado_civil">
                                    <option value="0">Seleccionar</option>
                                    <?php
                                        $estados = coopseg_lead_get_civil_states();
                                        foreach ($estados as $k => $v) {
                                        echo '<option value="' . $k . '">' . $v . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Email</label>
                        <input 
                            type="email" 
                            class="form-control form-control-email" 
                            name="email" 
                            id="email_persona"
                            onblur="validaEmail2();"
                            required
                        >
                        <div class="msj-error-email-box" id="msjErrorEmailBox" hidden>
                            <p class="msj-error-email-persona" id="msjErrorEmailPersona">Ingresa un email válido</p>
                        </div>
                    </div>
                    <div class="form-group telefono">
                    <label for="formGroupExampleInput">Teléfono</label>
                        <div class="">
                            <div class="input-phone-group">
                                <div class="input-phone-append">
                                    <span class="input-phone-static-numbers-checkout">(0</span>
                                    <input  type="number"
                                            placeholder="Área"
                                            id="telefono-area"
                                            onfocusout="validaTelArea()"
                                            class="selectores telefono-checkout-input selectores-phone-area selectores-persona"
                                    >
                                </div>
                                <div class="input-phone-append">
                                    <span class="input-phone-static-numbers-checkout">)-15</span>
                                </div>
                                <input  type="number" 
                                        id="telefono"
                                        class="selectores telefono-checkout-input selectores-persona"
                                        placeholder="Teléfono"
                                        onfocusout="validaTel();"
                                >
                            </div>
                            <div class="msj-error-email-box" id="msjErrorTelBox" >
                                <p class="msj-error-email-persona" id="msjErrorTelefono" hidden>Ingresa un teléfono válido</p>
                            </div>
                        </div>
                  

                    </div>

                </div>
                <div class="caja-grande-der">

                    <div>
                        <label for="formGroupExampleInput2">Localidad</label>
                            <select style="padding: initial;" name="localidad" class="form-control localidad-select2" id='loc' required>
                            <option value="0">Seleccionar</option>
                            <?php
                                        $resultLocalidades     = coopseg_places_get_places_db('', 40, 1, 0);
                                        $localidades = json_decode($resultLocalidades, true);
                                        foreach ($localidades as $k => $v) {
                                        echo '<option name="' . $v['idstate'] . '" value="' . $v['idcity'] . '">' . $v['city'].', '.$v['state'].', '.$v['zipcode'] . '</option>';
                                        }
                                    ?>
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Calle</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="calle" 
                            id="calle"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <div class="col-3 mr-3">
                                <label for="formGroupExampleInput2">Número</label>
                                <input 
                                    type="text" 
                                    class="form-control ancho-input-dir" 
                                    name="numero" 
                                    id="nro"
                                    required
                                >
                            </div>
                            <div class="col-3 mr-3">
                                <label for="formGroupExampleInput2">Piso</label>
                                <input type="text" class="form-control ancho-input-dir" name="piso" id="piso" maxlength="2">
                            </div>
                            <div class="col-3">
                                <label for="formGroupExampleInput2">Departamento</label>
                                <input type="text" class="form-control ancho-input-dir" name="depto" id="depto" maxlength="2">
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="ocupacion_error_box">
                <div class="loader-checkout-vehiculo-cedula-error animate__animated animate__bounceIn" id="loader-error-persona" hidden>
                    <p>Debes seleccionar un Productor</p>
                </div>
            </div>

            <div class="btns text-center ">
                <button class="btn-volver mx-5" name="paso" type="button" id="btn-volver-dni">VOLVER</button>
                <button class="btn-continuar" type="submit"  name="paso" value="2" id="bntDatosPersonales">CONTINUAR</button> 
                
            </div>
        </form>  
    </div>

</section>


<?php      include get_template_directory() . '/template-parts/cotizador/fragments/parts/nuevo_footer.php' ;
    // echo '<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>';
    // echo '<script src="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/js/own/cotiza2.js"></script>';

    
    
    
?>
<script>
    
    var commonEvent = {
        'category': '<?php echo $commonEvent->category; ?>',
        'product': '<?php echo $commonEvent->product; ?>',
        'vehicleBrand': '<?php echo $commonEvent->vehicleBrand ; ?>',
        'vehicleModel': '<?php echo $commonEvent->vehicleModel ; ?>',
        'vehicleYear': '<?php echo $commonEvent->vehicleYear; ?>',
        'vehicleVersion': '<?php echo $commonEvent->vehicleVersion; ?>',
      };
</script>

