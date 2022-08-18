function procesarDatos(e) {
    e.preventDefault();
    console.log('Procesando...')
    var success = false;
    var params = [];
    var descripciones = [];

    var reclamanteNombre = document.getElementById('reclamante-nombre').value;
    var reclamanteApellido = document.getElementById('reclamante-apellido').value;
    var reclamanteDocNro = document.getElementById('reclamante-documento-numero').value;

    if (reclamanteNombre && reclamanteApellido && reclamanteDocNro) {

        // Datos del siniestro
        console.log(reclamanteNombre)
        var fecha = document.getElementById('fecha').value;
        var hora = document.getElementById('hora').value;
        var idTipoDamnificado = document.querySelector('input[name="damnificado-tipo"]:checked').value;
        var esReclamoFranquicia = document.getElementById('franquicia').value == "1" ? 'true' : 'false';
        var idTipoPersonaReclamante = document.querySelector('input[name="tipo-persona"]:checked').value;
        
        params['FechaHoraSiniestro']        = `${fecha} ${hora}`;
        params['idTipoDamnificado']         = idTipoDamnificado;
        params['EsReclamoFranquicia']       = esReclamoFranquicia;
        params['idTipoPersonaReclamante']   = idTipoPersonaReclamante;

        // Reclamante
        params['ApellidoReclamante']        = document.getElementById('reclamante-apellido').value;
        params['NombreReclamante']          = document.getElementById('reclamante-nombre').value;
        params['IdTipoDocumentoReclamante'] = document.getElementById('reclamante-documento-tipo').value;
        params['NroDocumentoReclamante']    = document.getElementById('reclamante-documento-numero').value;
        params['GeneroReclamante']          = document.getElementById('reclamante-genero').value;
        params['IdEstadoCivilReclamante']   = document.getElementById('reclamante-estado-civil').value;
        params['ActividadReclamante']       = document.getElementById('reclamante-ocupacion').value;
        params['CalleReclamante']           = document.getElementById('reclamante-calle').value;
        params['NroCalleReclamante']        = document.getElementById('reclamante-numero').value;
        params['IdLocalidadReclamante']     = document.getElementById('reclamante-localidad').value;
        params['TelefonoReclamante']        = document.getElementById('reclamante-telefono').value;
        params['EmailReclamante']           = document.getElementById('reclamante-email').value;

        // Otro
        params['ApellidoOtro']              = document.getElementById('otro-apellido').value ? document.getElementById('otro-apellido').value : '';
        params['NombreOtro']                = document.getElementById('otro-nombre').value ?  document.getElementById('otro-nombre').value : '';
        params['IdTipoDocumentoOtro']       = document.getElementById('otro-documento-tipo').value ?  document.getElementById('otro-documento-tipo').value : '';
        params['NroDocuementoOtro']         = document.getElementById('otro-documento-numero').value ?  document.getElementById('otro-documento-numero').value : '';
        params['TelefonoOtro']              = document.getElementById('otro-telefono').value ?  document.getElementById('otro-telefono').value : '';
        params['EmailOtro']                 = document.getElementById('otro-email').value ?  document.getElementById('otro-email').value : '';
        params['VinculoOtro']               = document.getElementById('otro-vinculo').value ?  document.getElementById('otro-vinculo').value : '';
    
        // Lugar
        params['idLugarSiniestro']          = document.getElementById('dano-lugar').value;
        params['idLocalidadSiniestro']      = document.getElementById('dano-lugar-localidad').value;
        params['DescripcionLugarSiniestro'] = document.getElementById('dano-lugar-descripcion').value;
    
        // Patente
        params['PatenteAsegurado']          = document.getElementById('patente-vehiculo-asegurado').value;

        // Contar tipos de siniestro
        var tiposDeSiniestro = 0;


        // ------------------------
        // Si hay reclamo de vehículos
        // ------------------------
        if (document.querySelector('input[name=tipoDeSiniestroVehiculos]').checked) {
            console.log('ingresa')
            params['idTipoSiniestro'] = 1;
            tiposDeSiniestro ++;
            
            // Incluir item como un Array
            params['Vehiculos'] = new Array();
            params['Vehiculos']['ApellidoDamnificado']         = document.getElementById('dano-apellido').value;
            params['Vehiculos']['NombreDamnificado']           = document.getElementById('dano-nombre').value;
            params['Vehiculos']['idTipoDocumentoDamnificado']  = document.getElementById('dano-documento-tipo').value;
            params['Vehiculos']['NroDocumentoDamnificado']     = document.getElementById('dano-documento-numero').value;
            params['Vehiculos']['GeneroDamnificado']           = document.getElementById('dano-genero').value;
            params['Vehiculos']['IdTipoVehiculo']              = document.getElementById('dano-vehiculo-tipo').value;
            params['Vehiculos']['Patente']                     = document.getElementById('patente-vehiculo-propio').value;
            params['Vehiculos']['Anio']                        = document.getElementById('dano-vehiculo-ano').value;
            params['Vehiculos']['Codval']                      = document.getElementById('dano-vehiculo-version').value ? document.getElementById('dano-vehiculo-version').value : '';
            params['Vehiculos']['VehiculoEstacionado']         = document.querySelector('input[name="dano-vehiculo-estacionado"]:checked').value === "si" ? 'true' : 'false';
            params['Vehiculos']['ApellidoConductor']           = document.getElementById('conductor-apellido').value ? document.getElementById('conductor-apellido').value : '';
            params['Vehiculos']['NombreConductor']             = document.getElementById('conductor-nombre').value ? document.getElementById('conductor-nombre').value : '';
            params['Vehiculos']['IdTipoDocumentoConductor']    = document.getElementById('conductor-documento-tipo').value ? document.getElementById('conductor-documento-tipo').value : '';
            params['Vehiculos']['NroDocumentoConductor']       = document.getElementById('conductor-documento-numero').value ? document.getElementById('conductor-documento-numero').value : '';
            params['Vehiculos']['CompaniaAseguradora']         = document.getElementById('dano-vehiculo-aseguradora-nombre').value ? document.getElementById('dano-vehiculo-aseguradora-nombre').value : '';
            params['Vehiculos']['PolizaTercero']               = document.getElementById('dano-vehiculo-aseguradora-poliza').value ? document.getElementById('dano-vehiculo-aseguradora-poliza').value : '';
            params['Vehiculos']['PolizaTercero']               = ''; //TODO:
            params['Vehiculos']['Franquicia']                  = document.getElementById('dano-franquicia-valor').value ? document.getElementById('dano-franquicia-valor').value : '';
            params['Vehiculos']['DescripcionSiniestro']        = document.getElementById('dano-vehiculos-descripcion').value;


            // Agregar a array de descripciones
            descripciones.push(document.getElementById('dano-vehiculos-descripcion').value);

            console.log(params)
            console.log(descripciones)
            
        }



        // ------------------------
        // Si hay reclamo de Lesiones
        // ------------------------
        if (document.querySelector('input[name=tipoDeSiniestroLesiones]').checked) {

            params['idTipoSiniestro'] = 2;
            tiposDeSiniestro ++;


            params['Lesiones'] = new Array();
            params['Lesiones']['ApellidoDamnificado']          = document.getElementById('dano-apellido').value;
            params['Lesiones']['NombreDamnificado']            = document.getElementById('dano-nombre').value;
            params['Lesiones']['IdTipoDocumentoDamnificado']   = document.getElementById('dano-documento-tipo').value;
            params['Lesiones']['NroDocumentoDamnificado']      = document.getElementById('dano-documento-numero').value;
            params['Lesiones']['GeneroDamnificado']            = document.getElementById('dano-genero').value;
            params['Lesiones']['TipoLesion']                   = document.getElementById('dano-tipo-lesion').value;
            params['Lesiones']['NombreCentroSalud']            = document.getElementById('dano-centro-nombre').value;
            params['Lesiones']['IdLocalidadCentroSalud']       = document.getElementById('dano-centro-ubicacion').value;
            params['Lesiones']['NombreART']                    = document.getElementById('dano-art-nombre').value ? document.getElementById('dano-art-nombre').value : '';
            params['Lesiones']['DescripcionSiniestro']         = document.getElementById('dano-lesiones-descripcion').value;

            // Agregar a array de descripciones
            descripciones.push(document.getElementById('dano-lesiones-descripcion').value);
            console.log(params)
            console.log(descripciones)

        }


        // ------------------------
        // Si hay reclamo de Daños materiales
        // ------------------------
        if (document.querySelector('input[name=tipoDeSiniestroMateriales]').checked) {

            params['idTipoSiniestro'] = 3;
            tiposDeSiniestro ++;

            params['DaniosMateriales'] = new Array();
            params['DaniosMateriales']['ApellidoDamnificado'] = document.getElementById('dano-apellido').value; 
            params['DaniosMateriales']['NombreDamnificado'] = document.getElementById('dano-nombre').value; 
            params['DaniosMateriales']['IdTipoDocumentoDamnificado'] = document.getElementById('dano-documento-tipo').value; 
            params['DaniosMateriales']['NroDocumentoDamnificado'] = document.getElementById('dano-documento-numero').value; 
            params['DaniosMateriales']['GeneroDamnificado'] = document.getElementById('dano-genero').value; 
            params['DaniosMateriales']['CalleDanioMaterial'] = document.getElementById('dano-calle').value; 
            params['DaniosMateriales']['NroDanioMaterial'] = document.getElementById('dano-numero').value; 
            params['DaniosMateriales']['IdLocalidadDanioMaterial'] = document.getElementById('dano-localidad').value; 
            params['DaniosMateriales']['NombreAseguradora'] = document.getElementById('dano-seguro-aseguradora').value ? document.getElementById('dano-seguro-aseguradora').value : '';
            params['DaniosMateriales']['DescripcionSiniestro'] = document.getElementById('dano-materiales-descripcion').value; 


            // Agregar a array de descripciones
            descripciones.push(document.getElementById('dano-materiales-descripcion').value);
            console.log(params)
            console.log(descripciones)
        }
    }

    if (tiposDeSiniestro > 1) {
        params['IdTipoSiniestro'] = 4
    }

    console.log(params)


    
}




function getToken(datos) {
    const resp = fetch('https://wstest.cooperacionseguros.com.ar/cmpservicesTest/token', {
        method: "POST",
        body: JSON.stringify(datos),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })
    .then(response => response.json())
    .then( json => console.log(json))
    .catch(err => console.log('Error: ', err))
}