<?php

require_once get_template_directory() . '/api/api.php';
require_once get_template_directory() . '/classes/checkout.php';

$checkout = new Checkout();

get_header();

get_template_part('template-parts/checkout/fragment-pagination', null, [
  'step' => $checkout->step,
  'steps' => $checkout->steps,
]);

?>

<div id="checkout-form" class="container">

  <?php

    $checkout->get_template();

    if ($checkout->product->slug == 'seguro-de-motos' || $checkout->product->slug == 'seguro-de-autos-y-pick-ups') {
      get_template_part('template-parts/checkout/fragment-product-info', null, [
        'quote' => $checkout->quote,
      ]);
    }

  ?>
</div>

  <script>
    var guid = '<?php echo $checkout->guid; ?>';
    var commonEvent = {
      'category': '<?php echo $checkout->product->category; ?>',
      'product': '<?php echo $checkout->product->slug; ?>',
    };
    var instancia = '<?php echo $checkout->step->id; ?>';
    var purchasable = <?php echo ($checkout->product->slug == 'seguro-de-motos' || $checkout->product->slug == 'seguro-de-autos-y-pick-ups') ? 'true' : 'false' ?>;

    <?php if ($checkout->product->slug == 'seguro-de-motos' || $checkout->product->slug == 'seguro-de-autos-y-pick-ups') : ?>
      commonEvent['vehicleBrand'] = '<?php echo $checkout->quote['answers']['vehicleBrand']; ?>';
      <?php if ($checkout->product->slug == 'seguro-de-autos-y-pick-ups') : ?>
        commonEvent['vehicleModel'] = '<?php echo $checkout->quote['answers']['vehicleModel']; ?>';
        commonEvent['vehicleGnc'] = '<?php echo $checkout->quote['answers']['vehicleGnc']; ?>' ?? null;
      <?php endif; ?>
      commonEvent['vehicleYear'] = '<?php echo $checkout->quote['answers']['vehicleYear']; ?>';
      commonEvent['vehicleVersion'] = '<?php echo $checkout->quote['answers']['vehicleVersion']; ?>';

      commonEvent['vehiclePlan'] = '<?php echo $checkout->quote['answers']['planCobertura']; ?>';
      commonEvent['vehiclePlanPrice'] = <?php echo $checkout->quote['answers']['planPremioMensual'] + ($checkout->quote['answers']['apPremioMensual'] ?? 0); ?>;
      commonEvent['vehiclePlanPriceSubtotal'] = <?php echo $checkout->quote['answers']['planPremioMensual']; ?>;
      commonEvent['vehiclePlanPriceAP'] = <?php echo $checkout->quote['answers']['apPremioMensual'] ?? 0; ?>;
    <?php endif; ?>
  </script>

  <?php
  echo '<!-- Fecha: ' . date('m-d-Y H:i') . '-->';
  get_footer();
