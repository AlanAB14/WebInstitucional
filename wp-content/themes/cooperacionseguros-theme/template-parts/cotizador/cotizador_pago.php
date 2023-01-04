<?php  
    $urlImg="/wordpress/wp-content/themes/cooperacionseguros-theme/assets/img/cotizador/";
?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_datos_personales.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/cotizador/cotizador_pago.css">



<section>
    <div class="sup">
        <div class="det-pasos">
            <img src="<?php  echo  $urlImg . "grupo1-5.png" ;?>" alt="">
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
<section class="tar">
    <div class="my-tar">

        <div class="tar-dat">
            <div class="tar-space">
                <label class="lab-tit">Vas a pagar:</label>
                <label>Póliza de seguro</label>
                
                <div class="tar-dat-pago">
                    <label>Referencia de pago: </label>
                    <input type="text" name="ref-pago" value="15877515">
                </div>
                <div class="tar-dat-pago op">
                    <label>Monto: $</label>
                    <input type="text" name="ref-monto" value="5909.00">
                </div>
            </div>
        </div>
        <div class="tar-img">
    
        </div>
    </div>
</section>

<section class="tar-info">
    <form action="">
        <div class="form-group">
            <div class="label-num">
                <label for="">Número de Tarjeta</label>
            </div>
            <div class="input-num">
                <input type="text" class="form-control" id="num-tar" placeholder="Colocá los 16 dígitos de tu tarjeta">
            </div>
        </div>
        <div class="form-group">
            <div class="label-cad">
                <label for="">Caducidad</label>
            </div>
            <div class="input-cad">
                <input type="text" class="form-control" id="mes-tar" placeholder="Mes">
            </div>
            <div class="input-cad">
                <input type="text" class="form-control" id="año-tar" placeholder="Año">
            </div>
            <div class="label-cod-seg">
                <label for="">Código de seguridad</label>
            </div>
            <div class="input-cod-seg">
                <input type="text" class="form-control" id="cod-tar" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <div class="label-num">
                <label for="">Nombre y Apellido</label>
            </div>
            <div class="input-num">
                <input type="text" class="form-control" id="nom-tar" placeholder="Cómo figura en tu tarjeta">
            </div>
        </div>
    </form>
</section>
<section class="img-cer">
    <div>
        <img src="<?php  echo  $urlImg . "certificacion.png" ;?>" alt="">
    </div>
</section>
<section class="op-button">
    <div class="my-btn">
        <button class="btn-volver" name="paso" value="4" >VOLVER</button>
        <button class="btn-continuar" name="paso" value="6">CONTINUAR</button>
    </div>
</section>
<?php  include 'nuevo_footer.php' ;?>