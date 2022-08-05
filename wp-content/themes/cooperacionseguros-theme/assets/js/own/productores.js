// ********************** //
// Selección de planes
// ********************** //

// Cuando carga la página...
$(function () {
  var productoresContainer = $("#mapa-de-productores");
  // Si existe el contenedor del mapa de productores...

  if (productoresContainer.length) {
    // Variables genéricas para la selección y muestra de productores
    var producersFile = themePath + "api/api.php?get=producers";
    var placesFile = themePath + "api/api.php?get=places&producers=1";

    // Iniciar mapa
    var map = L.map("mapa").setView([-33.7497, -61.9669], 13);

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

    // Mostramos el layer de la ubicación
    $(productoresContainer).find(".location").show();

    // Sumamos el select2
    $("#userZip")
      .select2({
        language: "es",
        placeholder: "Seleccioná tu ubicación",
        allowClear: true,
        ajax: {
          url: placesFile,
          processResults: function (data) {
            var results = [];
            $.each(data, function (k, v) {
              results.push({
                id: v.idcity,
                text: v.altName + ", " + v.state + " (" + v.zipcode + ")",
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
      })
      .prop("disabled", false);

    // Si se selecciona una opción...
    $("#userZip").on("select2:select", function (e) {
      // El Select se mueve arriba
      $(productoresContainer).addClass("selected");

      // Mostramos productores de la ciudad elegida
      var city = $(this).val();
      showProducers(city);
    });

    // Si ya tenemos una ubicación seleccionada...
    function showProducers(city) {
      // Log
      // console.log(city);

      // Buscamos productores de la ciudad
      $.getJSON(producersFile, { idcity: city }, function (data) {
        // Si hay resultados
        if (data.error !== undefined) {
          productoresContainer.append(
            "<div class='alert'>Tu límite de consultas diarias ha sido superado.</div>"
          );
        } else {
          if (data.length) {
            // Si se superó el límite de consultas...
            // Vaciamos todos los markers
            markerGroup.clearLayers();

            // Sumamos markers de productores
            $.each(data, function (k, v) {
              var parsedEmail = v.email.replace(";", "<br />");
              L.marker([v.latitud, v.longitud], { icon: customMarker })
                .addTo(markerGroup)
                .bindPopup(
                  "<h1>" +
                    v.productor +
                    "</h1><p><strong>Dirección:</strong> " +
                    v.direccion +
                    ", " +
                    v.localidad +
                    "</p><p><strong>Teléfonos:</strong> " +
                    v.telefonos +
                    "</p><p><strong>E-mail:</strong> " +
                    parsedEmail +
                    "</p>"
                );
            });

            // Centrar el mapa en los markers encontrados
            map.fitBounds(markerGroup.getBounds());

            // Si no hay resultados
          } else {
            // ?
            // console.log("No hay resultados");
          }
        }
      });
    }
  }
});
