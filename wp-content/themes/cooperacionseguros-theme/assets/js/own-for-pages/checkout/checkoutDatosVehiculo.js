// const cookieDatosPlan = getCookie("datosPlan");
// const cookieCommonEvent = getCookie("commonEvent");
// const instanciaAlcanzada = JSON.parse(getCookie("instanciaAlcanzada"));

// Chequeo si hay guid parametro
const urlActiva   = window.location.href;
const existeParam = urlActiva.indexOf('?') != -1 ? true : false;
const guidParam   = urlActiva.split('?')[1];

procesarDatosAlInicio( guidParam );

const cookieGuid        = getCookie("guid");
const cookiePlanElejido = getCookie("planElejido");
const cookieVehiculo    = getCookie("datosVehiculo");
const cookieDatosPlan   = getCookie("datosPlan");



// if ( instanciaAlcanzada?.checkout?.paso < 2 || cookiePlan === null || cookieDatosPlan === null || !existeParam ) {
//     window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
// }



window.addEventListener('load', async() => {

    const datosPlan     = JSON.parse(cookieDatosPlan);
    const planElejido   = JSON.parse(cookiePlanElejido);
    const datosVehiculo = JSON.parse(cookieVehiculo); 

    // TRAIGO QUOTE
    var request = new XMLHttpRequest();
    request.open("GET", `${php_data.NuevaUrl}/quotes/${guidParam.toUpperCase()}.json`, false);
    request.send(null)
    var my_JSON_object = JSON.parse(request.responseText);
    const answersJSON = my_JSON_object.answers

    const nombrePlan = devuelveNombrePlan(answersJSON.planCobertura)


    // COMPLETO HTML
    document.getElementById('titDataReemplazo').innerHTML = `Estas contratando un ${ nombrePlan }`;
    document.getElementById('auto-data-reemplazo').innerHTML = `
        <div>PARA TU ${ answersJSON.vehicleBrand } ${ answersJSON.vehicleModel } DE ${ answersJSON.vehicleYear }</div>
        <div>Suma asegurada: ${ answersJSON.planSuma.replace(/\B(?=(\d{3})+(?!\d))/g, ".") } | Cuota mensual: ${ answersJSON.planPremioMensual.replace(/\B(?=(\d{3})+(?!\d))/g, ".") } | Cobertura: ${ answersJSON.planCobertura }</div>
    `


    funcionalidadBarraPasos();

    // Quito loader y muestro formulario
    document.getElementById('loader-home').hidden = true;
    document.getElementById('form-datos-vehiculo').hidden = false;


    // Habilito button continuar
    document.getElementById('button-continuar-datos-vehiculo').disabled = false;


    // SI EXISTE DATOS DE LEAD LOS COMPLETO
    const token = await getToken();
    const lead  = await getLead(JSON.parse(cookieGuid), token);


    const vehiculoDominio = document.getElementById('vehiculo-dominio');
    const vehiculoChasis  = document.getElementById('vehiculo-chasis');
    const vehiculoMotor   = document.getElementById('vehiculo-motor');

    vehiculoDominio.value = my_JSON_object.vehiculos.patente ? my_JSON_object.vehiculos.patente : ''; 
    vehiculoChasis.value = my_JSON_object.vehiculos.nroChasis ? my_JSON_object.vehiculos.nroChasis : ''; 
    vehiculoMotor.value = my_JSON_object.vehiculos.nroMotor ? my_JSON_object.vehiculos.nroMotor : ''; 


    // SUBIR DATOS CEDULA DORSO
    document.getElementById('foto-cedula-dorso').addEventListener('change', async(event) => {
        var formData = new FormData();

        formData.append('image', document.getElementById('foto-cedula-dorso').files[0])
        formData.append('guid',  document.getElementById('guid_cedula_dorso_hidden').value)
        formData.append('image_name', document.getElementById('image_name_cedula_dorso_hidden').value)
       


        $.ajax({
            url: themePath + "utils/upload_nuevo_checkout.php",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            dataType : 'json',
            processData: false,
            success: function (data) {

                data = data;
                let field_id = "hidden_" + data.image_name;
                $("#" + field_id).remove();
                $("#hidden-fields").append(
                '<input id="' +
                    field_id +
                    '" type="hidden" name="' +
                    data.image_name +
                    '" value="' +
                    data.path +
                    '">'
                );
    
    
                let file_selector = "#" + data.image_name;
                $(file_selector).addClass("is-valid");
                $(file_selector).parent().removeClass("loading");
            },
            error: function (e) {
                $(window.form).find("input").addClass("is-invalid");
            },
            });


        // Cambio nombre al input
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-cedula-dorso').innerHTML = fileName;
        const parent = document.getElementById('label-foto-cedula-dorso').parentNode;
        parent.classList.add('correct-class');
    })


    // COMPLETAR DATOS CON FOTO CEDULA
    document.getElementById('foto-cedula-frente').addEventListener('change', async(event) => {


        var formData = new FormData();

        formData.append('image', document.getElementById('foto-cedula-frente').files[0])
        formData.append('guid',  document.getElementById('guid_cedula_frente_hidden').value)
        formData.append('image_name', document.getElementById('image_name_cedula_frente_hidden').value)
       
        $.ajax({
            url: themePath + "utils/upload_nuevo_checkout.php",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            dataType : 'json',
            processData: false,
            success: function (data) {

                data = data;
                let field_id = "hidden_" + data.image_name;
                $("#" + field_id).remove();
                $("#hidden-fields").append(
                '<input id="' +
                    field_id +
                    '" type="hidden" name="' +
                    data.image_name +
                    '" value="' +
                    data.path +
                    '">'
                );
    
    
                let file_selector = "#" + data.image_name;
                $(file_selector).addClass("is-valid");
                $(file_selector).parent().removeClass("loading");
            },
            error: function (e) {
                $(window.form).find("input").addClass("is-invalid");
            },
            });


        // Tomo los campos
        const vehiculoDominio = document.getElementById('vehiculo-dominio');
        const vehiculoChasis  = document.getElementById('vehiculo-chasis');
        const vehiculoMotor   = document.getElementById('vehiculo-motor');

        // Oculto mensaje de error
        const msjError = document.getElementById('loader-error');
        const loader   = document.getElementById('loader-cedula');
        msjError.hidden = true;
        loader.hidden = true;


        // Cambio nombre al input
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-cedula-frente').innerHTML = fileName;
        const parent = document.getElementById('label-foto-cedula-frente').parentNode;
        parent.classList.add('correct-class');

        
        // Convierto img a base64
        const imageBase64 = await toBase64(event.target.files[0])
        const token = await getToken();

        // Muestro loader
        loader.hidden = false;

        // Oculto div
        const infoCedula = document.getElementById('info-mostrar-cedula')
        infoCedula.hidden = true;

        // Traigo datos de cédula
        const dataCedula = await getDataFromCedula(imageBase64, token);
        loader.hidden = true;

        if (dataCedula === undefined) {
            // Muestro mensaje de error
            msjError.hidden = false;
            vehiculoDominio.value = '';
            vehiculoChasis.value  = '';
            vehiculoMotor.value   = '';
        }else {
            vehiculoDominio.value = dataCedula.dominio;
            vehiculoChasis.value  = dataCedula.chasis;
            vehiculoMotor.value   = dataCedula.motor;
        }


    })


    
    // Cuando cambio los datos oculto mensaje de error
    document.getElementById('vehiculo-dominio').addEventListener('focus', () => {
        const msjError = document.getElementById('loader-error');
        msjError.hidden = true;
        document.getElementById('error-validar-datos').hidden = true;
    })
    document.getElementById('vehiculo-chasis').addEventListener('change', () => {
        const msjError = document.getElementById('loader-error');
        msjError.hidden = true;
        document.getElementById('error-validar-datos').hidden = true;
    })
    document.getElementById('vehiculo-motor').addEventListener('change', () => {
        const msjError = document.getElementById('loader-error');
        msjError.hidden = true;
        document.getElementById('error-validar-datos').hidden = true;
    })
    document.querySelector('input[name="vehiculoUso"]').addEventListener('change', () => {
        const msjError = document.getElementById('error-validar-uso');
        msjError.hidden = true;
        document.getElementById('error-validar-datos').hidden = true;
    })
    document.querySelector('input[name="vehiculoDaniado"]').addEventListener('change', () => {
        const msjError = document.getElementById('error-validar-danios');
        msjError.hidden = true;
        document.getElementById('error-validar-datos').hidden = true;
    })

    // Cambio label inputs file
    document.getElementById('foto-frontal-izquierda').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-frontal-izquierdo').innerHTML = fileName;
        const parent = document.getElementById('label-foto-frontal-izquierdo').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-frontal-derecha').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-frontal-derecha').innerHTML = fileName;
        const parent = document.getElementById('label-foto-frontal-derecha').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-parte-delantera').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-parte-delantera').innerHTML = fileName;
        const parent = document.getElementById('label-foto-parte-delantera').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-parte-posterior').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-parte-posterior').innerHTML = fileName;
        const parent = document.getElementById('label-foto-parte-posterior').parentNode;
        parent.classList.add('correct-class');
    })
    // Adicionales
    document.getElementById('foto-parabrisas').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-parabrisas').innerHTML = fileName;
        const parent = document.getElementById('label-foto-parabrisas').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-interior').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-interior').innerHTML = fileName;
        const parent = document.getElementById('label-foto-interior').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-tablero').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-tablero').innerHTML = fileName;
        const parent = document.getElementById('label-foto-tablero').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-techo-panoramico').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-techo-panoramico').innerHTML = fileName;
        const parent = document.getElementById('label-foto-techo-panoramico').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-cubiertas').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-cubiertas').innerHTML = fileName;
        const parent = document.getElementById('label-foto-cubiertas').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-kilometraje').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-kilometraje').innerHTML = fileName;
        const parent = document.getElementById('label-foto-kilometraje').parentNode;
        parent.classList.add('correct-class');
    })
    document.getElementById('foto-equipo-gnc').addEventListener('change', (event) => {
        fileName = cambiarNombreInput(event.target.files[0].name);
        document.getElementById('label-foto-equipo-gnc').innerHTML = fileName;
        const parent = document.getElementById('label-foto-equipo-gnc').parentNode;
        parent.classList.add('correct-class');
    })


    // SUBMIT DE FORMULARIO DATOS VEHICULO
    document.getElementById('form-datos-vehiculo').addEventListener('submit', async(event) => {
        event.preventDefault();

        // Tomo valores de radio buttons
        const vehiculoUso     = document.querySelector('input[name="vehiculoUso"]:checked').value;
        const vehiculoDaniado = document.querySelector('input[name="vehiculoDaniado"]:checked').value;
        


        if (vehiculoUso === '0') {
            // Habilito mensaje error
            document.getElementById('error-validar-uso').hidden = false;
            return
        }

        if (vehiculoDaniado === '1') {
            document.getElementById('error-validar-danios').hidden = false;
            return
        }

        // Tomo datos de los campos
        const vehiculoDominio = document.getElementById('vehiculo-dominio').value;
        const vehiculoChasis  = document.getElementById('vehiculo-chasis').value;
        const vehiculoMotor   = document.getElementById('vehiculo-motor').value;

        // Traigo lead
        const token = await getToken(); 
        let lead    = await getLead(JSON.parse(cookieGuid),token)

        // Construyo nuevo lead
        const newLead = {
            ...lead,
            instanciaAlcanzada : 14,
            vehiculos: [{
                ...lead.vehiculos[0],
                patente             : vehiculoDominio,
                nroChasis           : vehiculoChasis,
                nroMotor            : vehiculoMotor,
                daniosPreexistentes : Number(vehiculoDaniado)

            }]
        }

        // Grabo datos de lead
        const res = await saveLead(token, newLead);

        //Grabo datos en la quote
        const data = {
            tag: 'vehiculoData',
            guid: lead.idLead,
            dataObject: {
                patente             : vehiculoDominio,
                nroChasis           : vehiculoChasis,
                nroMotor            : vehiculoMotor,
                daniosPreExistentes : Number(vehiculoDaniado)
            }
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

        if (!res.ok) {
            document.getElementById('error-validar-datos').hidden = false;
            return
        }


        // Oculto y muestro formulario de imagenes
        document.getElementById('form-datos-vehiculo').hidden = true;
        document.getElementById('box-form-datos-vehiculo').hidden = true;
        document.getElementById('section-upload-images').hidden = false;

        document.getElementById('label_campana').hidden = true;

        document.getElementById('form-datos-vehiculo').classList.remove('animate__animated');
        document.getElementById('form-datos-vehiculo').classList.remove('animate__fadeIn');


        document.getElementById('foto-frontal-izquierda').focus();
        document.getElementById('loader-error-images').hidden = true;
    })



    // SUBMIT FORMULARIO FOTOS
    document.getElementById('form-imagenes-vehiculo').addEventListener('submit', async(event) => {
        event.preventDefault();

        const imgFrenteCedula       = document.getElementById('foto-cedula-frente');
        const imgDorsoCedula        = document.getElementById('foto-cedula-dorso');
        const imgFrontalIzquierda   = document.getElementById('foto-frontal-izquierda');
        const imgFrontalDerecha     = document.getElementById('foto-frontal-derecha');
        const imgParteDelantera     = document.getElementById('foto-parte-delantera');
        const imgPartePosterior     = document.getElementById('foto-parte-posterior');

        // Imagenes adicionales
        const imgParabrisas        = document.getElementById('foto-parabrisas');
        const imgInterior          = document.getElementById('foto-interior');
        const imgTablero           = document.getElementById('foto-tablero');
        const imgTechoPanoramico   = document.getElementById('foto-techo-panoramico');
        const imgCubiertas         = document.getElementById('foto-cubiertas');
        const imgKilometraje       = document.getElementById('foto-kilometraje');
        const imgEquipoGnc         = document.getElementById('foto-equipo-gnc');

        // Si no hay imagenes muestro el error
        if (imgFrenteCedula.files[0] == undefined || imgDorsoCedula.files[0] == undefined || imgFrontalDerecha.files[0] == undefined || imgFrontalIzquierda.files[0] == undefined || imgParteDelantera.files[0] == undefined || imgPartePosterior.files[0] == undefined) {
            document.getElementById('loader-error-images').hidden = false;
            return
        }


        let fotos = [
            // TODO:
            {
                idFoto: 1,
                imagenNombre: `${lead.idLead.toUpperCase()}-foto-cedula-frente`,
                imagenExtension: imgFrontalIzquierda.files[0].type.replace(/(.*)\//g, ''),
                imagenData: await toBase64(imgFrenteCedula.files[0])
            },
            {
                idFoto: 2,
                imagenNombre: `${lead.idLead.toUpperCase()}-foto-cedula-dorso`,
                imagenExtension: imgFrontalIzquierda.files[0].type.replace(/(.*)\//g, ''),
                imagenData: await toBase64(imgFrenteCedula.files[0])
            },
            {
                idFoto: 3,
                imagenNombre: `${lead.idLead.toUpperCase()}-foto-izquierda`,
                imagenExtension: imgFrontalIzquierda.files[0].type.replace(/(.*)\//g, ''),
                imagenData: await toBase64(imgFrontalIzquierda.files[0])
            },
            {
                idFoto: 4,
                imagenNombre: `${lead.idLead.toUpperCase()}-foto-derecha`,
                imagenExtension: imgFrontalDerecha.files[0].type.replace(/(.*)\//g, ''),
                imagenData: await toBase64(imgFrontalDerecha.files[0])
            },
            {
                idFoto: 5,
                imagenNombre: `${lead.idLead.toUpperCase()}-foto-frente`,
                imagenExtension: imgParteDelantera.files[0].type.replace(/(.*)\//g, ''),
                imagenData: await toBase64(imgParteDelantera.files[0])
            },
            {
                idFoto: 6,
                imagenNombre: `${lead.idLead.toUpperCase()}-foto-atras`,
                imagenExtension: imgPartePosterior.files[0].type.replace(/(.*)\//g, ''),
                imagenData: await toBase64(imgPartePosterior.files[0])
            },

        ];


        if (imgParabrisas.files[0]) {
            fotos.push(
                {
                    idFoto: 7,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-parabrisas`,
                    imagenExtension: imgParabrisas.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgParabrisas.files[0])
                }
            )
        }

        if (imgInterior.files[0]) {
            fotos.push(
                {
                    idFoto: 8,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-interior`,
                    imagenExtension: imgInterior.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgInterior.files[0])
                }
            )
        }
        
        if (imgTablero.files[0]) {
            fotos.push(
                {
                    idFoto: 9,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-tablero`,
                    imagenExtension: imgTablero.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgTablero.files[0])
                }
            )
        }

        if (imgTechoPanoramico.files[0]) {
            fotos.push(
                {
                    idFoto: 10,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-techo-panoramico`,
                    imagenExtension: imgTechoPanoramico.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgTechoPanoramico.files[0])
                }
            )
        }

        if (imgCubiertas.files[0]) {
            fotos.push(
                {
                    idFoto: 11,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-cubiertas`,
                    imagenExtension: imgCubiertas.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgCubiertas.files[0])
                }
            )
        }

        if (imgKilometraje.files[0]) {
            fotos.push(
                {
                    idFoto: 12,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-kilometraje`,
                    imagenExtension: imgKilometraje.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgKilometraje.files[0])
                }
            )
        }
        
        if (imgEquipoGnc.files[0]) {
            fotos.push(
                {
                    idFoto: 13,
                    imagenNombre: `${lead.idLead.toUpperCase()}-foto-equipo-gnc`,
                    imagenExtension: imgEquipoGnc.files[0].type.replace(/(.*)\//g, ''),
                    imagenData: await toBase64(imgEquipoGnc.files[0])
                }
            )
        }

        const files = {
            idLead: JSON.parse(cookieGuid),
            item: 1,
            fotos
        }

        const response = await uploadFotos(token, files);

        if (response.ok) {
            // Grabo instancia alcanzada
            const token = await getToken();
            const lead  = await getLead(JSON.parse(cookieGuid), token)

            const newLead = {
                ...lead,
                instanciaAlcanzada: 15
            }

            await saveLead(token, newLead)


            // Instancia Alcanzada
            const instanciaAlcanzada = {
                cotizador: {
                    cotizacionFinalizada: true
                },
                checkout : {
                    paso : 3,
                }
            }

            document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";

            window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/asesores?${JSON.parse(cookieGuid)}`
        }
    })

    // FUNCIONALIDAD SUBIR FOTOS
    // Vehicle photos
    $(".ajax-upload-nuevo input").on("change", function (_event) {
        document.getElementById('loader-error-images').hidden = true;
        $(this).parent("form").trigger("submit");
    });

    var image_names = [];

    $(".ajax-upload-nuevo").on("submit", function (event) {

        // Validar que el nombre de archivo no se haya usado previamente
        let new_image = $(this).find("input:file").val();
        event.preventDefault();
        $(this).addClass("loading");
        window.form = $(event.target);
        $.ajax({
        url: themePath + "utils/upload_nuevo_checkout.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            data = data;
            let field_id = "hidden_" + data.image_name;
            $("#" + field_id).remove();
            $("#hidden-fields").append(
            '<input id="' +
                field_id +
                '" type="hidden" name="' +
                data.image_name +
                '" value="' +
                data.path +
                '">'
            );

            image_names.push(new_image);

            let file_selector = "#" + data.image_name;
            $(file_selector).addClass("is-valid");
            $(file_selector).parent().removeClass("loading");
        },
        error: function (e) {
            $(window.form).find("input").addClass("is-invalid");
        },
        });
    });


    // Button volver
    document.getElementById('button-volver').addEventListener('click', () => {
        document.getElementById('section-upload-images').hidden = true;
        document.getElementById('box-form-datos-vehiculo').hidden = false;
        document.getElementById('form-datos-vehiculo').classList.add('animate__animated', 'animate__fadeIn');
        document.getElementById('form-datos-vehiculo').hidden = false;

        document.getElementById('label_campana').hidden = false;
    })


    // ENVIAR DATOS A TRIPOLIS PARA CONTINUAR DE TELEFONO
    document.getElementById('continuarDelTelefono').addEventListener('click', (event) => {
        const data = {
            contactFields: {
                email: lead.email,
                nombre: lead.nombre,
                // Apellido: 'Prueba',
                urlrecupero: window.location.href,
                guid: lead.idLead,
                producto: 'seguro-de-autos-y-pick-ups'
            },
            contactGroup: 'recuperotesting',
            database: 'leads'
        }
        $.ajax({
        url: themePath + "utils/save_contact_tripolis.php",
        type: "POST",
        data: {data},
        success: function (data) {
            Swal.fire({
                text: `Enviaremos un mail a ${lead.email} para que puedas continuar con el proceso.`,
                icon: 'success',
                confirmButtonText: 'Aceptar'
              })
        },
        error: function (e) {
            Swal.fire({
                text: `Ocurrió un error, por favor continua con el proceso.`,
                icon: 'error',
                confirmButtonText: 'Aceptar'
              })
        }
    });

    })

})


const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result.split(',')[1]);
    reader.onerror = error => reject(error);
});


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

function cambiarNombreInput(fileName) {
    const newFileName = fileName.length > 10 ? `${fileName.slice(0, 10)}...<i class="fas fa-check check-style"></i>` : `${fileName}<i class="fas fa-check check-style"></i>`;
    
    return newFileName;
    
}

function funcionalidadBarraPasos() {
    const checkoutPaso1 = document.getElementById('checkout-paso-1');
    checkoutPaso1.style.cursor = "pointer";
    checkoutPaso1.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/datos-solicitante?${JSON.parse(cookieGuid)}`;
    })
}

// Masks Patentes
$(".validar-patente").inputmask("(aa999aa)|(aaa-999)|(999-aaa)|(a999aaa)", {
    placeholder: "-------",
    casing: "upper",
    clearIncomplete: true,
});
$(".validar-patente-auto").inputmask("(aa999aa)|(aaa-999)", {
    placeholder: "-------",
    casing: "upper",
    clearIncomplete: true,
});
$(".validar-patente-moto").inputmask("(999-aaa)|(a999aaa)", {
    placeholder: "-------",
    casing: "upper",
    clearIncomplete: true,
});


// Traer token
async function getToken() {
    const resp = await fetch(`${ themePath }utils/get_token.php`,{
        method: 'POST'
    });
    const res = await resp.json();
    return res;
}


// Traer datos cédula
async function getDataFromCedula(image, token) {
    const data = {
        image
    }

    const url = php_data.COOPSEG_VEHICLES_CEDULA_URL;
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization' : `Bearer ${token}`
            },
            body: JSON.stringify(data)
        });

        const res = await response.json();
        return res;
    } catch (error) {
        console.log(error)
    } 
}

async function saveLead(token, data) {
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
            return response;
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

async function uploadFotos(token, data) {
    url = php_data.COOPSEG_VEHICLES_CARGAR_INSPECCION_URL;
    const body = JSON.stringify(data);
    try {
        const response = await fetch(`${url}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization' : `Bearer ${token}`
            },
            body
        })
        return response;
    } catch (error) {
        console.log(error)
    }
}



async function procesarDatosAlInicio( guidParam ) {
    const token = await getToken();
    const lead  = await getLead( guidParam, token )

    // TRAIGO QUOTE
    var request = new XMLHttpRequest();
    request.open("GET", `${php_data.NuevaUrl}/quotes/${lead.idLead.toUpperCase()}.json`, false);
    request.send(null)
    var my_JSON_object = JSON.parse(request.responseText);
    const answersJSON = my_JSON_object.answers

    if (!lead) {
        window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
    }else {
        // Instancia Alcanzada
        const instanciaAlcanzada = {
            cotizador: {
                cotizacionFinalizada: true
            },
            checkout : {
                paso : 2,
            }
        }

        let nombrePlan = devuelveNombrePlan(lead.vehiculos[0].cobertura);



        // SETEO COOKIES NUEVAMENTE
        document.cookie = "datosPersonales="+JSON.stringify({
            "telefono": lead.telefono,
            "nombre": lead.nombre,
            "mail": lead.email,
            "telArea":"3213",
            "tel":"3213132",
            "nombreCompleto": `${lead.nombre} ${lead.apellido}`,
            "apellido": lead.apellido,
            "codcli": lead.codcli,
            "fechaNacimiento": lead.fechaNacimiento,
            "nroDNI": lead.dni,
            "idLocalidad": lead.idLocalidad,
            "calle": lead.calle,
            "nro": lead.nro,
            "piso": lead.piso,
            "departamento": lead.depto,
            "genero": lead.genero,
            "idNacionalidad": lead.idNacionalidad,
            "lugarNacimiento": lead.lugarNacimiento,
            "email": lead.email,
            "idActividad": lead.idActividad,
            "idEstadoCivil": lead.idEstadoCivil
        })+"; path = /";
        document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";
        document.cookie = "guid="+JSON.stringify(lead.idLead)+"; path = /";
        document.cookie = "datosVehiculo="+JSON.stringify({
            "idMarca": answersJSON.vehicleBrandId,
            "marca": answersJSON.vehicleBrand,
            "idModelo": answersJSON.vehicleModelId,
            "modelo": answersJSON.vehicleModel,
            "agno": answersJSON.vehicleYear,
            "idVersion": `${answersJSON.codVal},${answersJSON.codInfoAuto}`,
            "version": answersJSON.vehicleVersion,
            "fieldId": `${lead.idLocalidad},${lead.idNacionalidad}`,
            "zipCode": answersJSON.userIdCity,
            "cotiza":"1",
            "localidad": `${answersJSON.userCity}, ${answersJSON.userState}, ${answersJSON.userZip}`,
            "idGnc": answersJSON.vehicleGncID,
            "gnc": answersJSON.vehicleGnc,
            "codInfoAuto": answersJSON.codInfoAuto,
            "codval": answersJSON.codVal
        })+"; path = /";
        document.cookie = "datosPlan="+JSON.stringify({
            "cobertura": lead.vehiculos[0].cobertura,
            "suma": answersJSON.planSuma,
            "sumaAccesorio": answersJSON.vehicleGncValue,
            "premio": answersJSON.planPremio,
            "premioMensual": answersJSON.planPremioMensual,
            "premioReferencia": answersJSON.planPremioReferencia,
            "prima": answersJSON.planPrima,
            "codigoConvenio": answersJSON.codigoConvenio,
            "bonusMaxConvenio": answersJSON.bonusMaxConvenio,
            "bonusMaxAntiguedad": answersJSON.bonusMaxAntiguedad,
            "bonusMaxSuma": answersJSON.bonusMaxSuma,
            "fechaInicio": answersJSON.planFechaInicio,
            "fechaFin": answersJSON.planFechaFin,
            "franquicia": answersJSON.planFranquicia,
            "cantidadFotosRequeridas":2
        })+"; path = /";
        document.cookie = "planElejido="+JSON.stringify({
            "plan": lead.vehiculos[0].cobertura,
            "precio": `$${answersJSON.planPremioMensual.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`,
            "nombrePlan": nombrePlan
        })+"; path = /";
        document.cookie = "commonEvent="+JSON.stringify({
            "category":"vehiculos",
            "product":"seguro-de-autos-y-pick-ups",
            "vehicleBrand":lead.vehiculos[0].marca,
            "vehicleModel":lead.vehiculos[0].modelo,
            "vehicleYear":lead.vehiculos[0].anio,
            "vehicleVersion":lead.vehiculos[0].version
        })+"; path = /";

       
    }

}


function devuelveNombrePlan( cobertura ) {
    if (cobertura === 'B2' || cobertura === 'B1') {
        return 'Plan esencial';
    }else if (cobertura === 'C2' || cobertura === 'C1'|| cobertura === 'C3') {
        return 'Plan superior';
    }else {
        return 'Plan exclusivo';
    }
}