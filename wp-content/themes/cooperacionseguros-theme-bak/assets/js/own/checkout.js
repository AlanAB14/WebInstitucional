var formReady = false;

$(function () {
  if ($(".page-checkout").length) {
    // Detectar el beforeunload, versión estándar
    window.onbeforeunload = function (event) {
      return formReady;
    };

    // Detectar el beforeunload, versión Chrome
    window.addEventListener("beforeunload", function (event) {
      if (!formReady) {
        event.preventDefault();
      }
    });
  }

  function submitHandler(form, event) {
    event.preventDefault();
    window.formReady = true;
    window.onbeforeunload = null;

    $("form")
      .find("button.btn")
      .prop("disabled", true)
      .append(' <i class="fas fa-circle-notch fa-spin"></i>');

    form.submit();
  }

  // Vehicle details
  $("#noUsoParticular, #siUsoParticular, #siEstaDanado, #noEstaDanado").on(
    "change",
    function () {
      if (
        !$("#noUsoParticular").is(":checked") &&
        !$("#siEstaDanado").is(":checked")
      ) {
        // Habilitar el botón del form
        $("form button").removeAttr("disabled");
      } else {
        // Deshabilitar el botón del form
        $("form button").attr({
          disabled: "disabled",
        });
      }

      // Revisar mensajes de error
      if ($("#siUsoParticular").is(":checked")) {
        $(".errorUsoParticular").addClass("d-none");
      }

      if ($("#noUsoParticular").is(":checked")) {
        $(".errorUsoParticular").removeClass("d-none");
      }

      if ($("#siEstaDanado").is(":checked")) {
        $(".errorEstaDanado").removeClass("d-none");
      }

      if ($("#noEstaDanado").is(":checked")) {
        $(".errorEstaDanado").addClass("d-none");
      }
    }
  );

  $("form#vehicle-details").validate({
    submitHandler,
  });

  // Vehicle photos
  $(".ajax-upload input").on("change", function (_event) {
    $(this).parent("form").trigger("submit");
  });

  var image_names = [];

  $(".ajax-upload").on("submit", function (event) {
    // Validar que el nombre de archivo no se haya usado previamente
    let new_image = $(this).find("input:file").val();
    /*
    if (image_names.includes(new_image)) {
      $(this)
        .find("input:file")
        .removeClass("is-valid")
        .removeClass("loading")
        .addClass("is-invalid");
      $("#repeated-images-error").removeClass("d-none");
      e.preventDefault();
      return false;
    } else {
    */
    event.preventDefault();
    $(this).addClass("loading");
    window.form = $(event.target);
    $.ajax({
      url: themePath + "utils/upload.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        data = JSON.parse(data);
        let field_id = "hidden_" + data.image_name;
        $("#" + field_id).remove();
        $("#hidden-fields").append(
          '<input id="' +
            field_id +
            '" type="hidden" name="' +
            data.image_name +
            '" value="' +
            data.path +
            '">'
        );

        image_names.push(new_image);

        let file_selector = "#" + data.image_name;
        $(file_selector).addClass("is-valid");
        $(file_selector).parent().removeClass("loading");
      },
      error: function (e) {
        $(window.form).find("input").addClass("is-invalid");
      },
    });
    /* } */
  });

  $("form#vehicle-photos button").on("click", function (event) {
    let productType = $("#product-type").val();

    if (productType == "seguro-de-autos-y-pick-ups") {
      if (
        $("#hidden_foto-frente").length &&
        $("#hidden_foto-derecha").length &&
        $("#hidden_foto-atras").length &&
        $("#hidden_foto-izquierda").length
      ) {
        submitHandler($("form#vehicle-photos"), event);
        return true;
      }
    } else if (productType == "seguro-de-motos") {
      if (
        $("#hidden_foto-frente-derecha").length &&
        $("#hidden_foto-izquierda-atras").length &&
        $("#hidden_foto-numero-motor").length &&
        $("#hidden_foto-numero-chasis").length
      ) {
        submitHandler($("form#vehicle-photos"), event);
        return true;
      }
    }

    $("#missing-images-error").removeClass("d-none");
    return false;
  });

  $("#imagen-adicional").on("click", function (e) {
    e.preventDefault();
    $("#images-adicionales").removeClass("d-none");
    $("#imagenes-adicionales-section").addClass("d-none");
  });

  // Vehicle details
  $("#customerLocalidadActual").select2({
    language: "es",
    placeholder: "Localidad donde vivís",
    allowClear: true,
    ajax: {
      url: placesFile,
      processResults: function (data) {
        var results = [];
        $.each(data, function (k, v) {
          results.push({
            id: v.idcity,
            text: v.city + ", " + v.state + " (" + v.zipcode + ")",
            city: v.city,
            idcity: v.idcity,
            state: v.state,
            idstate: v.idstate,
            quote: v.quote,
            emit: v.emit,
            zipcode: v.zipcode,
          });
        });

        return {
          results: results,
        };
      },
      data: function (params) {
        var query = {
          q: params.term,
          limit: "20",
        };
        return query;
      },
      cache: true,
    },
  });

  $("#customerLocalidadActual").on("select2:select", function (e) {
    var data = e.params.data;
    // Validar que el codigo postal pueda emitir
    if (data.emit != "1") {
      // Deshabilitamos formulario, mostrar mensaje de error y ocultar address-data
      $("#datos-solicitante button").attr({
        disabled: "disabled",
      });
      $("#address-data").addClass("d-none");
      $("#no-emit").removeClass("d-none");
    } else {
      // Completar provincia y localidad, ocultar mensaje de error y mostrar address-data
      $("#address-data").removeClass("d-none");
      $("#no-emit").addClass("d-none");
      $("#customerProvincia").val(data.state);
      $("#customerProvinciaId").val(data.idstate);
      $("#customerLocalidad").val(data.city);
      $("#customerLocalidadId").val(data.idcity);
      $("#customerLocalidadZip").val(data.zipcode);
      // console.log(data);
      $("#datos-solicitante button").removeAttr("disabled");
      $("#customerCalle").focus();
    }
  });

  $("#validarIdentidad").validate();
  $("#datos-solicitante").validate({
    rules: {
      customerPhonePrefix: {
        required: true,
        minlength: 2,
      },
      customerPhoneNumber: {
        required: true,
        minlength: 6,
      },
    },
    submitHandler,
  });

  var tipoPersona = $("input[name='persona']:checked").val();
  formPersona(tipoPersona);

  $("input[name='persona']").on("click", function () {
    tipoPersona = $(this).val();
    formPersona(tipoPersona);
  });

  function formPersona(tipoPersona) {
    if (tipoPersona === undefined || tipoPersona == "fisica") {
      console.log(tipoPersona);
      $(".formPersonaJuridica").hide();
      $(".formPersonaFisica").show();
    } else if (tipoPersona == "juridica") {
      $(".formPersonaJuridica").show();
      $(".formPersonaFisica").hide();
    }
  }

  function validarIdentidad() {
    $("#error-no-verificado").addClass("d-none");

    $(this)
      .find("button.btn")
      .prop("disabled", true)
      .append(' <i class="fas fa-circle-notch fa-spin"></i>');

    if (tipoPersona === undefined || tipoPersona == "fisica") {
      let num_dni = $("#numeroDni").val();
      let sexo;

      if ($("#sexoMasculino").prop("checked")) {
        sexo = "M";
      } else if ($("#sexoFemenino").prop("checked")) {
        sexo = "F";
      }

      $.ajax({
        url: `${themePath}api/api.php?get=customer&num_dni=${num_dni}&sexo=${sexo}`,
        context: document.body,
        success: function (data) {
          if (data.nroDocumento) {
            // Disableamos inputs
            $("#validarIdentidad input, #validarIdentidad button").attr({
              disabled: "disabled",
            });

            let fechaNacimiento = new Date(data.fechaNacimiento);

            // Cargamos data en el siguiente form
            $("#customerNombre").val(data.nombre);
            $("#customerApellido").val(data.apellido);
            $("#num_dni_hidden").val(data.nroDocumento);
            $("#sexo_hidden").val(sexo);
            $("#customerFechaNacimientoDia").val(fechaNacimiento.getDate());
            $("#customerFechaNacimientoMes").val(
              fechaNacimiento.getMonth() + 1
            );
            $("#customerFechaNacimientoAno").val(fechaNacimiento.getFullYear());
            $("#codcli").val(data.codcli);

            // Si existe nacionalidad
            if (data.idNacionalidad) {
              $("#customerNacionalidad").val(data.idNacionalidad);
            }

            // Si existe estado civil
            if (data.idEstadoCivil) {
              $("#customerEstadoCivil").val(data.idEstadoCivil);
            }

            // Ocupación, sólo si existe
            if (
              $("#customerOcupacion option[value='" + data.idActividad + "']")
                .length > 0
            ) {
              $("#customerOcupacion").val(data.idActividad);
            }

            // Teléfono, sólo si existe
            if (data.telefono) {
              $("#customerPhoneNumber").val(data.telefono);
            }

            // E-mail, sólo si no hay uno en la sesión
            if (!$("#customerEmail").val()) {
              $("#customerEmail").val(data.emailAOL);
            }

            // Buscamos el lugar de nacimiento a partir del ID
            if (data.lugarNacimiento) {
              $("#customerLugarNacimiento").val(data.lugarNacimiento);
            }

            $("#datos-solicitante .personaJuridica").each(function (i, e) {
              $(this).find("input").prop("disabled", true);
              $(this).hide();
            });

            // Mostramos el form
            $("#datos-solicitante").removeClass("d-none");

            // Enviamos lead intermedio por AJAX
            $.post(themePath + "inc/ajax-lead.php", {
              guid,
              dni: num_dni,
              genero: sexo,
              instancia,
            });

            // Ocultamos el coso inicial
            $("#validarIdentidad").slideUp();
          } else {
            // Si no se pudo verificar la identidad
            $("#error-no-verificado").removeClass("d-none");

            // Quitar la animación y rehabilitar el botón
            $("#validarIdentidad")
              .removeClass("validando")
              .find("button.btn")
              .prop("disabled", false)
              .html("Verificar identidad");
          }
        },
      }).done(function () {});
    } else {
      $("#datos-solicitante .personaFisica").each(function (i, e) {
        $(this).find("input").prop("disabled", true);
        $(this).hide();
      });

      $(this)
        .find("button.btn")
        .prop("disabled", true)
        .append(' <i class="fas fa-circle-notch fa-spin"></i>');

      // Mostramos el form
      $("#datos-solicitante").removeClass("d-none");

      // Sumamos el CUIT al form
      let num_cuit = $("#numeroCUIT").val();
      $("#num_cuit_hidden").val(num_cuit);

      $.post(themePath + "inc/ajax-lead.php", {
        guid,
        dni: num_cuit,
        genero: "",
        instancia,
      });

      $("#validarIdentidad").slideUp();
    }
  }

  $("#validarIdentidad").on("submit", function (event) {
    event.preventDefault();
    validarIdentidad();
  });

  // Advisors
  $("form#advisors").validate({
    submitHandler,
  });

  // Vehicle Summary
  $("form#vehicle-summary").validate({
    submitHandler,
  });

  // -- Activar y desactivar el modal de términos y condiciones
  $(".toggleTerminos").on("click", function (event) {
    $(this).toggleClass("active");
    $("#terminos").toggleClass("active");
    event.preventDefault();
  });

  // -- Deshabilitar y deschequear por defecto (si se vuelve o lo que sea)
  $("form#vehicle-summary button").attr({
    disabled: "disabled",
  });
  $("form#vehicle-summary #terminos-y-condiciones").prop("checked", false);

  // -- Habilitar solo si está chequeado
  $("form#vehicle-summary #terminos-y-condiciones").change(function () {
    if ($(this).is(":checked")) {
      $("form#vehicle-summary button").removeAttr("disabled");
    } else {
      $("form#vehicle-summary button").attr({
        disabled: "disabled",
      });
    }
  });
});
