<div class="medium-12 columns"><div id="comments-section" class="comments <?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if ($content['comments'] && $node->type != 'forum'): ?>
    <?php print render($title_prefix); ?>
    <h3 class="text-center"><strong>Comments<span class="color">.</span></strong></h3>
    <?php print render($title_suffix); ?>
  <?php endif; ?>

  <div id="comments" class="user-comments comment-wrapper comment-wrapper-nid-<?php print $node->nid?> comments-list"><?php print render($content['comments']); ?></div>

  <?php if ($content['comment_form']): ?>
    <h3 class="text-center"><strong>Add a comment<span class="color">.</span></strong></h3>
    <?php print render($content['comment_form']); ?>
  <?php endif; ?>
</div></div>