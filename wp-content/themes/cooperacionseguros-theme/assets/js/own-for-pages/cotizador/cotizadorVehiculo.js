// ONCHANGE INPUTS SELECT DE FORMULARIO VEHICULO

window.addEventListener('load', async() => {

    // Seteo campo localidad
    campoLocalidad();

    // MuestroForm y quito Loader
    document.getElementById('loader-cedula').hidden = true;
    document.getElementById('cuadro-vehiculo').hidden = false;
    document.getElementById('pasos-vehiculo').hidden = false;

    // Activo boton de continuar
    document.getElementById("buttonContinuar").disabled = false;

    vehiculoMarca = document.getElementById("marca-nuevo");
    vehiculoModelo = document.getElementById("model");
    vehiculoAnio = document.getElementById("agnoNew");
    vehiculoVersion = document.getElementById("version");
    vehiculoLocalidad = document.getElementById("localidad");
    vehiculoGNC = document.getElementById("gnc");


    const cookie = getCookie("datosVehiculo")
    if (cookie == null) {
        inicioSeleccion();
    }else {
        setCampos(cookie);
    }
});




async function cambioFormVehiculo( event ) {
    campoModificado = event.target.id;



    switch (campoModificado) {
        case vehiculoMarca.id:
            vehiculoModelo.disabled = false;
            data = await buscar("buscarModelos"); 
            modelos = data.modelos;
            reestablecerCampo(vehiculoModelo);
            reestablecerCampo(vehiculoAnio);
            reestablecerCampo(vehiculoVersion);
            reestablecerCampo(vehiculoGNC);
            modelos.forEach(function(modelo){
                opcion = document.createElement("option");
                opcion.value = modelo.idModelo;
                opcion.innerHTML = modelo.modelo;
                vehiculoModelo.appendChild(opcion);
            });

            localStorage.setItem("modelos", JSON.stringify(modelos));
            $('.selectores-modelo').css("pointer-events", "auto");
            vehiculoModelo.focus();
            break;
    
        case vehiculoModelo.id:
            vehiculoAnio.disabled = false;
            data= await buscar("buscarAños"); 
            anios = data.anios;
            reestablecerCampo(vehiculoAnio);
            reestablecerCampo(vehiculoVersion);
            reestablecerCampo(vehiculoGNC);
            anios.forEach(function(anio){
                opcion = document.createElement("option");
                opcion.value = anio;
                opcion.innerHTML = anio;
                vehiculoAnio.appendChild(opcion);
            });

            localStorage.setItem("anio", JSON.stringify(anios));
            $('.selectores-ano').css("pointer-events", "auto");
            vehiculoAnio.focus();
            break;
        
        case vehiculoAnio.id:
            vehiculoVersion.disabled = false;
            data = await buscar("buscarVersiones");
            versiones = data.versiones;      
            reestablecerCampo(vehiculoVersion);
            reestablecerCampo(vehiculoGNC);
            versiones.forEach(function(version){
                opcion = document.createElement("option");
                opcion.value = [version.codval, version.codia];
                opcion.innerHTML = version.modelo;
                vehiculoVersion.appendChild(opcion);
            });
            localStorage.setItem("versiones", JSON.stringify(versiones));    
            $('.selectores-version').css("pointer-events", "auto");
            vehiculoVersion.focus();
            break;

            
        case vehiculoVersion.id:
            vehiculoLocalidad.disabled = false;

            reestablecerCampo(vehiculoGNC);



            data = await buscar("buscarGNC"); 
            gnc = data.gnc;
            reestablecerCampo(vehiculoGNC);
            opcion = document.createElement("option");
            opcion.value = 0;
            opcion.innerHTML = "Sin G.N.C.";
            vehiculoGNC.appendChild(opcion);
            gnc.forEach(function(gnc){
                opcion = document.createElement("option");
                opcion.value = gnc.valor;
                opcion.innerHTML = gnc.detalle;
                vehiculoGNC.appendChild(opcion);
            });


            vehiculoLocalidad.focus();
            break;
        
        case vehiculoLocalidad.id:
            if (vehiculoGNC.value !== "") {
                return
            }
            vehiculoGNC.disabled = false;
            data = await buscar("buscarGNC"); 
            gnc = data.gnc;
            reestablecerCampo(vehiculoGNC);
            opcion = document.createElement("option");
            opcion.value = 0;
            opcion.innerHTML = "Sin G.N.C.";
            vehiculoGNC.appendChild(opcion);
            gnc.forEach(function(gnc){
                opcion = document.createElement("option");
                opcion.value = gnc.valor;
                opcion.innerHTML = gnc.detalle;
                vehiculoGNC.appendChild(opcion);
            });
            localStorage.setItem("gnc", JSON.stringify(gnc));
            $('.selectores-gnc').css("pointer-events", "auto");
            vehiculoGNC.focus();
            break;
    }
}


