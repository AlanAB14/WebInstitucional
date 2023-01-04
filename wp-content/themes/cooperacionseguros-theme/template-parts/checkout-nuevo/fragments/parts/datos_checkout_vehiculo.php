<?php  
    $urlImg="/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_del_auto.css">

<!-- ANIMATE -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>


<?php  //include 'barra_ingreso.php' ;?>
<?php  //include 'menu_bar.php' ;?>

<?php  
    // $seleccion = $_COOKIE['planElejido'];
    // $seleccion = str_replace("\\", "",$seleccion);
    // $seleccion = json_decode($seleccion);
    // $plan = $seleccion->plan;  
    // $plan = str_replace(" ", "",$plan);  
    // $planDatos = $_COOKIE['datosPlan'];
    // $planDatos = str_replace("\\", "",$planDatos);
    // $planDatos = json_decode($planDatos);

    $guid = $_COOKIE['guid'];
    $guid = str_replace("\\", "",$guid);
    $guid = json_decode($guid);
    
    // $commonEvent = $_COOKIE['commonEvent'];
    // $commonEvent = str_replace("\\", "",$commonEvent);
    // $commonEvent = json_decode($commonEvent);

    // $vehiculo = $commonEvent->vehicleBrand . " " . $commonEvent->vehicleModel . " DE " . $commonEvent->vehicleYear;
    // $suma_asegurada = $planDatos->suma;
    // $cuota = $seleccion->precio;
?>

