// Variables genéricas para la selección y muestra de productos
var themePath = "/wp-content/themes/cooperacionseguros-theme/";
var gtmIdentifier = (environment == 'prod') ? 'GTM-PXJ8MMZ' : 'GTM-K5MCW3Z';

// Funciones genéricas

$(function () {
  // Menú principal responsive
  $(".openmenu").on("click", function (event) {
    $(this).add("#primary-menu-container").toggleClass("active");
  });

  // Alto del header
  // var headerHeight = $("#header").outerHeight();

  // Detectar si el menú ha scrolleado
  $(window).bind("scroll", function () {
    // if ($(window).scrollTop() > headerHeight) {
    if ($(window).scrollTop() > 0) {
      $("#header").addClass("fixed");
    } else {
      $("#header").removeClass("fixed");
    }
  });

  // Scroll suave con hashes, versión robada pero con más detalles que la mía
  // Select all links with hashes
  $('a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    // Quitar tabs
    .not(".opentab")
    .click(function (event) {
      // On-page links
      if (
        location.pathname.replace(/^\//, "") ==
          this.pathname.replace(/^\//, "") &&
        location.hostname == this.hostname
      ) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length
          ? target
          : $("[name=" + this.hash.slice(1) + "]");
        // Does a scroll target exist?
        if (target.length) {
          // Only prevent default if animation is actually gonna happen
          event.preventDefault();
          $("html, body").animate(
            {
              scrollTop: target.offset().top,
            },
            600,
            function () {
              // Callback after animation
              // Must change focus!
              var $target = $(target);
              $target.focus();
              if ($target.is(":focus")) {
                // Checking if the target was focused
                return false;
              } else {
                $target.attr("tabindex", "-1"); // Adding tabindex for elements not focusable
                $target.focus(); // Set focus again
              }
            }
          );
        }
      }
    });

  // Clonar menú de categorías para armar submenú
  $("body").append('<div id="submenu" />');
  $("#product-menu").clone().appendTo("#submenu");

  // Botón para cerrar submenu
  $("#submenu").append('<i class="far fa-times-circle togglesubmenu" />');

  // Activar y desactivar menú secundario
  $(".togglesubmenu").on("click", function (event) {
    $(this).toggleClass("active");
    $("#submenu").toggleClass("active");
    event.preventDefault();
  });

  // Tooltips
  $(".tooltip").tooltipster({
    theme: "tooltipster-shadow",
    maxWidth: 600,
    trigger: "custom",
    triggerOpen: {
      mouseenter: true,
      touchstart: true,
      tap: true,
    },
    triggerClose: {
      mouseleave: true,
      originClick: true,
      touchleave: true,
      tap: true,
    },
  });

  // Acordeones de preguntas y respuestas
  $(".page-ayuda .wp-block-group h2").on("click", function (event) {
    $(this).parent().toggleClass("active");
    event.preventDefault();
  });

  // Si hay tabs, no scrollear antes de que aparezcan los tabs
  if ($(".block-tabs").length) {
    if (location.hash) {
      setTimeout(function () {
        window.scrollTo(0, 0);
      }, 1);
    }
  }

  // Mostrar tabs
  $(".block-tabs").responsiveTabs({
    collapsible: "accordion",
    setHash: true,
    //scrollToAccordion: true,
    click: function (event, tab) {
      // havetoscroll = true;
    },
    activate: function (event, tab) {},
  });
});

function setCookie(name, value, minutes) {
  var expires = "";
  if (minutes) {
    var date = new Date();
    date.setTime(date.getTime() + minutes * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

$(document).on("select2:open", () => {
  document.querySelector(".select2-search__field").focus();
});

function pushDataLayer(eventData) {
  window.dataLayer.push(eventData);

  if (environment == 'dev') {
    console.log(`Enviado ${eventData['event']}: \n`, eventData);
  }
}

function clearDataLayer() {
  var gtm = window.google_tag_manager[gtmIdentifier];
  gtm.dataLayer.reset();
}
