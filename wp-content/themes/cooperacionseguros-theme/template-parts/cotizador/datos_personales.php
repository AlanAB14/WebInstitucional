
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/datos_personales.css">
<form action="" id="form2" method="GET" name="datos personales">
    <div class="row">
      <span class="titulos titForm1">Ahora necesitamos algunos datos personales</span>
    </div>
    <div class="row">
        <input type="text" 
            id="nombre"
            class=selectores 
            placeholder="Nombre y Apellido"
            onfocusout="validaNombre();"
            required
            >
    </div>
    <div class="row">
         <input 
            type="text"
            id="email" 
            class=selectores 
            placeholder="E-mail"
            onblur="validaEmail();"
            required
        >
    </div>
    <div class="row">
        <input type="text" 
            id="telefono"
            class=selectores
            placeholder="incluí el código de área sin el cero" 
            onkeypress="maskTel();" 
            required
        >
    </div>
    <div class="row" id="anclaBtn2">
       <!-- <button id="btnForm2" class="btnCotiza" type="submit" onclick="datosPersonales();"> <a href= "/wordpress/seguro-personal-para-autos-y-pick-ups-cotizador-precios-2/" >Continuar</a></button> -->
        <a 
            href= "/wordpress/seguro-personal-para-autos-y-pick-ups-cotizador-precios-2/" 
            id="btnForm2" 
            class="btnCotiza" 
            type="submit" 
            onclick="datosPersonales();">
            Continuar
        </a>
       
    </div>
            
</form>
<script>
    document.getElementById("nombre").focus();
    document.getElementById('btnForm2').disabled = true;
    document.getElementById('anclaBtn2').disabled = true;
</script>