<?php

/**
 * Custom blocks
 */

// Bloque de detalles de un plan
add_filter('lazyblock/detalles-de-plan/frontend_callback', 'block_detalles_de_plan', 10, 2);

if (!function_exists('block_detalles_de_plan')) :

  function block_detalles_de_plan($output, $attributes)
  {
    ob_start();
    echo '<section id="cobertura" class="seleccion-de-planes">';

    // Si hay coberturas (chequeamos también que al menos exista la primera, porque el plugin puede devolver un item vacío)
    if (!empty($attributes['coberturas']) && !empty($attributes['coberturas'][0]['cobertura'])) {

      if (isset($attributes['titulo_coberturas'])) {
        echo '<h2 class="title">' . $attributes['titulo_coberturas'] . '</h2>';
      }

      foreach ($attributes['coberturas'] as $item) {
        $class = (isset($item['detalle']) && !empty(trim($item['detalle']))) ? 'detail condetalle' : 'detail';
        echo '<div class="opciones coberturas wrap">';
        echo '<div class="' . $class . '">';
        echo $item['cobertura'];
        if (isset($item['detalle'])) {
          echo '<small class="detalle">' . $item['detalle'] . '</small>';
        }
        echo '</div>';
        // echo '<div><span class="on">Incluida</span></div>';
        echo '</div>';
      }
    }

    // Si hay beneficios (misma lógica que coberturas)
    if (!empty($attributes['beneficios']) && !empty($attributes['beneficios'][0]['beneficio'])) {

      if (isset($attributes['titulo_beneficios'])) {
        echo '<h2 class="title">' . $attributes['titulo_beneficios'] . '</h2>';
      }

      foreach ($attributes['beneficios'] as $item) {
        $class = (isset($item['detalle']) && !empty(trim($item['detalle']))) ? 'detail condetalle' : 'detail';
        echo '<div class="opciones coberturas wrap">';
        echo '<div class="' . $class . '">';
        echo $item['beneficio'];
        if (isset($item['detalle'])) {
          echo '<small class="detalle">' . $item['detalle'] . '</small>';
        }
        echo '</div>';
        // echo '<div><span class="on">Incluida</span></div>';
        echo '</div>';
      }
    }

    // Si hay requisitos (misma lógica que coberturas)
    if (!empty($attributes['requisitos']) && !empty($attributes['requisitos'][0]['requisito'])) {
      echo '<span class="legal" data-items="requisitos">Requisitos mínimos de cobertura</span>';
      echo '<ul class="legalitems requisitos">';
      foreach ($attributes['requisitos'] as $item) {
        echo '<li>' . $item['requisito'] . '</li>';
      }
      echo '</ul>';
    }

    echo '</section>';
    return ob_get_clean();
  }
endif;

// Bloque de detalles de un plan
add_filter('lazyblock/tabla-de-planes/frontend_callback', 'block_tabla_de_planes', 10, 2);

if (!function_exists('block_tabla_de_planes')) :

  function block_tabla_de_planes($output, $attributes)
  {
    ob_start();
    echo '<section id="cobertura" class="seleccion-de-planes tabla-de-planes">';

    echo '<div class="opciones header wrap">';
    echo '<div class="detail"><h2>Detalles de planes</h2></div>';
    echo '<div class="plan basic"><h1>Esencial</h1></div>';
    echo '<div class="plan basic"><h1>Superior</h1></div>';
    echo '<div class="plan basic"><h1>Exclusivo</h1></div>';
    echo '</div>';

    // Si hay coberturas (chequeamos también que al menos exista la primera, porque el plugin puede devolver un item vacío)
    if (!empty($attributes['coberturas']) && !empty($attributes['coberturas'][0]['detalle_de_cobertura'])) {
      echo '<h2 class="title">Coberturas disponibles</h2>';

      foreach ($attributes['coberturas'] as $item) {
        $class = (isset($item['detalle']) && !empty(trim($item['detalle']))) ? 'detail condetalle' : 'detail';
        echo '<div class="opciones coberturas wrap">';
        echo '<div class="' . $class . '">' . $item['detalle_de_cobertura'] . '</div>';

        echo '<div>';
        echo (isset($item['basico'])) ? '<span class="on">Incluida</span>' : '<span class="off">No incluida</span>';
        echo '</div>';

        echo '<div>';
        echo (isset($item['medio'])) ? '<span class="on">Incluida</span>' : '<span class="off">No incluida</span>';
        echo '</div>';

        echo '<div>';
        echo (isset($item['full'])) ? '<span class="on">Incluida</span>' : '<span class="off">No incluida</span>';
        echo '</div>';

        echo '</div>';
      }
    }

    // Si hay beneficios, idem
    if (!empty($attributes['beneficios']) && !empty($attributes['beneficios'][0]['detalle_de_beneficio'])) {
      echo '<h2 class="title">Beneficios</h2>';

      foreach ($attributes['beneficios'] as $item) {
        $class = (isset($item['detalle']) && !empty(trim($item['detalle']))) ? 'detail condetalle' : 'detail';
        echo '<div class="opciones beneficios wrap">';
        echo '<div class="' . $class . '">' . $item['detalle_de_beneficio'] . '</div>';

        echo '<div>';
        echo (isset($item['basico'])) ? '<span class="on">Incluido</span>' : '<span class="off">No incluido</span>';
        echo '</div>';

        echo '<div>';
        echo (isset($item['medio'])) ? '<span class="on">Incluido</span>' : '<span class="off">No incluido</span>';
        echo '</div>';

        echo '<div>';
        echo (isset($item['full'])) ? '<span class="on">Incluido</span>' : '<span class="off">No incluido</span>';
        echo '</div>';

        echo '</div>';
      }
    }

    echo '</section>';
    return ob_get_clean();
  }
