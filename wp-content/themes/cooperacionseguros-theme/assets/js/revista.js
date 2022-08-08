function checkElementLocationEntrevistas() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-entrevistas').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationNovedadesInstitucionales() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-novedades-institucionales').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationCapitalHumano() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-capital-humano').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationInstalaciones() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-instalaciones').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationNovedadesComerciales() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-novedades-comerciales').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationAtencionAlCliente() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-atencion-al-cliente').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationRSE() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-responsabilidad-social-empresaria').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationInnovacion() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-innovacion').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationRedComercial() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-red-comercial').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }
function checkElementLocationSociosEstrategicos() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.category-socios-estrategicos').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('fade-in');
      }
    });
  }

  function checkElementComposicionCartera() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.composicion-cartera-img').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('animate__animated');
        $(this).addClass('animate__bounceInLeft');
        $(this).addClass('composicion-cartera-img-after');
      }
    });
  }

  function checkElementComposicionCanales() {
    var $window = $(window);
    var bottom_of_window = $window.scrollTop() + $window.height();
  
    $('.composicion-canales-img').each(function(i) {
      var $that = $(this);
      var bottom_of_object = $that.position().top + $that.outerHeight();
  
      //if element is in viewport, add the animate class
      if (bottom_of_window > bottom_of_object) {
        $(this).addClass('animate__animated');
        $(this).addClass('animate__bounceInRight');
        $(this).addClass('composicion-canales-img-after');
      }
    });
  }

  
  // if in viewport, show the animation
  checkElementLocationEntrevistas();
  checkElementLocationNovedadesComerciales();
  checkElementLocationNovedadesInstitucionales();
  checkElementLocationRSE();
  checkElementLocationRedComercial();
  checkElementLocationSociosEstrategicos();
  checkElementLocationInnovacion();
  checkElementLocationCapitalHumano();
  checkElementLocationAtencionAlCliente();
  checkElementLocationInstalaciones();
  checkElementComposicionCartera();
  checkElementComposicionCanales();
  
  $(window).on('scroll', function() {
    checkElementLocationEntrevistas();
    checkElementLocationNovedadesComerciales();
    checkElementLocationNovedadesInstitucionales();
    checkElementLocationRSE();
    checkElementLocationRedComercial();
    checkElementLocationSociosEstrategicos();
    checkElementLocationInnovacion();
    checkElementLocationCapitalHumano();
    checkElementLocationAtencionAlCliente();
    checkElementLocationInstalaciones();
    checkElementComposicionCartera();
    checkElementComposicionCanales();
  });






