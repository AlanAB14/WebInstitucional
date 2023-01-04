// // ONCHANGE INPUTS SELECT DE FORMULARIO VEHICULO



// async function cambioFormVehiculo( event ) {
//     console.log(event.target.id);
//     campoModificado = event.target.id;
//     vehiculoMarca = document.getElementById("marca-nuevo");
//     vehiculoModelo = document.getElementById("model");
//     vehiculoAnio = document.getElementById("agnoNew");
//     vehiculoVersion = document.getElementById("version");
//     vehiculoLocalidad = document.getElementById("localidad");
//     vehiculoGNC = document.getElementById("gnc");


//     switch (campoModificado) {
//         case vehiculoMarca.id:
//             vehiculoModelo.disabled = false;
//             data = await buscar("buscarModelos"); 
//             modelos = data.modelos;
//             reestablecerCampo(vehiculoModelo);
//             reestablecerCampo(vehiculoAnio);
//             reestablecerCampo(vehiculoVersion);
//             reestablecerCampo(vehiculoGNC);
//             modelos.forEach(function(modelo){
//                 opcion = document.createElement("option");
//                 opcion.value = modelo.idModelo;
//                 opcion.innerHTML = modelo.modelo;
//                 vehiculoModelo.appendChild(opcion);
//             });
//             $('.selectores-modelo').css("pointer-events", "auto");
//             vehiculoModelo.focus();
//             break;
    
//         case vehiculoModelo.id:
//             vehiculoAnio.disabled = false;
//             data= await buscar("buscarAños"); 
//             anios = data.anios;
//             reestablecerCampo(vehiculoAnio);
//             reestablecerCampo(vehiculoVersion);
//             reestablecerCampo(vehiculoGNC);
//             anios.forEach(function(anio){
//                 opcion = document.createElement("option");
//                 opcion.value = anio;
//                 opcion.innerHTML = anio;
//                 vehiculoAnio.appendChild(opcion);
//             });
//             $('.selectores-ano').css("pointer-events", "auto");
//             vehiculoAnio.focus();
//             break;
        
//         case vehiculoAnio.id:
//             vehiculoVersion.disabled = false;
//             data = await buscar("buscarVersiones");
//             versiones = data.versiones;      
//             reestablecerCampo(vehiculoVersion);
//             reestablecerCampo(vehiculoGNC);
//             versiones.forEach(function(version){
//                 opcion = document.createElement("option");
//                 opcion.value = [version.codval, version.codia];
//                 opcion.innerHTML = version.modelo;
//                 vehiculoVersion.appendChild(opcion);
//             });
//             $('.selectores-version').css("pointer-events", "auto");
//             vehiculoVersion.focus();
//             break;

            
//         case vehiculoVersion.id:
//             vehiculoLocalidad.disabled = false;
//             data = await buscar("buscarLocalidades");
//             localidades = data.localidades;           
//             reestablecerCampo(vehiculoGNC);
//             localidades.forEach(function(localidad){
//                 opcion = document.createElement("option");
//                 opcion.value = localidad.idcity;
//                 opcion.innerHTML = localidad.city+', '+localidad.state+', '+localidad.zipcode;
//                 vehiculoLocalidad.appendChild(opcion);
//             });

    

//             data = await buscar("buscarGNC"); 
//             console.log(data);
//             gnc = data.gnc;
//             reestablecerCampo(vehiculoGNC);
//             opcion = document.createElement("option");
//             opcion.value = 0;
//             opcion.innerHTML = "Sin G.N.C.";
//             vehiculoGNC.appendChild(opcion);
//             gnc.forEach(function(gnc){
//                 opcion = document.createElement("option");
//                 opcion.value = gnc.valor;
//                 opcion.innerHTML = gnc.detalle;
//                 vehiculoGNC.appendChild(opcion);
//             });
//             var selectLocalidades = $('.localidad-select2').select2();
//             selectLocalidades.data().select2.$container.addClass("selectores")
//             selectLocalidades.data().select2.$container.addClass("selectores-localidades")
//             vehiculoLocalidad.focus();
//             break;
        
