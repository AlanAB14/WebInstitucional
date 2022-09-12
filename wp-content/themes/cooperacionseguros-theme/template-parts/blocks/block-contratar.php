<?php

$guid = $_GET['guid'] ?? get_query_var('guid');
$quote = Quote::get_quote($guid);
$product = basename(get_permalink());
$productInfo = get_product_from_slug($product);

?>

<div class="block block-contratar">
  <?php if ($quote || empty($productInfo->questions)) : ?>
    <form method="post" action="/wordpress/checkout">
      <input type="hidden" name="guid" value="<?php echo $quote['guid']; ?>" />
      <input type="hidden" name="product" value="<?php echo $product; ?>" />

      <button class="btn big">Contratar</button>
    </form>
  <?php else : ?>
      <p class="submit"><a href="#" class="btn big productLauncher" data-slug="<?php echo $product; ?>">Contratar</a></p>
  <?php endif; ?>
</div>

<?php
  if ($quote) {
    track_script($quote['guid']);
  }
?>
