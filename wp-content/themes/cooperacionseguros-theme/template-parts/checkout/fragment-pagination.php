  <div class="paginacion">
    <ul class="step d-flex flex-nowrap">
      <?php foreach ($args['steps'] as $step): ?>
        <?php if($step->private) continue; ?>
        <li class="step-item <?php if ($args['step']->slug == $step->slug) echo 'active'; ?>">
          <span><strong><?php echo $step->title; ?></strong></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
