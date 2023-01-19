

const cookie = getCookie("datosVehiculo");
const cookiePersonales = getCookie("datosPersonales");
const instanciaAlcanzada = JSON.parse(getCookie("instanciaAlcanzada"));

// Chequeo si hay guid parametro
const urlActiva   = window.location.href;
const existeParam = urlActiva.indexOf('?') != -1 ? true : false;


if (instanciaAlcanzada?.cotizador?.paso < 3 || cookie == null || cookiePersonales == null || !existeParam ) {
    window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
}

window.addEventListener('load', async() => {

    // PREGUNTO SI COTIZA
    const cotiza = document.getElementById('input-cotiza')?.value;
    if (cotiza && cotiza === "noCotiza") {
    // BOTON ERROR VOLVER
        document.getElementById('btn-error-volver').addEventListener('click', (e) => {
            localStorage.removeItem('gnc');
            localStorage.removeItem('marcas');
            localStorage.removeItem('versiones');
            localStorage.removeItem('modelos');
            localStorage.removeItem('anio');

            delete_cookie('datosVehiculo');
            delete_cookie('datosPersonales');
            delete_cookie('guid');

            window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
        });
    }else {

    // Oculto loader y muestro section
    document.getElementById('seccion_planes').hidden = false;
    document.getElementById('loader-cedula').hidden = true;


    funcionalidadBarraPasos();

    document.getElementById("btnCotizaBasic").disabled = false;
    document.getElementById("btnCotizaMedium").disabled = false;
    document.getElementById("btnCotizaFull").disabled = false;


    const token = await getToken();
    const guid = getCookie("guid");
    const datosPersonales = JSON.parse(getCookie("datosPersonales"));
    const datosVehiculo = JSON.parse(getCookie("datosVehiculo"));
    const data = {
        idLead: guid,
        nombre: datosPersonales.nombreCompleto,
        apellido: datosPersonales.apellido,
        telefono: datosPersonales.telefono,
        email: datosPersonales.mail,
    }

    const idVersion = datosVehiculo.idVersion.split(',');
    const idVersionNumber = Number(idVersion[0])

    const lead = await getLead(JSON.parse(guid), token);

    const leadNuevo = {
        ...lead,
        nombre: datosPersonales.nombreCompleto,
        apellido: datosPersonales.apellido,
        telefono: datosPersonales.telefono,
        instanciaAlcanzada : 11,
        vehiculos: [{
            ...lead.vehiculos[0],
            idVersion: idVersionNumber,
        }]
    }


    await grabarLead(leadNuevo,token);



    $franquicia = document.getElementById("franquicia");
    $selGrua = document.getElementById('km-grua');
    const full = JSON.parse($selGrua.dataset.full);
    let fulltier = $selGrua.value;
    const plans = JSON.parse($selGrua.dataset.plans);

    if (fulltier) {
        $franquicia.innerHTML = "";
        $.each(full[fulltier], function(index, plan){
            let { franquicia, premioMensual } = plans[plan];

            if(index==0){
                $total = premioMensual;
            }
            $opcion = document.createElement("option");
            $opcion.value = premioMensual;

            $opcion.innerHTML = numberToPrice(franquicia);
            $franquicia.appendChild($opcion);
        });



        // Nos aseguramos que la cobertura de AP está chequeada al cargar
        $("#packFull").prop("checked", true);

        // Cuál es el valor de AP?
        var valorAP = parseInt($("#packFull").val());
        if (document.getElementById('packFull').checked) {
            $precioFull = document.getElementById("precioFull");
            $precioFull.innerHTML = "$" + numberToPrice($total + valorAP);
        }else {
            $precioFull = document.getElementById("precioFull");
            $precioFull.innerHTML = "$" + numberToPrice($total);
        }
        }
    }
})


function selectFranquicia(){
    $premio = document.getElementById("franquicia").value;
    $nuevoPrecio = document.getElementById("precioFull");

    const coberturaApInput = document.getElementById("packFull");
    const coberturaApValue = document.getElementById("packFull").value;

    if (coberturaApInput.checked) {
        $nuevoPrecio.innerHTML = "$" + numberToPrice(parseInt($premio) + parseInt(coberturaApValue));
    }else{
        $nuevoPrecio.innerHTML = "$" + numberToPrice($premio);
    }
}