function reestablecerCampo(campo) {
    campo.innerHTML = "";
    opcion = document.createElement("option");
    opcion.value = '';
    switch (campo.id) {
        case "marca-nuevo":
            opcion.innerHTML = "Seleccione una marca";
            break;

        case "model":
            opcion.innerHTML = "Seleccione un modelo";
            break;
        
        case "agnoNew":
            opcion.innerHTML = "Seleccione un año";        
            break;

        case "version":
            opcion.innerHTML = "Seleccione una versión";   
            break;

            
        case "gnc":
            opcion.innerHTML = "Seleccione una opción";   
            break;
    }
    campo.appendChild(opcion);
}


async function inicioSeleccion(){


    
    $misDatos= await buscar("buscarMarcas");
    $marcas = $misDatos.marcas;
    $selMarca = document.getElementById("marca-nuevo");
    $selMarca.innerHTML = "";
    $opcion = document.createElement("option");
        $opcion.value = '';
        $opcion.innerHTML = "Seleccione una marca";
        $selMarca.appendChild($opcion);
    $marcas.forEach(function(marca, index){
        $opcion = document.createElement("option");
        $opcion.value = marca.idMarca;
        $opcion.innerHTML = marca.marca;
        $selMarca.appendChild($opcion);
        
    });

    localStorage.setItem("marcas", JSON.stringify($marcas));

    $('.selectores-marca').css("pointer-events", "auto");
    document.getElementById("marca-nuevo").focus();
}

async function buscar(action){
    $url = `${php_data.NuevaUrl}/template-parts/cotizador/completa_datos.php`;
    $action = action;
    
    if($action == "buscarModelos"){
        $body=JSON.stringify({
            idMarca: vehiculoMarca.value,
            action: $action,
        });
    }else if($action == "buscarAños"){
        $body=JSON.stringify({
            idModelo: vehiculoModelo.value,
            action: $action,
        });
    }else if($action == "buscarVersiones"){
        $body=JSON.stringify({
            idModelo: vehiculoModelo.value,
            idAnio: vehiculoAnio.value,
            action: $action,
        });
    }else if($action == "buscarGNC"){
        $body=JSON.stringify({
            query: "g.n.c",
            action: $action,
        });
    }else if($action == "buscarLocalidades"){
        // CAMBIO POR SELECT2
    }else if($action == "buscarMarcas"){
        $body=JSON.stringify({
            action: $action,
        });
    }

    const response = await fetch($url, {
        method: 'POST',
        body: $body
    });
    const data = await response.json();
    return data;
}




