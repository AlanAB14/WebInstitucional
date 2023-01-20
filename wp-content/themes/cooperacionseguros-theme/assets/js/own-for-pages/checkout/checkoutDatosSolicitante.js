const cookiePlan = getCookie("planElejido");
const guid = getCookie("guid");
const instanciaAlcanzada = JSON.parse(getCookie("instanciaAlcanzada"));

// Chequeo si hay guid parametro
const urlActiva   = window.location.href;
const existeParam = urlActiva.indexOf('?') != -1 ? true : false;

if ( !instanciaAlcanzada?.cotizador?.cotizacionFinalizada ||  cookiePlan == null || guid == null || !existeParam) {
    window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
}



$(document).ready(async function(){

    // Verifico si ya hay dni en lead
    const token = await getToken();
    const lead  = await getLead(JSON.parse(guid), token);

    // Si hay dni lo establezco
    if (lead.dni) {
        document.getElementById('dni-dato-solicitante').value = lead.dni
    }


    $("#buttonDni").removeAttr("disabled");

    let form_persona = document.getElementById('form-datos-personal');
    $('.localidad-select2').select2();
    $('.select2-container').addClass('form-control-select2');
    let genero = '';
    $('#femenino').click(function(){
        genero = "F";
        $('#msnDNI').attr('hidden', true);
        $('#form-datos-personal').attr('hidden', true);
    });
    
    $('#masculino').click(function(){
        genero = "M";
        $('#msnDNI').attr('hidden', true);
        $('#form-datos-personal').attr('hidden', true);
    });

    $('#buttonDni').click(function(){
        const nroDNI = $('input[name="dni"]').val();

        // Valido DNI
        if (nroDNI === '') {
            $('#msnDNI').html('<p>Debes ingresar el DNI</p>');
            $('#msnDNI').removeAttr('hidden');
            return
        }        

        // Valido Genero
        if (document.getElementById('femenino').checked === false && document.getElementById('masculino').checked === false) {
            $('#msnDNI').html('<p>Debes seleccionar el género</p>');
            $('#msnDNI').removeAttr('hidden');
            return
        }        
  
        if (document.getElementById('femenino').checked) {
            genero = "F";
        }else if (document.getElementById('masculino').checked) {
            genero = "M";
        }

        if(nroDNI.length == 8 && genero != ''){
            buscaDNI(nroDNI, genero);            
        }else{
            $('#msnDNI').removeAttr('hidden');
        }
    });

    document.getElementById('btn-volver-dni').addEventListener('click', () => {
        document.getElementById('form-datos-personal').hidden = true;
        document.getElementById('container-ingresar-dni').hidden = false;
        document.getElementById('container-ingresar-dni').classList.add('animate__animated', 'animate__fadeIn');
        document.getElementById('dni-dato-solicitante').focus();
        

    })

    // Si hace focus en campo quito error
    document.getElementById('ocupacion').addEventListener('focus', () => {
        document.getElementById('loader-error-persona').hidden = true;
        document.getElementById('ocupacion').classList.remove('border-error');
    })
    document.getElementById('estado_civil').addEventListener('focus', () => {
        document.getElementById('loader-error-persona').hidden = true;
        document.getElementById('estado_civil').classList.remove('border-error');
    })
})

function hiddenDniData() {
    $('#form-datos-personal').attr('hidden', true);
    $('#msnDNI').attr('hidden', true);
}

