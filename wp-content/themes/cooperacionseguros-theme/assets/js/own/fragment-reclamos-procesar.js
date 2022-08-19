window.onload = function () {
    var date = new Date();
    


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


        // params['FechaHoraSiniestro']        = `${fecha} ${hora}`;
        // params['idTipoDamnificado']         = idTipoDamnificado;
        // params['EsReclamoFranquicia']       = esReclamoFranquicia;
        // params['idTipoPersonaReclamante']   = idTipoPersonaReclamante;

        
        // Reclamante
        // params['ApellidoReclamante']        = document.getElementById('reclamante-apellido').value;
        // params['NombreReclamante']          = document.getElementById('reclamante-nombre').value;
        // params['IdTipoDocumentoReclamante'] = document.getElementById('reclamante-documento-tipo').value;
        // params['NroDocumentoReclamante']    = document.getElementById('reclamante-documento-numero').value;
        // params['GeneroReclamante']          = document.getElementById('reclamante-genero').value;
        // params['IdEstadoCivilReclamante']   = document.getElementById('reclamante-estado-civil').value;
        // params['ActividadReclamante']       = document.getElementById('reclamante-ocupacion').value;
        // params['CalleReclamante']           = document.getElementById('reclamante-calle').value;
        // params['NroCalleReclamante']        = document.getElementById('reclamante-numero').value;
        // params['IdLocalidadReclamante']     = document.getElementById('reclamante-localidad').value;
        // params['TelefonoReclamante']        = document.getElementById('reclamante-telefono').value;
        // params['EmailReclamante']           = document.getElementById('reclamante-email').value;
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
        // params['ApellidoOtro']              = document.getElementById('otro-apellido').value ? document.getElementById('otro-apellido').value : '';
        // params['NombreOtro']                = document.getElementById('otro-nombre').value ?  document.getElementById('otro-nombre').value : '';
        // params['IdTipoDocumentoOtro']       = document.getElementById('otro-documento-tipo').value ?  document.getElementById('otro-documento-tipo').value : '';
        // params['NroDocuementoOtro']         = document.getElementById('otro-documento-numero').value ?  document.getElementById('otro-documento-numero').value : '';
        // params['TelefonoOtro']              = document.getElementById('otro-telefono').value ?  document.getElementById('otro-telefono').value : '';
        // params['EmailOtro']                 = document.getElementById('otro-email').value ?  document.getElementById('otro-email').value : '';
        // params['VinculoOtro']               = document.getElementById('otro-vinculo').value ?  document.getElementById('otro-vinculo').value : '';
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
        // params['idLugarSiniestro']          = document.getElementById('dano-lugar').value;
        // params['idLocalidadSiniestro']      = document.getElementById('dano-lugar-localidad').value;
        // params['DescripcionLugarSiniestro'] = document.getElementById('dano-lugar-descripcion').value;
        params = {
            ...params,
            idLugarSiniestro            : document.getElementById('dano-lugar').value,
            idLocalidadSiniestro        : document.getElementById('dano-lugar-localidad').value,
            DescripcionLugarSiniestro   : document.getElementById('dano-lugar-descripcion').value
        }

        // Patente
        // params['PatenteAsegurado']          = document.getElementById('patente-vehiculo-asegurado').value;
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
            // params['Vehiculos'] = new Array();
            // params['Vehiculos']['ApellidoDamnificado']         = document.getElementById('dano-apellido').value;
            // params['Vehiculos']['NombreDamnificado']           = document.getElementById('dano-nombre').value;
            // params['Vehiculos']['idTipoDocumentoDamnificado']  = document.getElementById('dano-documento-tipo').value;
            // params['Vehiculos']['NroDocumentoDamnificado']     = document.getElementById('dano-documento-numero').value;
            // params['Vehiculos']['GeneroDamnificado']           = document.getElementById('dano-genero').value;
            // params['Vehiculos']['IdTipoVehiculo']              = document.getElementById('dano-vehiculo-tipo').value;
            // params['Vehiculos']['Patente']                     = document.getElementById('patente-vehiculo-propio').value;
            // params['Vehiculos']['Anio']                        = document.getElementById('dano-vehiculo-ano').value;
            // params['Vehiculos']['Codval']                      = document.getElementById('dano-vehiculo-version').value ? document.getElementById('dano-vehiculo-version').value : '';
            // params['Vehiculos']['VehiculoEstacionado']         = document.querySelector('input[name="dano-vehiculo-estacionado"]:checked').value === "si" ? 'true' : 'false';
            // params['Vehiculos']['ApellidoConductor']           = document.getElementById('conductor-apellido').value ? document.getElementById('conductor-apellido').value : '';
            // params['Vehiculos']['NombreConductor']             = document.getElementById('conductor-nombre').value ? document.getElementById('conductor-nombre').value : '';
            // params['Vehiculos']['IdTipoDocumentoConductor']    = document.getElementById('conductor-documento-tipo').value ? document.getElementById('conductor-documento-tipo').value : '';
            // params['Vehiculos']['NroDocumentoConductor']       = document.getElementById('conductor-documento-numero').value ? document.getElementById('conductor-documento-numero').value : '';
            // params['Vehiculos']['CompaniaAseguradora']         = document.getElementById('dano-vehiculo-aseguradora-nombre').value ? document.getElementById('dano-vehiculo-aseguradora-nombre').value : '';
            // params['Vehiculos']['PolizaTercero']               = document.getElementById('dano-vehiculo-aseguradora-poliza').value ? document.getElementById('dano-vehiculo-aseguradora-poliza').value : '';
            // params['Vehiculos']['PolizaTercero']               = ''; //TODO:
            // params['Vehiculos']['Franquicia']                  = document.getElementById('dano-franquicia-valor').value ? document.getElementById('dano-franquicia-valor').value : '';
            // params['Vehiculos']['DescripcionSiniestro']        = document.getElementById('dano-vehiculos-descripcion').value;
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


            // params['Lesiones'] = new Array();
            // params['Lesiones']['ApellidoDamnificado']          = document.getElementById('dano-apellido').value;
            // params['Lesiones']['NombreDamnificado']            = document.getElementById('dano-nombre').value;
            // params['Lesiones']['IdTipoDocumentoDamnificado']   = document.getElementById('dano-documento-tipo').value;
            // params['Lesiones']['NroDocumentoDamnificado']      = document.getElementById('dano-documento-numero').value;
            // params['Lesiones']['GeneroDamnificado']            = document.getElementById('dano-genero').value;
            // params['Lesiones']['TipoLesion']                   = document.getElementById('dano-tipo-lesion').value;
            // params['Lesiones']['NombreCentroSalud']            = document.getElementById('dano-centro-nombre').value;
            // params['Lesiones']['IdLocalidadCentroSalud']       = document.getElementById('dano-centro-ubicacion').value;
            // params['Lesiones']['NombreART']                    = document.getElementById('dano-art-nombre').value ? document.getElementById('dano-art-nombre').value : '';
            // params['Lesiones']['DescripcionSiniestro']         = document.getElementById('dano-lesiones-descripcion').value;
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

            // params['DaniosMateriales'] = new Array();
            // params['DaniosMateriales']['ApellidoDamnificado'] = document.getElementById('dano-apellido').value; 
            // params['DaniosMateriales']['NombreDamnificado'] = document.getElementById('dano-nombre').value; 
            // params['DaniosMateriales']['IdTipoDocumentoDamnificado'] = document.getElementById('dano-documento-tipo').value; 
            // params['DaniosMateriales']['NroDocumentoDamnificado'] = document.getElementById('dano-documento-numero').value; 
            // params['DaniosMateriales']['GeneroDamnificado'] = document.getElementById('dano-genero').value; 
            // params['DaniosMateriales']['CalleDanioMaterial'] = document.getElementById('dano-calle').value; 
            // params['DaniosMateriales']['NroDanioMaterial'] = document.getElementById('dano-numero').value; 
            // params['DaniosMateriales']['IdLocalidadDanioMaterial'] = document.getElementById('dano-localidad').value; 
            // params['DaniosMateriales']['NombreAseguradora'] = document.getElementById('dano-seguro-aseguradora').value ? document.getElementById('dano-seguro-aseguradora').value : '';
            // params['DaniosMateriales']['DescripcionSiniestro'] = document.getElementById('dano-materiales-descripcion').value; 
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

        var fecha = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + date.getFullYear()
        var hora = `${date.getHours()}:${date.getMinutes()}`;
        var fechaHora = `${fecha} ${hora}`
        
        var files = {}
        files = {
            NroReclamoTercero: code,
            FechaHora: fechaHora
        }
        document.getElementsByClassName('file')
    }else {
        console.log('Error en Enviar params');
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