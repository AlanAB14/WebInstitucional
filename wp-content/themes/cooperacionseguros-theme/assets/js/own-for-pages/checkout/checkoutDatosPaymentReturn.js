
// Chequeo si hay guid parametro
const urlActiva   = window.location.href;
const existeParam = urlActiva.indexOf('?') != -1 ? true : false;

const urlString = new URL(urlActiva);

// Obtengo params de url
const statusResponse = urlString.searchParams.get("status"); 
const guid           = urlString.searchParams.get("idLead");


// Si no hay params retorna al comienzo del cotizador
// if (!existeParam || !guid || !statusResponse) {
//     window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
// }

window.addEventListener('load', async() => {

    // Oculto loader y muestro section
    document.getElementById('section_payment_return').hidden = false;
    document.getElementById('loader-payment').hidden = true;

    // Traigo lead
    const token = await getToken();
    const lead  = await getLead(guid, token);



    var title    = document.getElementById('box_response_title');
    var image    = document.getElementById('box_response_image');
    var textBox  = document.getElementById('box_response_text');
    switch (statusResponse) {
        case "success":
            const newLead = {
                ...lead,
                instanciaAlcanzada: 17
            }
        
            // Grabo Lead
            await grabarLead(newLead, token);
        
            const dataObject = {
                instanciaAlcanzada: 17,
                descripcionInstancia: 'Instancia final, confirmación o rechazo de epagos.'
            }
            const data = {
                tag: 'instanciaAlcanzada',
                guid: lead.idLead,
                dataObject
            }
        
            $.ajax({
                url: themePath + "utils/save_quote_nuevo.php",
                type: "POST",
                data: {data},
                success: function (data) {
                    console.log('SE HIZO')
                },
                error: function (e) {
                    console.log('HUBO ERROR')
                }
            });
            let textAIngresarSuccess = '';
            title.innerHTML   = `¡${capitalizeFirstLetter(lead.nombre.toLowerCase())}, tu póliza fue emitida correctamente!`;
            image.innerHTML = `
                <img src='${php_data.NuevaUrl}/assets/img/cotizador/ok.jpg' alt='Ok-image' />
            `
            for (let index = 0; index < 4; index++) {
                switch (index) {
                    case 0:
                        textAIngresarSuccess = 'En los próximos minutos vas a recibir una confirmación de la transacción de tu e-mail.';
                        break;
                    case 1:
                        textAIngresarSuccess = 'También vas a recibir un e-mail con todos los detalles y una copia digital de tu póliza.';
                        break;
                    case 2:
                        textAIngresarSuccess = 'Tu productor está disponible para asesorarte y aclarar cualquier duda que tengas sobre la póliza contratada.';
                        break;
                    case 3:
                        textAIngresarSuccess = 'Podrás consultar y administrar tus pólizas, obtener certificados de cobertura, imprimir comprobantes, pagar online e imprimir copias desde nuestra página de autogestion: asegurados.cooperacionseguros.com.ar';
                        break;
                }
                textBox.innerHTML += `
                <div class="response_text-line">
                    <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                    </svg>
                    <p>${textAIngresarSuccess}</p> 
                </div>
                `
            }
            trackInitCheckout( lead.idLead );
            break;

        case "pending":
            const newLeadPending = {
                ...lead,
                instanciaAlcanzada: 17
            }
        
            // Grabo Lead
            await grabarLead(newLeadPending, token);
        
            const dataObjectPending = {
                instanciaAlcanzada: 17,
                descripcionInstancia: 'Instancia final, confirmación o rechazo de epagos.'
            }
            const dataPending = {
                tag: 'instanciaAlcanzada',
                guid: lead.idLead,
                dataObjectPending
            }
        
            $.ajax({
                url: themePath + "utils/save_quote_nuevo.php",
                type: "POST",
                data: {data},
                success: function (data) {
                    console.log('SE HIZO')
                },
                error: function (e) {
                    console.log('HUBO ERROR')
                }
            });
            let textAIngresarPending = '';
            title.innerHTML   = `${capitalizeFirstLetter(lead.nombre.toLowerCase())},tu póliza está siendo procesada.`;
            image.innerHTML = `
                <img src='${php_data.NuevaUrl}/assets/img/cotizador/tiempo.jpg' alt='time-image' />
            `
            for (let index = 0; index < 2; index++) {
                switch (index) {
                    case 0:
                        textAIngresarPending = 'El pago se realizó correctamente. En breve estarás recibiendo la póliza en tu mail.';
                        break;
                    case 1:
                        textAIngresarPending = 'Por cualquier duda podés comunicarte con nuestro Centro de Atención al Cliente al 0800 – 777- 7070 o por mail a clientes@cooperacionseguros.com.ar';
                        break;
                }
                textBox.innerHTML += `
                <div class="response_text-line">
                    <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                    </svg>
                    <p>${textAIngresarPending}</p> 
                </div>
                `
            }
            break;

        case "failure":
            const newLeadFailure = {
                ...lead,
                instanciaAlcanzada: 17
            }
        
            // Grabo Lead
            await grabarLead(newLeadFailure, token);
        
            const dataObjectFailure = {
                instanciaAlcanzada: 17,
                descripcionInstancia: 'Instancia final, confirmación o rechazo de epagos.'
            }
            const dataFailure = {
                tag: 'instanciaAlcanzada',
                guid: lead.idLead,
                dataObjectFailure
            }
        
            $.ajax({
                url: themePath + "utils/save_quote_nuevo.php",
                type: "POST",
                data: {data},
                success: function (data) {
                    console.log('SE HIZO')
                },
                error: function (e) {
                    console.log('HUBO ERROR')
                }
            });
            let textAIngresarFailure = '';
                title.innerHTML   = `${capitalizeFirstLetter(lead.nombre.toLowerCase())},tu póliza no se emitió.`;
                image.innerHTML = `
                    <img src='${php_data.NuevaUrl}/assets/img/cotizador/error.jpg' alt='Ok-image' />
                `
                for (let index = 0; index < 2; index++) {
                    switch (index) {
                        case 0:
                            textAIngresarFailure = 'No pudimos procesar tu pago. Revisa nuevamente los datos ingresados o intenta con otra tarjeta';
                            break;
                        case 1:
                            textAIngresarFailure = 'Por cualquier duda podés comunicarte con nuestro Centro de Atención al Cliente al 0800 – 777- 7070 o por mail a clientes@cooperacionseguros.com.ar';
                            break;
                    }
                    textBox.innerHTML += `
                    <div class="response_text-line">
                        <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                        </svg>
                        <p>${textAIngresarFailure}</p> 
                    </div>
                    `
                }
            break;
        case "failurePago":
            let textAIngresarFailurePago = '';
                title.innerHTML   = `${capitalizeFirstLetter(lead.nombre.toLowerCase())},tu póliza no se emitió.`;
                image.innerHTML = `
                    <img src='${php_data.NuevaUrl}/assets/img/cotizador/error.jpg' alt='Ok-image' />
                `
                for (let index = 0; index < 2; index++) {
                    switch (index) {
                        case 0:
                            textAIngresarFailurePago = 'Ocurrió un error al generar la preferencia de pago.';
                            break;
                        case 1:
                            textAIngresarFailurePago = 'Por cualquier duda podés comunicarte con nuestro Centro de Atención al Cliente al 0800 – 777- 7070 o por mail a clientes@cooperacionseguros.com.ar';
                            break;
                    }
                    textBox.innerHTML += `
                    <div class="response_text-line">
                        <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                        </svg>
                        <p>${textAIngresarFailurePago}</p> 
                    </div>
                    `
                }
            break;
        case "failurePoliza":
            let textAIngresarFailurePoliza = '';
                title.innerHTML   = `Error póliza anomalizada`;
                image.innerHTML = `
                    <img src='${php_data.NuevaUrl}/assets/img/cotizador/error.jpg' alt='Ok-image' />
                `
                for (let index = 0; index < 2; index++) {
                    switch (index) {
                        case 0:
                            textAIngresarFailurePoliza = 'Tu póliza está siendo procesada.';
                            break;
                        case 1:
                            textAIngresarFailurePoliza = 'Por cualquier duda podés comunicarte con nuestro Centro de Atención al Cliente al 0800 – 777- 7070 o por mail a clientes@cooperacionseguros.com.ar';
                            break;
                    }
                    textBox.innerHTML += `
                    <div class="response_text-line">
                        <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                        </svg>
                        <p>${textAIngresarFailurePoliza}</p> 
                    </div>
                    `
                }
            break;
        case "failurePropuesta":
            let textAIngresarFailurePropuesta = '';
                title.innerHTML   = `Error al generar propuesta`;
                image.innerHTML = `
                    <img src='${php_data.NuevaUrl}/assets/img/cotizador/error.jpg' alt='Ok-image' />
                `
                for (let index = 0; index < 2; index++) {
                    switch (index) {
                        case 0:
                            textAIngresarFailurePropuesta = 'Ocurrió un error al generar el número de propuesta.';
                            break;
                        case 1:
                            textAIngresarFailurePropuesta = 'Por cualquier duda podés comunicarte con nuestro Centro de Atención al Cliente al 0800 – 777- 7070 o por mail a clientes@cooperacionseguros.com.ar';
                            break;
                    }
                    textBox.innerHTML += `
                    <div class="response_text-line">
                        <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                        </svg>
                        <p>${textAIngresarFailurePropuesta}</p> 
                    </div>
                    `
                }
            break;
        case "failureInesperado":
            let textAIngresarFailureInesperado = '';
                title.innerHTML   = `Error inesperado`;
                image.innerHTML = `
                    <img src='${php_data.NuevaUrl}/assets/img/cotizador/error.jpg' alt='Ok-image' />
                `
                for (let index = 0; index < 2; index++) {
                    switch (index) {
                        case 0:
                            textAIngresarFailureInesperado = 'Ocurrió un error inesperado.';
                            break;
                        case 1:
                            textAIngresarFailureInesperado = 'Por cualquier duda podés comunicarte con nuestro Centro de Atención al Cliente al 0800 – 777- 7070 o por mail a clientes@cooperacionseguros.com.ar';
                            break;
                    }
                    textBox.innerHTML += `
                    <div class="response_text-line">
                        <svg class="icon-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path class="icon-color" fill="#444" d="M8 16c4.4 0 8-3.6 8-8s-3.6-8-8-8-8 3.6-8 8 3.6 8 8 8zM5.2 4.4L6.6 3l5 5-5 5-1.4-1.4L8.8 8 5.2 4.4z"/>
                        </svg>
                        <p>${textAIngresarFailureInesperado}</p> 
                    </div>
                    `
                }
            break;
    }

    // Limpio datos almacenados en el navegador
    borrarDatosTemporales();
})


