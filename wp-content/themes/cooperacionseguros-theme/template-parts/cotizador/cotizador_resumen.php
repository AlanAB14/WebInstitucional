<?php  
    $urlImg="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador_resumen.css">



<section>
    <div class="sup">
        <div class="det-pasos">
            <img src="<?php  echo  $urlImg . "grupo1-4.png" ;?>" alt="">
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
        
    </div>
</section>
<section class="resumen">
    <form action="#" method="POST">
        <section class="main-box-p4">
            <div class="my-container-fluid">
                <label>Si todos los datos que registramos son correctos, ya podés contratar tu póliza.</label>
            </div>
            <div class="my-container-p4">
                <div class="box-left">
                    <div class="box-left-top">
                        <div class="box-left-top-content">
                            <div class="b-l-t-content-title">
                                <label>Datos sobre vos</label>
                            </div>
                            <div class="b-l-t-content-inputs">
                                <label>DNI:</label>
                                    <input type="text" name="dni" value="32.904.493" readonly>
                                <label>Nombre:</label>
                                    <input type="text" name="nombre" value="ANA GABRIEL" readonly>
                                <label>Apellido:</label>
                                    <input type="text" name="apellido" value="ALVAREZ GONZALEZ"readonly >
                                <label>Nacido el:</label>
                                    <input type="text" name="fecha_nacimiento" value="25/4/1987" readonly>
                                <label>Email:</label>
                                    <input type="email" name="email" value="anagriselalvarez@gmail.com" readonly>
                                <label>Teléfono:</label>
                                    <input type="text" name="telefono" value="(261) 449985" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="box-left-top">
                        <div class="box-left-top-content">
                            <div class="b-l-t-content-title">
                                <label>Datos de tu vehículo</label>
                            </div>
                            <div class="b-l-t-content-inputs ">
                                <label>Vehículo: </label>
                                    <input type="text" name="vehiculo" value="GUERRERO GD 100 2021" readonly>
                                <label>Circulo en:</label>
                                    <input type="text" name="localidad_circulacion" value="Venado Tuerto, Santa Fe (2600)" readonly>
                                <label>Patente:</label>
                                    <input type="text" name="patente" value="A123ABG" readonly>
                                <label>Chasis:</label>
                                    <input type="text" name="chasis" value="5UXXW3C53J0T8683" readonly>
                                <label>Motor:</label>
                                    <input type="email" name="motor" value="52WVC10338" readonly>
                                <label class="box-down">Suma asegurada:</label>
                                    <input class="box-down" type="text" name="total_asegurado" value="$ 7.015.00,00" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parte derecha - Fotos -->
                <div class="box-right">

                    <!-- Fila 1 -->
                    <div class="row-arriba">
                        <div class="caja-interna-arriba">
                            <label>Fotos</label>
                        </div>
                    </div>

                    <!-- Fila 2 -->
                    <div class="row-abajo">
                        <div class="caja-interna-abajo">
                            <div class="caja-interna-abajo-row">
                                <div class="column-interna">
                                    <!-- <img src="#" alt="#"> -->
                                </div>
                                <div class="column-interna">
                                    <!-- <img src="#" alt="#"> -->
                                </div>
                                <div class="column-interna">
                                    <!-- <img src="#" alt="#"> -->
                                </div>
                            </div>
                            <div class="caja-interna-abajo-row">
                                <div class="column-interna">
                                    <!-- <img src="#" alt="#"> -->
                                </div>
                                <div class="column-interna">
                                    <!-- <img src="#" alt="#"> -->
                                </div>
                                <div class="column-interna">
                                    <!-- <img src="#" alt="#"> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="my-container-orange">
                <div class="text-orange">
                    <label>Asesor asignado: REMONDEGUI, SILVIA GRACIELA 25 de mayo 254, Venado Tuerto</label>
                </div>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="consentimiento_tyc" id="consentimiento_tyc">
                <div class="checkbox-text">
                    <label for="consentimiento_tyc">Expreso mi consentimiento para suscribir esta póliza y aceptar los Términos y Condiciones.</label>
                </div>
            </div>

            <div class="my-btn">
                <button class="btn-volver" name="paso" value="3" >VOLVER</button>
                <button class="btn-continuar" name="paso" value="5">CONTINUAR</button>
            </div>
        </section>
    </form>
</section>

<?php  include 'nuevo_footer.php' ;?>