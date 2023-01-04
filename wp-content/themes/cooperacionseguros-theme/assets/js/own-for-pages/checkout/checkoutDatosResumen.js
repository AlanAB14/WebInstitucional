const cookiePlan = getCookie("planElejido");
const cookieDatosPlan = JSON.parse(getCookie("datosPlan"));
const cookieDatosPersonales = JSON.parse(getCookie('datosPersonales'))
const cookieDatosVehiculo = JSON.parse(getCookie('datosVehiculo'));
const cookieCommonEvent = getCookie("commonEvent");
const cookieGuid = getCookie("guid");
const instanciaAlcanzada = JSON.parse(getCookie("instanciaAlcanzada"));

// Chequeo si hay guid parametro
const urlActiva   = window.location.href;
const existeParam = urlActiva.indexOf('?') != -1 ? true : false;

if ( instanciaAlcanzada?.checkout?.paso < 4 || cookiePlan === null || cookieDatosPlan === null || !existeParam) {
    window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
}

window.addEventListener('load', async() => {


    // MuestroForm y quito Loader
    document.getElementById('loader-resumen').hidden = true;
    document.getElementById('section_resumen').hidden = false;

    funcionalidadBarraPasos();

    // Pido token
    const token = await getToken();
    const lead = await getLead(JSON.parse(cookieGuid), token);
    console.log(lead)

    // Traigo PAS seleciconado
    // Creo objeto con parametros para traer productores sugeridos
    const data = {
        nroDni      : lead.dni,
        sexo        : lead.genero,
        idLocalidad : lead.idLocalidad
    }
    const pas = devuelvePas(lead.codint)
    console.log(pas)

    // TRAIGO QUOTE
    var request = new XMLHttpRequest();
    request.open("GET", `${php_data.NuevaUrl}/quotes/${lead.idLead.toUpperCase()}.json`, false);
    request.send(null)
    var my_JSON_object = JSON.parse(request.responseText);
    console.log(my_JSON_object);
    var coberturaApDatos = my_JSON_object.answers;
    var personaDatos     = my_JSON_object;

    // Completo datos resumen
    const fieldDni               = document.getElementById('datos-dni');
    const fieldNombre            = document.getElementById('datos-nombre');
    const fieldApellido          = document.getElementById('datos-apellido');
    const fieldFechaNacimiento   = document.getElementById('datos-fecha-nacimiento');
    const fieldEmail             = document.getElementById('datos-email');
    const fieldTelefono          = document.getElementById('datos-telefono');
    
    const fieldVehiculo          = document.getElementById('datos-vehiculo');
    const fieldVehiculoLocalidad = document.getElementById('datos-localidad-circulacion');
    const fieldVehiculoChasis    = document.getElementById('datos-chasis');
    const fieldVehiculoPatente   = document.getElementById('datos-patente');
    const fieldVehiculoMotor     = document.getElementById('datos-motor');
    const fieldVehiculoSuma      = document.getElementById('datos-suma-asegurada');
    const fieldVehiculoCuota     = document.getElementById('datos-cuota-mensual');
    const fieldVehiculoCobertura = document.getElementById('datos-cobertura');

    const fieldAsesorAsignado    = document.getElementById('label_asesor_asignado');

    const fechaFormat             = new Date(lead.fechaNacimiento)
    fieldDni.value                = numberWithPoints(lead.dni);
    fieldNombre.value             = lead.nombre;
    fieldApellido.value           = lead.apellido;
    fieldFechaNacimiento.value    = formatDate(fechaFormat);
    fieldEmail.value              = lead.email;
    fieldTelefono.value           = lead.telefono;
 
    fieldVehiculo.value           = lead.vehiculos[0].version;
    fieldVehiculoLocalidad.value  = lead.vehiculos[0].guardaHabitual;
    fieldVehiculoPatente.value    = lead.vehiculos[0].patente;
    fieldVehiculoChasis.value     = lead.vehiculos[0].nroChasis;
    fieldVehiculoMotor.value      = lead.vehiculos[0].nroMotor;
    fieldVehiculoSuma.value       = `$${numberWithPoints(lead.vehiculos[0].valorVehiculo)}`;
    fieldVehiculoCuota.value      = `$${numberWithPoints(coberturaApDatos.planPremioMensual)}`;
    fieldVehiculoCobertura.value  = `${lead.vehiculos[0].cobertura}`;

    fieldAsesorAsignado.innerHTML = `Asesor asginado: ${pas[0].productor}, ${pas[0].direccion}, ${pas[0].localidad}`;


    // MOSTRAR IMAGENES
    const divImagenes = document.getElementById('imagenes-inspeccion')

    console.log(my_JSON_object["fotos-vehiculo"])
    if (my_JSON_object["fotos-vehiculo"]) {
        Object.values(my_JSON_object["fotos-vehiculo"]).forEach(imagen => {
            divImagenes.innerHTML += `
            <img class="imagen-vehiculo-resumen" src="${php_data.COOPSEG_QUOTE_IMAGES_URL}${imagen}">
            `
        });
    }else {
        divImagenes.innerHTML = "<h2>Error al traer imágenes</h2>"
    }






    // SUBMIT DEL FORMULARIO
    document.getElementById('form_resumen').addEventListener('submit', async(e) => {
        e.preventDefault();

        // MUESTRO LOADER
        document.getElementById('loader-resumen').hidden = false;
        document.getElementById('section_resumen').hidden = true;

        console.log('Datos enviados');

        const vehiculo = {
            "Codval": parseInt(personaDatos.answers.codVal),
            "anio": parseInt(personaDatos.answers.vehicleYear),
            "Cobertura": personaDatos.answers.planCobertura,
            "IdLocalidad": parseInt(personaDatos.answers.userZip),
            "Franquicia": parseInt(personaDatos.answers.planFranquicia),
            "NroChasis": personaDatos.vehiculos.nroChasis,
            "NroMotor": personaDatos.vehiculos.nroMotor,
            "Patente": personaDatos.vehiculos.patente,
            "usaGNC": personaDatos.answers.vehicleGncID && personaDatos.answers.vehicleGncID != 0 ? 'true' : 'false',
            "codigoAccesorio": personaDatos.answers.vehicleGncID && personaDatos.answers.vehicleGncID != 0 ? parseInt(personaDatos.answers.vehicleGncID) : null,
            "codigoConvenio": parseInt(personaDatos.answers.codigoConvenio),
            "bonusMaxConvenio": parseInt(personaDatos.answers.bonusMaxConvenio),
            "bonusMaxAntiguedad": parseInt(personaDatos.answers.bonusMaxAntiguedad),
            "bonusMaxSuma": parseInt(personaDatos.answers.bonusMaxSuma)
        }
        const persona = {
            "codcli": personaDatos.codcli ? personaDatos.codcli : '',
            "nombre": personaDatos.nombre,
            "apellido": personaDatos.apellido,
            "fechaNacimiento": formatDate(new Date(personaDatos.fechaNacimiento)),
            "nroDni": personaDatos.dni,
            "idLocalidad": personaDatos.idLocalidad,
            "calle": personaDatos.calle,
            "nro": personaDatos.nro,
            "piso": personaDatos.piso,
            "departamento": personaDatos.depto,
            "genero": personaDatos.genero,
            "idNacionalidad": parseInt(personaDatos.idNacionalidad),
            "LugarNacimiento": personaDatos.lugarNacimiento,
            "email": personaDatos.email,
            "idActividad": parseInt(personaDatos.idActividad),
            "idEstadoCivil": parseInt(personaDatos.idEstadoCivil),
            "telefono": personaDatos.telefono
        }

        const accidentePasajeros = {
            "idProducto": coberturaApDatos.apIdProducto ? parseInt(coberturaApDatos.apIdProducto) : '',
            "idPlantSuscWebCab": coberturaApDatos.apIdPlantSuscWebCab ? parseInt(coberturaApDatos.apIdPlantSuscWebCab) : '',
            "premio": coberturaApDatos.apPremio ? parseInt(coberturaApDatos.apPremio) : '0',
            "prima": coberturaApDatos.apPrima ? parseInt(coberturaApDatos.apPrima) : '0'
        };

        const datos = {
            "idRama": parseInt(personaDatos.producto),
            "CodigoProductor": personaDatos.codint,
            "InicioVigencia": formatDate(new Date()),
            "CantidadMeses": 4,
            "SumaAsegurada": parseFloat(personaDatos.answers.vehicleValue),
            "premio": parseFloat(personaDatos.answers.planPremio),
            "premioReferencia": parseFloat(personaDatos.answers.planPremioReferencia),
            "prima": parseFloat(personaDatos.answers.planPrima),
            "idLead": personaDatos.idLead,
            "persona": persona,
            "vehiculo": vehiculo,
            "accidentePasajeros": accidentePasajeros
        }

        console.log(datos)

        const idPropuesta = await suscribeDatos(datos,token);

        if (idPropuesta >= 1) {
            // GUARDO IDPROPUESTA EN QUOTE
            const dataObject = {
                idPropuesta,
            }
            const data = {
                tag: 'idPropuesta',
                guid: lead.idLead,
                dataObject
            }
            $.ajax({
                url: themePath + "utils/save_quote_nuevo.php",
                type: "POST",
                data: {data},
                success: async function (data) {
                    console.log('SE HIZO')

                    // Valido Propuesta
                    const idPoliza = await validaPropuesta(token, idPropuesta);
                    if (idPoliza >= 1) {
                        console.log(lead)
                        if (lead.codcli && lead.codcli !== "") {
                            userId = lead.codcli;
                        }else {
                            userId =  lead.dni;
                        }

                        console.log(userId)
                        console.log(formatDatePayment(new Date()));

                        var dateExpires = new Date();
                        dateExpires.setDate(dateExpires.getDate() + 30);
                        const datePlus30 = dateExpires.toISOString().split('T')[0]; 

                        console.log(datePlus30);

                        const paymentAmount = my_JSON_object.answers.apPremioMensual ? parseFloat(Number(my_JSON_object.answers.planPremioMensual) + Number(my_JSON_object.answers.apPremioMensual)) : parseFloat(Number(my_JSON_object.answers.planPremioMensual));

                        // Creo objeto para enviar a preferencia de pago
                        const payment = {
                            ApplicationId: 'VENTADIRECTA',
                            UserId: userId,
                            UserEmail: lead.email,
                            ExternalReference: idPoliza,
                            ExpirationDateFrom: formatDatePayment(new Date()),
                            ExpirationDateTo: datePlus30,
                            Expires: true,
                            BackUrlSuccess: `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=success`,
                            BackUrlPending: `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=pending`,
                            BackUrlFailure: `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=failure`,
                            PaymentTitle: 'Póliza de seguro',
                            PaymentDescription: `Referencia de pago: ${idPoliza}`,
                            PaymentAmount: paymentAmount,
                            HabilitaRecurrencia: 'F'
                        }

                        console.log(payment);

                        // Creo preferencia de pago
                        const preferenciaPagoLink = await crearPreferenciaDePago(token, payment);
                        
                        if (preferenciaPagoLink !== "") {
                            const nuevoLead = {
                                ...lead,
                                instanciaAlcanzada: 16
                            }

                            await saveLead(token, nuevoLead);

                            const dataObject = {
                                idPoliza,
                            }
                            const data = {
                                tag: 'idPoliza',
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

                            // Instancia Alcanzada
                            const instanciaAlcanzada = {
                                cotizador: {
                                    cotizacionFinalizada: true
                                },
                                checkout : {
                                    paso : 5,
                                }
                            }
                        
                        
                            document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";
                            
                            window.location.href = `${preferenciaPagoLink}`
                        }else {
                            window.location.href = `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=failurePago`
                        }

                        
                    }else {
                            window.location.href = `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=failurePoliza`
                    }
                    
                },
                error: function (e) {
                    window.location.href = `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=failureInesperado`
                }
            });


        }else {
            window.location.href = `${php_data.homeUrl}/checkout/payment/?idLead=${lead.idLead.toUpperCase()}&status=failurePropuesta`
        }
    })


    // Boton de volver
    document.getElementById('btn_volver').addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/asesores?${JSON.parse(cookieGuid)}`;
    })
    
})


function funcionalidadBarraPasos() {
    const checkoutPaso1 = document.getElementById('checkout-paso-1');
    checkoutPaso1.style.cursor = "pointer";
    checkoutPaso1.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/datos-solicitante?${JSON.parse(cookieGuid)}`;
    })
    const checkoutPaso2 = document.getElementById('checkout-paso-2');
    checkoutPaso2.style.cursor = "pointer";
    checkoutPaso2.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/datos-vehiculo?${JSON.parse(cookieGuid)}`;
    })
    const checkoutPaso3 = document.getElementById('checkout-paso-3');
    checkoutPaso3.style.cursor = "pointer";
    checkoutPaso3.addEventListener('click', () => {
        window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/asesores?${JSON.parse(cookieGuid)}`;
    })
}
  
