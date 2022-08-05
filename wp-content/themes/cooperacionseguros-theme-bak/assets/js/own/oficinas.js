// Cuando carga la página...
$(function () {
  var oficinasContainer = $("#mapa-de-oficinas");
  var cachedOffices;

  // Si existe el contenedor del mapa de productores...

  if (oficinasContainer.length) {
    // Obtener oficinas
    $.getJSON(themePath + "data/offices.json", function (data) {
      // Asignamos el resultado a la variable de oficinas
      cachedOffices = data;
    });

    // Iniciar mapa
    var map = L.map("mapa").setView(["-33.7443351", "-61.96413"], 15);

    // Deshabilitamos la rueda para no complicar el scroll?

    // disable scroll-zooming initially
    map.scrollWheelZoom.disable();

    var zoomTimer;

    // on entering the map we're starting a timer to
    // 3 seconds after which we'll enable scroll-zooming
    map.on("mouseover", function () {
      zoomTimer = setTimeout(function () {
        map.scrollWheelZoom.enable();
      }, 3000);
    });

    // on leaving the map we're disarming not yet triggered timers
    // and disabling scrolling
    map.on("mouseout", function () {
      clearTimeout(zoomTimer);
      map.scrollWheelZoom.disable();
    });

    // Agregar layer de openstreetmap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}", {
      foo: "bar",
      attribution:
        'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    }).addTo(map);

    // Agregar layer para los markers
    var markerGroup = L.featureGroup().addTo(map);

    // Cambiar el marker por defecto por algo propio
    var customMarker = L.divIcon({ className: "map-marker", iconSize: "30" });

    L.marker(["-33.7443351", "-61.96413"], { icon: customMarker })
      .addTo(markerGroup)
      .bindPopup(
        "<img src='" +
          themePath +
          "assets/img/oficinas/casacentral.jpg' alt='' width='300' height='220' /><h1>Oficina Central</h1><p>25 de Mayo 530, Venado Tuerto (Santa Fé)</p><p>03462-435100 / 435200 y líneas rotativas</p><p><a href='mailto:info@cooperacionseguros.com.ar'>info@cooperacionseguros.com.ar</a>"
      )
      .openPopup();

    // Actualizar provincia
    $(".provincias li").on("click", function (event) {
      // Marcar elemento activo
      $(this).siblings().removeClass("active");
      $(this).addClass("active");

      // Definir qué lista usamos
      var provincia = $(this).data("provincia");

      // Vaciamos todos los markers
      markerGroup.clearLayers();

      // Sumamos markers de productores
      $.each(cachedOffices[provincia], function (k, v) {
        L.marker([v.latitud, v.longitud], { icon: customMarker })
          .addTo(markerGroup)
          .bindPopup(
            "<img src='" +
              themePath +
              "assets/img/oficinas/" +
              v.imagen +
              "' alt='' width='300' height='220' /><h1>" +
              k +
              "</h1><p>" +
              v.direccion +
              "</p><p>" +
              v.telefono +
              "</p><p><a href='mailto:" +
              v.email +
              "'>" +
              v.email +
              "</a></p>"
          );
      });

      // Al abrir un modal, centrar mapa en marker y popup
      map.on("popupopen", function (e) {
        var px = map.project(e.target._popup._latlng); // find the pixel location on the map where the popup anchor is
        px.y -= e.target._popup._container.clientHeight / 2; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
        map.panTo(map.unproject(px), { animate: true }); // pan to new center
      });

      // Centrar el mapa en los markers encontrados
      map.fitBounds(markerGroup.getBounds());
    });
  }
});
