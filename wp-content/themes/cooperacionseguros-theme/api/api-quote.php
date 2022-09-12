<?php

require_once rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/wordpress/wp-load.php';
require_once get_template_directory() . '/classes/quote.php';

function init_quote($product, $data) {
  $quote = Quote::create_quote($product, $data);

  return $quote['guid'];
}
