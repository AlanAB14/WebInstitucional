<?php
/**
 * Template Name: Cotizador Custom Template
 */
$url = get_template_directory();
$urlImg = $url . '/assets/img/cotizador/';
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
      <link rel="stylesheet" href="<?php echo get_template_directory(); ?>/assets/css/new_cotizador.css">
      
    </head>
    <body>
         <header>
            <div class="barra">
              <div class="acceso">
                <img src=" <?php echo $urlImg; ?>contacto-personas.png" alt="" >
                <p class="lblAsegurados fuentesLbl">Ingreso <span>Asegurados</span></p>
              </div>
              <div class="acceso">
                <img src="<?php echo $urlImg; ?>contacto-personas.png" alt="" >
                <p class="lblProductores fuentesLbl">Ingreso <span>Productores</span></p>
              </div>
            </div>
        </header>
        

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
</html>