function numberToPrice(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
}

function selectGrua(){
    $precio = document.getElementById("precioFull").innerHTML;
    $franquicia = document.getElementById("franquicia");
    $selGrua = document.getElementById('km-grua');
    const full = JSON.parse($selGrua.dataset.full);
    let fulltier = $selGrua.value;
    const plans = JSON.parse($selGrua.dataset.plans);

    const coberturaApInput = document.getElementById("packFull");
    const coberturaApValue = document.getElementById("packFull").value;

    $franquicia.innerHTML = "";
    $.each(full[fulltier], function(index, plan){
        let { franquicia, premioMensual } = plans[plan];

        if(index==0){
            if (coberturaApInput.checked) {
                $total = premioMensual + parseInt(coberturaApValue);
            }else {
                $total = premioMensual;
            }
        }
        $opcion = document.createElement("option");
        $opcion.value = premioMensual;

        $opcion.innerHTML = numberToPrice(franquicia);
        $franquicia.appendChild($opcion);
    });

    $precioFull = document.getElementById("precioFull");
    $precioFull.innerHTML = "$" + numberToPrice($total);
}

async function envioPlan($index){
    const guid = JSON.parse(getCookie("guid"));
    let plan;
    switch($index){
        case "1":
            $btnPlan = document.getElementById('btnCotizaBasic');
            $precioCouta = document.getElementById('precioBasico').innerHTML;
            nombrePlan = document.getElementById('nombreBasico').innerHTML;
            coberturaApChecked = document.getElementById('packBasico').checked;
            break;
        case "2":
            $btnPlan = document.getElementById('btnCotizaMedium');
            $precioCouta = document.getElementById('precioMedium').innerHTML;
            nombrePlan = document.getElementById('nombreMedium').innerHTML;
            coberturaApChecked = document.getElementById('packSuperior').checked;
            break;
        case "3":
            $btnPlan = document.getElementById('btnCotizaFull');
            $precioCouta = document.getElementById("precioFull").innerHTML;
            nombrePlan = document.getElementById('nombreFull').innerHTML;
            coberturaApChecked = document.getElementById('packFull').checked;
            break;
    }
    plan = $btnPlan.value.trim();
    $planEscojido = {plan: plan, precio: $precioCouta, nombrePlan: nombrePlan};
    document.cookie = "planElejido="+JSON.stringify($planEscojido)+"; path = /";
    //$selGrua = document.getElementById('km-grua');
    //const plans = JSON.parse($selGrua.dataset.plans);



    $("input[name=planCobertura]").val(plan);
    $("input[name=planSuma]").val(plans[plan].suma);
    $("input[name=planPremio]" ).val(plans[plan].premio);
    $("input[name=planPremioMensual]").val(plans[plan].premioMensual);
    $("input[name=planPremioReferencia]").val(plans[plan].premioReferencia);
    $("input[name=planPrima]").val(plans[plan].prima);
    $("input[name=planFechaInicio]").val(plans[plan].fechaInicio);
    $("input[name=planFechaFin]").val(plans[plan].fechaFin);
    $("input[name=planFranquicia]").val(plans[plan].franquicia);
    $("input[name=codigoConvenio]").val(plans[plan].codigoConvenio);
    $("input[name=bonusMaxConvenio]").val(plans[plan].bonusMaxConvenio);
    $("input[name=bonusMaxAntiguedad]").val(plans[plan].bonusMaxAntiguedad);
    $("input[name=bonusMaxSuma]").val(plans[plan].bonusMaxSuma);

    trackInitCheckout(plan);
    document.cookie = "datosPlan="+JSON.stringify(plans[plan])+"; path = /";
    document.cookie = "commonEvent="+JSON.stringify(commonEvent)+"; path = /";

    const token = await getToken();
    const lead = await getLead(guid, token);




    // SI ESTA CHEKCEADO GRABO COBERTURA AP EN QUOTE
    if (coberturaApChecked) {
        console.log('cobertura checked')
        const dataObject = {
            coberturaap: ap.premioMensual,
            apOnOff: 'on',
            apIdProducto: ap.idProducto,
            apIdPlantSuscWebCab: ap.idPlantSuscWebCab,
            apPremio: ap.premio,
            apPremioMensual: ap.premioMensual,
            apPrima: ap.prima,
            planCobertura: $("input[name=planCobertura]").val(plan)[0].value,
            planSuma: $("input[name=planSuma]").val(plans[plan].suma)[0].value,
            planPremio: $("input[name=planPremio]" ).val(plans[plan].premio)[0].value,
            planPremioMensual: $("input[name=planPremioMensual]").val(plans[plan].premioMensual)[0].value,
            planPremioReferencia: $("input[name=planPremioReferencia]").val(plans[plan].premioReferencia)[0].value,
            planPrima: $("input[name=planPrima]").val(plans[plan].prima)[0].value,
            planFechaInicio: $("input[name=planFechaInicio]").val(plans[plan].fechaInicio)[0].value,
            planFechaFin: $("input[name=planFechaFin]").val(plans[plan].fechaFin)[0].value,
            planFranquicia: $("input[name=planFranquicia]").val(plans[plan].franquicia)[0].value,
            codigoConvenio: $("input[name=codigoConvenio]").val(plans[plan].codigoConvenio)[0].value,
            bonusMaxConvenio: $("input[name=bonusMaxConvenio]").val(plans[plan].bonusMaxConvenio)[0].value,
            bonusMaxAntiguedad: $("input[name=bonusMaxAntiguedad]").val(plans[plan].bonusMaxAntiguedad)[0].value,
            bonusMaxSuma: $("input[name=bonusMaxSuma]").val(plans[plan].bonusMaxSuma)[0].value
        }
        const data = {
            tag: 'answers',
            guid,
            dataObject
        }
        $.ajax({
            url: themePath + "utils/save_quote_nuevo.php",
            type: "POST",
            data: {data},
            success: function (data) {
                console.log('ACTUALIZÓ QUOTE')
            },
            error: function (e) {
            console.log('HUBO ERROR')
            }
        });

    }else {
        console.log('cobertura no checked')

        const dataObject = {
            planCobertura: $("input[name=planCobertura]").val(plan)[0].value,
            planSuma: $("input[name=planSuma]").val(plans[plan].suma)[0].value,
            planPremio: $("input[name=planPremio]" ).val(plans[plan].premio)[0].value,
            planPremioMensual: $("input[name=planPremioMensual]").val(plans[plan].premioMensual)[0].value,
            planPremioReferencia: $("input[name=planPremioReferencia]").val(plans[plan].premioReferencia)[0].value,
            planPrima: $("input[name=planPrima]").val(plans[plan].prima)[0].value,
            planFechaInicio: $("input[name=planFechaInicio]").val(plans[plan].fechaInicio)[0].value,
            planFechaFin: $("input[name=planFechaFin]").val(plans[plan].fechaFin)[0].value,
            planFranquicia: $("input[name=planFranquicia]").val(plans[plan].franquicia)[0].value,
            codigoConvenio: $("input[name=codigoConvenio]").val(plans[plan].codigoConvenio)[0].value,
            bonusMaxConvenio: $("input[name=bonusMaxConvenio]").val(plans[plan].bonusMaxConvenio)[0].value,
            bonusMaxAntiguedad: $("input[name=bonusMaxAntiguedad]").val(plans[plan].bonusMaxAntiguedad)[0].value,
            bonusMaxSuma: $("input[name=bonusMaxSuma]").val(plans[plan].bonusMaxSuma)[0].value
        }

        const data = {
            tag: 'answers',
            guid,
            dataObject
        }
        $.ajax({
            url: themePath + "utils/save_quote_nuevo.php",
            type: "POST",
            data: {data},
            success: function (data) {

                console.log('ACTUALIZÓ QUOTE')

            },
            error: function (e) {
            console.log('HUBO ERROR')
            }
        });
    }

    const leadNuevo = {
        ...lead,
        instanciaAlcanzada: 12,
        vehiculos: [{
            ...lead.vehiculos[0],
            cobertura: plan,
        }]
    }



    await grabarLead(leadNuevo, token);

    // Instancia Alcanzada
    const instanciaAlcanzada = {
        cotizador : {
            paso : 3,
            cotizacionFinalizada : true
        }
    }
    document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";
    window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/datos-solicitante?${guid}`;
}

function trackInitCheckout(selectedPlan) {
    const eventData = {
        ...commonEvent,
    }
    eventData['event'] = 'trackEcommerceCheckPricing';
    eventData['vehiclePlan'] = selectedPlan;
    eventData['vehiclePlanPrice'] = plans[selectedPlan].premioMensual;
    eventData['vehiclePlanPriceAP'] = ap.premioMensual ?? null;
    eventData['vehiclePlanIncludeAP'] = '';

    pushDataLayer(eventData);
}


function checkCoberturaAP(pack) {
    switch (pack) {
        case "basico":
            $precio = document.getElementById("precioBasico").innerHTML;
            $packFull = document.getElementById("packBasico");
            $total=0;
            $valor = $packFull.value;
            $precio = $precio.replace(/\./g, '');
            $precio = $precio.replace(/\$/g, '');
            if($packFull.checked){
                $total = parseInt($precio) + parseInt($valor);
            }else{
                $total = parseInt($precio) - parseInt($valor);
            }
            $nuevoPrecio = document.getElementById("precioBasico");
            $nuevoPrecioAbajo = document.getElementById("precioBasicoAbajo");
            $nuevoPrecio.innerHTML = "$"+numberToPrice($total);
            $nuevoPrecioAbajo.innerHTML = "$"+numberToPrice($total);
            break;

        case "superior":
            $precio = document.getElementById("precioMedium").innerHTML;
            $packFull = document.getElementById("packSuperior");
            $total=0;
            $valor = $packFull.value;
            $precio = $precio.replace(/\./g, '');
            $precio = $precio.replace(/\$/g, '');
            if($packFull.checked){
                $total = parseInt($precio) + parseInt($valor);
            }else{
                $total = parseInt($precio) - parseInt($valor);
            }
            $nuevoPrecio = document.getElementById("precioMedium");
            $nuevoPrecioAbajo = document.getElementById("precioMediumAbajo");
            $nuevoPrecio.innerHTML = "$"+numberToPrice($total);
            $nuevoPrecioAbajo.innerHTML = "$"+numberToPrice($total);
            break;

        case "full":
            $precio = document.getElementById("precioFull").innerHTML;
            $packFull = document.getElementById("packFull");
            $total=0;
            $valor = $packFull.value;
            $precio = $precio.replace(/\./g, '');
            $precio = $precio.replace(/\$/g, '');
            if($packFull.checked){
                $total = parseInt($precio) + parseInt($valor);
            }else{
                $total = parseInt($precio) - parseInt($valor);
            }
            $nuevoPrecio = document.getElementById("precioFull");
            $nuevoPrecioAbajo = document.getElementById("precioFullAbajo");
            $nuevoPrecio.innerHTML = "$"+numberToPrice($total);
            $nuevoPrecioAbajo.innerHTML = "$"+numberToPrice($total);
            break;
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
    const imgVehiculo = document.getElementById('img_vehiculo_cotizacion');
    imgVehiculo.style.cursor = "pointer";
    imgVehiculo.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
    })

    const imgPersona = document.getElementById('img_persona_cotizacion');
    imgPersona.style.cursor = "pointer";
    imgPersona.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/persona/`;
    })
}


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
            console.log('Lead Actualizado');
        }else {
            console.log('Error al Actualizar Lead');
        }
    } catch (error) {
        console.log(error)
    }
}

    async function getLead(guid, token) {
    url = php_data.COOPSEG_LEADS_GET_URL;
    console.log(url);
    try {
        const response = await fetch(`${url}?idLead=${guid}`, {
            method: 'GET',
            headers: {
                'Accept': '*/*',
                'Authorization' : ` Bearer ${token}`,
                'Cache-Control': 'no-cache',
                'Connection': 'keep-alive',
                'Content-Type': 'application/json',
                //'Host': ' . COOPSEG_CONFIG_HOST_URL . '',
                'User-Agent': `${ php_data.COOPSEG_CONFIG_CLIENT_ID }`,
                'accept-encoding': 'gzip, deflate',
                'cache-control': 'no-cache',
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'POST, PUT, PATCH, GET, DELETE, OPTIONS',
                'Access-Control-Allow-Headers': '*'
                
            },
        })
        console.log(response);
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


function delete_cookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}







