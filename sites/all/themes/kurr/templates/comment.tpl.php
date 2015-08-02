<div class="<?php print $classes; ?> box-users clearfix"<?php print $attributes; ?>>

  <div class="avatar">
    <?php print $picture; ?>
  </div>

  <div class="comment-body">

    <?php if ($new): ?>
      <span class="new"><?php print $new; ?></span>
    <?php endif; ?>

    <?php print render($title_prefix); ?>
    <h4 class="title"<?php print $title_attributes; ?>><?php print $author; ?></h4>
    <?php print render($title_suffix); ?>
    <span class="date"><?php print $created; ?></span><br>
    <span class="lead"><?php print check_plain($comment->subject); ?></span>
    <div class="content"<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['links']);
        print render($content);
      ?>
      <?php if ($signature): ?>
      <footer class="user-signature clearfix">
        <?php print $signature; ?>
      </footer>
      <?php endif; ?>
    </div> <!-- /.content -->
    <div class="comment-links"><?php print render($content['links']); ?></div>
  </div> <!-- /.comment-text -->
</div>