endif;


// Bloque de detalles de un plan con porcentajes
add_filter('lazyblock/tabla-de-planes-con-porcentajes/frontend_callback', 'block_tabla_de_planes_con_porcentajes', 10, 2);

if (!function_exists('block_tabla_de_planes_con_porcentajes')) :

  function block_tabla_de_planes_con_porcentajes($output, $attributes)
  {
    ob_start();
    echo '<section id="cobertura" class="seleccion-de-planes tabla-de-planes porcentaje doble">';

    echo '<div class="opciones header wrap">';
    echo '<div class="detail"><h2>Detalles de planes</h2></div>';
    echo '<div class="plan basic"><h1>Tradicional</h1></div>';
    echo '<div class="plan basic"><h1>Premium</h1></div>';
    echo '</div>';

    // Si hay coberturas (chequeamos también que al menos exista la primera, porque el plugin puede devolver un item vacío)
    if (!empty($attributes['coberturas']) && !empty($attributes['coberturas'][0]['texto'])) {
      echo '<h2 class="title">Coberturas disponibles</h2>';

      foreach ($attributes['coberturas'] as $item) {
        $class = (isset($item['detalle']) && !empty(trim($item['detalle']))) ? 'detail condetalle' : 'detail';
        echo '<div class="opciones coberturas wrap">';
        echo '<div class="' . $class . '">' . $item['texto'] . '</div>';

        echo '<div>';
        echo (isset($item['tradicional'])) ? '<span>' . $item['tradicional'] . '%</span>' : '<span class="off">No incluida</span>';
        echo '</div>';

        echo '<div>';
        echo (isset($item['premium'])) ? '<span>' . $item['premium'] . '%</span>' : '<span class="off">No incluida</span>';
        echo '</div>';


        echo '</div>';
      }
    }

    // Si hay adicionales (chequeamos también que al menos exista la primera, porque el plugin puede devolver un item vacío)
    if (!empty($attributes['coberturas']) && !empty($attributes['adicionales'][0]['texto'])) {
      echo '<h2 class="title">Adicionales</h2>';

      foreach ($attributes['adicionales'] as $item) {
        $class = (isset($item['detalle']) && !empty(trim($item['detalle']))) ? 'detail condetalle' : 'detail';

        if (!isset($item['tradicional']) && !isset($item['premium'])) {
          $class .= ' textonly';
        }

        echo '<div class="opciones adicionales wrap">';

        echo '<div class="' . $class . '">' . $item['texto'] . '</div>';

        if (isset($item['tradicional']) && isset($item['premium'])) {
          echo '<div>';
          echo (isset($item['tradicional'])) ? '<span>' . $item['tradicional'] . '%</span>' : '<span class="off">No incluida</span>';
          echo '</div>';

          echo '<div>';
          echo (isset($item['premium'])) ? '<span>' . $item['premium'] . '%</span>' : '<span class="off">No incluida</span>';
          echo '</div>';
        }


        echo '</div>';
      }
    }

    echo '</section>';
    return ob_get_clean();
  }
endif;


// Bloque de tabs
add_filter('lazyblock/tabs/frontend_callback', 'block_tabs', 10, 2);

if (!function_exists('block_tabs')) :

  function block_tabs($output, $attributes)
  {
    ob_start();
    echo '<div class="wrap block block-tabs">';

    // Preguntas y respuestas
    if (!empty($attributes['tab']) && !empty($attributes['tab'][0]['titulo'])) {

      echo '<ul class="tab-labels">';
      foreach ($attributes['tab'] as $i) {
        echo '<li><a href="#tab-' . sanitize_title($i['titulo']) . '" class="opentab">' . $i['titulo'] . '</a></li>';
      }
      echo '</ul>';

      foreach ($attributes['tab'] as $i) {
        echo '<div id="tab-' . sanitize_title($i['titulo']) . '" class="tab">' . wpautop($i['contenido']) . '</div>';
      }
    }

    echo '</div>';
    return ob_get_clean();
  }
endif;