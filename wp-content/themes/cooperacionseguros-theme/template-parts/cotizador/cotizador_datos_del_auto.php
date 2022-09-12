<?php  
    $urlImg="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador_datos_del_auto.css">

<?php  //include 'barra_ingreso.php' ;?>
<?php  //include 'menu_bar.php' ;?>

<section class="main-container">
    <div class="sup">
        <div class="det-pasos">
            <img src="<?php  echo  $urlImg . "grupo1-2.png" ;?>" alt="">
        </div>
        <div class="titData">
            Estás contratando un Plan Exclusivo
        </div>
        <div class="caja">
            <div class="auto-data">
                <div>PARA TU VOLKSWAGEN AMAROK DE 2021</div>
                <div>Suma asegurada: $0,00 | Cuota mensual: $368,00</div>
            </div>
        </div>
        <div class="caja2">
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
    <div class="container container-gris">
        <div class="container">
            <label class="text-container-gris">Fotos de tu cédula verde</label>
        </div>
    </div>
    
    <div class="container mt-5 mb-5">

        <form action="#" method="POST">

            <div class="caja-grande">

                <div class="caja-grande-izq">

                    <div class="form-group d-flex justify-content-start group">
                        <input type="text" class="form-control" placeholder="" value="Foto frente" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="" type="button">Adjuntar</button>
                        </div>
                    </div>

                    <div class="form-group group">

                        <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell-fill pr-1 icon-campana" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                            </svg>Sacá la foto mostrando todos los datos de la cédula</p>
                    </div>

                    <div class="media">
                        <img class="" src="<?php  echo  $urlImg . "cedula-verde.png" ;?>">
                        
                    </div>

                    <div class="form-group ">
                        <label  for="formGroupExampleInput">Número de patente <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill icon-preg" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </label>
                        <input type="text" class="form-control-dis" name="num_patente" placeholder="AAA111" id="formGroupExampleInput">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Número de chasis <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill icon-preg" viewBox="0 0 16 16" data-toggle="popover">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </label>
                        <input type="text" class="form-control-dis" name="num_chasis" placeholder="5UXXW3C53JOT0683" id="formGroupExampleInput">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Número de motor
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill icon-preg" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </label>
                        <input type="text" class="form-control-dis" name="num_motor" placeholder="52WVC10338" id="formGroupExampleInput">
                    </div>
                </div>

                <div class="caja-grande-der">
                    <div class="genero">
                        <label class="mr-4">¿El vehículo es de uso particular?</label>
                        <label for="si">Sí
                            <input type="radio" class="input-r mr-4" name="vehiculo_preg" id="si" value="si">
                        </label>

                        <label for="no">No
                            <input type="radio" class="input-r" name="vehiculo_preg" id="masculino" value="no">
                        </label>
                    </div>
                    <div class="genero">
                        <label class="mr-4">¿El vehículo está dañado?</label>
                        <label for="si">Sí
                            <input type="radio" class="input-r mr-4" name="vehiculo_preg" id="si" value="si">
                        </label>

                        <label for="no">No
                            <input type="radio" class="input-r" name="vehiculo_preg" id="masculino" value="no">
                        </label>
                    </div>
                    <div class="error-validar-dni text-center">
                        <label><strong>Lo sentimos</strong>: Para asegurar su vehículo de uso comercial, comunícate con nustro Departamento de Atención al cliente y recibí asesoramiento personalizado. <br>
                            <strong>0800-777-7070</strong> de Lunes a Viernes 7.00 a 20.00 hs.
                        </label>
                    </div>
                    <div class="error-validar-dni text-center">
                        <label><strong>Lo sentimos</strong>: Si tu vehículo tiene daños, deberás agendar verificación previa con nuestro Departamento de Atención al cliente antes de poder contratar tu póliza. <br>
                            <strong>0800-777-7070</strong> de Lunes a Viernes 7.00 a 20.00 hs.
                        </label>
                    </div>
                </div>

            </div>
            <div class="text-center">
                <button class="btn-continuar" value="btn-continuar">CONTINUAR</button>
            </div>
        </form>
    </div>
    <div class="text-center caja-adjuntar-img">
        <label>Ahora, necesitamos que adjuntes algunas imágenes </label>
        <label>importantes para crear la póliza</label>
        <div class="recuadro container mb-5">
            <label>Si querés continuar desde tu teléfono, <span><a href="#">hacé click acá</a></span> y te llegará un link</label>
        </div>
    </div>

    <div class="container container-gris">
        <div class="container">
            <label class="text-container-gris">Fotos de tu vehículo</label>
        </div>
    </div>

    <div class="container mt-5">

        <form action="#" method="POST">

            <div class="caja-inputs-file">

                <div class="caja-inputs-izq">

                    <div class="form-group d-flex justify-content-start">
                        <input type="text" class="form-control" placeholder="" value="Foto parte frontal izquierdo" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="" type="button">Adjuntar</button>
                        </div>
                    </div>
                    <div class="form-group  d-flex justify-content-start">
                        <input type="text" class="form-control" placeholder="" value="Foto parte frontal derecha" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="" type="button">Adjuntar</button>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-start">
                        <input type="text" class="form-control" placeholder="" value="Foto frente" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="" type="button">Adjuntar</button>
                        </div>
                    </div>

                </div>

                <div class="caja-inputs-der">

                    <div class="form-group d-flex justify-content-start">
                        <input type="text" class="form-control" placeholder="" value="Foto parte delantera" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="" type="button">Adjuntar</button>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-start">
                        <input type="text" class="form-control" placeholder="" value="Foto parte posterior" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="" type="button">Adjuntar</button>
                        </div>
                    </div>
                    
                </div>

            </div>
            
            <div class="btns text-center mt-1">
                <button class="btn-añadir-img-adicionales">AÑADIR IMÁGENES ADICIONALES</button>
            </div>

            <div class="btns text-center mt-5">
                <button class="btn-volver mx-5" name="paso" value="1">VOLVER</button>
                <button class="btn-continuar" name="paso" value="3">CONTINUAR</button>
            </div>
        </form>
    </div>
    
</section>
<?php  include 'nuevo_footer.php' ;?>

<script>
        $(function() {
            $('[data-toggle="popover"]').popover({
                placement: 'right',
                trigger: 'hover',
                html: true,
                content: '<div class="img-popover"><img src="<?php  echo  $urlImg . "cedula-popover.png" ;?>"</div>'
            })
        });
</script>