<?php
$base_path = base_path();
$path_to_theme = drupal_get_path('theme', 'kurr');
$site_name = variable_get('site_name');

// Get Cocoon theme settings
if (theme_get_setting('testimonials_bg')):
  $testimonials_bg_fid = theme_get_setting('testimonials_bg');
  $testimonials_bg_img = file_create_url(file_load($testimonials_bg_fid)->uri);
endif;

if (theme_get_setting('quote_bg')):
  $quote_bg_fid = theme_get_setting('quote_bg');
  $quote_bg_img = file_create_url(file_load($quote_bg_fid)->uri);
endif;

if (theme_get_setting('social_bg')):
  $social_bg_fid = theme_get_setting('social_bg');
  $social_bg_img = file_create_url(file_load($social_bg_fid)->uri);
endif;
?>
<?php if ($page['main_menu']): ?>
  <div class="menu-btn<?php if (theme_get_setting('menu_position') == 'left'): ?>-left<?php endif; ?>">
    <img alt="" src="<?php print $base_path . $path_to_theme; ?>/images/nav.svg">
  </div>
  <nav class="pushy pushy-<?php print (theme_get_setting('menu_position')); ?>">
    <div class="logo-small">
      <a class="inner-link" href="<?php print $front_page; ?>#home"><img class="logo nav-logo"  alt="<?php print $site_name; ?>" src="<?php print $logo; ?>" ></a><br>
    </div>
    <?php print render($page['main_menu']); ?>
    <?php if(theme_get_setting('menu_line_1') || theme_get_setting('menu_line_2') || theme_get_setting('menu_line_3')): ?>
      <div class="bottom-content">
        <ul class="contact-details">
          <?php if(theme_get_setting('menu_line_1')): ?><li><?php print(theme_get_setting('menu_line_1')); ?></li><?php endif; ?>
          <?php if(theme_get_setting('menu_line_2')): ?><li><?php print(theme_get_setting('menu_line_2')); ?></li><?php endif; ?>
          <?php if(theme_get_setting('menu_line_3')): ?><li><?php print(theme_get_setting('menu_line_3')); ?></li><?php endif; ?>
        </ul>
      </div>
    <?php endif; ?>
  </nav>
<?php endif; ?>  
<div class="site-overlay"></div>        
<section id="home">
  <div class="bg_overlay"></div>
  <div class="row">
    <div class="medium-8 medium-text-center medium-centered small-8 small-text-centered small-centered columns">
      <img class="logo" src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" /><br />
      <?php if(theme_get_setting('header_title')): ?><h3 class="white"><?php print(theme_get_setting('header_title')); ?></h3><?php endif; ?>
      <?php if(theme_get_setting('header_subtitle')): ?><p class="white"><?php print(theme_get_setting('header_subtitle')); ?></p><?php endif; ?>
    </div>
  </div>
</section>
<div id="wrapper">
  <?php if ($messages): ?>
    <div id="messages" class="row">
      <?php print $messages; ?>
    </div>
  <?php endif; ?>
  <section><div class="row">
    <?php print render($page['content']); ?>
  </div></section>
  <?php if(theme_get_setting('copyright')): ?>
    <footer>
      <div class="row text-center">
        <h5 class="text-center"><?php print(theme_get_setting('copyright')); ?></h5>
      </div>
    </footer>
  <?php endif; ?>
</div><!-- /.wrapper -->
