<?php
  $valorAccesorio = $args['quote']['answers']['vehicleGncValue'] ?? '0';
  $cuotaMensual = $args['quote']['answers']['planPremioMensual'] + (isset($args['quote']['answers']['apPremioMensual']) ? $args['quote']['answers']['apPremioMensual'] : 0);
?>

<div class="planinfo">
  <p class="plan">
    Estás contratando un plan
    <strong><?php echo $args['quote']['answers']['planCobertura'] ?></strong>
    para <?php echo ($args['quote']['product'] == 'seguro-de-motos') ? 'una' : 'un'; ?>
    <strong>
      <?php echo $args['quote']['answers']['vehicleBrand'] ?>
      <?php if (isset($args['quote']['answers']['vehicleModel'])) {
            echo $args['quote']['answers']['vehicleModel'];
          } else {
            echo $args['quote']['answers']['vehicleVersion'];
          } ?>
    </strong>
    de <strong><?php echo $args['quote']['answers']['vehicleYear'] ?></strong>
  </p>
  <p class="suma">Suma asegurada:
    <strong>$<?php echo number_format(($args['quote']['answers']['vehicleValue'] + $valorAccesorio), 2, ',', '.') ?></strong>
  </p>

  <p class="cuota">Cuota mensual: <strong>$<?php echo number_format(($cuotaMensual), 2, ',', '.') ?></strong></p>
</div>
