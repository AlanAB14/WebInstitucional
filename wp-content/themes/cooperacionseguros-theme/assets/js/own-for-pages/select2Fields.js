$(document).ready(function() {

    var selectLocalidades = $('.localidad-select2').select2();
    selectLocalidades.data().select2.$container.addClass("selectores")
    selectLocalidades.data().select2.$container.addClass("selectores-select2")
    selectLocalidades.data().select2.$container.addClass("selectores-localidad")
    var selectMarca = $('.marca-select2').select2();
    selectMarca.data().select2.$container.addClass("selectores")
    selectMarca.data().select2.$container.addClass("selectores-select2")
    selectMarca.data().select2.$container.addClass("selectores-marca")
    var selectModelo = $('.modelo-select2').select2();
    selectModelo.data().select2.$container.addClass("selectores")
    selectModelo.data().select2.$container.addClass("selectores-select2")
    selectModelo.data().select2.$container.addClass("selectores-modelo")
    var selectAno = $('.ano-select2').select2();
    selectAno.data().select2.$container.addClass("selectores")
    selectAno.data().select2.$container.addClass("selectores-select2")
    selectAno.data().select2.$container.addClass("selectores-ano")
    var selectVersion = $('.version-select2').select2();
    selectVersion.data().select2.$container.addClass("selectores")
    selectVersion.data().select2.$container.addClass("selectores-select2")
    selectVersion.data().select2.$container.addClass("selectores-version")
    var selectGnc = $('.gnc-select2').select2();
    selectGnc.data().select2.$container.addClass("selectores")
    selectGnc.data().select2.$container.addClass("selectores-select2")
    selectGnc.data().select2.$container.addClass("selectores-gnc")

    $('.selectores-localidad').css("pointer-events", "none");
    $('.selectores-marca').css("pointer-events", "none");
    $('.selectores-modelo').css("pointer-events", "none");
    $('.selectores-ano').css("pointer-events", "none");
    $('.selectores-version').css("pointer-events", "none");
    $('.selectores-gnc').css("pointer-events", "none");

});