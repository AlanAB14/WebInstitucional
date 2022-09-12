<?php  
    $urlImg="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/css/cotizador_datos_personales.css">

<?php  
    $seleccion = $_COOKIE['planElejido'];
    $seleccion = str_replace("\\", "",$seleccion);
    $seleccion = json_decode($seleccion);
    $plan = $seleccion->plan;  
    $plan = str_replace(" ", "",$plan);  
    $plans = $_COOKIE['datosPlan'];
    $plans = str_replace("\\", "",$plans);
    $plans = json_decode($plans);
    
    $commonEvent = $_COOKIE['commonEvent'];
    $commonEvent = str_replace("\\", "",$commonEvent);
    $commonEvent = json_decode($commonEvent);

    $vehiculo = $commonEvent->vehicleBrand . " " . $commonEvent->vehicleModel . " DE " . $commonEvent->vehicleYear;
    $suma_asegurada = $plans->$plan->suma;
    $cuota = $seleccion->precio;
?>

<section class="main-container">
    <div class="sup">
        <div class="det-pasos">
            <img src="<?php  echo  $urlImg . "grupo1.png" ;?>" alt="">
        </div>
        <div class="titData">
            Estás contratando un Plan Exclusivo
        </div>
        <div class="caja">
            <div class="auto-data">
                <div>PARA TU <?php  echo $vehiculo ;?></div>
                <div>Suma asegurada: $<?php  echo $suma_asegurada ;?> | Cuota mensual: <?php  echo $cuota ;?></div>
            </div>
        </div>
    </div>
    <div class="container container-gris">
        <div class="container">
            <label class="text-container-gris">A continuación, ingresá tus datos</label>
        </div>
    </div>
    <!-- Sección: container dni - genero -->
    <div class="container pl-5 pt-5">

        <!-- <form action=""  id='formDNI'> -->
            <div class="container">
                <div class="dni">

                    <label><strong>DNI</strong>
                        <input class="input-t margin-dni pl-3" type="text" name="dni" placeholder="Ingresa los 8 dígitos de tu DNI, sin puntos" maxlength="8">
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

            <div class="container error-validar-dni text-center" id="msnDNI" hidden>
                <p>Hubo un problema al validar tus datos y no podemos continuar el proceso. <br>
                    Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunícate con nuestro Departamento de Atención al Cliente. <br>
                    0800-777-7070 de Lunes a Viernes 7.00 a 20.00 hs.</p>
            </div>
            <div class="text-center mt-5 mb-5">
                <button 
                    class="btn-continuar dniBoton" 
                    value="btn-continuar" 
                    id="miBtn" 
                    
                    >
                    CONTINUAR
                </button>
            </div>
        <!-- </form> -->
    </div>

    
    <!-- Sección: container inputs datos personales -->
    <div class="container mt-5" id="form-datos-personal" hidden>

        <!-- TODO: le quito el form para porder manejar los links como anclas y no como botones -->

        <form action="/wordpress/cotizador" method="POST"> 
            
            <div class="caja-grande">

                <div class="caja-grande-izq">

                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre y apellido</label>
                        <input 
                            type="text" 
                            class="form-control oscuro" 
                            name="nombre_apellido" 
                            id="nombre_apellido"
                            required
                        >
                    </div>
                    <div class="form-group" style="height: 79px;" >
                        <label for="formGroupExampleInput">Fecha de nacimiento</label>
                        <!-- <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento"> -->
                        <div >

                            <input type="text" class="cuadro_fecha" id="dia" required>
                            <input type="text" class="cuadro_barra" value="/">
                            <input type="text" class="cuadro_fecha" id="mes" required>
                            <input type="text" class="cuadro_barra" value="/">
                            <input type="text" class="cuadro_fecha" id="anio" required>
                            
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
                            <div class="col-3 mr-2">
                                <label for="formGroupExampleInput">Ocupación</label>
                                <select class="form-control ancho-input" name="ocupacion" id="ocupacion" required>
                                    <option >Seleccionar</option>
                                    <?php
                                        $ocupaciones = coopseg_lead_get_jobs();
                                        foreach ($ocupaciones as $k => $v) {
                                        echo '<option value="' . $k . '">' . $v . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="formGroupExampleInput">Estado</label>
                                <select class="form-control ancho-input" name="estado_civil" required>
                                    <option>Seleccionar</option>
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
                            class="form-control" 
                            name="email" 
                            id="email_persona"
                            onblur="validaEmail2();"
                            required
                        >
                    </div>
                    <div class="form-group telefono">
                        <label for="formGroupExampleInput">Teléfono</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="tel" 
                            id="tel" 
                            placeholder="Incluí el código de área sin el cero"
                            required
                        >
                    </div>

                </div>

                <div class="caja-grande-der">

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Localidad</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="localidad"
                            id="loc"
                            required
                        >
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
                                    class="form-control ancho-input" 
                                    name="numero" 
                                    id="nro"
                                    required
                                >
                            </div>
                            <div class="col-3 mr-3">
                                <label for="formGroupExampleInput2">Piso</label>
                                <input type="text" class="form-control ancho-input" name="piso" id="piso">
                            </div>
                            <div class="col-3">
                                <label for="formGroupExampleInput2">Departamento</label>
                                <input type="text" class="form-control ancho-input" name="depto" id="depto">
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="btns text-center ">
                <button class="btn-volver mx-5" name="paso" value="1">VOLVER</button>
                <button class="btn-continuar"  name="paso" value="2" id="bntDatosPersonales">CONTINUAR</button> 
                
            </div>
        </form>  
    </div>

</section>


<?php  include 'nuevo_footer.php' ;
    echo '<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>';
    echo '<script src="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/js/own/cotiza2.js"></script>';
    echo '<script> var guid = '. $guid .'</script>';
    
    
    
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

