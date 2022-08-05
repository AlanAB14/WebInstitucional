// ********************** //
// Selección de planes
// ********************** //

$(function () {
  var planesContainer = $(".seleccion-de-planes.transaccional");
  var planesContainerDesktop = $(".seleccion-de-planes.transaccional .desktop");
  // Si existe el bloque de planes transaccionable...
  if (planesContainer.length) {
    // Variables para el que te sigue
    var planesHeader = planesContainerDesktop.find(".header");
    var planesHeaderTop = planesContainer.offset().top - $("#header").height();
    var planesFooter = planesContainerDesktop.find(".footer");
    var planesFooterTop = planesFooter.offset().top - $("#header").height();

    // Detectar srcroll para cambiar clases del header
    $(window).scroll(function () {
      var currentScroll = $(window).scrollTop();

      // Fijar el header
      if (currentScroll >= planesHeaderTop) {
        planesHeader.addClass("fixed");
      } else {
        planesHeader.removeClass("fixed");
      }

      // Si el footer está a la vista, es otra clase que no muestra el precio
      if (checkVisible(planesFooter, 50) || currentScroll >= planesFooterTop) {
        planesHeader.addClass("noprice");
      } else {
        planesHeader.removeClass("noprice");
      }
    });

    // Nos aseguramos que la cobertura de AP está chequeada al cargar
    $(".togglecoberturaap").prop("checked", true);

    // Cuál es el valor de AP?
    var valorAP = parseInt($("#coberturaap").val());

    // Si la cobertura de AP se cambia...
    $(".togglecoberturaap").on("change", function () {
      // Si se activa o desactiva el valor de AP...
      if (this.checked) {
        $(this)
          .parent()
          .siblings()
          .find("span")
          .removeClass("off")
          .addClass("on");

        // Actualizar precios
        $(".price strong").each(function () {
          var precio = parseInt($(this).text().replace(/\D/g, ""));
          $(this).text(numberToPrice(precio + valorAP));
        });

        // Asegurar que los inputs de Ap están habilitados
        planesContainer.find("input.dataAp").prop("disabled", false);
        planesContainer.find('input[name="apOnOff"]').val("on");

        // Revisar todos los checkboxes de la clase para activarlos
        $(".togglecoberturaap").prop("checked", true);
      } else {
        $(this)
          .parent()
          .siblings()
          .find("span")
          .removeClass("on")
          .addClass("off");

        // Actualizar precios
        $(".price strong").each(function () {
          var precio = parseInt($(this).text().replace(/\D/g, ""));
          $(this).text(numberToPrice(precio - valorAP));
        });

        // Asegurar que los inputs de Ap están deshabilitados
        planesContainer.find("input.dataAp").prop("disabled", true);
        planesContainer.find('input[name="apOnOff"]').val("off");

        // Revisar todos los checkboxes de la clase para activarlos
        $(".togglecoberturaap").prop("checked", false);
      }
    });

    // Si se cambia el servicio de grúa...
    $("#coberturagrua, #coberturagruaMobile").on("change", function () {
      // Cuál es el valor de grúa?
      let fulltier = $(this).val();

      // Ocultar / Mostrar opciones
      $("#coberturafranquicia, #coberturafranquiciaMobile").empty();

      $.each(full[fulltier], function (i, plan) {
        let { franquicia, premioMensual } = plans[plan];

        $("#coberturafranquicia, #coberturafranquiciaMobile").append(
          `<option name="${plan}" value="${franquicia}" data-key="${plan}" data-price="${premioMensual}">
          $${numberToPrice(franquicia)}
          </option>`
        );
        //console.log(value);
      });

      // Dejar primera opción de franquicia seleccionada
      $("#coberturafranquicia, #coberturafranquiciaMobile")
        .find("option:enabled:first")
        .prop("selected", true);

      // Triggear el evento "change" para cambiar los valores
      $("#coberturafranquicia, #coberturafranquiciaMobile").trigger("change");
    });

    // Cargar opciones de grúa iniciales
    $("#coberturagrua, #coberturagruaMobile").trigger("change");

    // Si se cambia el servicio de franquicia...
    $("#coberturafranquicia, #coberturafranquiciaMobile").on(
      "change",
      function () {
        // Cuál es el plan que corresponde?
        let plan = $(this).find(":selected").attr("data-key");

        // Cambiamos el plan que va a enviar el botón
        planesContainer.find(".enviar.full").attr("data-plan", plan);

        // Cuál es el precio del plan seleccionado?
        let planPrice = parseInt(plans[plan].premioMensual);

        // Hay que considerar cobertura a pasajeros?
        if ($("#coberturaap").is(":checked")) {
          planPrice = planPrice + valorAP;
        }

        // Actualizar precio del plan full
        $(".full .price strong").each(function () {
          $(this).text(numberToPrice(planPrice));
        });
      }
    );

    // Completar datos faltantes y enviar form al clickear en un botón
    $(".enviar").on("click", function (event) {
      // Evitar el default
      event.preventDefault();

      // Plan elegido
      let selectedPlan = $(this).attr("data-plan");

      // Agregar el plan elegido al envío
      planesContainer.find("input[name=planCobertura]").val(selectedPlan);

      // Si el producto es de vehículos, agregar vvalores de campos para el checkout
      if (typeof plans !== "undefined") {
        planesContainer
          .find("input[name=planSuma]")
          .val(plans[selectedPlan].suma);

        planesContainer
          .find("input[name=planPremio]")
          .val(plans[selectedPlan].premio);

        planesContainer
          .find("input[name=planPremioMensual]")
          .val(plans[selectedPlan].premioMensual);

        planesContainer
          .find("input[name=planPremioReferencia]")
          .val(plans[selectedPlan].premioReferencia);

        planesContainer
          .find("input[name=planPrima]")
          .val(plans[selectedPlan].prima);

        planesContainer
          .find("input[name=planFechaInicio]")
          .val(plans[selectedPlan].fechaInicio);

        planesContainer
          .find("input[name=planFechaFin]")
          .val(plans[selectedPlan].fechaFin);

        planesContainer
          .find("input[name=planFranquicia]")
          .val(plans[selectedPlan].franquicia);

        planesContainer
          .find("input[name=codigoConvenio]")
          .val(plans[selectedPlan].codigoConvenio);

        planesContainer
          .find("input[name=bonusMaxConvenio]")
          .val(plans[selectedPlan].bonusMaxConvenio);

        planesContainer
          .find("input[name=bonusMaxAntiguedad]")
          .val(plans[selectedPlan].bonusMaxAntiguedad);

        planesContainer
          .find("input[name=bonusMaxSuma]")
          .val(plans[selectedPlan].bonusMaxSuma);
      }

      // Enviar formulario
      planesContainer.find("form").submit();
    });

    // Cuántos slides hay para el mobile?
    let totalslides = $(".planesmobile").children().length;

    // Iniciar Slick en mobile
    $(".planesmobile").slick({
      mobileFirst: true,
      responsive: [
        {
          breakpoint: 480,
          settings: "unslick",
        },
      ],
      dots: false,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      initialSlide: totalslides - 1,
      centerMode: true,
    });
  }

  // Para los bloques de planes en general...
  // Ampliar detalles
  $(".condetalle").on("click", function () {
    $(this).toggleClass("ampliado");
  });

  $(".legal").on("click", function () {
    let legalItems = $(this).data("items");
    $("." + legalItems).toggleClass("ampliado");
  });

  // Completar datos faltantes y enviar form al clickear en un botón
  $(".vermasdetalles").on("click", function (event) {
    event.preventDefault();

    $(this).hide();
    $(this).next(".masdetalles").toggleClass("ampliado");
  });
});
