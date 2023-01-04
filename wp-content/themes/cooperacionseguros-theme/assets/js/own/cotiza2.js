

// console.log('<-- cotiza2 funcionando -->');


// let genero = '';
// let nombre, apellido, fechaNac ='';

// $(document).ready(function(){
//     $('#femenino').click(function(){
//         genero = "F";
//         $('#msnDNI').attr('hidden', true);
//     });
    
//     $('#masculino').click(function(){
//         genero = "M";
//         $('#msnDNI').attr('hidden', true);
//     });
//     $('#miBtn').click(function(){
//         console.log('<-- funcion boton DNI -->');
//         const nroDNI = $('input[name="dni"]').val();
//         if(nroDNI.length == 8 && genero != ''){
//             buscaDNI(nroDNI, genero);
            
//         }else{
//             $('#msnDNI').removeAttr('hidden');
//         }
//     });

//     function buscaDNI(nroDNI, genero){
//         console.log('<-- funcion buscaDNI -->');
//         $.ajax({
//             url: `/wordpress/wp-content/themes/cooperacionseguros-theme/api/api.php?get=customer&num_dni=${nroDNI}&sexo=${genero}`,
//             context: document.body,
//             success: function (data) {
//                 console.log('DNI exito..' );
//                 nombre = data.nombre;
//                 apellido = data.apellido;
//                 fechaNac = new Date(data.fechaNacimiento);
//                 $('#nombre_apellido').val(data.nombre+' '+data.apellido);
//                 let fechaNacimiento = new Date(data.fechaNacimiento);
//                 $('#dia').val(fechaNacimiento.getDate());
//                 $('#mes').val(fechaNacimiento.getMonth()+1);
//                 $('#anio').val(fechaNacimiento.getFullYear());
    
//                 // Enviamos lead intermedio por AJAX
//                 $.post("/wordpress/wp-content/themes/cooperacionseguros-theme/template-parts/cotizador/save-lead.php", {
//                     guid: guid,
//                     dni: nroDNI,
//                     genero: genero,
//                     instancia: '2',
//                     descripcion: 'Datos-Solicitante-Ingreso DNI',
//                     paso: '1'
//                 });

//                 const eventData = {
//                     'customerType': 'fisica',
//                     'customerGender': genero,
//                     'event': 'trackEcommerceCheckoutValidateCustomer',
//                     ...commonEvent,
//                 };
//                 pushDataLayer(eventData);

//                 let form_persona = document.getElementById('form-datos-personal');
//                 form_persona.scrollIntoView({block: 'center'});
//                 form_persona.removeAttribute('hidden');
//                 $('#lugar_nac').focus();
    
//             }
//         }).done(function () {});
//     }

//     $('#btnDatosPersonales').click(function(){
//         // recolectamos informacion del formulario
//         //let cod_cli= $('#cod_cli').val();
//         let dia = $('#dia').val();
//         let mes = $('#mes').val();
//         let anio = $('#anio').val();
//         let lugar_nac = $('#lugar_nac').val();
//         let nacionalidadId = $('#nac').val();
//         let estado_civil = $('#estado_civil').val();
//         let ocupacion = $('#ocupacion').val();
//         let calle = $('#calle').val();
//         let numero = $('#nro').val();
//         let piso = $('#piso').val();
//         let depto = $('#depto').val();
//         //let localidadActual = $('#localidadAc').val();//id localidad actual
//         let localidad = $('#localidad').val();
//         //let provinciaId = $('#provinciaId').val();
//         //let provincia = $('#provincia').val();
//         //let codigoPostal = $('#codigoPostal').val();
//         let telefono = $('#tel').val();
//         let email = $('#email_persona').val();
//         // Enviamos lead intermedio por AJAX
//         $.post("/wordpress/wp-content/themes/cooperacionseguros-theme/template-parts/cotizador/save-lead.php", {
//             guid: guid,
//             dni: nroDNI,
//             genero: genero,
//             instancia: '2',
//             descripcion: 'Datos-Solicitante',
//             paso: '2',
//             dia: dia,
//             mes: mes,
//             anio: anio,
//             nombre: nombre,
//             apellido: apellido,
//             fechaNacimiento: fechaNac,
//             lugarNacimiento: lugar_nac,
//             nacionalidadId: nacionalidadId,
//             estadoCivil: estado_civil,
//             ocupacion: ocupacion,
//             calle: calle,
//             numero: numero,
//             piso: piso,
//             depto: depto,
//             localidad: localidad,
//             //provinciaId: provinciaId,
//             //provincia: provincia,
//             //codigoPostal: codigoPostal,
//             telefono: telefono,
//             email: email
//         });

//         const eventData = {
//             'location': $('#loc').val(),
//             'event': 'trackEcommerceCheckoutCustomerDetails',
//             ...commonEvent,
//             'customerCitizenship' : $('select[name="nacionalidad"] option:selected').text(),
//             'customerOccupation' : $('select[name="ocupacion"] option:selected').text(),
//             'customerCivilStatus' : $('select[name="estado_civil"] option:selected').text(),
//         };
//         pushDataLayer(eventData);
//     });

//     $('#tel').on('keypress', function(e){
//         $tel = document.getElementById("tel");
//         $tel.addEventListener("keyup", function(event) {
//             if (event.keyCode === 8) {
//                 return;
//             }
//             var value = this.value;
//             if(value.length === 1){
//                 this.value = "(0"+value;
//             }        
//             else if (value.length === 6) {
//                 this.value = value + ')15-';
//             } 
//         });
//     });
    

    
    
// });

// function validaEmail2(){
//     console.log('<-- funcion validaEmail -->');
//     $email = document.getElementById("email_persona");
    
//     //buscar espacio en blanco
//     if($email.value.indexOf("@") == -1){
        
//         $email.focus();
//     }
    
// }







