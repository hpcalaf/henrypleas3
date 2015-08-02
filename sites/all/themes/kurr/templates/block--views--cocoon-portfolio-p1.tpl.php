<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <?php if ($block->subject): ?>
      <div class="medium-3 small-12 columns animated" data-animate-delay="0"  data-animate="fadeInDown">
        <div class="title-section">
          <h3<?php print $title_attributes; ?>><strong><?php print $block->subject ?></strong></h3>
        </div>
      </div>
    <?php endif;?>
    <?php print render($title_suffix); ?>
      <?php if ($block->subject): ?>
        <div class="section-desc">
      <?php endif; ?>
        <div class="content"<?php print $content_attributes; ?>>
          <?php print $content ?>
        </div>
      <?php if ($block->subject): ?>
        </div><!-- /.section-desc -->
      <?php endif; ?>
</div>