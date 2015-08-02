<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?> data-wow-delay="0.2s" data-wow-duration="1.2s"  data-wow-offset="30" data-equalizer>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>