//         case vehiculoLocalidad.id:
//             if (vehiculoGNC.value !== "") {
//                 return
//             }
    
//             vehiculoGNC.disabled = false;
//             data = await buscar("buscarGNC"); 
//             gnc = data.gnc;
//             reestablecerCampo(vehiculoGNC);
//             opcion = document.createElement("option");
//             opcion.value = 0;
//             opcion.innerHTML = "Sin G.N.C.";
//             vehiculoGNC.appendChild(opcion);
//             gnc.forEach(function(gnc){
//                 opcion = document.createElement("option");
//                 opcion.value = gnc.valor;
//                 opcion.innerHTML = gnc.detalle;
//                 vehiculoGNC.appendChild(opcion);
//             });
//             $('.selectores-gnc').css("pointer-events", "auto");
//             vehiculoGNC.focus();
//             break;
//     }
// }


// function reestablecerCampo(campo) {
//     campo.innerHTML = "";
//     opcion = document.createElement("option");
//     opcion.value = '';
//     switch (campo.id) {
//         case "marca-nuevo":
//             opcion.innerHTML = "Seleccione una marca";
//             break;

//         case "model":
//             opcion.innerHTML = "Seleccione un modelo";
//             break;
        
//         case "agnoNew":
//             opcion.innerHTML = "Seleccione un año";        
//             break;

//         case "version":
//             opcion.innerHTML = "Seleccione una versión";   
//             break;
            
//         case "gnc":
//             opcion.innerHTML = "Seleccione una opción";   
//     }
//     campo.appendChild(opcion);
// }


// async function incioSeleccion(){
//     console.log(php_data.homeUrl)


    
//     $misDatos= await buscar("buscarMarcas"); 
//     $marcas = $misDatos.marcas;
//     $selMarca = document.getElementById("marca-nuevo");
//     $selMarca.innerHTML = "";
//     $opcion = document.createElement("option");
//         $opcion.value = 0;
//         $opcion.innerHTML = "Seleccione una marca";
//         $selMarca.appendChild($opcion);
//     $marcas.forEach(function(marca, index){
//         $opcion = document.createElement("option");
//         $opcion.value = marca.idMarca;
//         $opcion.innerHTML = marca.marca;
//         $selMarca.appendChild($opcion);
        
//     });

//     $('.selectores-marca').css("pointer-events", "auto");
//     document.getElementById("marca-nuevo").focus();
// }



// // async function selMarca(){
// //     $idMarca = document.getElementById("marca-nuevo");
    
// //     $misDatos= await buscar("buscarModelos"); 
    
// //     $modelos = $misDatos.modelos;
    
// //     $selModelo = document.getElementById("model");
// //     $selModelo.innerHTML = "";
// //     $opcion = document.createElement("option");
// //         $opcion.value = 0;
// //         $opcion.innerHTML = "Seleccione un modelo";
// //         $selModelo.appendChild($opcion);
// //     $modelos.forEach(function(modelo){
// //         $opcion = document.createElement("option");
// //         $opcion.value = modelo.idModelo;
// //         $opcion.innerHTML = modelo.modelo;
// //         $selModelo.appendChild($opcion);
// //     });   
    
// // }

// // async function selModelo(){
// //     $idModelo = document.getElementById("model");
// //     $misDatos= await buscar("buscarAños"); 

// //     $anios = $misDatos.anios;
    
// //     $selAnio = document.getElementById("agnoNew");
// //     $selAnio.innerHTML = "";
// //     $opcion = document.createElement("option");
// //         $opcion.value = "";
// //         $opcion.innerHTML = "Seleccione un año";
// //         $selAnio.appendChild($opcion);
// //     $anios.forEach(function(anio){
// //         $opcion = document.createElement("option");
// //         $opcion.value = anio;
// //         $opcion.innerHTML = anio;
// //         $selAnio.appendChild($opcion);
// //     });   
// // }

// // async function selAnio(){
// //     $idAnio = document.getElementById("agnoNew");
// //     $misDatos= await buscar("buscarVersiones"); 
    
// //     $versiones = $misDatos.versiones;
    