function enfoqueMision() {
    const textBox = document.getElementById("enfoque-descripcion-text");
    textBox.classList.remove("animacion-vision", "animacion-valores");
    textBox.classList.add("enfoque-mision-location", "description-height-animation");
    textBox.classList.remove("enfoque-vision-location", "enfoque-valores-location");
    if (textBox.classList.contains("animacion-mision")) {
        textBox.innerHTML = "<div class='descripcion-texts-enfoques animate__animated modal_content'><span class='close' onClick='cerrar();'>&times;</span><p style='padding:0!important;' id='entrada-enfoque-text' class='card-enfoque-text'>Proteger lo más valioso de nuestros asegurados, acompañándolos en la comprensión de sus riesgos para brindarles soluciones y tranquilidad.</p></div>";
        textBox.style.display = "block";
        return
    }
    textBox.innerHTML = "<div class='descripcion-texts-enfoques animate__animated animate__fadeInUp modal_content'><span class='close' onClick='cerrar();'>&times;</span><p style='padding:0!important;' id='entrada-enfoque-text' class='card-enfoque-text animate__animated animate__fadeIn '>Proteger lo más valioso de nuestros asegurados, acompañándolos en la comprensión de sus riesgos para brindarles soluciones y tranquilidad.</p></div>";
    textBox.style.display = "block";
    textBox.classList.add("animacion-mision")
}
function enfoqueVision() {
    const textBox = document.getElementById("enfoque-descripcion-text");
    textBox.classList.remove("animacion-mision", "animacion-valores");
    textBox.classList.add("enfoque-vision-location", "description-height-animation");
    textBox.classList.remove("enfoque-mision-location", "enfoque-valores-location");
    if (textBox.classList.contains("animacion-vision")) {
        textBox.innerHTML = "<div class='descripcion-texts-enfoques animate__animated modal_content'><span class='close' onClick='cerrar();'>&times;</span><p style='padding:0!important;' id='entrada-enfoque-text' class='card-enfoque-text'>Ampliar nuestros negocios, expandiendo nuestra presencia y la oferta de productos, apoyados en innovación, solvencia y excelencia para brindar a nuestros asegurados un valor diferencial.</p></div>";
        textBox.style.display = "block";
        return
    }
    textBox.innerHTML = "<div class='descripcion-texts-enfoques animate__animated animate__fadeInUp modal_content'><span class='close' onClick='cerrar();'>&times;</span><p style='padding:0!important;' id='entrada-enfoque-text' class='card-enfoque-text'>Ampliar nuestros negocios, expandiendo nuestra presencia y la oferta de productos, apoyados en innovación, solvencia y excelencia para brindar a nuestros asegurados un valor diferencial.</p></div>";
    textBox.style.display = "block";
    textBox.classList.add("animacion-vision")
}
function enfoqueValores() {
    const textBox = document.getElementById("enfoque-descripcion-text");
    textBox.classList.remove("animacion-mision", "animacion-vision");
    textBox.classList.add("enfoque-valores-location", "description-height-animation");
    textBox.classList.remove("enfoque-mision-location", "enfoque-vision-location");
    if (textBox.classList.contains("animacion-valores")) {
        textBox.innerHTML = "<div class='descripcion-texts-enfoques animate__animated valores_text_grid modal_content'><span class='close' onClick='cerrar();'>&times;</span><p style='padding:0!important;' id='entrada-enfoque-text' class='card-enfoque-text'><i class='far fa-gem'></i> <span>Respeto:</span> tratamos a todas nuestras audiencias mirando a las personas con igualdad, sin importar raza, género o ideología, desde el lado más humano de los vínculos, con calidez y consideración.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Integridad:</span> mostramos coherencia entre lo que decimos y hacemos. Somos leales a nuestros principios morales y a los compromisos establecidos.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Foco en el cliente:</span> brindamos una atención personalizada, en tiempo y forma, manteniendo en el centro de nuestras acciones a nuestros clientes.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Relaciones de largo plazo:</span> construimos y cultivamos vínculos sustentables para con nuestros colaboradores, clientes y proveedores.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Trabajo en equipo:</span> la organización la conformamos entre todos, trabajando de manera colaborativa y complementaria en torno a la misma visión.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Mejora continua:</span> aprendemos permanentemente, innovamos y buscamos la excelencia en todo lo que hacemos.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Compromiso social:</span> somos inclusivos y consistentes cuando tomamos decisiones. Nos aseguramos de cumplir con nuestra función social y principios mutualistas.</p><p style='padding:0!important;'><i class='far fa-gem'></i> <span>Estimular el talento:</span> estimulamos las capacidades sobresalientes de nuestra gente y alentamos a un Liderazgo que motiva y desarrolla a las personas como parte del equipo.</p></div>";
        textBox.classList.add("enfoque-vision-location")
        textBox.style.display = "block";
        return
    }
    textBox.innerHTML = "<div class='descripcion-texts-enfoques animate__animated animate__fadeInUp valores_text_grid modal_content'><span class='close' onClick='cerrar();'>&times;</span><p style='padding:0!important;' id='entrada-enfoque-text' class='card-enfoque-text animate__animated animate__fadeIn'><i class='far fa-gem'></i> <span>Respeto:</span> tratamos a todas nuestras audiencias mirando a las personas con igualdad, sin importar raza, género o ideología, desde el lado más humano de los vínculos, con calidez y consideración.</p><p class='animate__animated animate__fadeIn' style='padding:0!important;'><i class='far fa-gem'></i> <span>Integridad:</span> mostramos coherencia entre lo que decimos y hacemos. Somos leales a nuestros principios morales y a los compromisos establecidos.</p><p class='animate__animated animate__fadeIn' style='padding:0!important;'><i class='far fa-gem'></i> <span>Foco en el cliente:</span> brindamos una atención personalizada, en tiempo y forma, manteniendo en el centro de nuestras acciones a nuestros clientes.</p><p class='animate__animated animate__fadeIn' style='padding:0!important;'><i class='far fa-gem'></i> <span>Relaciones de largo plazo:</span> construimos y cultivamos vínculos sustentables para con nuestros colaboradores, clientes y proveedores.</p><p class='animate__animated animate__fadeIn' style='padding:0!important;'><i class='far fa-gem'></i> <span>Trabajo en equipo:</span> la organización la conformamos entre todos, trabajando de manera colaborativa y complementaria en torno a la misma visión.</p><p class='animate__animated animate__fadeIn' style='padding:0!important;'><i class='far fa-gem'></i> <span>Mejora continua:</span> aprendemos permanentemente, innovamos y buscamos la excelencia en todo lo que hacemos.</p><p class='animate__animated animate__fadeIn' style='padding:0!important;'><i class='far fa-gem'></i> <span>Compromiso social:</span> somos inclusivos y consistentes cuando tomamos decisiones. Nos aseguramos de cumplir con nuestra función social y principios mutualistas.</p><p animate__animated animate__fadeIn style='padding:0!important;'><i class='far fa-gem'></i> <span>Estimular el talento:</span> estimulamos las capacidades sobresalientes de nuestra gente y alentamos a un Liderazgo que motiva y desarrolla a las personas como parte del equipo.</p></div>";
    textBox.style.display = "block";
    textBox.classList.add("animacion-valores")
}


window.onclick = function(event) {
    const textBox = document.getElementById("enfoque-descripcion-text");
    if (event.target == textBox) {
      textBox.style.display = "none";
    }
}

function cerrar() {
    const textBox = document.getElementById("enfoque-descripcion-text");
    textBox.style.display = "none";
}