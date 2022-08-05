// Cuando carga la página...
$(function () {
  // Que aparezca el botón
  setTimeout(function () {
    $("#llamenButton").addClass("active");
  }, 1000);

  // Que aparezca el botón de Whatsapp
  setTimeout(function () {
    $("#whatsappButton").addClass("active");
  }, 1500);

  // Activar y desactivar el modal
  $(".toggleLlamen").on("click", function (event) {
    $(".toggleLlamen").toggleClass("active");
    $("#quiero-que-me-llamen").toggleClass("active");
    event.preventDefault();
  });

  // Validar y enviar el formulario
  $("#llamenme").validate({
    rules: {
      llamenNombre: {
        required: true,
        minlength: 5,
        minWords: 2,
      },
      llamenTelefono: {
        required: true,
        number: true,
        minlength: 6,
      },
    },
    messages: {
      llamenNombre: {
        required: "Ingresá tu nombre y apellido",
        minlength: jQuery.validator.format("Ingresa al menos {0} letras"),
        minWords: "Ingresá también tu apellido",
      },
      llamenTelefono: {
        required: "Ingresá tu teléfono",
        number: "Ingresá sólo números",
        minlength: jQuery.validator.format("Ingresa al menos {0} números"),
      },
    },
    submitHandler: function (form, event) {
      // No enviar al validar
      event.preventDefault();

      var form = $("#llamenme");
      var url = themePath + "utils/mail.php";
      var formdata = form.serialize();

      form.find(".submit button").addClass("loading").prop("disabled", true);
      form.find("input, textarea, button").prop("disabled", true);

      $.post(url, formdata, function (data) {
        if (data != "true") {
          form
            .find(".submit button")
            .removeClass("loading")
            .prop("disabled", false);
          form.find("input, textarea, button").prop("disabled", false);
          form.find(".mensaje").remove();
          form.append("<span class='mensaje'>" + data + "</span>");
        } else {
          form
            .empty()
            .append(
              "<h4 class='success'><strong>¡Recibimos tu teléfono!</strong> Pronto nos vamos a comunicar con vos para responder todas tus dudas</h4>"
            );

          // Evento
          gtag("event", "consulta", {
            event_category: "boton",
            event_label: "enviar",
            value: "",
          });

          $("html, body").animate(
            {
              scrollTop: form.parent().offset().top - 64,
            },
            500,
            "linear"
          );
        }
      });
    },
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
  });
});
