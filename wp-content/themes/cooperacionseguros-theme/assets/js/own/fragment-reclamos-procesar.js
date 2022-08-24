window.onload = async function () {
    var date = new Date();
    alert(`${php_data.NuevaUrl}/fragment-tripolis.php`)
    // window.location = `${php_data.NuevaUrl}/fragment-tripolis.php`
    // await fetch('http://localhost:8080/cooperacion_local/fragment-tripolis.php')

}
async function procesarDatos(e) {
    e.preventDefault();
    console.log('Procesando...')



    var success = false;
    var params = {};
    var descripciones = [];

    var reclamanteNombre = document.getElementById('reclamante-nombre').value;
    var reclamanteApellido = document.getElementById('reclamante-apellido').value;
    var reclamanteDocNro = document.getElementById('reclamante-documento-numero').value;

    if (reclamanteNombre && reclamanteApellido && reclamanteDocNro) {

        // Formatear Fecha
        function convertDigitIn(str){
            return str.split('-').reverse().join('-');
        }

        // Datos del siniestro
        console.log(reclamanteNombre)
        var fecha = convertDigitIn(document.getElementById('fecha').value);
        var hora = document.getElementById('hora').value;
        var idTipoDamnificado = document.querySelector('input[name="damnificado-tipo"]:checked').value;
        var esReclamoFranquicia = document.getElementById('franquicia').value == "1" ? 'true' : 'false';
        var idTipoPersonaReclamante = document.querySelector('input[name="tipo-persona"]:checked').value;
        
        params = {
            FechaHoraSiniestro      : `${fecha}T${hora}`,
            idTipoDamnificado       : idTipoDamnificado,
            EsReclamoFranquicia     : esReclamoFranquicia,
            idTipoPersonaReclamante               
        }



        
        // Reclamante
        params = {
            ...params,
            ApellidoReclamante          : document.getElementById('reclamante-apellido').value,
            NombreReclamante            : document.getElementById('reclamante-nombre').value,
            IdTipoDocumentoReclamante   : document.getElementById('reclamante-documento-tipo').value,
            NroDocumentoReclamante      : document.getElementById('reclamante-documento-numero').value,
            GeneroReclamante            : document.getElementById('reclamante-genero').value,
            IdEstadoCivilReclamante     : document.getElementById('reclamante-estado-civil').value,
            ActividadReclamante         : document.getElementById('reclamante-ocupacion').value,
            CalleReclamante             : document.getElementById('reclamante-calle').value,
            NroCalleReclamante          : document.getElementById('reclamante-numero').value,
            IdLocalidadReclamante       : document.getElementById('reclamante-localidad').value,
            TelefonoReclamante          : document.getElementById('reclamante-telefono').value,
            EmailReclamante             : document.getElementById('reclamante-email').value
        }

        // Otro
        params = {
            ...params,
            ApellidoOtro        : document.getElementById('otro-apellido').value ? document.getElementById('otro-apellido').value : '',
            NombreOtro          : document.getElementById('otro-nombre').value ?  document.getElementById('otro-nombre').value : '',
            IdTipoDocumentoOtro : document.getElementById('otro-documento-tipo').value ?  document.getElementById('otro-documento-tipo').value : '',
            NroDocuementoOtro   : document.getElementById('otro-documento-numero').value ?  document.getElementById('otro-documento-numero').value : '',
            TelefonoOtro        : document.getElementById('otro-telefono').value ?  document.getElementById('otro-telefono').value : '',
            EmailOtro           : document.getElementById('otro-email').value ?  document.getElementById('otro-email').value : '',
            VinculoOtro         : document.getElementById('otro-vinculo').value ?  document.getElementById('otro-vinculo').value : ''
        }


        // Lugar
        params = {
            ...params,
            idLugarSiniestro            : document.getElementById('dano-lugar').value,
            idLocalidadSiniestro        : document.getElementById('dano-lugar-localidad').value,
            DescripcionLugarSiniestro   : document.getElementById('dano-lugar-descripcion').value
        }

        // Patente
        params = {
            ...params,
            PatenteAsegurado : document.getElementById('patente-vehiculo-asegurado').value
        }

        // Contar tipos de siniestro
        var tiposDeSiniestro = 0;


        // ------------------------
        // Si hay reclamo de vehículos
        // ------------------------
        if (document.querySelector('input[name=tipoDeSiniestroVehiculos]').checked) {
            console.log('ingresa')
            params.idTipoSiniestro = 1;
            tiposDeSiniestro ++;
            
            // Incluir item como un Array
            params = {
                ...params,
                Vehiculos : [{
                    ApellidoDamnificado         : document.getElementById('dano-apellido').value,
                    NombreDamnificado           : document.getElementById('dano-nombre').value,
                    idTipoDocumentoDamnificado  : document.getElementById('dano-documento-tipo').value,
                    NroDocumentoDamnificado     : document.getElementById('dano-documento-numero').value,
                    GeneroDamnificado           : document.getElementById('dano-genero').value,
                    IdTipoVehiculo              : document.getElementById('dano-vehiculo-tipo').value,
                    Patente                     : document.getElementById('patente-vehiculo-propio').value,
                    Anio                        : document.getElementById('dano-vehiculo-ano').value,
                    Codval                      : document.getElementById('dano-vehiculo-version').value ? document.getElementById('dano-vehiculo-version').value : '',
                    VehiculoEstacionado         : document.querySelector('input[name="dano-vehiculo-estacionado"]:checked').value === "si" ? 'true' : 'false',
                    ApellidoConductor           : document.getElementById('conductor-apellido').value ? document.getElementById('conductor-apellido').value : '',
                    NombreConductor             : document.getElementById('conductor-nombre').value ? document.getElementById('conductor-nombre').value : '',
                    IdTipoDocumentoConductor    : document.getElementById('conductor-documento-tipo').value ? document.getElementById('conductor-documento-tipo').value : '',
                    NroDocumentoConductor       : document.getElementById('conductor-documento-numero').value ? document.getElementById('conductor-documento-numero').value : '',
                    CompaniaAseguradora         : document.getElementById('dano-vehiculo-aseguradora-nombre').value ? document.getElementById('dano-vehiculo-aseguradora-nombre').value : '',
                    PolizaTercero               : document.getElementById('dano-vehiculo-aseguradora-poliza').value ? document.getElementById('dano-vehiculo-aseguradora-poliza').value : '',
                    PolizaTercero               : '', // TODO:
                    Franquicia                  : document.getElementById('dano-franquicia-valor').value ? document.getElementById('dano-franquicia-valor').value : '',
                    DescripcionSiniestro        : document.getElementById('dano-vehiculos-descripcion').value
                }]
            }


            // Agregar a array de descripciones
            descripciones.push(document.getElementById('dano-vehiculos-descripcion').value);

            console.log(params)
            console.log(descripciones)
            
        }



        // ------------------------
        // Si hay reclamo de Lesiones
        // ------------------------
        if (document.querySelector('input[name=tipoDeSiniestroLesiones]').checked) {

            params.idTipoSiniestro = 2;
            tiposDeSiniestro ++;


            params = {
                ...params,
                Lesiones : [{
                    ApellidoDamnificado         : document.getElementById('dano-apellido').value,
                    NombreDamnificado           : document.getElementById('dano-nombre').value,
                    IdTipoDocumentoDamnificado  : document.getElementById('dano-documento-tipo').value,
                    NroDocumentoDamnificado     : document.getElementById('dano-documento-numero').value,
                    GeneroDamnificado           : document.getElementById('dano-genero').value,
                    TipoLesion                  : document.getElementById('dano-tipo-lesion').value,
                    NombreCentroSalud           : document.getElementById('dano-centro-nombre').value,
                    IdLocalidadCentroSalud      : document.getElementById('dano-centro-ubicacion').value,
                    NombreART                   : document.getElementById('dano-art-nombre').value ? document.getElementById('dano-art-nombre').value : '',
                    DescripcionSiniestro        : document.getElementById('dano-lesiones-descripcion').value
                }]
            }
            // Agregar a array de descripciones
            descripciones.push(document.getElementById('dano-lesiones-descripcion').value);
            console.log(params)
            console.log(descripciones)

        }


        // ------------------------
        // Si hay reclamo de Daños materiales
        // ------------------------
        if (document.querySelector('input[name=tipoDeSiniestroMateriales]').checked) {

            params.idTipoSiniestro = 3;
            tiposDeSiniestro ++;

            params = {
                ...params,
                DaniosMateriales: [{
                    ApellidoDamnificado         : document.getElementById('dano-apellido').value,
                    NombreDamnificado           : document.getElementById('dano-nombre').value,
                    IdTipoDocumentoDamnificado  : document.getElementById('dano-documento-tipo').value,
                    NroDocumentoDamnificado     : document.getElementById('dano-documento-numero').value,
                    GeneroDamnificado           : document.getElementById('dano-genero').value,
                    CalleDanioMaterial          : document.getElementById('dano-calle').value,
                    NroDanioMaterial            : document.getElementById('dano-numero').value,
                    IdLocalidadDanioMaterial    : document.getElementById('dano-localidad').value,
                    NombreAseguradora           : document.getElementById('dano-seguro-aseguradora').value ? document.getElementById('dano-seguro-aseguradora').value : '',
                    DescripcionSiniestro        : document.getElementById('dano-materiales-descripcion').value
                }]
            }

            // Agregar a array de descripciones
            descripciones.push(document.getElementById('dano-materiales-descripcion').value);
            console.log(params)
            console.log(descripciones)
        }
    

    if (tiposDeSiniestro > 1) {
        params.idTipoSiniestro = 4
    }

    console.log(params)
    const tokenTercero = await getToken();
    var result = await ingresoReclamoTercero(tokenTercero.access_token, params);
    console.log(result)

    if (result && ( result !== '"Error no controlado."' )) {
        console.log('Ingreso!');
        var code = result.replace(/[^\d]/g, "");

        // Enviar archivos
        var uploadDir = `${php_data.templateUrl}/${php_data.COOPSEG_QUOTE_IMAGES_DIR}`;

        var newDate = new Date();
        var fecha = ((newDate.getMonth() > 8) ? (newDate.getMonth() + 1) : ('0' + (newDate.getMonth() + 1))) + '-' + ((newDate.getDate() > 9) ? newDate.getDate() : ('0' + newDate.getDate())) + '-' + newDate.getFullYear()
        var hora = `${newDate.getHours()}:${newDate.getMinutes()}`;
        var fechaHora = `${fecha} ${hora}`
        
        var files = {}
        files = {
            NroReclamoTercero: code,
            FechaHora: fechaHora,
            Archivos: []
        }
        
        $("#reclamos-de-terceros-form").find("input[type=file]").each(async function(index, field){
            const file = field.files[0];


              if(file) {
                var extension = file.name.split('.').pop();
                var fileName = `${code}-${field.name}`;
                var fieldId = field.id;
                var imageId = `image-${fieldId}`;
                var ContenidoArchivo = document.getElementById(imageId).src;
                var base64result = ContenidoArchivo.substr(ContenidoArchivo.indexOf(',') + 1);
                    
                console.log(base64result)
                files.Archivos.push({
                    NombreArchivo: fileName,
                    ExtensionArchivo: extension,
                    ContenidoArchivo: base64result
                })
            }
            
        });
        console.log(files)

        const inspeccion = await ingresoInspeccion(tokenTercero.access_token, files)
        var sectionReclamoTercero = document.getElementById("reclamos-de-terceros")

        if (inspeccion && inspeccion.status === 200) {
            success = true;
        } else {
            console.log('Error en - Reclamo Inspeccion');
        }
    }else {
        console.log('Error en - Reclamo Agregar')
    }
}else {
    console.log('Error - Invalid POST')
} 



    if (success) {
            const data = {
                
            database : 'reclamosterceros',
            contactGroup : 'terceros',
            contactFields : {
                guid : `test-${code}`,
                email : params.EmailReclamante,
                nombreyapellido : `${reclamanteNombre} ${reclamanteApellido}`,
                numerodereclamo : code,
                detalle : (`Patente: ${params.PatenteAsegurado} - ${descripciones[0]}`).substring(0,255),
            }
        
        };

        console.log(data)
        

        sectionReclamoTercero.innerHTML = 
        `
        <div class="confirmacion wrap">
        <header class="header">
        <h1>Tu reclamo fue ingresado</h1>
        <p class="aviso">Número de reclamo: <strong>${ code }</strong></p>
        <p>Tu reclamo fue ingresado correctamente. En breve recibirás por e-mail tu número de reclamo para que puedas hacer seguimiento online de su estado. Si te queda alguna duda podés <a href="/contacto/">contactarnos</a> o consultar <a href="/ayuda/">nuestra sección de ayuda</a>.</p>
        <p class="action"><a href="/" class="btn">Volver al inicio</a></p>
        </header>
        </div>
        `;


       const resp = await fetch(`${php_data.NuevaUrl}/fragment-tripolis.php`,{
        method: "POST",
        body: JSON.stringify(data)
       })

       console.log(resp)
       const respuesta = await resp.json();
       console.log(respuesta)
       

        
    } else {
        sectionReclamoTercero.innerHTML = 
        `
        <div class="wrap">
        <header class="header">
        <h1>Hubo un problema</h1>
        <p>Se produjo un problema al enviar tu reclamo. Por favor comunicate con nuestro equipo de Atención al Cliente: <a href="mailto:' .  get_theme_mod('custom_option_email') . '">' .  get_theme_mod('custom_option_email') . '</a> –  Teléfono: <strong>' .  get_theme_mod('custom_option_phone') . '</strong>, de lunes a viernes en el horario de 7 a 20hs.</p>
        </header>
        </div>
        `
    }

}





async function getToken() {
    try {
        const response = await fetch(php_data.COOPSEG_TOKEN_URL, {
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                'grant_type': php_data.COOPSEG_CONFIG_GRANT_TYPE,
                'client_id' : php_data.COOPSEG_CONFIG_TERCEROS_CLIENT_ID,
                'client_secret' : php_data.COOPSEG_CONFIG_TERCEROS_CLIENT_SECRET
            })
        })
        const res = await response.json();
        console.log(res)
        return res
    } catch (error) {
        console.log(error)
        throw new Error(error);
    }
}


async function ingresoReclamoTercero(tokenTercero, data) {
    try {
        const response = await fetch(php_data.COOPSEG_RECLAMOS_AGREGAR, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${tokenTercero}`
            },
            body: JSON.stringify(data)
        })
        console.log(response);
        const res = await response.json();
        console.log(res)
        return res
    } catch (error) {
        console.log(error)
    }
}

async function ingresoInspeccion(tokenTercero, files) {
    try {
        const response = await fetch(php_data.COOPSEG_RECLAMOS_INSPECCION, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${tokenTercero}`
            },
            body: JSON.stringify(files)
        })
        console.log(response);
        return response
    } catch (e) {
        console.log(e)
    }
}