// //     $selVersion = document.getElementById("version");
// //     $selVersion.innerHTML = "";
// //     $opcion = document.createElement("option");
// //         $opcion.value = "";
// //         $opcion.innerHTML = "Seleccione una versión";
// //         $selVersion.appendChild($opcion);
// //     $versiones.forEach(function(version){
// //         $opcion = document.createElement("option");
// //         $opcion.value = [version.codval, version.codia];
// //         $opcion.innerHTML = version.modelo;
// //         $selVersion.appendChild($opcion);
// //     });   
// // }

// // async function selVersion(){
    
// //     $misDatos= await buscar("buscarLocalidades");
// //     $localidades = $misDatos.localidades;
    
// //     $selLocalidad = document.getElementById("localidad");
// //     $selLocalidad.innerHTML = "";
// //     $opcion = document.createElement("option");
// //         $opcion.value = "";
// //         $opcion.innerHTML = "Seleccione una localidad";
// //         $selLocalidad.appendChild($opcion);
// //     $localidades.forEach(function(localidad){
// //         $opcion = document.createElement("option");
// //         $opcion.value = localidad.idcity;
// //         $opcion.innerHTML = localidad.city+', '+localidad.state+', '+localidad.zipcode;
// //         $selLocalidad.appendChild($opcion);
// //     });
// // }

// // async function selLocalidad(){
// //     //$idGNC = document.getElementById("gnc");
// //     $misDatos= await buscar("buscarGNC"); 
// //     console.log($misDatos);
// //     $gnc = $misDatos.gnc;
    
// //     $selGNC = document.getElementById("gnc");
// //     $selGNC.innerHTML = "";
// //     $opcion = document.createElement("option");
// //     $opcion.value = "";
// //     $opcion.innerHTML = "Selecciones una opción";
// //     $selGNC.appendChild($opcion);
// //     $opcion = document.createElement("option");
// //     $opcion.value = 0;
// //     $opcion.innerHTML = "Sin G.N.C.";
// //     $selGNC.appendChild($opcion);
// //     $gnc.forEach(function(gnc){
// //         $opcion = document.createElement("option");
// //         $opcion.value = gnc.valor;
// //         $opcion.innerHTML = gnc.detalle;
// //         $selGNC.appendChild($opcion);
// //     });   
// // }


// async function buscar(action){
//     $url = "http://localhost/wordpress/wp-content/themes/cooperacionseguros-theme/template-parts/cotizador/completa_datos.php";
//     $action = action;
    
//     if($action == "buscarModelos"){
//         $body=JSON.stringify({
//             idMarca: vehiculoMarca.value,
//             action: $action,
//         });
//     }else if($action == "buscarAños"){
//         $body=JSON.stringify({
//             idModelo: vehiculoModelo.value,
//             action: $action,
//         });
//     }else if($action == "buscarVersiones"){
//         $body=JSON.stringify({
//             idModelo: vehiculoModelo.value,
//             idAnio: vehiculoAnio.value,
//             action: $action,
//         });
//     }else if($action == "buscarGNC"){
//         $body=JSON.stringify({
//             query: "g.n.c",
//             action: $action,
//         });
//     }else if($action == "buscarLocalidades"){
//         $body=JSON.stringify({
//             action: $action,
//         });
//     }else if($action == "buscarMarcas"){
//         $body=JSON.stringify({
//             action: $action,
//         });
//     }

//     const response = await fetch($url, {
//         method: 'POST',
//         body: $body
//     });
//     const data = await response.json();
//     // console.log(data);
//     return data;
// }

// function form1(){
//     marcaSel = document.getElementById('marca-nuevo');
//     modeloSel = document.getElementById('model');
//     agnoSel = document.getElementById('agnoNew');
//     versionSel = document.getElementById('version');
//     localidadSel = document.getElementById('localidad');
//     gncSel = document.getElementById('gnc');



//     const opcionesVehiculos = {
//         idMarca : marcaSel.value,
//         marca : marcaSel.options[marcaSel.selectedIndex].text,
//         idModelo : modeloSel.value,
//         modelo : modeloSel.options[modeloSel.selectedIndex].text,
//         agno: agnoSel.value,
//         idVersion : versionSel.value,
//         version : versionSel.options[versionSel.selectedIndex].text,
//         zipCode : localidadSel.value,
//         localidad : localidadSel.options[localidadSel.selectedIndex].text,
//         idGnc : gncSel.value,
//         gnc : gncSel.options[gncSel.selectedIndex].text
//     }   

