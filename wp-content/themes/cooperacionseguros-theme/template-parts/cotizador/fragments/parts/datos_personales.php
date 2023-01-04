
<form onsubmit="submitForm2(event)" id="form2" method="GET" name="datos personales">
    <div class="row">
      <span class="titulos titForm1">Ahora necesitamos algunos datos personales</span>
    </div>
    <div class="row msj-persona">
        <input  type="text" 
                id="nombre"
                class="selectores selectores-persona" 
                placeholder="Nombre y Apellido"
                onfocusout="validaNombre();"
            >
        <p class="msj-error-persona" id="msjErrorNombre" hidden>Ingresa nombre y apellido</p>
    </div>
    <div class="row msj-persona">
         <input 
                type="text"
                id="email" 
                class="selectores selectores-persona" 
                placeholder="E-mail"
                onfocusout="validaEmail();"
        >
        <p class="msj-error-persona" id="msjErrorEmail" hidden>Ingresa un email válido</p>
    </div>
    <div class="row msj-persona">
        <div class="input-phone-group">
            <div class="input-phone-append">
                <span class="input-phone-static-numbers">(0</span>
                <input  type="number"
                        placeholder="Área"
                        id="telefono-area"
                        onfocusout="validaTelArea()"
                        class="selectores selectores-phone-area selectores-persona"
                >
            </div>
            <div class="input-phone-append">
                <span class="input-phone-static-numbers">)-15</span>
            </div>
            <input  type="number" 
                    id="telefono"
                    class="selectores selectores-phone-number selectores-persona"
                    placeholder="Teléfono"
                    onfocusout="validaTel();"
            >
        </div>
        <p class="msj-error-persona" id="msjErrorTelefono" hidden>Ingresa un número de telefono</p>
    </div>
    <div class="row" id="anclaBtn2">
       <!-- <button id="btnForm2" class="btnCotiza" type="submit" onclick="datosPersonales();"> <a href= "/wordpress/seguro-personal-para-autos-y-pick-ups-cotizador-precios-2/" >Continuar</a></button> -->
        <button 
            id="btnForm2" 
            class="btnCotiza btn-continuar-persona" 
            type="submit"
            disabled 
            >
            Continuar
        </button>
       
    </div>
            
</form>