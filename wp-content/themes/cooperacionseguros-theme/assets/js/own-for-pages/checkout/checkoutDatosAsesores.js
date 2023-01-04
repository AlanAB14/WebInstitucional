const cookiePlan = getCookie("planElejido");
const cookieDatosPlan = getCookie("datosPlan");
const cookieCommonEvent = getCookie("commonEvent");
const cookieGuid = getCookie("guid");
const instanciaAlcanzada = JSON.parse(getCookie("instanciaAlcanzada"));



if ( instanciaAlcanzada?.checkout?.paso < 3 || cookiePlan === null || cookieDatosPlan === null ) {
    window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/vehiculo/`;
}

window.addEventListener('load', async() => {

  funcionalidadBarraPasos();

  // Creo variable validacion
  let isValid = false;

  // Muestro botones de Continuar y volver
  document.getElementById('btn-section').hidden = false;

  // Obtengo token
  const token = await getToken();
  
  // Obtengo lead
  const lead  = await getLead(JSON.parse(cookieGuid), token)


  // Creo objeto con parametros para traer productores sugeridos
  const data = {
    nroDni      : lead.dni,
    sexo        : lead.genero,
    idLocalidad : lead.idLocalidad
  }

  // Si ya consulto a los PAS el mismo usuario los traigo de localstorage
  const producersLocal = localStorage.getItem('producers') ? JSON.parse(localStorage.getItem('producers')) : false;
  if (producersLocal && producersLocal.dniConsultante === lead.dni) {
    producers = producersLocal.producers;
  }else {
    producers = await getProducers(data, token)
    
    // Guardo los PAS en localStorage
    localStorage.setItem('producers', JSON.stringify({
      producers,
      dniConsultante: lead.dni
    }));
  }

  producers.forEach(producer => {

    let containerProducers  = document.getElementById('container-producers');
    let divProducer         = document.createElement('div');
    divProducer.id          = `cod-${producer.codigoProductor}`;
    divProducer.onclick     = function () { inputRadio(producer.codigoProductor); isValid = true; }
    
    divProducer.classList.add('column');

    divProducer.innerHTML = `<input type='radio'
                                    name='producer-item'
                                    class='radio-producer'
                                    id='_${producer.codigoProductor}'
                                    value=${producer.codigoProductor}
                                    >
                                      <strong>
                                        <p id='name_${producer.codigoProductor}' hidden>${producer.productor}</p>
                                        ${producer.productor.length > 26 ? producer.productor.slice(0, 26) + '...' : producer.productor}
                                      </strong>${producer.direccion}, ${producer.localidad}`;

    containerProducers.appendChild(divProducer)
  });



  // Muestro los PAS
  if (!producers) {
    document.getElementById('container-producers').innerHTML = '<div>Ocurrió un error al traer los productores</div>'
  } else {
    // Oculto loader y muestro productores
    document.getElementById('loader-cedula').hidden = true;
    document.getElementById('container-producers').hidden = false;
  }

  if (lead.codint) {
    if (document.getElementById(`_${lead.codint}`) !== null && document.getElementById(`cod-${lead.codint}`) !== null) {
      document.getElementById(`_${lead.codint}`).checked = true;
      document.getElementById(`cod-${lead.codint}`).classList.add('column-checked');
      isValid = true;
    }
  }

  // SUBMIT DEL FORMULARIO
  document.getElementById('advisors-form').addEventListener('submit', async(event) => {
    event.preventDefault();

    if (!isValid) {
      document.getElementById('loader-error').hidden = false;
      return;
    }

   
    isValid = true;

    // Tomo valores de input seleccionado
    const productorSeleccionadoCodigo = $("input[type='radio'][name='producer-item']:checked").val();
    const productorSeleccionadoName = document.getElementById(`name_${productorSeleccionadoCodigo}`).innerHTML;

    // Saco token
    const token = await getToken();
    // Traigo Lead 
    const guid  = JSON.parse(cookieGuid);
    const lead  = await getLead(guid, token);

    // Creo nuevo lead
    const newLead = {
      ...lead,
      codint: productorSeleccionadoCodigo,
      instanciaAlcanzada: 16
    }

    await saveLead(token, newLead);

    // Guardo en quote
    const dataObject = {
        codint: productorSeleccionadoCodigo
    }
    const data = {
        tag: 'codint',
        guid,
        dataObject
    }
    $.ajax({
      url: themePath + "utils/save_quote_nuevo.php",
      type: "POST",
      data: {data},
      success: function (data) {
          console.log('SE ACTUALIZO QUOTE')
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
          paso : 4,
      }
  }


    document.cookie = "instanciaAlcanzada="+JSON.stringify(instanciaAlcanzada)+"; path = /";

    window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/resumen?${JSON.parse(cookieGuid)}`
  })


  // Boton Volver
  document.getElementById('button-volver').addEventListener('click', (e) => {
    e.preventDefault();
    window.location.href = `${php_data.NuevaUrl}/checkout/cotizador-personal-autos-y-pick-ups/datos-vehiculo?${JSON.parse(cookieGuid)}`;
  })

})


function inputRadio(codProductor) {

  var elems = document.querySelectorAll(".column");
  [].forEach.call(elems, function(el) {
      el.classList.remove("column-checked");
  });


  document.getElementById(`_${codProductor}`).checked = true;
  document.getElementById(`cod-${codProductor}`).classList.add('column-checked');
  
  // Quito mensaje error cuando se clickea una box
  document.getElementById('loader-error').hidden = true;
}

// Insertar Elemento despues en DOM
function insertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
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

// Traer token
async function getToken() {
  const resp = await fetch(`${ themePath }utils/get_token.php`,{
      method: 'POST'
  });
  const res = await resp.json();
  return res;
}

// Traer Productores sugeridos
async function getProducers(data, token) {
  url = php_data.COOPSEG_SUGGEST_PRODUCERS_URL;
  try {
      const response = await fetch(`${url}?nroDni=${data.nroDni}&sexo=${data.sexo}&idLocalidad=${data.idLocalidad}`, {
          method: 'GET',
          headers: {
              'Authorization' : `Bearer ${token}`
          },
      })
      const res = await response.json();
      if (response.ok) {
          return res
      }else {
          console.log('Error al traer productores');
      }
  } catch (error) {
      console.log(error)
  }
}

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
