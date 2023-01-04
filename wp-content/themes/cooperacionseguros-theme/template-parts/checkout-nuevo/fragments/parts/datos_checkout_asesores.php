<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/new_cotizador.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_del_auto.css">

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


<section>
    <div class="sup">
        <div class="pasos">
            <div class="paso-1" id="checkout-paso-1">1</div>
            <div class="paso-2" id="checkout-paso-2">2</div>
            <div class="paso-3 paso-seleccionado" id="checkout-paso-3">3</div>
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
</section>
<section class="asesores">
    <div class="my-container-fluid">
        <span class="title">¡Ya casi! Seleccioná un asesor personalizado</span>
        <span>Siempre es bueno tener a alguien cerca. Tu asesor será el responsable de aclarar cualquier duda que puedas llegar a tener sobre la cobertura que estas contratando.</span>
        <span>Seleccionamos especialmente una lista de asesores de tu zona para que elijas a uno de ellos.</span>
    </div>
    <form id="advisors-form" method="POST">
        <section class="main-box">
            <div class="my-container">

                <div class="loader-checkout-vehiculo-cedula" id="loader-cedula">
                        <p>Espere mientras procesamos los datos...</p>
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/checkout/loader.gif'  ?>" alt="">
                </div>

                <div class="my-row animate__animated animate__fadeIn" id="container-producers" hidden>
                    <!-- PRODUCERS -->
                </div>

            </div>
        </section>

        <div class="loader-checkout-vehiculo-cedula-error animate__animated animate__bounceIn" id="loader-error" hidden>
            <p>Debes seleccionar un Productor</p>
        </div>

        <section class="container-btn" id="btn-section" hidden>
            <div class="my-btn">
                <button class="btn-volver"name="paso" id="button-volver">VOLVER</button>
                <button class="btn-continuar" name="paso" type="submit" id="button-continuar">CONTINUAR</button>
            </div>
        </section>
    </form>
</section>

<?php      include get_template_directory() . '/template-parts/cotizador/fragments/parts/nuevo_footer.php' ; ?>

