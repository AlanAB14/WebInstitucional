// ********************** //
// Selección de productos
// ********************** //

// Constantes genéricas para la selección y muestra de productos
const jsonFile = themePath + "data/products.json";
const placesFile = themePath + "api/api.php?get=places&allowed=1";
const placesFileAll = themePath + "api/api.php?get=places";
const brandsFile = themePath + "api/api.php?get=vehicle_brands";
const modelsFile = themePath + "api/api.php?get=vehicle_models";
const yearsFile = themePath + "api/api.php?get=vehicle_years";
const versionsFile = themePath + "api/api.php?get=vehicle_versions";
const versionsMotorbikesFile =
  themePath + "api/api.php?get=vehicle_versions_catbrandyear";
const gncFile = themePath + "api/api.php?get=vehicle_accesories&query=g.n.c";
const agroTypeFile = themePath + "api/api.php?get=agro_types";
const agroBrandFile = themePath + "api/api.php?get=agro_brands";
const agroYearsFile = yearsFile;
const apiQuote = "api/api.php?get=quote";
let currentGuid;

$(function () {
  // Variables particulares a la selección de productos
  let productContainer = $("#seleccion-de-productos");
  let productContainerTitle = productContainer.parent().find("h1.description");
  let loadingItem = '<i class="fas fa-circle-notch fa-spin loadingItem"></i>';
  let delaytime = 200;
  let cachedProducts;
  let cachedQuestions;
  let currentQuestion = 0;
  let totalQuestions = 0;
  let userData = {
    currentProduct: null,
  };

  // Templates para botones
  $.templates({
    // Botones
    templateBotonesProductos:
      '<button class="item productbutton {{:slug}}" data-key="{{:key}}" data-slug="{{:slug}}"><img src="' +
      themePath +
      'assets/img/iconos/productos/{{:slug}}.png" alt="" /><h1>{{:title}}</h1><h2>{{:subtitle}}</h2></button>',
    templateBotonesSubproductos:
      '<button class="item productbutton subproduct {{:slug}}" data-key="{{:key}}" data-slug="{{:slug}}"><h3>{{:parentTitle}}</h3><h1>{{:title}}</h1></button>',
    // Preguntas
    templatePreguntas:
      '<p class="item question {{:question}}" data-question="{{:questionNumber}}">\
      {{if question === "nombre"}} {{include tmpl="templatePreguntasNombre"/}}\
      {{else question === "email"}} {{include tmpl="templatePreguntasEmail"/}}\
      {{else question === "ubicacion"}} {{include tmpl="templatePreguntasUbicacion"/}}\
      {{else question === "marca"}} {{include tmpl="templatePreguntasMarca"/}}\
      {{else question === "modelo"}} {{include tmpl="templatePreguntasModelo"/}}\
      {{else question === "ano"}} {{include tmpl="templatePreguntasAno"/}}\
      {{else question === "version"}} {{include tmpl="templatePreguntasVersion"/}}\
      {{else question === "gnc"}} {{include tmpl="templatePreguntasGnc"/}}\
      {{else question === "edad"}} {{include tmpl="templatePreguntasEdad"/}}\
      {{else question === "suma"}} {{include tmpl="templatePreguntasSuma"/}}\
      {{else question === "agroTipo"}} {{include tmpl="templatePreguntasAgroTipo"/}}\
      {{else question === "agroMarca"}} {{include tmpl="templatePreguntasAgroMarca"/}}\
      {{else question === "agroModelo"}} {{include tmpl="templatePreguntasAgroModelo"/}}\
      {{else question === "agroAno"}} {{include tmpl="templatePreguntasAgroAno"/}}\
      {{else question === "separadorPersona"}} {{include tmpl="templateSeparadorPersona"/}}\
      {{else question === "separadorVehiculo"}} {{include tmpl="templateSeparadorVehiculo"/}}\
      {{/if}}\
      <button class="nextquestion"><i class="fas fa-arrow-right"></i></button>\
      </p>',
    templatePreguntasNombre:
      '<span class="q">Mi nombre es</span> <input type="text" name="userName" /> ',
    templatePreguntasEmail:
      '<span class="q">Mi e-mail es</span> <input type="email" name="userEmail" /> ',
    templatePreguntasUbicacion:
      '<span class="q"></span> <select class="selectField" name="userZip" id="userZip" data-placeholder="Ingresá una localidad" disabled><option value=""> </option></select> ',
    templatePreguntasMarca:
      '<span class="q">La marca del vehículo es</span> <select class="selectField" name="vehicleBrand" id="vehicleBrand" data-placeholder="Seleccioná una marca" disabled><option value=""> </option></select> ',
    templatePreguntasModelo:
      '<span class="q">El modelo es</span> <select class="selectField" name="vehicleModel" id="vehicleModel" data-placeholder="Seleccioná un modelo" disabled><option value=""> </option></select> ',
    templatePreguntasAno:
      '<span class="q">El vehículo es del año</span> <select  class="selectField" name="vehicleYear" id="vehicleYear" data-placeholder="Seleccioná un año" disabled><option value=""> </option></select> ',
    templatePreguntasVersion:
      '<span class="q">La version es</span> <select class="selectField" name="vehicleVersion" id="vehicleVersion" data-placeholder="Seleccioná una versión" disabled><option value=""> </option></select> ',
    templatePreguntasGnc:
      '<span class="q">Versión de GNC</span> <select class="selectField" name="vehicleGnc" id="vehicleGnc" data-placeholder="¿El vehículo tiene GNC?" disabled><option value=""> </option></select> ',
    templatePreguntasEdad:
      '<span class="q">Nací el</span> <select class="selectField" name="userBirthDay" id="userBirthDay" data-placeholder="día"><option value=""></option></select> <span class="q">de</span> <select class="selectField" name="userBirthMonth" id="userBirthMonth" data-placeholder="mes"><option value=""></option></select> <span class="q">de</span> <select class="selectField" name="userBirthYear" id="userBirthYear" data-placeholder="año" ><option value=""></option></select> ',
    templatePreguntasSuma:
      '<span class="q">Quiero una suma asegurada de </span> <select class="selectField" name="sumaAsegurada" id="sumaAsegurada" data-placeholder="Seleccioná una suma a asegurar"><option value="100000">$100.000</option><option value="250000">$250.000</option><option value="500000">$500.000</option><option value="1000000">$1.000.000</option><option value="2000000">$2.000.000</option></select> ',
    templatePreguntasAgroTipo:
      '<span class="q">Tipo de unidad</span> <select class="selectField" name="agroType" id="agroType" data-placeholder="Seleccioná un tipo" disabled><option value=""> </option></select> ',
    templatePreguntasAgroMarca:
      '<span class="q">La marca es</span> <select class="selectField" name="agroBrand" id="agroBrand" data-placeholder="Seleccioná una marca" disabled><option value=""> </option></select> ',
    templatePreguntasAgroModelo:
      '<span class="q">El modelo es</span> <input type="type" name="agroModel" id="agroModel" placeholder="Detallá el modelo de la maquinaria" /> ',
    templatePreguntasAgroAno:
      '<span class="q">La unidad es del año</span> <select  class="selectField" name="agroYear" id="agroYear" data-placeholder="Seleccioná un año" disabled><option value=""> </option></select> ',
    templateSeparadorPersona:
      '<span class="q separador" tabindex="1">Ahora necesitamos algunos datos personales</span>',
    templateSeparadorVehiculo:
      '<span class="q separador" tabindex="1">Comentanos un poco sobre tu vehículo</span>',
  });

  // Función para mostrar y seleccionar productos
  function productLauncher() {
    // Lista de productos
    var products = cachedProducts.products;

    // Paso 1:
    // Mostrar los productos

    // Quitar cargando y agregar botones
    productContainer
      .removeClass("loading")
      .removeClass("questions")
      .addClass("buttons");

    // Agregar todos los productos
    $.each(products, function (i, el) {
      $boton = $([]);
      var html = $.templates.templateBotonesProductos.render({
        title: el.title,
        subtitle: el.subtitle,
        slug: el.slug,
        key: i,
      });

      $boton.add(html).appendTo(productContainer);
    });

    // Mostrar todos los productos
    productContainer.find(".item").each(function (i, e) {
      setTimeout(function () {
        $(e).addClass("show");
      }, i * delaytime);
    });

    // Agregar buscador
    if ($("#productFilterContainer").length == 0) {
      productContainer.before(
        '<p class="form" id="productFilterContainer"><input type="text" id="productFilter" placeholder="Búsqueda rápida: ¿Qué seguro estás buscando?" /><i class="fas fa-search clearfilter"></i></p>'
      );
    }
  }

  // Función para buscar item
  function getCurrentProduct(obj, key, val) {
    var product;
    $.each(obj.products, function (i, el) {
      if (el[key] == val) {
        product = el;
      } else if (el.hasOwnProperty("products")) {
        subproduct = getCurrentProduct(el, key, val);
        if (subproduct) product = subproduct;
      }
    });

    // Sumar el slug del producto a userData
    userData.currentProduct = val;

    // Devolver producto
    return product;
  }

  // Paso 2:
  // Al hacer click en un producto...
  $(document).on("click", "form .productbutton", function () {
    // Alto de la ventana para mejorar el 100vh en mobile
    var windowHeight = window.innerHeight;

    // Create a new div and assign the width/height/top/left properties of the input
    var filler = $("<div class='filler'/>").css({
      "min-height": $("#productos").innerHeight(),
    });
    // Agregar el elemento del efecto y fondo
    $("#productos").addClass("preOverlay").before(filler);

    window.setTimeout(function () {
      $("#productos").addClass("overlay").css({ "min-height": windowHeight });
    }, 100);

    // Si no existe el botón de cerrar
    if ($(".closeproducts").length === 0) {
      $("#productos").append('<div class="closeproducts" />');
    }

    // Quitar la clase del filtro y mostrar cargando
    productContainer.removeClass("filter").addClass("loading");

    // Desactivar botones y suavizar vecinos
    $(".productbutton").prop("disabled", true);
    $(this).siblings().addClass("disabled");

    // Definir key y slug para sumar a los botones
    var key = $(this).data("key").toString();
    var currentSlug = $(this).data("slug");

    // Buscar producto actual
    var currentProduct = getCurrentProduct(cachedProducts, "slug", currentSlug);

    // Agregar texto al título, sólo si es un parent
    productContainerTitle.html(
      "Seguros de <strong>" + currentProduct.title + "</strong>"
    );

    // Chequear si el producto seleccionado tiene subproductos
    if (
      currentProduct.hasOwnProperty("products") &&
      currentProduct["products"].length != 0
    ) {
      // Vaciar contenedor, quitar "cargando" y confirmar que seguimos viendo botones
      productContainer.find(".item").remove();
      productContainer
        .removeClass("loading")
        .removeClass("questions")
        .addClass("buttons");

      // Redefinir productos
      products = currentProduct["products"];

      // Agregar todos los productos
      $.each(products, function (i, el) {
        $boton = $([]);
        var html = $.templates.templateBotonesSubproductos.render({
          title: el.title,
          slug: el.slug,
          parentTitle: cachedProducts.products[key]["title"],
          key: i,
        });
        $boton.add(html).appendTo(productContainer);
      });

      // Mostrar todos los productos
      window.setTimeout(function () {
        productContainer.find(".item").each(function (i, e) {
          setTimeout(function () {
            $(e).addClass("show");
          }, i * delaytime);
        });
      }, 600);

      // Si no tiene subproductos, chequear si tiene preguntas
    } else {
      if (
        currentProduct.hasOwnProperty("questions") &&
        currentProduct["questions"].length != 0
      ) {
        // Vaciar contenedor, quitar "cargando" y cambiar la clase a las preguntas
        productContainer.find(".item").remove();
        productContainer
          .removeClass("loading")
          .removeClass("buttons")
          .addClass("questions");

        // Cambiar intro de preguntas
        productContainerTitle.html(
          "Contestá unas preguntas y te encontraremos un <strong>" +
            currentProduct.pagetitle +
            "</strong> a medida."
        );

        // Definir preguntas
        var questions = (cachedQuestions = currentProduct.questions);
        totalQuestions = questions.length;

        // Mostrar Pregunta actual
        showcurrentQuestion(currentQuestion, totalQuestions);

        // Si no tiene subproductos ni preguntas, despachar
      } else {
        //Despachamos
        dispatch(null);
      }
    }
  });

  // Función para mostrar pregunta actual
  function showcurrentQuestion(i, totalQuestions) {
    // Si no existe el contador
    if ($("#counter").length === 0) {
      $("#productos").append('<div id="counter" />');
    }

    // Mostrar el paso actual en el counter
    $("#counter").html(
      '<p class="texto">' +
        (i + 1) +
        " <em>de</em> " +
        totalQuestions +
        '</p><p class="puntos"></pl>'
    );

    // Sumamos puntitos
    for (n = 1; n <= totalQuestions; n++) {
      if (n == i + 1) {
        $("#counter .puntos").append('<span class="dot active" />');
      } else {
        $("#counter .puntos").append('<span class="dot" />');
      }
    }

    // Si hay preguntas cargadas, agregar clase para ocultarlas
    productContainer.find(".item:not(.done)").each(function (i, e) {
      $(e).addClass("done").append('<span class="cancel"></span>');
    });

    var questions = cachedQuestions;

    // Agregar próxima pregunta
    $question = $([]);
    var html = $.templates.templatePreguntas.render({
      question: questions[i],
      questionNumber: i,
    });
    $question.add(html).prependTo(productContainer);

    // Mostrar la pregunta con delay
    productContainer.find(".item:not(.done)").each(function (i, e) {
      setTimeout(function () {
        $(e).addClass("show");
        $(e).find("input, select, .separador").focus();
      }, delaytime);
    });

    // En algunas preguntas, leemos cookies a ver si podemos autocompletar datos
    if (questions[i] == "nombre" || questions[i] == "email") {
      // Qué campo está activo?
      var activeField = $(".question:not(.done)").find("input");
      var fieldName = activeField.attr("name");
      if (
        Cookies.getJSON("userData") !== undefined &&
        Cookies.getJSON("userData")[fieldName]
      ) {
        activeField.val(Cookies.getJSON("userData")[fieldName]);
      }
    }

    // Si la pregunta es de vehículos usar el autocompletar con combo
    if (
      questions[i] == "ubicacion" ||
      questions[i] == "marca" ||
      questions[i] == "modelo" ||
      questions[i] == "version" ||
      questions[i] == "ano" ||
      questions[i] == "gnc" ||
      questions[i] == "agroTipo" ||
      questions[i] == "agroMarca" ||
      questions[i] == "agroAno"
    ) {
      // Por defecto el campo está deshabilitado
      $(".question:not(.done)").find(".nextquestion").prop("disabled", true);

      // Qué categoría estamos contestando? 1 para coches, 2 para motos
      var category =
        userData.currentProduct == "seguro-de-autos-y-pick-ups" ? 1 : 2;

      // El campo es una variable porque puede ser cualquiera de las opciones del combo
      var comboField = $(".question:not(.done)").find(".selectField");

      // Agregamos la ruedita para mejorar el tiempo que tarda en cargar select2
      comboField.parent().append(loadingItem);

      // Según cuál sea la pregunta cambian las variables del autocompletado
      if (questions[i] == "ubicacion") {
        // console.log(userData.currentProduct);
        var dataFile =
          userData.currentProduct == "seguro-de-autos-y-pick-ups" ||
          userData.currentProduct == "seguro-de-motos"
            ? placesFileAll + "&limit=20"
            : placesFile + "&limit=20";
      } else if (questions[i] == "marca") {
        var dataFile = brandsFile + "&category=" + category;
        //var dataField = "marca";
        //var hiddenFields = { vehicleBrandId: "idMarca" };
      } else if (questions[i] == "modelo") {
        var dataFile =
          modelsFile +
          "&brand=" +
          userData.vehicleBrandId +
          "&category=" +
          category;
        var dataField = "modelo";
        var hiddenFields = {
          vehicleModelId: "idModelo",
        };
      } else if (questions[i] == "version") {
        if (category == 2) {
          var dataFile =
            versionsMotorbikesFile +
            "&category=2&brand=" +
            userData.vehicleBrandId +
            "&year=" +
            userData.vehicleYear;
        } else {
          var dataFile =
            versionsFile +
            "&model=" +
            userData.vehicleModelId +
            "&year=" +
            userData.vehicleYear;
        }
        var dataField = "modelo";
        var hiddenFields = {
          codInfoAuto: "codia",
          codval: "codval",
          vehicleValue: "valor",
        };
      } else if (questions[i] == "ano") {
        var dataFile = yearsFile + "&model=" + userData.vehicleModelId;
        var dataField = "";
      } else if (questions[i] == "gnc") {
        var dataFile = gncFile;
        var dataField = "detalle";
        var hiddenFields = { vehicleGncId: "codigo", vehicleGncValue: "valor" };
      } else if (questions[i] == "agroTipo") {
        var dataFile = agroTypeFile;
        var dataField = "";
      } else if (questions[i] == "agroMarca") {
        var dataFile = agroBrandFile + "&type=" + userData.agroType;
        var dataField = "";
      } else if (questions[i] == "agroAno") {
        var dataFile = agroYearsFile + "&model=agro";
        var dataField = "";
      }

      // Obtener resultados de archivos
      $.getJSON(dataFile, function (data) {
        // Si es GNC, le sumamos la opción de "Sin GNC"
        if (questions[i] == "gnc") {
          data.unshift({ codigo: "0", detalle: "Sin G.N.C.", valor: "0" });
        }
        // Popular el select
        $.each(data, function (k, v) {
          // Si buscamos un campo específico de un array... sino, el v
          var value = dataField ? v[dataField] : v;

          // Sumamos options al select
          $(comboField).append(
            "<option value='" +
              value +
              "' data-key='" +
              k +
              "'>" +
              value +
              "</option>"
          );
        });

        // Sumamos el select2
        if (questions[i] == "ubicacion") {
          // El texto cambia para autos y motos pero el template es el mismo, así que...
          if (
            userData.currentProduct == "seguro-de-autos-y-pick-ups" ||
            userData.currentProduct == "seguro-de-motos"
          ) {
            $(comboField).prev(".q").text("¿Dónde circula el vehículo?");
          } else {
            $(comboField).prev(".q").text("Mi localidad es");
          }

          $(comboField).select2({
            language: "es",
            placeholder: "Seleccioná",
            allowClear: true,
            ajax: {
              delay: 250,
              url: dataFile,
              processResults: function (data) {
                var results = [];
                $.each(data, function (k, v) {
                  results.push({
                    id: v.zipcode,
                    text: v.city + ", " + v.state + " (" + v.zipcode + ")",
                    extraFields: {
                      userCity: v.city,
                      userState: v.state,
                      userIdCity: v.idcity,
                    },
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
              success: function (data) {
                $("#dropdown").select2({
                  data: data,
                });
              },
              cache: true,
            },
          });

          // Si tenemos la ubicación en una cookie...
          if (
            Cookies.getJSON("userData") !== undefined &&
            Cookies.getJSON("userData")["userCity"]
          ) {
            $(comboField).select2("open");

            // Get the search box within the dropdown or the selection
            // Dropdown = single, Selection = multiple
            var $search =
              $(comboField).data("select2").dropdown.$search ||
              $(comboField).data("select2").selection.$search;
            // This is undocumented and may change in the future

            $search.val(Cookies.getJSON("userData")["userCity"]);
            setTimeout(function () {
              $search.trigger("input");
            }, 500);
          }
        } else if (questions[i] == "marca") {
          $(comboField).select2({
            language: "es",
            placeholder: "Seleccioná",
            allowClear: true,
            ajax: {
              delay: 250,
              url: dataFile,
              processResults: function (data) {
                var results = [];
                $.each(data, function (k, v) {
                  results.push({
                    id: v.marca,
                    text: v.marca,
                    extraFields: {
                      vehicleBrandId: v.idMarca,
                      vehicleBrandName: v.marca,
                    },
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
        } else {
          $(comboField).select2({
            language: "es",
            placeholder: "Seleccioná",
            allowClear: true,
          });
        }

        // Borrar la ruedita
        $(comboField).parent().find(".loadingItem").remove();

        // Habilitar el campo
        function showComboField() {
          $(comboField).prop("disabled", false).select2("open");
        }

        // Hacer un delay antes de abrir, para no romper la posición con las animaciones
        setTimeout(showComboField, 500);

        // Si se selecciona una opción...
        $(comboField).on("select2:select", function (e) {
          // Si el elemento viene con sus propios "campos extra..."
          if (e.params.data.hasOwnProperty("extraFields")) {
            $.each(e.params.data.extraFields, function (k, v) {
              // Boorramos los campos que ya existan
              $(productContainer)
                .find("#" + k + "")
                .remove();

              // Agregamos los campos con los valores que necesitamos
              $(productContainer).append(
                "<input id='" +
                  k +
                  "' name='" +
                  k +
                  "' type='hidden' value='" +
                  v +
                  "' />"
              );
            });
            // Si no viene con sus campos extra, tendrá hiddenFields declarados
          } else {
            // La key es la del resultado original
            var key = $(e.params.data.element).data("key");

            // Agregamos los valores necesarios a los campos ocultos, buscando en el resultado original
            $.each(hiddenFields, function (k, v) {
              // Boorramos los campos que ya existan
              $(productContainer)
                .find("#" + k + "")
                .remove();

              // Agregamos los campos con los valores que necesitamos
              $(productContainer).append(
                "<input id='" +
                  k +
                  "' name='" +
                  k +
                  "' type='hidden' value='" +
                  data[key][v] +
                  "' />"
              );
            });
          }

          // Cerramos el select2 a la fuerza
          $(comboField).select2("close").prop("disabled", true);

          // Habilitamos el botón de continuar
          $(".question:not(.done)")
            .find(".nextquestion")
            .prop("disabled", false)
            //.focus();
            .trigger("click");
        });

        // Si se deselecciona una opción...
        $(comboField).on("select2:clear", function (e) {
          // Habilitamos el botón de continuar
          $(".question:not(.done)")
            .find(".nextquestion")
            .prop("disabled", true);
        });
      });
    }

    // Si la pregunta es de edad
    if (questions[i] == "edad") {
      // Sumamos options al select de días
      for (n = 1; n <= 31; n++) {
        $("#userBirthDay").append(
          "<option value='" + n + "' >" + n + "</option>"
        );
      }

      // Sumamos options al select de meses
      var meses = [
        "enero",
        "febrero",
        "marzo",
        "abril",
        "mayo",
        "junio",
        "julio",
        "agosto",
        "septiembre",
        "octubre",
        "noviembre",
        "diciembre",
      ];
      for (n = 1; n <= 12; n++) {
        $("#userBirthMonth").append(
          "<option value='" + n + "' >" + meses[n - 1] + "</option>"
        );
      }

      // Sumamos options al select de años
      var year = new Date().getFullYear();
      var minYear = year - 65;
      var maxYear = year - 18;

      for (n = minYear; n <= maxYear; n++) {
        $("#userBirthYear").append(
          "<option value='" + n + "' >" + n + "</option>"
        );
      }

      $("#userBirthDay, #userBirthMonth, #userBirthYear").select2({
        language: "es",
        allowClear: true,
      });

      // Si tenemos el cumpleaños en una cookie...
      if (
        Cookies.getJSON("userData") !== undefined &&
        Cookies.getJSON("userData")["userBirthDay"]
      ) {
        $("#userBirthDay")
          .val(Cookies.getJSON("userData")["userBirthDay"])
          .trigger("change");
      }
      if (
        Cookies.getJSON("userData") !== undefined &&
        Cookies.getJSON("userData")["userBirthMonth"]
      ) {
        $("#userBirthMonth")
          .val(Cookies.getJSON("userData")["userBirthMonth"])
          .trigger("change");
      }
      if (
        Cookies.getJSON("userData") !== undefined &&
        Cookies.getJSON("userData")["userBirthYear"]
      ) {
        $("#userBirthYear")
          .val(Cookies.getJSON("userData")["userBirthYear"])
          .trigger("change");
      }
    }

    // Si la pregunta es de una suma a asegurar
    if (questions[i] == "suma") {
      $("#sumaAsegurada").select2({
        language: "es",
      });
    }
  }

  // Probar enviar al clickear Enter
  productContainer.keypress(function (e) {
    // console.log('enter');
    if (e.which == 13) {
      e.preventDefault();
      $(".question:not(.done)")
        .find(".nextquestion:not(:disabled)")
        .trigger("click");
    }
  });

  // Enviar al clickear en un separador
  $(document).on("click", ".separador", function (event) {
    $(this).next("button.nextquestion:not(:disabled)").trigger("click");
  });

  // Al completar una pregunta, mostrar la siguiente o confirmar que no hay más preguntas
  $(document).on("click", ".nextquestion", function (event) {
    // Evitar el default
    event.preventDefault();

    // Validar formulario entero (siempre completo por si hubo un cambio)
    var isvalid = productContainer.valid();

    // Si es válido...
    if (isvalid) {
      // Actualizar datos para todas las preguntas, ya que se pueden haber cambiado
      productContainer.find("input, select").each(function (i, e) {
        var answer = $(this).val();
        var label = $(this).attr("name");

        // Lo deshabilitamos para que no se pueda modificar
        $(this).prop("disabled", true).trigger("change");

        // Guardar datos
        if (userData.label != answer) {
          userData[label] = answer;
        }
      });

      // Deshabilitamos este boton para que no se active al hacer "enter" en otras preguntas
      $(this).prop("disabled", true);

      currentQuestion = currentQuestion + 1;
      if (currentQuestion < totalQuestions) {
        showcurrentQuestion(currentQuestion, totalQuestions);
      } else {
        // Despachamos
        dispatch(userData);
      }
    }
  });

  // Al cancelar una pregunta...
  $(document).on("click", ".cancel", function (event) {
    // Confirmar cuál es la pregunta
    currentQuestion = $(this).parent().data("question");

    // Eliminar todas las preguntas posteriores
    $(this).parent().prevAll().remove();
    $(this).parent().remove();

    // Mostrar preguntas a partir de la eliminada
    // console.log(currentQuestion);
    showcurrentQuestion(currentQuestion, totalQuestions);
  });

  // Si hay que cerrar productos y relanzar el launcher...
  $(document).on("click", ".closeproducts", function () {
    // Borrar este botón
    $(this).remove();

    // Borrar cualquier filler
    $(".filler").remove();

    // Borrar bloque de cotizar
    $(".block-cotizar").remove();

    // Borrar contador
    $("#counter").remove();

    // Desactivar versión "overlay" y borrar todas las clases
    $("#productos").attr("class", "");

    // Borrar todos los ítems
    productContainer.find(".item").remove();

    // Reiniciar el título, sólo si es un parent
    productContainerTitle.html("Descubrí nuestras coberturas");

    // La pregunta y el total de preguntas tienen que ser nuevamente 0
    currentQuestion = 0;
    totalQuestions = 0;

    // Relanzar el launcher
    productLauncher();
  });

  // Dispatcher
  function dispatch() {
    // Mostrar cargando
    productContainer.addClass("loading");

    // Si tenemos más data que sólo el producto...
    if (Object.keys(userData).length > 1) {
      // Borrar cookie anterior?
      Cookies.remove("userData");

      // Guardar cookie
      Cookies.set("userData", userData, { expires: 30 });
    }

    // Enviar datos al api para generar el quote y/o saber a donde redigir
    let form = new FormData();
    for (let item in userData) {
      form.append(item, userData[item]);
    }

    $.post({
      url: apiQuote,
      data: form,
      processData: false,
      contentType: false,
    })
      .done(function (response) {
        if (response.url) {
          $.redirect(response.url);
        } else {
          // Si no hay página posible?
        }
      })
      .fail((error) => {
        console.log("Ocurrió un error con la petición.", error);
      });
  }

  /**
   * Filtrador / Buscador
   */

  $(document).on("keyup", "#productFilter", function () {
    // Resultados en 0
    var results = 0;

    // Definir valor de búsqueda, normalizado
    var value = $("#productFilter")
      .val()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "");

    if (value.length > 2) {
      // Si hay algo escrito, vaciar el contenedor...
      productContainer.addClass("filter").empty();

      // Marcar el buscador como activo
      $("#productFilterContainer").addClass("active");

      // Definir expresión de búsqueda
      var expression = new RegExp(value, "i");

      // Iterar en la versión cacheada de los productos
      $.each(cachedProducts.products, function (key, value) {
        $.each(value.products, function (k, v) {
          if (v.keywords) {
            var normalizedTitle = v.title
              .normalize("NFD")
              .replace(/[\u0300-\u036f]/g, "");
            var normalizedKeywords = v.keywords
              .normalize("NFD")
              .replace(/[\u0300-\u036f]/g, "");
            if (
              normalizedTitle.search(expression) != -1 ||
              normalizedKeywords.search(expression) != -1
            ) {
              $boton = $([]);
              var html = $.templates.templateBotonesSubproductos.render({
                title: v.title,
                slug: v.slug,
                parentTitle: cachedProducts.products[key]["title"],
                key: k,
              });
              $boton.add(html).appendTo(productContainer);

              // Sumar un resultado
              results++;
            }
          }
        });
      });

      if (!results) {
        productContainer.append(
          '<p class="empty">No encontramos productos que coincidan con tu búsqueda.</p>'
        );
      }
    } else if (!value) {
      // Si queda vacío, vaciar y relanzar el launcher
      productContainer.removeClass("filter").empty();
      productLauncher();

      // Marcar el buscador como inactivo
      $("#productFilterContainer").removeClass("active");
    }
  });

  // Vaciar el buscador con botón
  $(document).on("click", ".clearfilter", function () {
    // Limpiar valor del input
    $("#productFilter").val("");

    // Vaciar y relanzar el launcher
    productContainer.removeClass("filter").empty();
    productLauncher();

    // Marcar el buscador como inactivo
    $("#productFilterContainer").removeClass("active");
  });

  /**
   * Lanzamos el preguntador
   */

  // Si existe el bloque de productos, lanzar automáticamente
  if (productContainer.length) {
    // Obtener el archivo de productos
    $.getJSON(jsonFile, function (data) {
      // Asignamos el resultado a la variable de productos
      cachedProducts = data;

      // Ejecutar la función para mostrar y seleccionar productos
      productLauncher();

      // Iniciamos el validate
      validateForm();
    });
  }

  // Lanzar el productLauncher desde afuera
  $(document).on("click", ".productLauncher", function (event) {
    // Evitar el default
    event.preventDefault();

    // Que producto estamos referenciando?
    currentSlug = $(this).data("slug");

    // Tiene un Guid ya asignado?
    if ($(this).data("guid")) {
      currentGuid = $(this).data("guid");
    }

    // Sumamos el contenedor del preguntador
    $(this)
      .parents(".block")
      .empty()
      .before(
        '<div id="productos" class="overlay"><div class="wrap"><form id="seleccion-de-productos"></form></div><div class="closeproducts" /></div>'
      );

    // Redefinimos el contenedor
    productContainer = $("#seleccion-de-productos");

    // Agregamos el contenedor del productLauncher
    $.getJSON(jsonFile, function (data) {
      // Asignamos el resultado a la variable de productos
      cachedProducts = data;

      // Datos del producto referenciado

      var currentProduct = getCurrentProduct(
        cachedProducts,
        "slug",
        currentSlug
      );

      // Definir preguntas
      var questions = (cachedQuestions = currentProduct.questions);
      totalQuestions = questions.length;

      // Mostrar pregunta actual
      showcurrentQuestion(currentQuestion, totalQuestions);

      // Iniciamos el validate
      validateForm();
    });
  });

  // Hacer trigger de un botón que está en la página
  $(document).on("click", ".triggerButton", function (event) {
    // Evitar el default
    event.preventDefault();

    // Que botón estamos referenciando?
    buttonClass = $(this).data("button");

    // Simular click
    $("button." + buttonClass).trigger("click");
  });

  /**
   * Validator para todos los casos posibles del formulario
   */

  function validateForm() {
    productContainer.validate({
      rules: {
        userName: {
          required: true,
          minlength: 5,
          minWords: 2,
        },
        userZip: {
          required: true,
          // minlength: 5
        },
        vehicleBrand: {
          required: true,
        },
        vehicleModel: {
          required: true,
        },
        vehicleYear: {
          required: true,
        },
        userEmail: {
          required: true,
          email: true,
          validate_email: true,
          minlength: 4,
        },
        userBirthDay: {
          required: true,
          number: true,
        },
        userBirthMonth: {
          required: true,
        },
        userBirthYear: {
          required: true,
          number: true,
        },
        userBirthYear: {
          required: true,
          number: true,
        },
        sumaAsegurada: {
          required: true,
        },
        agroModel: {
          required: true,
          minlength: 2,
        },
      },
      messages: {
        userName: {
          required: "Ingresá tu nombre y apellido",
          minlength: jQuery.validator.format("Ingresa al menos {0} letras"),
          minWords: "Ingresá también tu apellido",
        },
        userZip: {
          required: "Ingresá tu ubicación",
          minlength: jQuery.validator.format("Ingresa al menos {0} letras"),
        },
        vehicleBrand: {
          required: "Ingresá la marca del vehículo",
        },
        vehicleModel: {
          required: "Ingresá el modelo del vehículo",
        },
        vehicleYear: {
          required: "Ingresá el año del vehículo",
        },
        userEmail: {
          required: "Ingresá tu e-mail",
          email: "Ingresá un e-mail válido",
          validate_email: "Ingresá un e-mail válido",
          minlength: jQuery.validator.format("Ingresa al menos {0} caracteres"),
        },
        userBirthDay: {
          required: "Por favor, seleccioná un día",
          number: "Ingresá sólo números",
        },
        userBirthMonth: {
          required: "Por favor, seleccioná un mes",
        },
        sumaAsegurada: {
          required: "Por favor, seleccioná una suma",
        },
        agroModel: {
          required: "Por favor, ingresá un modelo",
          minlength: jQuery.validator.format("Ingresa al menos {0} letras"),
        },
      },
      submitHandler: function (_form, event) {
        event.preventDefault();
      },
      errorPlacement: function (error, element) {
        error.insertBefore(element);
      },
    });
  }

  // Fix genérico para no permitir que el select2 se abra con el enter
  $(document).on("select2:opening.disabled", ":disabled", function () {
    return false;
  });
});
