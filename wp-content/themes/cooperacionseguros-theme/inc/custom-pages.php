<?php

add_action('init', function () {
  add_rewrite_rule(
    'checkout/([0-9a-zA-Z-]+)/([0-9a-zA-Z-]+)/([0-9a-zA-Z-]+)/?$',
    'index.php?pagename=checkout&product=$matches[1]&step=$matches[2]&guid=$matches[3]',
    'top'
  );

  add_rewrite_rule(
    'checkout/([0-9a-zA-Z-]+)/([0-9a-zA-Z-]+)/([0-9a-zA-Z-]+)/([0-9a-zA-Z-]+)/?$',
    'index.php?pagename=checkout&product=$matches[1]&step=$matches[2]&guid=$matches[3]&status=$matches[4]',
    'top'
  );

  add_rewrite_rule(
    'seguro-de-motos/([0-9a-zA-Z-]+)/?$',
    'index.php?pagename=seguro-de-motos&guid=$matches[1]',
    'top'
  );

  add_rewrite_rule(
    'seguro-de-autos-y-pick-ups/([0-9a-zA-Z-]+)/?$',
    'index.php?pagename=seguro-de-autos-y-pick-ups&guid=$matches[1]',
    'top'
  );

  add_rewrite_rule(
    'seguro-de-vida-individual/([0-9a-zA-Z-]+)/?$',
    'index.php?pagename=seguro-de-vida-individual&guid=$matches[1]',
    'top'
  );

  add_rewrite_rule(
    'seguro-de-maquinaria-e-implementos/([0-9a-zA-Z-]+)/?$',
    'index.php?pagename=seguro-de-maquinaria-e-implementos&guid=$matches[1]',
    'top'
  );
});

add_filter('query_vars', function ($query_vars) {
  $query_vars[] = 'product';
  $query_vars[] = 'guid';
  $query_vars[] = 'step';
  $query_vars[] = 'status';
  return $query_vars;
});

add_filter( 'document_title_parts', function ( $title_parts ) {
  global $pagename;

  if ($pagename == 'checkout') {
    $product = get_product_from_slug(get_query_var('product'));
    $step = array_filter($product->steps, function ($step) {
      return ($step->slug == get_query_var('step'));
    });
    $title = array_shift($step)->title ?? null;

    if ($title) {
      $title_parts['title'] = 'Checkout: ' . $title;
    }
  }

  return $title_parts;
} );
