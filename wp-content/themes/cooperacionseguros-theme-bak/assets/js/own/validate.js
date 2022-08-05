function maxLengthCheck(object) {
  if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength);
}

$(function () {
  // Setup Jquery Validator custom messages
  (function (factory) {
    if (typeof define === "function" && define.amd) {
      define(["jquery", "../jquery.validate"], factory);
    } else if (typeof module === "object" && module.exports) {
      module.exports = factory(require("jquery"));
    } else {
      factory(jQuery);
    }
  })(function ($) {
    $.extend($.validator.messages, {
      required: "Este campo es obligatorio.",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida.",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "Por favor, escribe un número válido.",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      extension: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: $.validator.format(
        "Por favor, no escribas más de {0} caracteres."
      ),
      minlength: $.validator.format(
        "Por favor, no escribas menos de {0} caracteres."
      ),
      rangelength: $.validator.format(
        "Por favor, escribe un valor entre {0} y {1} caracteres."
      ),
      range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: $.validator.format(
        "Por favor, escribe un valor menor o igual a {0}."
      ),
      min: $.validator.format(
        "Por favor, escribe un valor mayor o igual a {0}."
      ),
      nifES: "Por favor, escribe un NIF válido.",
      nieES: "Por favor, escribe un NIE válido.",
      cifES: "Por favor, escribe un CIF válido.",
      maxSize: "Los archivos no pueden exceder los {0}kb.",
      accept: "Por favor ingresá un archivo con los formatos aceptados.",
    });

    return $;
  });

  // Masks Datos personales
  $(".validar-dni").inputmask("9{6,9}", {
    placeholder: "________",
    clearIncomplete: true,
  });
  $(".validar-pasaporte").inputmask("9{6,9}", {
    placeholder: "XXXXXXXX",
    clearIncomplete: true,
  });
  $(".validar-cuit").inputmask("99-99999999-9", {
    placeholder: "__-________-__",
    clearIncomplete: true,
  });
  $(".validar-cuil").inputmask("99-99999999-9", {
    placeholder: "__-________-__",
    clearIncomplete: true,
  });

  // Masks Patentes
  $(".validar-patente").inputmask("(aa999aa)|(aaa-999)|(999-aaa)|(a999aaa)", {
    placeholder: "-------",
    casing: "upper",
    clearIncomplete: true,
  });
  $(".validar-patente-auto").inputmask("(aa999aa)|(aaa-999)", {
    placeholder: "-------",
    casing: "upper",
    clearIncomplete: true,
  });
  $(".validar-patente-moto").inputmask("(999-aaa)|(a999aaa)", {
    placeholder: "-------",
    casing: "upper",
    clearIncomplete: true,
  });

  // Masks otros
  $(".validar-fecha").inputmask("99-99-9999", {
    placeholder: "DD-MM-YYY",
  });
});