function buscaDNI(nroDNI, genero){

    const datosPersonales = JSON.parse(getCookie("datosPersonales"));

    const fieldNombre       = $('#nombre_apellido');
    const fieldDia          = $('#dia');
    const fieldMes          = $('#mes');
    const fieldAnio         = $('#anio');
    const fieldLugarNac     = $('#lugar_nac');
    const fieldNacionalidad = $('#nac');
    const fieldOcupacion    = $('#ocupacion');
    const fieldEstadoCivil  = $('#estado_civil');
    const fieldEmail        = $('#email_persona');
    const fieldTelefono     = $('#tel');
    const fieldTelArea      = $('#telefono-area');
    const fieldTelNum       = $('#telefono');
    const fieldLocalidad    = $('#loc');
    const fieldCalle        = $('#calle');
    const fieldCalleNro     = $('#nro');
    const fieldCallePiso    = $('#piso');
    const fieldCalleDepto   = $('#depto');

    $.ajax({
        url: `${php_data.NuevaUrl}/api/api.php?get=customer&num_dni=${nroDNI}&sexo=${genero}`,
        context: document.body,
        success: async function (data) {

            if (data === 'Datos inválidos de la persona.') {
                $('#msnDNI').html('<p>Hubo un problema al validar tus datos y no podemos continuar el proceso. <br>Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunícate con nuestro Departamento de Atención al Cliente. <br>0800-777-7070 de Lunes a Viernes 7.00 a 20.00 hs.</p>');
                $('#msnDNI').removeAttr('hidden');
                return;
            }else if (data === 'null') {
                $('#msnDNI').html('<p>Hubo un problema al validar tus datos y no podemos continuar el proceso. <br>Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunícate con nuestro Departamento de Atención al Cliente. <br>0800-777-7070 de Lunes a Viernes 7.00 a 20.00 hs.</p>');
                $('#msnDNI').removeAttr('hidden');
                return;
            }

            // Verifico rangos de edad
            // TRAIGO QUOTE
            var request = new XMLHttpRequest();
            request.open("GET", `${php_data.NuevaUrl}/quotes/${JSON.parse(guid).toUpperCase()}.json`, false);
            request.send(null)
            var my_JSON_object = JSON.parse(request.responseText);
            var personaDatos     = my_JSON_object;

            if (personaDatos?.product === "seguro-de-autos-y-pick-ups" && (getAge(data.fechaNacimiento) < 17 || getAge(data.fechaNacimiento) > 70)) {
                $('#msnDNI').html('<p>Hubo un problema al validar tus datos y no podemos continuar el proceso. <br>Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunícate con nuestro Departamento de Atención al Cliente. <br>0800-777-7070 de Lunes a Viernes 7.00 a 20.00 hs.</p>');
                $('#msnDNI').removeAttr('hidden');
                return;
            }else if (personaDatos?.product === "seguro-de-motos" && (getAge(data.fechaNacimiento) < 16 || getAge(data.fechaNacimiento) > 70)) {
                $('#msnDNI').html('<p>Hubo un problema al validar tus datos y no podemos continuar el proceso. <br>Revisá tus datos e intentá nuevamente o, si tenés alguna duda, comunícate con nuestro Departamento de Atención al Cliente. <br>0800-777-7070 de Lunes a Viernes 7.00 a 20.00 hs.</p>');
                $('#msnDNI').removeAttr('hidden');
                return;
            } 

            // Muestro form datos personales
            let form_persona = document.getElementById('form-datos-personal');
            form_persona.scrollIntoView({block: 'center'});
            form_persona.removeAttribute('hidden');
            $('#lugar_nac').focus();

            // Oculto dni
            document.getElementById('container-ingresar-dni').hidden = true;



            nombre = data.nombre;
            apellido = data.apellido;
            const fechaDeNacimiento = data.fechaNacimiento;
            fechaNac = devuelveFechaFormat(data.fechaNacimiento);
            document.getElementById('fecha_nacimiento').value = fechaDeNacimiento;
            fieldNombre.val(data.nombre+' '+data.apellido);
            let fechaNacimiento = new Date(data.fechaNacimiento);
            fieldDia.val(fechaNacimiento.getDate());
            fieldMes.val(fechaNacimiento.getMonth() + 1 < 10 ? `0${fechaNacimiento.getMonth() + 1}` : fechaNacimiento.getMonth() + 1);
            fieldAnio.val(fechaNacimiento.getFullYear());

            fieldEmail.val(datosPersonales.mail ? datosPersonales.mail : '');
            fieldCalle.val(data.calle ? data.calle : '');
            fieldCalleNro.val(data.numero ? data.numero : '');
            fieldTelArea.val(datosPersonales.telArea ? datosPersonales.telArea : '');
            fieldTelNum.val(datosPersonales.tel ? datosPersonales.tel : '');
            fieldLugarNac.val(data.lugarNacimiento ? data.lugarNacimiento : '');

            fieldOcupacion.val(data.idActividad ? data.idActividad : 0);
            fieldEstadoCivil.val(data.idEstadoCivil ? data.idEstadoCivil : 0);

            let localidad = document.getElementById('loc');

            // INSERTO LOCALIDAD TRAIDA DE SERVICIO
            Array.prototype.forEach.call(localidad.options, function(option, index) {
                const localidadTextArray = option.textContent.split(', ');
                const localidadUser = data.localidad.replace("_", " ").toLowerCase();

                if (localidadTextArray[0].toLowerCase() === localidadUser) {
                    document.getElementById('loc').value = option.value;
                    $('#loc').trigger('change');
                }
              });

            // PIDO TOKEN Y TRAIGO LEAD
            const token = await getToken();
            const lead  = await getLead(JSON.parse(guid), token);

            const newLead = {
                ...lead,
                nombre,
                apellido,
                dni: nroDNI,
                genero,
                instanciaAlcanzada: 13,
                descripcion: 'Datos-Solicitante-Ingreso DNI',
                paso: '1'
            }

            // GRABO LEAD
            await grabarLead(newLead, token);


            const eventData = {
                'customerType': 'fisica',
                'customerGender': genero,
                'event': 'trackEcommerceCheckoutValidateCustomer',
                ...commonEvent,
            };
            pushDataLayer(eventData);
        }
    }).done(function () {});
}