// Traer cookie
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

// Guardar Lead
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
            console.log('Lead Actualizado');
            return response;
        }else {
            console.log('Error al Actualizar Lead');
        }
    } catch (error) {
        console.log(error)
    }
  }

// Formato numero con puntos
function numberWithPoints(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Formato a fecha
function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
}
function formatDate(date) {
    return [
      padTo2Digits(date.getMonth() + 1),
      padTo2Digits(date.getDate()),
      date.getFullYear(),
    ].join('/');
}

// Formato fecha payment
function formatDatePayment(date) {
    return [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
      ].join('/');
}

// Devuelve info de PAS seleccionado
function devuelvePas(codPas) {
    const arrayPas = localStorage.getItem('producers') ? JSON.parse(localStorage.getItem('producers')) : '';
    const pasSeleccionado = arrayPas.producers.filter((pas) => {
        if (pas.codigoProductor === codPas) {
            return pas
        }
    });
    return pasSeleccionado ? pasSeleccionado : '';
}

async function suscribeDatos(data, token) {
    const url  = php_data.COOPSEG_SUSCRIBIR_URL;
    const body = JSON.stringify(data);
    console.log(body)
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
        console.log(response);
        const res = await response.json();
        console.log(res);
        return res;
    } catch (error) {
        console.log(error)
    }
}

async function validaPropuesta(token, idPropuesta) {
    const url  = php_data.COOPSEG_VALIDAR_URL;
    try {
        const response = await fetch(`${url}?idPropuesta=${idPropuesta}`, {
            method: 'POST',
            headers: {
                'Authorization' : `Bearer ${token}`
            },
        })
        console.log(response);
        const res = await response.json();
        return res;
    } catch (error) {
        console.log(error)
    }
}

async function crearPreferenciaDePago(token, data) {
    const url  = php_data.COOPSEG_CREAR_PREFERENCIA_PAGO;
    const body = JSON.stringify(data);
    console.log(body)
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
        console.log(response);
        const res = await response.json();
        console.log(res);
        return res;
    } catch (error) {
        console.log(error)
    }
}