//     document.cookie = "datosVehiculo="+JSON.stringify(opcionesVehiculos)+"; path = /";

//     document.cookie = "stepFirst=persona; path=/";


//     window.location.href = `${php_data.NuevaUrl}/cotizador-personal-autos-y-pick-ups/persona/`;
// }

// function maskTel(){
//     $tel = document.getElementById("telefono");
//     $tel.addEventListener("keyup", function(event) {
//         if (event.keyCode === 8) {
//             return;
//         }
//         var value = this.value;
//         if(value.length === 1){
//             this.value = "(0"+value;
//         }        
//         else if (value.length === 6) {
//             this.value = value + ')15-';
//         } 
//     });
// }

// function validaNombre(){
//     $nombre = document.getElementById("nombre");
    
//     if($nombre.value.indexOf(" ") == -1){
        
//         $nombre.focus();
//     }
    
// }

// function validaEmail(){
//     $email = document.getElementById("email");
    
//     //buscar espacio en blanco
//     if($email.value.indexOf("@") == -1){
        
//         $email.focus();
//     }
//     document.getElementById('btnForm2').disabled = false;
//     document.getElementById('anclaBtn2').disabled = false;
// }

// function datosPersonales(){
//     $tel = document.getElementById("telefono");
//     $nombre = document.getElementById("nombre");
//     $email = document.getElementById("email");
    
//     const datosPersonales = {
//         telefono : $tel.value,
//         nombre : $nombre.value,
//         mail : $email.value,
//     }   

//     document.cookie = "datosPersonales="+JSON.stringify(datosPersonales)+"; path = /";
    
// }
// function selectGrua(){
//     $precio = document.getElementById("precioFull").innerHTML;
//     $franquicia = document.getElementById("franquicia");
//     $selGrua = document.getElementById('km-grua');
//     const full = JSON.parse($selGrua.dataset.full);
//     let fulltier = $selGrua.value;
//     const plans = JSON.parse($selGrua.dataset.plans);
        
//     $franquicia.innerHTML = "";
//     $.each(full[fulltier], function(index, plan){
//         let { franquicia, premioMensual } = plans[plan]; 
        
//         if(index==0){
//             $total = premioMensual;
//         }
//         $opcion = document.createElement("option");
//         $opcion.value = premioMensual;
        
//         $opcion.innerHTML = numberToPrice(franquicia);
//         $franquicia.appendChild($opcion);
//     });
    
//     $precioFull = document.getElementById("precioFull");
//     $precioFull.innerHTML = "$" + numberToPrice($total);

// }

// function envioPlan($index){
//     //event.preventDefault();
//     //console.log('entre..');
//     //console.log($index);
//     let plan;
//     switch($index){
//         case "1":
//             $btnPlan = document.getElementById('btnCotizaBasic');
//             $precioCouta = document.getElementById('precioBasico').innerHTML;
//             break;
//         case "2":
//             $btnPlan = document.getElementById('btnCotizaMedium');
//             $precioCouta = document.getElementById('precioMedium').innerHTML;
//             break;
//         case "3":
//             $btnPlan = document.getElementById('btnCotizaFull');
//             $precioCouta = document.getElementById("precioFull").innerHTML;
//             break;
//     }