<section class="main-container">
    <div class="sup">
        <div class="pasos">
                <div class="paso-1" id="checkout-paso-1">1</div>
                <div class="paso-2 paso-seleccionado" id="checkout-paso-2">2</div>
                <div class="paso-3" id="checkout-paso-3">3</div>
                <div class="paso-4" id="checkout-paso-4">4</div>
                <!-- TODO: <div class="paso-5" id="checkout-paso-5">5</div> -->
        </div>

        <div class="titData" id="titDataReemplazo" >
            <!-- Estás contratando un  -->
        </div>
        <div class="caja">
            <div class="auto-data" id="auto-data-reemplazo">
                <!-- <div>PARA TU </div>
                <div>Suma asegurada: $?> | Cuota mensual:  | Cobertura: </div> -->
            </div>
        </div>
        <div class="caja2" id="label_campana">
            <div class="titData">Te pediremos algunos datos para terminar de asegurar tu vehículo</div>
            <div class="subtitulo">
                <div>
                    <img src="<?php  echo  $urlImg . "campana.png" ;?>" alt="">
                </div>
                <div class="sub-texto">
                    <label for="">Recordá que para contratar tu seguro vas a necesitar tener a mano tu cédula azul o verde, además de tener acceso a fotos actuales de tu vehículo de la parte frontal derecha, izquierda, parte delantera y trasera.</label>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container mt-5 mb-5" id="box-form-datos-vehiculo">

        <form id="form-datos-vehiculo" method="POST" hidden>



            <div class="container container-gris">
                <div class="container">
                    <label class="text-container-gris">Fotos de tu cédula verde</label>
                </div>
            </div>

            <div class="caja-grande mt-5">

                <div class="caja-grande-izq">

                    <div class="form-group d-flex justify-content-start group">
                        <input  type="file" 
                                    class="form-control ocultar-input" 
                                    id="foto-cedula-frente"
                                    name="image" 
                                    value="Foto frente cedula" 
                                    aria-describedby="basic-addon1" 
                                    accept="image/*"
                                    required>
                        <label for="foto-cedula-frente" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-cedula-frente">Cédula “verde” frente</p><span class="input-file-cedula-button">Adjuntar</span></label>
                        <input type="hidden" id="guid_cedula_frente_hidden" name="guid" value="<?php echo $guid ?>">
                        <input type="hidden"id="image_name_cedula_frente_hidden"  name="image_name" value="foto-cedula-frente">
                        
                        <!-- <input type="file" class="form-control" id="upload-foto-cedula" value="Foto frente" aria-describedby="basic-addon1" accept="image/*">
                        <label for="upload-foto-cedula" class="input-file-cedula"><p class="text-inside-input" id="label-foto-cedula-frente">Cédula “verde” frente</p><span class="input-file-cedula-button">Adjuntar</span></label> -->
                    </div>

                    <div class="loader-checkout-vehiculo-cedula" id="loader-cedula" hidden>
                        <p>Espere mientras procesamos los datos...</p>
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/checkout/loader.gif'  ?>" alt="">
                    </div>

                    <div class="loader-checkout-vehiculo-cedula-error" id="loader-error" hidden>
                        <p>No se ha podido detectar datos de la cédula, por favor ingréselos manualmente</p>
                    </div>

                    <div id="info-mostrar-cedula">
                        <div class="form-group group">
    
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell-fill pr-1 icon-campana" viewBox="0 0 16 16">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                                </svg>Sacá la foto mostrando todos los datos de la cédula</p>
                        </div>
    
                        <div class="media">
                            <img class="" src="<?php  echo  get_template_directory_uri() . "/assets/img/cotizador/cedula-verde.png" ;?>">
                            
                        </div>
                    </div>

                    <div class="form-group ">
                        <label  for="formGroupExampleInput">Número de patente <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill icon-preg" viewBox="0 0 16 16" data-toggle="popover-patente">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </label>
                        <input  type="text"
                                class="form-control-dis validar-patente-auto"
                                name="num_patente" 
                                placeholder="AAA111" 
                                id="vehiculo-dominio"
                                maxlength="7"
                                style="text-transform:uppercase"
                                required
                                >
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Número de chasis <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill icon-preg" viewBox="0 0 16 16" data-toggle="popover-chasis">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </label>
                        <input  type="text" 
                                class="form-control-dis" 
                                name="num_chasis" 
                                placeholder="5UXXW3C53JOT0683" 
                                id="vehiculo-chasis"
                                required
                                >
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Número de motor
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill icon-preg" viewBox="0 0 16 16" data-toggle="popover-motor">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </label>
                        <input  type="text" 
                                class="form-control-dis" 
                                name="num_motor" 
                                placeholder="52WVC10338" 
                                id="vehiculo-motor"
                                required
                                >
                    </div>
                </div>

                <div class="caja-grande-der">
                    <div class="form-group d-flex justify-content-start group cedula-verde-dorso-label">
                        <input  type="file" 
                                    class="form-control ocultar-input" 
                                    id="foto-cedula-dorso"
                                    name="image" 
                                    value="Foto dorso cedula" 
                                    aria-describedby="basic-addon1" 
                                    accept="image/*"
                                    required>
                        <label for="foto-cedula-dorso" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-cedula-dorso">Cédula “verde” dorso</p><span class="input-file-cedula-button">Adjuntar</span></label>
                        <input type="hidden" id="guid_cedula_dorso_hidden" name="guid" value="<?php echo $guid ?>">
                        <input type="hidden" id="image_name_cedula_dorso_hidden" name="image_name" value="foto-cedula-dorso">
                    </div>

                    <div class="genero vehiculo-info-radio">
                        <label class="mr-4">¿El vehículo es de uso particular?</label>
                        <label for="siUsoParticularCheckout">Sí
                            <input  type="radio" 
                                    class="input-r mr-4" 
                                    name="vehiculoUso" 
                                    id="siUsoParticularCheckout" 
                                    value="1"
                                    required
                                    checked
                                    >
                        </label>

                        <label for="noUsoParticularCheckout">No
                            <input  type="radio" 
                                    class="input-r" 
                                    name="vehiculoUso" 
                                    id="noUsoParticularCheckout" 
                                    value="0"
                                    required
                                    >
                        </label>
                    </div>
                    <div class="genero vehiculo-info-radio">
                        <label class="mr-4">¿El vehículo está dañado?</label>
                        <label for="siDaniadoCheckout">Sí
                            <input  type="radio" 
                                    class="input-r mr-4" 
                                    name="vehiculoDaniado" 
                                    id="siDaniadoCheckout" 
                                    value="1"
                                    required
                                    >
                        </label>

                        <label for="noDaniadoCheckout">No
                            <input  type="radio" 
                                    class="input-r" 
                                    name="vehiculoDaniado" 
                                    id="noDaniadoCheckout" 
                                    value="0"
                                    required
                                    checked>
                        </label>
                    </div>

                    <div class="error-validar-dni text-center animate__animated animate__bounceIn" id="error-validar-uso" hidden>
                        <label><strong>Lo sentimos</strong>: Para asegurar su vehículo de uso comercial, comunícate con nustro Departamento de Atención al cliente y recibí asesoramiento personalizado. <br>
                            <strong>0800-777-7070</strong> de Lunes a Viernes 7.00 a 20.00 hs.
                        </label>
                    </div>
                    <div class="error-validar-dni text-center animate__animated animate__bounceIn" id="error-validar-danios" hidden>
                        <label><strong>Lo sentimos</strong>: Si tu vehículo tiene daños, deberás agendar verificación previa con nuestro Departamento de Atención al cliente antes de poder contratar tu póliza. <br>
                            <strong>0800-777-7070</strong> de Lunes a Viernes 7.00 a 20.00 hs.
                        </label>
                    </div>
                    <div class="error-validar-dni text-center animate__animated animate__bounceIn" id="error-validar-datos" hidden>
                        <label><strong>Lo sentimos</strong>: Ocrurrió un error al tomar tus datos, por favor comunicate con nosotros. <br>
                            <strong>0800-777-7070</strong> de Lunes a Viernes 7.00 a 20.00 hs.
                        </label>
                    </div>

                    
                </div>

            </div>


            <div class="text-center">
                <button class="btn-continuar"
                        value="btn-continuar"
                        type="submit"
                        id="button-continuar-datos-vehiculo"
                        disabled
                        >CONTINUAR</button>
            </div>
        </form>

        <div class="loader-checkout-vehiculo-cedula" id="loader-home">
            <p>Espere un momento...</p>
            <img src="<?php echo get_template_directory_uri() . '/assets/img/checkout/loader.gif'  ?>" alt="">
        </div>
    </div>


    <!-- SECCION IMAGENES -->
    <section id="section-upload-images" class="animate__animated animate__fadeIn" hidden>
        <div class="text-center caja-adjuntar-img seccion-imagenes-caja-superior">
            <label>Ahora, necesitamos que adjuntes algunas imágenes </label>
            <label>importantes para crear la póliza</label>
            <div class="recuadro container mb-5 seccion-imagenes-caja-superior-recuadro">
                <label>Si querés continuar desde tu teléfono, <span><a id="continuarDelTelefono">hacé click acá</a></span> y te llegará un link</label>
            </div>
        </div>
    
        <div class="container container-gris">
            <div class="container">
                <label class="text-container-gris">Fotos de tu vehículo</label>
            </div>
        </div>
    
        <div class="container container-fotos-vehiculo mt-5">
                <div class="caja-inputs-file">
    
                    <div class="caja-inputs-izq">
    
                        <div class="form-group d-flex justify-content-start">
                            <form class="ajax-upload-nuevo">
                                <input  type="file" 
                                        class="form-control ocultar-input" 
                                        id="foto-frontal-izquierda"
                                        name="image" 
                                        value="Foto parte frontal izquierdo" 
                                        aria-describedby="basic-addon1" 
                                        accept="image/*"
                                        required>
                                <label for="foto-frontal-izquierda" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-frontal-izquierdo">Foto lateral izquierdo</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                <input type="hidden" name="image_name" value="foto-izquierda">
                            </form>
                        </div>
                        <div class="form-group  d-flex justify-content-start">
                            <form class="ajax-upload-nuevo">
                                <input  type="file" 
                                        class="form-control ocultar-input" 
                                        id="foto-frontal-derecha"
                                        name="image" 
                                        value="Foto parte frontal derecha" 
                                        aria-describedby="basic-addon1"
                                        accept="image/*"
                                        required>
                                <label for="foto-frontal-derecha" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-frontal-derecha">Foto lateral derecha</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                <input type="hidden" name="image_name" value="foto-derecha">
                            </form>
                        </div>
    
                    </div>
    
                    <div class="caja-inputs-der">
    
                        <div class="form-group d-flex justify-content-start">
                            <form class="ajax-upload-nuevo">
                                <input  type="file" 
                                        class="form-control ocultar-input" 
                                        id="foto-parte-delantera"
                                        name="image" 
                                        value="Foto parte delantera" 
                                        aria-describedby="basic-addon1" 
                                        accept="image/*"
                                        required>
                                <label for="foto-parte-delantera" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-parte-delantera">Foto parte frontal</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                <input type="hidden" name="image_name" value="foto-delantera">
                            </form>
                        </div>
                        <div class="form-group d-flex justify-content-start">
                            <form class="ajax-upload-nuevo">
                                <input  type="file" 
                                            class="form-control ocultar-input" 
                                            id="foto-parte-posterior"
                                            name="image" 
                                            value="Foto parte posterior" 
                                            aria-describedby="basic-addon1" 
                                            accept="image/*"
                                            required>
                                <label for="foto-parte-posterior" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-parte-posterior">Foto parte posterior</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                <input type="hidden" name="image_name" value="foto-trasera">
                            </form>
                        </div>
                        
                    </div>
    
                </div>

                <div class="btns text-center mt-1" id="imagenes-adicionales-section">
                        <button type="button" id="imagen-adicional" style="cursor: pointer;" class="btn-añadir-img-adicionales">AÑADIR IMÁGENES ADICIONALES</button>
                </div>

                <!-- IMAGENES ADICIONALES -->
                <div class="container mt-5 d-none" id="images-adicionales">
                    <hr />
                        <div class="caja-inputs-file">
        
                            <div class="caja-inputs-izq">
                                    <div class="form-group d-flex justify-content-start">
                                            <form class="ajax-upload-nuevo">
                                                <input  type="file" 
                                                            class="form-control ocultar-input" 
                                                            id="foto-parabrisas"
                                                            name="image" 
                                                            value="Foto parabrisas" 
                                                            aria-describedby="basic-addon1" 
                                                            accept="image/*"
                                                            >
                                                <label for="foto-parabrisas" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-parabrisas">Foto parabrisas</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                                <input type="hidden" name="image_name" value="foto-parabrisas">
                                            </form>
                                    </div>

                                    <div class="form-group d-flex justify-content-start">
                                            <form class="ajax-upload-nuevo">
                                                <input  type="file" 
                                                            class="form-control ocultar-input" 
                                                            id="foto-interior"
                                                            name="image" 
                                                            value="Foto interior" 
                                                            aria-describedby="basic-addon1" 
                                                            accept="image/*"
                                                            >
                                                <label for="foto-interior" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-interior">Foto interior</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                                <input type="hidden" name="image_name" value="foto-interior">
                                            </form>
                                    </div>

                                    <div class="form-group d-flex justify-content-start">
                                            <form class="ajax-upload-nuevo">
                                                <input  type="file" 
                                                            class="form-control ocultar-input" 
                                                            id="foto-tablero"
                                                            name="image" 
                                                            value="Foto tablero" 
                                                            aria-describedby="basic-addon1" 
                                                            accept="image/*"
                                                            >
                                                <label for="foto-tablero" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-tablero">Foto tablero</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                                <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                                <input type="hidden" name="image_name" value="foto-tablero">
                                            </form>
                                    </div>

                                    <div class="form-group d-flex justify-content-start">
                                        <form class="ajax-upload-nuevo">
                                            <input  type="file" 
                                                        class="form-control ocultar-input" 
                                                        id="foto-techo-panoramico"
                                                        name="image" 
                                                        value="Foto techo panoramico" 
                                                        aria-describedby="basic-addon1" 
                                                        accept="image/*"
                                                        >
                                            <label for="foto-techo-panoramico" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-techo-panoramico">Foto techo panorámico</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                            <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                            <input type="hidden" name="image_name" value="foto-techo-panoramico">
                                        </form>
                                </div>
                            </div>

                            <div class="caja-inputs-der">

                                <div class="form-group d-flex justify-content-start">
                                        <form class="ajax-upload-nuevo">
                                            <input  type="file" 
                                                        class="form-control ocultar-input" 
                                                        id="foto-cubiertas"
                                                        name="image" 
                                                        value="Foto cubiertas" 
                                                        aria-describedby="basic-addon1" 
                                                        accept="image/*"
                                                        >
                                            <label for="foto-cubiertas" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-cubiertas">Foto cubiertas</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                            <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                            <input type="hidden" name="image_name" value="foto-cubiertas">
                                        </form>
                                </div>

                                <div class="form-group d-flex justify-content-start">
                                        <form class="ajax-upload-nuevo">
                                            <input  type="file" 
                                                        class="form-control ocultar-input" 
                                                        id="foto-kilometraje"
                                                        name="image" 
                                                        value="Foto kilometraje" 
                                                        aria-describedby="basic-addon1" 
                                                        accept="image/*"
                                                        >
                                            <label for="foto-kilometraje" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-kilometraje">Foto kilometraje</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                            <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                            <input type="hidden" name="image_name" value="foto-kilometraje">
                                        </form>
                                </div>

                                <div class="form-group d-flex justify-content-start">
                                        <form class="ajax-upload-nuevo">
                                            <input  type="file" 
                                                        class="form-control ocultar-input" 
                                                        id="foto-equipo-gnc"
                                                        name="image" 
                                                        value="Foto equipo gnc" 
                                                        aria-describedby="basic-addon1" 
                                                        accept="image/*"
                                                        >
                                            <label for="foto-equipo-gnc" class="input-file-cedula"> <p class="text-inside-input" id="label-foto-equipo-gnc">Foto equipo GNC</p><span class="input-file-cedula-button">Adjuntar</span></label>
                                            <input type="hidden" name="guid" value="<?php echo $guid ?>">
                                            <input type="hidden" name="image_name" value="foto-equipo-gnc">
                                        </form>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Mensaje error -->
                <div style="display: flex; justify-content: center;">
                    <div class="loader-checkout-vehiculo-cedula-error animate__animated animate__bounceIn" id="loader-error-images" hidden>
                        <p>Debes subir las imágenes</p>
                    </div>
                </div>

            <form id="form-imagenes-vehiculo">
                <div class="btns text-center mt-5">
                    <button class="btn-volver mx-5" id="button-volver">VOLVER</button>
                    <button class="btn-continuar" type="submit">CONTINUAR</button>
                </div>
            </form>
        </div>
    </section>
    
</section>
<?php      include get_template_directory() . '/template-parts/cotizador/fragments/parts/nuevo_footer.php' ; ?>

<script>
        $(function() {
            $('[data-toggle="popover-patente"]').popover({
                placement: 'right',
                trigger: 'hover',
                html: true,
                content: '<div class="img-popover"><img src="<?php  echo get_template_directory_uri() . "/assets/img/cotizador/cedula-dominio-popover.png" ;?>"</div>'
            })
        });
        $(function() {
            $('[data-toggle="popover-chasis"]').popover({
                placement: 'right',
                trigger: 'hover',
                html: true,
                content: '<div class="img-popover"><img src="<?php  echo get_template_directory_uri() . "/assets/img/cotizador/cedula-chasis-popover.png" ;?>"</div>'
            })
        });
        $(function() {
            $('[data-toggle="popover-motor"]').popover({
                placement: 'right',
                trigger: 'hover',
                html: true,
                content: '<div class="img-popover"><img src="<?php  echo get_template_directory_uri() . "/assets/img/cotizador/cedula-motor-popover.png" ;?>"</div>'
            })
        });
</script>
