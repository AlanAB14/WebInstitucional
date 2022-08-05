/**
 * Funciones genéricas
 */

// Templates para Documentos
$.templates({
  templateDocumentos:
    '<p><label for="{{:id}}" class="fileUpload"><span>{{:label}}</span></label><input type="file" id="{{:id}}" name="{{:id}}" accept="image/*,.jfif,application/pdf" maxsize="3000" /> </p>',

  // TODO required
});

// Scroll hacia un elemento
function scrollToElement(element) {
  // Scrollear al próximo paso
  $("html, body").animate(
    {
      scrollTop: element.offset().top - 16,
    },
    600
  );
}

//  Próximo paso
function nextStep(el) {
  var parent = el.parents(".paso");

  if (parent.nextAll().length > 0) {
    var nextElement = parent.next(".paso");

    // Mostrar contenido del próximo paso
    nextElement.addClass("active").find(".content").show();

    // Si el paso es de documentos, ejecutar la función para ver qué documentos mostrar
    if (nextElement.is("#paso6")) {
      showDocuments();
    }

    // Desactivar elementos anteriores (salvo en los dos primeros pasos)
    if (nextElement.is("#paso2") || nextElement.is("#paso3")) {
      nextElement.prevAll().addClass("almostDone");
    } else {
      nextElement.prevAll().removeClass("active").addClass("done");
    }
    // Scrollear hacia el siguiente paso
    scrollToElement(nextElement);
  } else {
    // console.log("No hay próximo paso");
  }
}

// Función para mostrar los documentos requeridos según las condiciones anteriores
function showDocuments() {
  var documentsFile = themePath + "data/terceros.json";
  $.getJSON(documentsFile, function (data) {
    // Agregar documentos necesarios
    $.each(data.documents, function (i, el) {
      if ($("#" + el.category).is(":checked") || el.category == "all") {
        $archivo = $([]);
        var html = $.templates.templateDocumentos.render({
          id: el.category + "-" + el.id,
          label: el.label,
        });

        $archivo.add(html).appendTo("#documentos");
      }
    });

    // Activar el botón de continuar
    $("#paso6").find(".continuar button").prop("disabled", false);
  });
}

// Validar un campo
function validateField(field) {
  var id = field.attr("id");

  // Deshabilitar campo y botón
  field.prop("readonly", true).addClass("disabled");
  field
    .next(".validar")
    .addClass("disabled")
    .append(' <i class="fas fa-circle-notch fa-spin"></i>');

  //Borrar mensajes
  field.parents("fieldset").find(".note").remove();

  // Si se validan patentes
  if (id == "patente-vehiculo-propio" || id == "patente-vehiculo-asegurado") {
    // Validar form para confirmar que tenemos fecha y hora
    $("#reclamos-de-terceros-form").validate();

    // Si el formulario es válido...
    if ($("#reclamos-de-terceros-form").valid()) {
      /**
       * Validar patente propia Web service
       */
      if (id == "patente-vehiculo-propio") {
        $.post(themePath + "inc/ajax-terceros.php", {
          consulta: "patente",
          patente: field.val(),
          fecha: $("#fecha").val(),
          hora: $("#hora").val(),
        }).done(function (data) {
          if (data == 2) {
            // Patente ya está asegurada, debe ir a AOL
            field.prop("readonly", false).removeClass("disabled");
            field.next(".validar").removeClass("disabled").find("i").remove();
            field
              .parents("fieldset")
              .append(
                '<p class="note alert"><span>La patente corresponde a un asegurado de Cooperación Seguros. Para un reclamo sobre tu seguro, ingresá a <a href="https://asegurados.cooperacionseguros.com.ar/" target="_blank">Asegurados ONLINE</a>.</span></p>'
              );
          } else {
            // Patente no está asegurada, se puede continuar
            field
              .next(".validar")
              .text("Validada")
              .addClass("done")
              .find("i")
              .remove();

            // Botón para editar
            field
              .parent()
              .append('<span class="edit">Modificar patente</span>');

            // Autocompletar la patente en el siniestro de vehículos
            $("#dano-vehiculo-patente").val(field.val());

            // Ir al próximo elemento
            nextElement = field.parents("fieldset").next("fieldset");
            nextElement.show();
            scrollToElement(nextElement);

            // Si la patente del vehículo asegurado ya está completa y validada, se podría continuar...
            if ($("#patente-vehiculo-asegurado").hasClass("valid disabled")) {
              field
                .parents(".content")
                .find(".continuar button")
                .prop("disabled", false);
            }
          }
        });
      } else if (id == "patente-vehiculo-asegurado") {
        /**
         * Validar patente vehículo asegurado via Web service
         */
        $.post(themePath + "inc/ajax-terceros.php", {
          consulta: "patente",
          patente: field.val(),
          fecha: $("#fecha").val(),
          hora: $("#hora").val(),
        }).done(function (data) {
          if (data == 1) {
            // La patente no existe
            field.prop("readonly", false).removeClass("disabled");
            field.next(".validar").removeClass("disabled").find("i").remove();
            field
              .parents("fieldset")
              .append(
                '<p class="note alert"><span>La patente ingresada no corresponde con un asegurado de Cooperación Seguros. Por favor, intentalo nuevamente.</span></p>'
              );
          } else if (data == 2) {
            // La patente existe y está asegurada
            field
              .next(".validar")
              .text("Validada")
              .addClass("done")
              .find("i")
              .remove();
            field
              .parents(".content")
              .find(".continuar button")
              .prop("disabled", false);

            // Botón para editar
            field
              .parent()
              .append('<span class="edit">Modificar patente</span>');
          } else if (data == 3) {
            //Patente existente con póliza NO vigente
            field.prop("readonly", false).removeClass("disabled");
            field.next(".validar").removeClass("disabled").find("i").remove();
            field
              .parents("fieldset")
              .append(
                '<p class="note alert"><span>La patente corresponde a un asegurado de Cooperación Seguros con una póliza no vigente. Por favor, comunicate con <a href="/contacto" target="_blank">atención al cliente</a> para recibir ayuda con tu reclamo.</span></p>'
              );
          }
        });
      }
    } else {
      // Si el form no es válido...
      field.prop("readonly", false).removeClass("disabled");
      field.next(".validar").removeClass("disabled").find("i").remove();
    }
  }
}