async function form1(event){
    event.preventDefault();

    console.log($('#localidad').find(':selected'));

    if (vehiculoMarca.value === '0' || vehiculoMarca.value === '') {
        return;
    }
    if (vehiculoModelo.value === '0' || vehiculoModelo.value === '') {
        return;
    }
    if (vehiculoAnio.value === '0' || vehiculoAnio.value === '') {
        return;
    }
    if (vehiculoVersion.value === '0' || vehiculoVersion.value === '') {
        return;
    }
    if (vehiculoLocalidad.value === '0' || vehiculoLocalidad.value === '') {
        return;
    }
    if (vehiculoGNC.value === '') {
        return;
    }

    marcaSel = document.getElementById('marca-nuevo');
    modeloSel = document.getElementById('model');
    agnoSel = document.getElementById('agnoNew');
    versionSel = document.getElementById('version');
    localidadSel = document.getElementById('localidad');
    gncSel = document.getElementById('gnc');

    const versionCodes = versionSel.value.split(',');
    const idYQuote = localidadSel.value.split(',');
    console.log(localidadSel.getAttribute("name"));

    const opcionesVehiculos = {
        idMarca : marcaSel.value,
        marca : marcaSel.options[marcaSel.selectedIndex].text,
        idModelo : modeloSel.value,
        modelo : modeloSel.options[modeloSel.selectedIndex].text,
        agno: agnoSel.value,
        idVersion : versionSel.value,
        version : versionSel.options[versionSel.selectedIndex].text,
        fieldId: localidadSel.value,
        zipCode : idYQuote[0],
        cotiza: idYQuote[1],
        localidad : localidadSel.options[localidadSel.selectedIndex].text,
        idGnc : gncSel.value,
        gnc : gncSel.options[gncSel.selectedIndex].text,
        codInfoAuto: versionCodes[1],
        codval: versionCodes[0]
    }   


    document.cookie = "datosVehiculo="+JSON.stringify(opcionesVehiculos)+"; path = /";

    // Instancia Alcanzada
    const instanciaAlcanzada = {
        cotizador : {
            paso : 2,
            cotizacionFinalizada : false
        }
    }
    
    document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";
    
    trackInitCheckout(opcionesVehiculos);
    
    window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/persona/`;
}

function setCampos(cookie) {

    const data = JSON.parse(cookie);

    vehiculoMarca.disabled = false;
    $('.selectores-marca').css("pointer-events", "auto");
    vehiculoModelo.disabled = false;

    $('.selectores-modelo').css("pointer-events", "auto");

    vehiculoAnio.disabled = false;
    $('.selectores-ano').css("pointer-events", "auto");

    vehiculoVersion.disabled = false;
    $('.selectores-version').css("pointer-events", "auto");

    vehiculoLocalidad.disabled = false;
    $('.selectores-localidad').css("pointer-events", "auto");

    vehiculoGNC.disabled = false;
    $('.selectores-gnc').css("pointer-events", "auto");

    const marcas = JSON.parse(localStorage.getItem("marcas"));
    const modelos = JSON.parse(localStorage.getItem("modelos"));
    const anios = JSON.parse(localStorage.getItem("anio"));
    const versiones = JSON.parse(localStorage.getItem("versiones"));

    const gncs = JSON.parse(localStorage.getItem("gnc"));



    if (marcas) {
        marcas.forEach(function(marca, index){
            $opcion = document.createElement("option");
            $opcion.value = marca.idMarca;
            $opcion.innerHTML = marca.marca;
            vehiculoMarca.appendChild($opcion);
            
        });
    
        vehiculoMarca.value = data.idMarca;
    }else {
        inicioSeleccion()
        return
    }

    if (modelos) {
        modelos.forEach(function(modelo){
            opcion = document.createElement("option");
            opcion.value = modelo.idModelo;
            opcion.innerHTML = modelo.modelo;
            vehiculoModelo.appendChild(opcion);
        });
    
        vehiculoModelo.value = data.idModelo;
    }else {
        inicioSeleccion()
        return
    }

    if (anios) {
        anios.forEach(function(anio){
            opcion = document.createElement("option");
            opcion.value = anio;
            opcion.innerHTML = anio;
            vehiculoAnio.appendChild(opcion);
        });
    
        vehiculoAnio.value = data.agno;
    }else {
        inicioSeleccion()
        return
    }

    if (versiones) {
        versiones.forEach(function(version){
            opcion = document.createElement("option");
            opcion.value = [version.codval, version.codia];
            opcion.innerHTML = version.modelo;
            vehiculoVersion.appendChild(opcion);
        });
    
        vehiculoVersion.value = data.idVersion;
    }else {
        inicioSeleccion()
        return
    }

    if (data.fieldId) {        
            opcion = document.createElement("option");
            opcion.value = data.fieldId;
            opcion.innerHTML = data.localidad;
            vehiculoLocalidad.appendChild(opcion);
    
        vehiculoLocalidad.value = data.fieldId;
    }else {
        inicioSeleccion()
        return
    }

    if (gncs) {
        opcionGnc = document.createElement("option");
        opcionGnc.value = 0;
        opcionGnc.innerHTML = "Sin G.N.C.";
        vehiculoGNC.appendChild(opcionGnc);
        gncs.forEach(function(gnc){
            opcion = document.createElement("option");
            opcion.value = gnc.valor;
            opcion.innerHTML = gnc.detalle;
            vehiculoGNC.appendChild(opcion);
        });
    
        vehiculoGNC.value = data.idGnc;
        return
    }
}


function campoLocalidad() {
    $('#localidad').select2({
        language: "es",
        ajax: {
          url: themePath + "api/api.php?get=places",
          processResults: function (data) {
            var results = [];
            $.each(data, function (k, v) {
              results.push({
                id: v.idcity+","+v.quote,
                name: v.quote,
                value: v.idcity,
                text: v.city + ", " + v.state + ", " + v.zipcode,
                extraFields: {
                  userCity: v.city,
                  userState: v.state,
                  userIdCity: v.idcity,
                  userQuote: v.quote
                },
              });
            });

            return {
              results: results,
            };
          },
          data: function (params) {
            var query = {
              q: params.term,
              limit: "40",
            };
            return query;
          },
          success: function (data) {
            $("#dropdown").select2({
              data: data,
            });
          },
          cache: true,
        },
    })

    $(".select2-container").addClass('selectores')
    $(".select2-container").addClass('selectores-localidades')
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

function trackInitCheckout( data ) {

    var commonEvent = {
        'event': 'datos_vehiculo',
        'product': 'seguro-de-autos-y-pick-ups',
        'vehicleBrand': data.marca,
        'vehicleModel': data.modelo,
        'vehicleYear': data.agno,
        'vehicleVersion': data.version,
        'vehicleGnc': data.gnc,
        'localidad': data.localidad
    };

    pushDataLayer(commonEvent);
}

