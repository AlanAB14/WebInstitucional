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
    var instancia = '<?php echo $checkout->step->id; ?>';

    <?php if ($checkout->product->slug == 'seguro-de-motos' || $checkout->product->slug == 'seguro-de-autos-y-pick-ups') {
      $cuotaMensual = (isset($checkout->quote['answers']['apPremioMensual'])) ? $checkout->quote['answers']['planPremioMensual'] + $checkout->quote['answers']['apPremioMensual'] : $checkout->quote['answers']['planPremioMensual'];
      $valorCuotaMensual = number_format($cuotaMensual, 2, '.', '');

      if ($checkout->step == 'datos-vehiculo') {
        $checkout_event = 'begin_checkout';
      } else if (($checkout->step == 'finalizado') && ($_GET['payment'] == 'success')) {
        $checkout_event = 'purchase';
      } else {
        $checkout_event = 'checkout_progress';
      }
      ?>

      // Analytics e-commerce
      gtag("event", "<?php echo $checkout_event; ?>", {
        <?php if ($checkout->step == 'finalizado' && isset($_GET['payment']) && ($_GET['payment'] == 'success')) : ?>
          "transaction_id": "<?php echo $checkout->guid; ?>",
          "value": "<?php echo $valorCuotaMensual; ?>",
          "currency": "ARS",
          "shipping": 0,
        <?php endif; ?>
        "items": [{
          "id": "<?php echo $checkout->quote['answers']['planCobertura']; ?>",
          "name": "<?php echo $checkout->quote['answers']['planCobertura']; ?>",
          "category": "<?php echo $checkout->quote['product']; ?>",
          "quantity": 1,
          "price": "<?php echo $valorCuotaMensual; ?>"
        }]
      });

    <?php } ?>


    // Facebook
    <?php if ($checkout->step == 'asesores') { ?>
      fbq('track', 'CompleteRegistration');
    <?php } ?>
    <?php if ($checkout->step == 'pago') { ?>
      fbq('track', 'Purchase');
    <?php } ?>

    <?php if ($checkout->step == 'pago' && isset($_GET['payment']) && ($_GET['payment'] == 'success')) { ?>
      // Event snippet for Purchase - Google Ads conversion page
      gtag('event', 'conversion', {
        'send_to': 'AW-690670402/YFJkCJOMzfwBEMKWq8kC',
        'transaction_id': ''
      });
    <?php } ?>
  </script>

  <?php
  echo '<!-- Fecha: ' . date('m-d-Y H:i') . '-->';
  get_footer();