// Traer token
async function getToken() {
    const resp = await fetch(`${ themePath }utils/get_token.php`,{
        method: 'POST'
    });
    const res = await resp.json();
    return res;
}


// Traer Lead
async function getLead(guid, token) {
    const url = php_data.COOPSEG_LEADS_GET_URL;
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

// Grabo lead
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

// Formato a nombre
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function trackInitCheckout( idLead ) {
    // TRAIGO QUOTE
    var request = new XMLHttpRequest();
    request.open("GET", `${php_data.NuevaUrl}/quotes/${idLead.toUpperCase()}.json`, false);
    request.send(null)
    var my_JSON_object = JSON.parse(request.responseText);
    var {answers} = my_JSON_object; 
    var commonEvent = {
        'event': 'trackEcommercePurchase',
        'product': 'seguro-de-autos-y-pick-ups',
        'vehicleBrand': answers.vehicleBrand,
        'vehicleModel': answers.vehicleModel,
        'vehiclePlan': answers.planCobertura,
        'vehiclePlanPrice': answers.planPremioMensual,
        'vehiclePlanPriceAP': answers.apPremioMensual,
        'vehiclePlanPriceSubtotal': Number(answers.planPremioMensual) + Number(answers.apPremioMensual),
        'vehicleVersion': answers.vehicleVersion,
        'vehicleYear': answers.vehicleYear,
        'localidad': `${answers.userCity},${answers.userState}`
    };

    pushDataLayer(commonEvent);
}


function borrarDatosTemporales() {
    localStorage.removeItem('gnc');
    localStorage.removeItem('marcas');
    localStorage.removeItem('localidades');
    localStorage.removeItem('versiones');
    localStorage.removeItem('modelos');
    localStorage.removeItem('anio');
    localStorage.removeItem('producers');

    delete_cookie('datosVehiculo');
    delete_cookie('datosPersonales');
    delete_cookie('datosPlan');
    delete_cookie('commonEvent');
    delete_cookie('instanciaAlcanzada');
    delete_cookie('planElejido');

}

function delete_cookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}