// Resetear campos de un elemento
function clearForm(element) {
  element
    .find(":input")
    .not(":button, :submit, :reset, :hidden, :checkbox, :radio")
    .val("");
  element.find(":checkbox, :radio").prop("checked", false);
}

/**
 * Cuando carga la página
 */
$(function () {
  // Variables particulares a la selección de productos
  var formContainer = $("#reclamos-de-terceros-form");
  var submittable = false;

  // Si el form existe...
  if (formContainer.length) {
    /**
     * Paso 1
     */
    $("#paso1 input[type=checkbox]").change(function () {
      // Confirmar si hay al menos un checkbox tildado
      if ($("#paso1 input[type=checkbox]").is(":checked")) {
        $("#paso1").find(".continuar button").prop("disabled", false);
      } else {
        $("#paso1").find(".continuar button").prop("disabled", true);
      }

      // Escondecr condicionales y loopear entre todas las opciones chequeadas para mostrar los que estén activos
      formContainer.find(".showconditional").hide();
      $("#paso1 input[type=checkbox]:checked").each(function (index) {
        var target = $(this).attr("id");
        formContainer.find(".showconditional." + target).show();
      });

      /*
      // Mostrar documentación para este tipo de siniestro
      var target = $(this).attr("id");
      if ($(this).is(":checked")) {
        $("#paso2")
          .find(".tipo." + target)
          .show();
        formContainer.find(".showconditional." + target).show();
      } else {
        $("#paso2")
          .find(".tipo." + target)
          .hide();
        formContainer.find(".showconditional." + target).hide();
      }
      */

      // Si vehículos está seleccionado y todavía no se validó la patente del vehículo propio, ocultar la del tercero
      if (
        $("#vehiculos").is(":checked") &&
        !$("#patente-vehiculo-propio").hasClass("valid disabled")
      ) {
        $("#paso3").find(".lesiones").hide();
      } else {
        $("#paso3").find(".lesiones").show();
      }
    });

    /**
     * Paso 4
     */

    // Cargamos siempre con persona física por default
    $("#paso4 #tipo-persona-fisica").prop("checked", true);

    // Máscara por defecto para el DNI
    $("#reclamante-documento-numero").inputmask("9{6,9}", {
      placeholder: "XXXXXXXX",
    });

    // Cambiar tipos de documento
    $("#paso4 input[name=tipo-persona]").change(function () {
      var tipo = $(this).val();

      // Vaciar campos
      $("#reclamante-documento-tipo, #reclamante-documento-numero").empty();

      if (tipo == 1) {
        var options = { 3: "DNI", 6: "Pasaporte", 10: "CUIL" };
        $("#reclamante-documento-numero").inputmask("9{6,9}", {
          placeholder: "XXXXXXXX",
        });
      } else {
        var options = { 9: "CUIT" };
        $("#reclamante-documento-numero").inputmask("99-99999999-9", {
          placeholder: "XX-XXXXXXXX-XX",
        });
      }

      // Completar opciones aceptadas para cada caso
      $.each(options, function (k, v) {
        $("#reclamante-documento-tipo").append(new Option(v, k));
      });
    });

    $("#paso4 select[name=reclamante-documento-tipo]").change(function () {
      let tipo = $(this).val();

      $("#reclamante-documento-numero").removeClass(function (
        _index,
        className
      ) {
        return (className.match(/(^|\s)validar-\S+/g) || []).join(" ");
      });

      switch (parseInt(tipo)) {
        case 3: // DNI
          $("#reclamante-documento-numero").inputmask("9{6,9}", {
            placeholder: "XXXXXXXX",
          });
          break;
        case 6: // PASAPORTE
          $("#reclamante-documento-numero").inputmask("9{6,9}", {
            placeholder: "XXXXXXXX",
          });
          break;
        case 9: // CUIT
          $("#reclamante-documento-numero").inputmask("99-99999999-9", {
            placeholder: "XX-XXXXXXXX-XX",
          });
          break;
        case 10: // CUIL
          $("#reclamante-documento-numero").inputmask("99-99999999-9", {
            placeholder: "XX-XXXXXXXX-XX",
          });
          break;
      }
    });

    // Elegir el tipo de damnificado
    $("#paso4 input[type=radio][name=damnificado-tipo]").change(function () {
      // Mostrar los datos propios si el damnificado es otro
      var damnificadoOtro = $("#paso4").find(".damnificado-otro");
      if ($(this).val() == 5) {
        damnificadoOtro.show();
      } else {
        clearForm(damnificadoOtro);
        damnificadoOtro.hide();
      }

      // Mostrar los datos del reclamante
      $("#paso4 .datos-reclamante").show();

      // Habilitar botón
      $("#paso4").find(".continuar button").prop("disabled", false);
    });

    /*
    $("#paso4 input[name=damnificado]").change(function () {
      var target = $(this).attr("id");

      if ($(this).is(":checked")) {
        // Vaciar los forms para evitar un ida y vuelta con un texto vaciado
        $("#paso4")
          .find(".tipo")
          .each(function () {
            clearForm($(this));
            $(this).hide();
          });

        // Mostrar el campo del tipo correspondiente
        $("#paso4")
          .find(".tipo." + target)
          .show();

        // Deshabilitar el botón por si hubo un cambio
        $("#paso4").find(".continuar button").prop("disabled", true);
      }
    });

    // Al elegir el tipo de damnificado
    $("#paso4 #damnificado-no-tipo, #paso4 #damnificado-si-tipo").change(
      function () {
        // Ir al próximo elemento
        nextElement = $("#paso4 .datos-reclamante");
        nextElement.show();
        scrollToElement(nextElement);

        // Habilitar botón
        $("#paso4").find(".continuar button").prop("disabled", false);
      }
    );
    */

    $(".localidad").select2({
      language: "es",
      placeholder: "Localidad",
      allowClear: true,
      ajax: {
        delay: 250,
        url: placesFileAll,
        processResults: function (data) {
          var results = [];
          $.each(data, function (k, v) {
            results.push({
              id: v.idcity,
              text: v.city + ", " + v.state + " (" + v.zipcode + ")",
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
        cache: true,
      },
    });

    /**
     * Paso 5
     */

    var category;
    var vehicleBrandId;
    var vehicleModelId;
    var vehicleYear;

    function comboField(field) {
      var id = field.attr("id");

      if (id == "dano-vehiculo-marca") {
        var dataFile = brandsFile + "&category=" + category;
        var dataKey = "idMarca";
        var dataField = "marca";
        var legend = "Seleccioná la marca del vehículo";
      } else if (id == "dano-vehiculo-modelo") {
        var dataFile =
          modelsFile + "&brand=" + vehicleBrandId + "&category=" + category;
        var dataKey = "idModelo";
        var dataField = "modelo";
        var legend = "Seleccioná el modelo";
      } else if (id == "dano-vehiculo-ano") {
        var dataFile =
          yearsFile + "&model=" + vehicleModelId + "&fillEmpty=true";
        var legend = "Seleccioná el año";
      } else if (id == "dano-vehiculo-version") {
        if (category == 2) {
          var dataFile =
            versionsMotorbikesFile +
            "&category=2&brand=" +
            vehicleBrandId +
            "&year=" +
            vehicleYear;
        } else {
          var dataFile =
            versionsFile + "&model=" + vehicleModelId + "&year=" + vehicleYear;
        }
        var dataKey = "codval";
        var dataField = "modelo";
        var legend = "Seleccioná el modelo del vehículo";
      }

      $.getJSON(dataFile, function (data) {
        // Agregaar leyenda por defecto
        $(field)
          .empty()
          .append("<option value='' data-key=''>" + legend + "</option>");

        // Popular el select
        $.each(data, function (k, v) {
          // Si buscamos un campo específico de un array... sino, el v
          var value = dataField ? v[dataField] : v;
          var key = dataKey ? v[dataKey] : v;

          // Sumamos options al select
          $(field)
            .append("<option value='" + key + "'>" + value + "</option>")
            .prop("disabled", false)
            .select2();
        });
      });
    }

    // Al elegir el tipo, popular las marcas
    $("#dano-vehiculo-tipo").change(function (e) {
      category = $(this).val();
      if (category) {
        comboField($("#dano-vehiculo-marca"));
      }
    });

    // Al elegir la marca, popular los modelos
    $("#dano-vehiculo-marca").on("select2:select", function (e) {
      vehicleBrandId = $(this).val();
      if (vehicleBrandId) {
        comboField($("#dano-vehiculo-modelo"));
      }
    });

    // Al elegir el modelo, popular los añnos
    $("#dano-vehiculo-modelo").on("select2:select", function (e) {
      vehicleModelId = $(this).val();
      if (vehicleModelId) {
        comboField($("#dano-vehiculo-ano"));
      }
    });

    // Al elegir el año..
    $("#dano-vehiculo-ano").on("select2:select", function (e) {
      vehicleYear = $(this).val();
      if (vehicleYear) {
        comboField($("#dano-vehiculo-version"));
      }
    });

    // Cargamos siempre con vehículo etacionado por default
    // $("#paso5 #dano-vehiculo-estacionado-si").prop("checked", true);

    // Si el vehículo estaba estacionado
    $("#paso5 input[name=dano-vehiculo-estacionado]").change(function () {
      if ($(this).val() == "si") {
        // Vaciar los forms para evitar un ida y vuelta con un texto vaciado
        $("#paso5")
          .find(".conductor")
          .each(function () {
            clearForm($(this));
            $(this).hide();
          });
      } else {
        $("#paso5")
          .find(".conductor")
          .each(function () {
            $(this).show();
          });
      }
    });

    /**
     * Para todos los pasos
     */

    // Inputs de upload
    $(document).on("change", "input[type=file]", function (e) {
      //var file = $(this).val();
      var file = e.target.files[0].name;
      var label = $(this).prev("label");
      label.find("span").text(file);
      label.addClass("done");
    });

    // Fecha y hora
    var startDate = new Date();
    startDate.setFullYear(startDate.getFullYear() - 3);

    var endDate = new Date();

    $(".fecha")
      .datepicker({
        language: "es-ES",
        format: "dd-mm-YYYY",
        autoHide: true,
        startDate: startDate,
        endDate: endDate,
        pick: function (e) {
          e.preventDefault();
          $(this).val($(this).datepicker("getDate", true));
          return $(this).trigger("input");
        },
      })
      .attr("readonly", "true")
      .keypress(function (event) {
        if (event.keyCode == 8) {
          event.preventDefault();
        }
      });

    $(".hora").inputmask({
      alias: "datetime",
      placeholder: "00:00",
      inputFormat: "HH:MM",
      insertMode: false,
      showMaskOnHover: false,
      hourFormat: 24,
    });

    // Próximo paso
    $(".continuar button").click(function (event) {
      // Evitar el default
      event.preventDefault();

      // Definir paso
      var id = $(this).parents(".paso").attr("id");

      // Hay al menos un tipo de siniestro seleccionado?
      var checkboxes =
        $("#paso1 .checkboxes :checkbox:checked").length > 0 ? true : false;

      // Confirmar validación antes de seguir
      if (formContainer.valid() && checkboxes) {
        //if (1 == 1) {
        if (id == "paso6") {
          // Deshabilitar y mostrar que está cargando
          $("#paso6")
            .find(".continuar button")
            .prop("disabled", true)
            .append(' <i class="fas fa-circle-notch fa-spin"></i>');

          // Enviar los datos genéricos para mostrar la información a verificar
          $.post(themePath + "inc/ajax-terceros.php", {
            consulta: "verificar",
            data: formContainer.serialize(),
          }).done(function (data) {
            // Mostrar el próximo paso
            nextStep($("#paso6 .continuar button"));

            // Borrar info si ya existía
            $("#paso7").find(".verificarinfo").remove();

            // Mostrar detalles
            $("<div />", {
              class: "verificarinfo",
              html: data,
            }).prependTo($("#paso7 fieldset"));

            // Habilitar el botón para enviar el formulario
            $("#paso7").find(".continuar button").prop("disabled", false);
          });
        } else if (id == "paso7") {
          // Deshabilitar botón
          $("#paso7")
            .find(".continuar button")
            .prop("disabled", true)
            .append(' <i class="fas fa-circle-notch fa-spin"></i>');

          // En el último paso se envia finalmente el form
          submittable = true;

          formContainer.submit();
        } else {
          // Ver próximo paso
          nextStep($(this));
        }
      } else {
        // Si no hay al menos un siniestro seleccionado...
        if (!checkboxes) {
          $("#paso1 .checkboxes").addClass("error");
        }

        // Scroll hasta el primer elemento con un error para entender qué falta
        scrollToElement($(".error:visible:first"));
      }
    });

    // Cancelar proceso
    $(".cancelar button").click(function (event) {
      // Evitar el default
      event.preventDefault();

      // Mostrar confirmación y recargar el form si el usuario cancela
      if (
        confirm(
          "¿Estás seguro de que queré cancelar? Se perderán todos los datos cargados."
        )
      ) {
        clearForm(formContainer);
        location.reload();
      } else {
        return false;
      }
    });

    // Validar un campo
    $(".validar").click(function (event) {
      // Evitar el default
      event.preventDefault();

      // Campo relacionado
      var field = $(this).prev("input");

      // Ver próximo paso
      if (field.val() && !$(this).hasClass("disabled")) {
        validateField(field);
      }
    });

    // Al hacer click en una patente validada...
    $("body").on("click", ".edit", function () {
      var parent = $(this).parent();
      var fieldID = parent.find("input").attr("id");

      // Rehabilitar campo y botón
      parent
        .find("input")
        .prop("readonly", false)
        .removeClass("disabled")
        .empty();
      parent
        .find(".validar")
        .text("Validar")
        .removeClass("disabled done")
        .find("i")
        .remove();

      // Deshabilitar botón de continuar para que no se avance con patentes sin validar
      parent
        .parents(".content")
        .find(".continuar button")
        .prop("disabled", true);

      // Si se modifica la patente del vehículo propio, se oculta la del asegurado para evitar la validación
      if (fieldID == "patente-vehiculo-propio") {
        nextElement = $(this).parents("fieldset").next("fieldset");
        nextElement.hide();
        scrollToElement(parent);
      }

      // Borrar botón de editar
      $(this).remove();
    });

    // Si se edita la fecha y hora y ya hay patentes completadas...
    $("#fecha, #hora").on("input", function () {
      // Si el vehículo asegurado está validado
      if ($("#patente-vehiculo-asegurado").is(".disabled.valid")) {
        $("#patente-vehiculo-asegurado")
          .parent()
          .find(".edit")
          .trigger("click");
      }

      // Si el vehículo propio está validado
      if ($("#patente-vehiculo-propio").is(".disabled.valid")) {
        $("#patente-vehiculo-propio").parent().find(".edit").trigger("click");
      }
    });

    // Reusar datos de personas
    // $(".reusar").click(function (event) {
    $("body").on("click", ".reusar", function (event) {
      // Evitar el default
      event.preventDefault();

      // Origen y destino
      var origen = $(this).data("origen");
      var destino = $(this).data("destino");

      // Lista de campos a considerar
      var campos = [
        "apellido",
        "nombre",
        "documento-tipo",
        "documento-numero",
        "genero",
      ];

      $.each(campos, function (i, v) {
        $("#" + destino + "-" + v + "").val(
          $("#" + origen + "-" + v + "").val()
        );
      });
    });

    // Habilitar un campo que depende de un si/no
    $(".toggleNext").change(function (e) {
      var val = $(this).val();

      $(this)
        .parents(".cols")
        .find("input")
        .each(function () {
          if (val == 1) {
            $(this)
              .prop("required", true)
              .prop("readonly", false)
              .removeClass("disabled")
              .focus();
          } else {
            $(this)
              .prop("required", false)
              .prop("readonly", true)
              .addClass("disabled")
              .val("");
            $(this).siblings("label.error").remove();
          }
        });
    });

    // Validar form

    // Si la fecha está completada y es hoy...
    $.validator.addMethod(
      "checkTime",
      function (value, element, param) {
        if ($("#fecha").val()) {
          var today = new Date();
          var fechaHoy = today.toISOString().substring(0, 10);
          var fecha = $("#fecha").val().split("-").reverse().join("-");

          // Si la fecha es hoy, la hora no puede ser más que la hora actual
          if (fecha == fechaHoy) {
            if ($("#hora").val()) {
              var time = today.getHours() + ":" + today.getMinutes();
              if ($("#hora").val() > time) {
                return false;
              }
            }
          }
          return true;
        }
      },
      "Ingresá una hora menor a la hora actual"
    );

    formContainer.validate({
      ignore: ":hidden",
      rules: {
        hora: { required: true, checkTime: true },
      },
      errorPlacement: function (error, element) {
        error.appendTo(element.parent());
      },
      submitHandler: function (form) {
        if (submittable) {
          //if (1 === 1) {
          form.submit();
        } else {
          // console.log("Error al enviar");
        }
      },
    });
  }

  // Evitar el envío del form por defecto
  /*
  formContainer.on("submit", function (e) {
    if ($(this).valid() && submittable) {
      return true;
    } else {
      console.log("Not valid");
      return false;
    }
  });
  */

  /**
   * Consultar reclamo
   */
  $("#consultar-estado .consultar").click(function (event) {
    // Evitar el default
    event.preventDefault();

    var button = $(this);
    var container = $(this).parents("fieldset");

    if (formContainer.valid()) {
      // Deshabilitar botón e inputs
      button
        .addClass("disabled")
        .append(' <i class="fas fa-circle-notch fa-spin"></i>');

      formContainer.find(":input").prop("disabled", true);

      // Enviar info
      $.post(themePath + "inc/ajax-terceros.php", {
        consulta: "estado",
        documento: $("#consulta-documento").val(),
        reclamo: $("#consulta-reclamo").val(),
      }).done(function (data) {
        if (data != "null") {
          // Marcar botón como "done"
          button.remove();

          // Borrar posibles errores
          container.find(".error").remove();

          // Mostrar detalles
          var $response = $("<dl />", { class: "inforeclamo" }).appendTo(
            container
          );

          // Sumar cada item de la respuesta a los detalles
          $.each(data, function (k, v) {
            $("<dt />", { text: k }).appendTo($response);
            $("<dd />", { text: v }).appendTo($response);
          });
        } else {
          // Rehabilitar campo
          container.find(":input").prop("disabled", false);
          button.removeClass("disabled").find("i").remove();

          // Borrar posibles errores
          container.find(".error").remove();

          // Mostrar error
          button
            .parent()
            .before(
              '<p class="note error"><span>No se ha encontrado ningún reclamo activo con el número ingresado. Por favor, intentalo de nuevo.</span></p>'
            );
        }
      });
    } else {
      formContainer.validate();
    }
  });

  /**
   * Labels flotantes en el formulario
   */

  // Si ya tienen algún valor al cargar
  formContainer.find("input, textarea").each(function () {
    if ($(this).val().length != 0) {
      $(this).parent().find("label").addClass("active");
    } else {
      $(this).parent().find("label").removeClass("active");
    }
  });

  // Al hacer foco, mover
  formContainer.find("input, textarea").focus(function () {
    $(this).parent().find("label").addClass("active");
  });

  // Al perder foco, si el campo no tiene valor, volver a acomodar
  formContainer.find("input, textarea").focusout(function () {
    if ($(this).val().length == 0) {
      $(this).parent().find("label").removeClass("active");
    }
  });

  // Cambiar clases en el cambio de un select
  formContainer.find("select").change(function () {
    if ($(this).val().length == 0) {
      $(this).parent().find("label").removeClass("active");
    } else {
      $(this).parent().find("label").addClass("active");
    }
  });
});