function validaEmail2(){
    $email = document.getElementById("email_persona");
    const msjError = document.getElementById('msjErrorEmailBox');
    const emailBox = document.getElementById('email_persona')
    
    //buscar espacio en blanco
    if(!isEmail($email.value)){
        msjError.hidden = false;
        emailBox.classList.add('border-error');
        $email.focus();
    }else {
        msjError.hidden = true;
        emailBox.classList.remove('border-error');
    }
    
}

function validaTel() {
    telefono = document.getElementById("telefono");

    const msjErrorTelefono = document.getElementById('msjErrorTelefono');

        if(telefono.value.trim().length < 6) {
           msjErrorTelefono.innerHTML = 'Por favor, no escribas menos de 6 caracteres'
           msjErrorTelefono.hidden = false;
           msjErrorTelefono.style.textAlign = "end"
           telefono.classList.add('border-error');
           telefono.focus();
        }else {
            msjErrorTelefono.hidden = true;
            telefono.classList.remove('border-error');
        }
}

async function submitDatosPersonales(e) {
    e.preventDefault();
    // recolectamos informacion del formulario
            //let cod_cli= $('#cod_cli').val();
            let dia = $('#dia').val();
            let mes = $('#mes').val();
            let anio = $('#anio').val();
            let lugar_nac = $('#lugar_nac').val();
            let nacionalidadId = $('#nac').val();
            let estado_civil = $('#estado_civil').val();
            let ocupacion = $('#ocupacion').val();
            let calle = $('#calle').val();
            let numero = $('#nro').val();
            let piso = $('#piso').val();
            let depto = $('#depto').val();
            //let localidadActual = $('#localidadAc').val();//id localidad actual
            let idLocalidad = $('#loc').val();
            let localidad = document.getElementById('loc');
            let localidadText = localidad.options[localidad.selectedIndex].text;
            let genero = document.getElementById('masculino').checked ? 'M' : 'F';
            //let provinciaId = $('#provinciaId').val();
            //let provincia = $('#provincia').val();
            //let codigoPostal = $('#codigoPostal').val();
            let telefono = `${$('#telefono-area').val()}${$('#telefono').val()}`;
            let email = $('#email_persona').val();
            // Enviamos lead intermedio por AJAX


            // Verifico si selecciono ocupacion
            if (ocupacion === "0") {
                document.getElementById('loader-error-persona').hidden = false;
                document.getElementById('loader-error-persona').innerHTML = 'Debes seleccionar una ocupación';
                document.getElementById('ocupacion').classList.add('border-error');
                return
            }

            // Verifico si selecciono estado civil
            if (estado_civil === "0") {
                document.getElementById('loader-error-persona').hidden = false;
                document.getElementById('loader-error-persona').innerHTML = 'Debes seleccionar estado civil';
                document.getElementById('estado_civil').classList.add('border-error');
                return
            }

            const token = await getToken();
            const lead  = await getLead(JSON.parse(guid), token);

            var opcionSeleccionada= localidad.options[localidad.selectedIndex];

            localidadTextArray = localidadText.split(', ');
            
            const personalData = {
                codcli: lead.codcli ? lead.codcli : '',
                nombre: lead.nombre,
                apellido: lead.apellido,
                fechaNacimiento: document.getElementById('fecha_nacimiento').value,
                nroDNI: lead.dni,
                idLocalidad,
                calle,
                nro: numero,
                piso,
                departamento: depto,
                genero,
                idNacionalidad: nacionalidadId,
                lugarNacimiento: lugar_nac,
                email,
                idActividad: ocupacion,
                idEstadoCivil: estado_civil,
                telefono
            }

            const newLead = {
                ...lead,
                ...personalData
            }

            await grabarLead(newLead, token);

            // Guardo en quote
            const dataObject = {
                nombre: lead.nombre,
                apellido: lead.apellido,
                fechaNacimiento: lead.fechaNacimiento,
                dni: lead.dni,
                genero,
                telefono,
                email,
                idNacionalidad: nacionalidadId,
                idEstadoCivil: estado_civil,
                idActividad: ocupacion,
                calle,
                nro: numero,
                piso,
                depto,
                idLocalidad,
                localidad: localidadTextArray[0],
                codigoPostal: localidadTextArray[2],
                idProvincia: opcionSeleccionada.getAttribute('name'),
                provincia: localidadTextArray[1],
                fechaNacimiento: document.getElementById('fecha_nacimiento').value,
                lugarNacimiento: lugar_nac,
                codcli: lead.codcli ? lead.codcli : '',
            }
            const data = {
                tag: 'personalData',
                guid: lead.idLead,
                dataObject
            }
            $.ajax({
            url: themePath + "utils/save_quote_nuevo.php",
            type: "POST",
            data: {data},
            success: function (data) {},
            error: function (e) {
            console.log('HUBO ERROR')
            }
        });
    
            const eventData = {
                'location': $('#loc').val(),
                'event': 'trackEcommerceCheckoutCustomerDetails',
                ...commonEvent,
                'customerCitizenship' : $('select[name="nacionalidad"] option:selected').text(),
                'customerOccupation' : $('select[name="ocupacion"] option:selected').text(),
                'customerCivilStatus' : $('select[name="estado_civil"] option:selected').text(),
            };
            pushDataLayer(eventData);


            // Instancia Alcanzada
            const instanciaAlcanzada = {
                cotizador: {
                    cotizacionFinalizada: true
                },
                checkout : {
                    paso : 2,
                }
            }

        
            const datosPersonales = JSON.parse(getCookie("datosPersonales"));

            // Grabo lugar de nacimiento en la cookie
            document.cookie = "datosPersonales="+JSON.stringify({...datosPersonales, ...personalData})+"; path = /";
            document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";

            window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/datos-vehiculo?${JSON.parse(guid)}`
}


    

function validaTelArea() {
    telefonoArea = document.getElementById("telefono-area");
    const msjErrorTelefono = document.getElementById('msjErrorTelefono');

    if(telefonoArea.value.trim().length < 2) {
        msjErrorTelefono.innerHTML = 'Por favor, no escribas menos de 2 caracteres'
        msjErrorTelefono.hidden = false;
        msjErrorTelefono.style.textAlign = "start"
        telefonoArea.classList.add('border-error');
        telefonoArea.focus();
    }else {
        msjErrorTelefono.hidden = true;
        telefonoArea.classList.remove('border-error');
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

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}


// Traer token
async function getToken() {
    const resp = await fetch(`${ themePath }utils/get_token.php`,{
        method: 'POST'
    });
    const res = await resp.json();
    return res;
}

async function grabarLead(data,token) {
    url = php_data.COOPSEG_LEADS_URL;
    const body = JSON.stringify(data);
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization' : `Bearer ${token}`
            },
            body
        })
        if (response.ok) {
        }else {
            console.log('Error al Actualizar Lead');
        }
    } catch (error) {
        console.log(error)
    }
}

async function getLead(guid, token) {
url = php_data.COOPSEG_LEADS_GET_URL;
try {
    const response = await fetch(`${url}?idLead=${guid}`, {
        method: 'GET',
        headers: {
            'Authorization' : `Bearer ${token}`
        },
    })
    const res = await response.json();
    if (response.ok) {
        return res
    }else {
        console.log('Error al Actualizar Lead');
    }
} catch (error) {
    console.log(error)
}
    
}

function devuelveFechaFormat(fecha) {
    let date = new Date(fecha)

    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()

    if(month < 10){
    return `${day}-0${month}-${year}`;
    }else{
    return `${day}-${month}-${year}`;
    }
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}