//     plan = $btnPlan.value;
//     $planEscojido = {plan: plan, precio: $precioCouta};
//     document.cookie = "planElejido="+JSON.stringify($planEscojido)+"; path = /";
//     //$selGrua = document.getElementById('km-grua');
//     //const plans = JSON.parse($selGrua.dataset.plans);
//     $("input[name=planCobertura]").val(plan);
//     $("input[name=planSuma]").val(plans[plan].suma);
//     $("input[name=planPremio]" ).val(plans[plan].premio);
//     $("input[name=planPremioMensual]").val(plans[plan].premioMensual);
//     $("input[name=planPremioReferencia]").val(plans[plan].premioReferencia);
//     $("input[name=planPrima]").val(plans[plan].prima);
//     $("input[name=planFechaInicio]").val(plans[plan].fechaInicio);
//     $("input[name=planFechaFin]").val(plans[plan].fechaFin);
//     $("input[name=planFranquicia]").val(plans[plan].franquicia);
//     $("input[name=codigoConvenio]").val(plans[plan].codigoConvenio);
//     $("input[name=bonusMaxConvenio]").val(plans[plan].bonusMaxConvenio);
//     $("input[name=bonusMaxAntiguedad]").val(plans[plan].bonusMaxAntiguedad);
//     $("input[name=bonusMaxSuma]").val(plans[plan].bonusMaxSuma);

//     trackInitCheckout(plan);
//     document.cookie = "datosPlan="+JSON.stringify(plans)+"; path = /";
//     document.cookie = "commonEvent="+JSON.stringify(commonEvent)+"; path = /";
// }

// function trackInitCheckout(selectedPlan) {
//     const eventData = {
//         ...commonEvent,
//     }
//     console.log(eventData);
//     //if (product == 'seguro-de-motos' || product == 'seguro-de-autos-y-pick-ups') {
//         eventData['event'] = 'trackEcommerceInitCheckout';
//         eventData['vehiclePlan'] = selectedPlan;
//         eventData['vehiclePlanPrice'] = plans[selectedPlan].premioMensual;
//         eventData['vehiclePlanPriceAP'] = ap.premioMensual ?? null;
//         eventData['vehiclePlanIncludeAP'] = '';
//     //} else if (product == 'seguro-de-vida-individual') {
//         //eventData['event'] = 'trackInitCheckout';
//         //eventData['lifeInsurancePlan'] = selectedPlan;
//         //eventData['lifeInsurancePlanPrice'] = '';
//     //}

//     pushDataLayer(eventData);
//     }

// function numberToPrice(num) {
//     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
// }

// function selectFranquicia(){
//     $premio = document.getElementById("franquicia").value;
//     $nuevoPrecio = document.getElementById("precioFull");
//     $nuevoPrecio.innerHTML = "$" + numberToPrice($premio);
    
// }
// function checkPackBasico(){
//     $precio = document.getElementById("precioBasico").innerHTML;
//     $packFull = document.getElementById("packBasico");
//     $total=0;
//     $valor = $packFull.value;
//     $precio = $precio.replace(/\./g, '');   
//     $precio = $precio.replace(/\$/g, '');
//     if($packFull.checked){
//         $total = parseInt($precio) + parseInt($valor);
//     }else{
//         $total = parseInt($precio) - parseInt($valor);
//     }
//     $nuevoPrecio = document.getElementById("precioBasico");
//     $nuevoPrecio.innerHTML = "$"+numberToPrice($total);
// } 
// function checkPackSup(){
//     $precio = document.getElementById("precioMedium").innerHTML;
//     $packFull = document.getElementById("packSuperior");
//     $total=0;
//     $valor = $packFull.value;
//     $precio = $precio.replace(/\./g, '');   
//     $precio = $precio.replace(/\$/g, '');
//     if($packFull.checked){
//         $total = parseInt($precio) + parseInt($valor);
//     }else{
//         $total = parseInt($precio) - parseInt($valor);
//     }
//     $nuevoPrecio = document.getElementById("precioMedium");
//     $nuevoPrecio.innerHTML = "$"+numberToPrice($total);
// }
// function checkPackFull(){
//     $precio = document.getElementById("precioFull").innerHTML;
//     $packFull = document.getElementById("packFull");
//     $total=0;
//     $valor = $packFull.value;
//     $precio = $precio.replace(/\./g, '');   
//     $precio = $precio.replace(/\$/g, '');
//     if($packFull.checked){
//         $total = parseInt($precio) + parseInt($valor);
//     }else{
//         $total = parseInt($precio) - parseInt($valor);
//     }
//     $nuevoPrecio = document.getElementById("precioFull");
//     $nuevoPrecio.innerHTML = "$"+numberToPrice($total);
// }




