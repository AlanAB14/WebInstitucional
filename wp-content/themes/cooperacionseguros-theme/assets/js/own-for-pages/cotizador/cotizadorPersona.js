
    const cookie = getCookie("datosVehiculo");
    const cookiePersonales = getCookie("datosPersonales");
    const instanciaAlcanzada = JSON.parse(getCookie("instanciaAlcanzada"));



    if ( instanciaAlcanzada?.cotizador?.paso < 2 || cookie == null) {
        window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
    }

  

    const validation = {
        name: false,
        email: false,
        tel: false,
        telArea: false
    }


    window.addEventListener('load', () => {


        // MuestroForm y quito Loader
        document.getElementById('loader-cedula').hidden = true;
        document.getElementById('cuadro-persona').hidden = false;
        document.getElementById('pasos-persona').hidden = false;

        // Activo boton de continuar
        document.getElementById("btnForm2").disabled = false;
        funcionalidadBarraPasos();
        if (cookiePersonales) {
            completarCampos(cookiePersonales);
        }
    });

        
    function validaNombre(){
        const nombre          = document.getElementById('nombre');
        const msjErrorNombre  = document.getElementById('msjErrorNombre');

            if(nombre.value.trim().indexOf(" ") == -1 || nombre.value.trim() === ''){
               msjErrorNombre.hidden = false;
               nombre.classList.add('border-error');
               validation.name = false;
            }else {
               msjErrorNombre.hidden = true;
               validation.name = true;
               nombre.classList.remove('border-error');
            }
    }

 
    
    function validaEmail(){
        email = document.getElementById("email");
        const msjErrorEmail = document.getElementById('msjErrorEmail');


            if(email.value.trim() === ''){
               msjErrorEmail.innerHTML = 'Ingresa un email'
               msjErrorEmail.hidden = false;
               email.classList.add('border-error');
               validation.email = false;    
            } else if(!isEmail(email.value)) {
                msjErrorEmail.innerHTML = 'Ingresa un email válido'
                msjErrorEmail.hidden = false;
                email.classList.add('border-error');
                validation.email = false;
            }
            else {
                msjErrorEmail.hidden = true;
                validation.email = true;
                email.classList.remove('border-error');
            }
    }

    function validaTel() {
        telefono = document.getElementById("telefono");
        const msjErrorTelefono = document.getElementById('msjErrorTelefono');

            if(telefono.value.trim() === '' ){
               msjErrorTelefono.innerHTML = 'Ingresa un número de teléfono'
               msjErrorTelefono.hidden = false;
               msjErrorTelefono.style.textAlign = "end"
               telefono.classList.add('border-error');
               validation.tel = false;
            }else if(telefono.value.trim().length < 6) {
               msjErrorTelefono.innerHTML = 'Por favor, no escribas menos de 6 caracteres'
               msjErrorTelefono.hidden = false;
               msjErrorTelefono.style.textAlign = "end"
               telefono.classList.add('border-error');
               validation.tel = false;
            }else {
                msjErrorTelefono.hidden = true;
                validation.tel = true;
                telefono.classList.remove('border-error');
            }
    }

    function validaTelArea() {
        telefonoArea = document.getElementById("telefono-area");
        const msjErrorTelefono = document.getElementById('msjErrorTelefono');

        if(telefonoArea.value.trim() === '') {
            msjErrorTelefono.innerHTML = 'Ingresa código de área'
            msjErrorTelefono.hidden = false;
            msjErrorTelefono.style.textAlign = "start"
            telefonoArea.classList.add('border-error');
            validation.telArea = false;
        }else if(telefonoArea.value.trim().length < 2) {
            msjErrorTelefono.innerHTML = 'Por favor, no escribas menos de 2 caracteres'
            msjErrorTelefono.hidden = false;
            msjErrorTelefono.style.textAlign = "start"
            telefonoArea.classList.add('border-error');
            validation.telArea = false;
        }else {
            msjErrorTelefono.hidden = true;
            validation.telArea = true;
            telefonoArea.classList.remove('border-error');
        }
    }


    async function datosPersonales(){
        telefono     = document.getElementById("telefono");
        telefonoArea = document.getElementById("telefono-area");
        nombre       = document.getElementById("nombre");
        email        = document.getElementById("email");
        
        const telefonoCompleto = `${telefonoArea.value}${telefono.value}`;

        
        const nombrePrueba   = nombre.value.split(" ");
        const apellido       = nombrePrueba[nombrePrueba.length - 1];
        nombrePrueba.pop();
        const nombreCompleto = nombrePrueba.join(' ');


        const datosPersonales = {
            telefono        : telefonoCompleto,
            nombre          : nombre.value,
            mail            : email.value,
            telArea         : telefonoArea.value,
            tel             : telefono.value,
            nombreCompleto,
            apellido
        }
    
        document.cookie = "datosPersonales="+JSON.stringify(datosPersonales)+"; path = /";

         // Instancia Alcanzada
    const instanciaAlcanzada = {
        cotizador : {
            paso : 3,
            cotizacionFinalizada : false
        }
    }

    const data = {
        tag: 'creoQuote',
        guid: '',
    }

    $.ajax({
        url: themePath + "utils/save_quote_nuevo.php",
        type: "POST",
        data: {data},
        success: function (datos) {
            const guid = datos;

            document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";

            document.cookie = "guid="+JSON.stringify(guid)+"; path = /";

            console.log(guid)

            window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/cotizacion?${guid}`;

            console.log('ACTUALIZÓ QUOTE')

        },
        error: function (e) {
        console.log('HUBO ERROR')
        }
    });
    }


    function submitForm2(event) {
        const nombre            = document.getElementById('nombre');
        const email             = document.getElementById('email');
        const telefono          = document.getElementById('telefono');
        const telefonoArea      = document.getElementById('telefono-area');

        event.preventDefault();


        
        if (!validation.telArea) {
            validaTelArea();
            telefonoArea.focus();
        }

        if (!validation.tel) {
            validaTel();
            telefono.focus();
        }

        if (!validation.email) {
            validaEmail();
            email.focus();
        }

        if (!validation.name) {
            validaNombre();
            nombre.focus();
        }


        if (!validation.name || !validation.email || !validation.telArea || !validation.tel ) {
            return
        }else {
            datosPersonales();
        }
    }
    
    
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
}
    
function funcionalidadBarraPasos() {
    const imgVehiculo = document.getElementById('img_vehiculo');
    imgVehiculo.style.cursor = "pointer";
    imgVehiculo.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
    })
}


function completarCampos(cookie) {
    const data = JSON.parse(cookie);

    const nombre       = document.getElementById('nombre');
    const email        = document.getElementById('email');
    const telefono     = document.getElementById('telefono');
    const telefonoArea = document.getElementById('telefono-area');

    nombre.value       = data.nombre;
    email.value        = data.mail;
    telefono.value     = data.tel;
    telefonoArea.value = data.telArea;
}

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}




    
   