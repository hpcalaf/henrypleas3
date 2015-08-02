<?php
function kurr_form_system_theme_settings_alter(&$form, &$form_state) {
  // Cocoon Options
  $form['cocoon_options'] = array(
      '#type' => 'vertical_tabs',
      '#title' => t('Cocoon Theme Options'),
      '#weight' => 0,
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
  );
  // Cocoon Theme Skin Panel
  $form['cocoon_options']['cocoon_skin'] = array(
    '#type' => 'fieldset', 
    '#title' => t('Cocoon Theme Skin'), 
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  // Cocoon Theme Skin Panel: Select Skin
  $form['cocoon_options']['cocoon_skin']['skin'] = array(
    '#type' => 'select',
    '#title' => t('Select Skin'),
    '#description' => t('Choose a default skin color for the theme.'),
    '#options' => array(
      'brown' => t('Brown'),
      'green' => t('Green'),
      'orange' => t('Orange'),
      'red' => t('Red'),
      'turquoise' => t('Turquoise'),
      'violet' => t('Violet'),
    ),
    '#default_value' => theme_get_setting('skin'),
  );
  // Cocoon Theme Skin Panel: Color
  $form['cocoon_options']['cocoon_skin']['color'] = array(
    '#type' => 'select',
    '#title' => t('Base Color'),
    '#description' => t('Choose a base color for the theme.'),
    '#options' => array(
      'light' => t('Light'),
      'dark' => t('Dark'),
    ),
    '#default_value' => theme_get_setting('color'),
  );

  // Cocoon Theme Skin Panel: Menu Position
  $form['cocoon_options']['cocoon_skin']['menu_position'] = array(
    '#type' => 'select',
    '#title' => t('Menu Position'),
    '#description' => t('Choose a position for the menu.'),
    '#options' => array(
      'left' => t('Left'),
      'right' => t('Right'),
    ),
    '#default_value' => theme_get_setting('menu_position'),
  );
  // Cocoon Theme Skin Panel: Custom CSS
  $form['cocoon_options']['cocoon_skin']['custom_css'] = array(
    '#type' => 'textarea', 
    '#title' => t('Custom CSS'), 
    '#description' => t('Specify custom CSS tags and styling to apply to the theme. You can also override default styles here.'),
    '#rows' => '5',
    '#default_value' => theme_get_setting('custom_css'),
  );
  // Cocoon Theme Features Panel
  $form['cocoon_options']['cocoon_features'] = array(
    '#type' => 'fieldset', 
    '#title' => t('Cocoon Theme Features'), 
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  // Cocoon Theme Features Panel: Header title
  $form['cocoon_options']['cocoon_features']['header_title'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Header Title'),
    '#default_value' => theme_get_setting('header_title'),
    '#description'   => t("Title in the header."),
  );
  // Cocoon Theme Features Panel: Header subtitle
  $form['cocoon_options']['cocoon_features']['header_subtitle'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Header Subtitle'),
    '#default_value' => theme_get_setting('header_subtitle'),
    '#description'   => t("Subtitle in the header."),
  );
  // Cocoon Theme Features Panel: Copyright
  $form['cocoon_options']['cocoon_features']['copyright'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Footer Copyright Message'),
    '#default_value' => theme_get_setting('copyright'),
    '#description'   => t("The copyright/disclaimer text in the footer."),
  );
  // Cocoon Theme Features Panel: Menu info line 1 
  $form['cocoon_options']['cocoon_features']['menu_line_1'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Menu Info Line 1'),
    '#default_value' => theme_get_setting('menu_line_1'),
    '#description'   => t("First line of menu info. You may include HTML."),
  );
  // Cocoon Theme Features Panel: Menu info line 2
  $form['cocoon_options']['cocoon_features']['menu_line_2'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Menu Info Line 2'),
    '#default_value' => theme_get_setting('menu_line_2'),
    '#description'   => t("Second line of menu info. You may include HTML."),
  );
  // Cocoon Theme Features Panel: Menu info line 3
  $form['cocoon_options']['cocoon_features']['menu_line_3'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Menu Info Line 3'),
    '#default_value' => theme_get_setting('menu_line_3'),
    '#description'   => t("Third line of menu info. You may include HTML."),
  );
  // Cocoon Theme Features Panel: Preloader
  $form['cocoon_options']['cocoon_features']['preloader'] = array(
    '#type' => 'select',
    '#title' => t('Homepage Preloader'),
    '#description' => t('Display loading screen while page loads?'),
    '#options' => array(
      0 => t('No'),
      1 => t('Yes'),
    ),
    '#default_value' => theme_get_setting('preloader'),
  );
  // Cocoon Theme Features Panel: Testimonials BG
  $form['cocoon_options']['cocoon_features']['testimonials_bg'] = array(
    '#type'     => 'managed_file',
    '#title'    => t('Testimonials Background Image'),
    '#description'   => t('Upload a background image for the testimonials section.'),
    '#required' => FALSE,
    '#upload_location' => 'public://kurr/backgrounds',
    '#default_value' => theme_get_setting('testimonials_bg'), 
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );
  // Cocoon Theme Features Panel: Quote BG
  $form['cocoon_options']['cocoon_features']['quote_bg'] = array(
    '#type'     => 'managed_file',
    '#title'    => t('Quote Background Image'),
    '#description'   => t('Upload a background image for the quote section.'),
    '#required' => FALSE,
    '#upload_location' => 'public://kurr/backgrounds',
    '#default_value' => theme_get_setting('quote_bg'), 
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );
  // Cocoon Theme Features Panel: Social BG
  $form['cocoon_options']['cocoon_features']['social_bg'] = array(
    '#type'     => 'managed_file',
    '#title'    => t('Social Links Background Image'),
    '#description'   => t('Upload a background image for the social links section.'),
    '#required' => FALSE,
    '#upload_location' => 'public://kurr/backgrounds',
    '#default_value' => theme_get_setting('social_bg'), 
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );
  $form['cocoon_branding'] = array(
    '#prefix' => '<div class="cocoon-branding">',
    '#markup' => '<span>Created by Cocoon</span>',
    '#suffix' => '</div>',
    '#weight' => -100,
  );

  $path_to_theme = drupal_get_path('theme','kurr');
  $form['#attached'] = array(
    'css' => array(
      $path_to_theme . '/css/cocoon-theme-settings.css'
    ),
  );

  $form['cocoon_options']['drupal_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Drupal Core Settings'),
  );

  $form['cocoon_options']['drupal_settings']['theme_settings'] = $form['theme_settings'];
  $form['cocoon_options']['drupal_settings']['logo_settings']['logo'] = $form['logo'];
  $form['cocoon_options']['drupal_settings']['favicon'] = $form['favicon'];
  unset($form['theme_settings']);
  unset($form['logo']);
  unset($form['favicon']);

  $form['#submit'][] = 'kurr_settings_form_submit';

  // Get all themes.
  $themes = list_themes();

  // Get the current theme
  $active_theme = $GLOBALS['theme_key'];
  $form_state['build_info']['files'][] = str_replace("/$active_theme.info", '', $themes[$active_theme]->filename) . '/theme-settings.php';
}

function kurr_settings_form_submit(&$form, $form_state) {

  $testimonials_bg_image_fid = $form_state['values']['testimonials_bg'];
  $testimonials_bg_image = file_load($testimonials_bg_image_fid);
  if (is_object($testimonials_bg_image)) {
    // Check to make sure that the file is set to be permanent.
    if ($testimonials_bg_image->status == 0) {
      // Update the status.
      $testimonials_bg_image->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($testimonials_bg_image);
      // Add a reference to prevent warnings.
      file_usage_add($testimonials_bg_image, 'kurr', 'theme', 1);
    }
  }

  $quote_bg_image_fid = $form_state['values']['quote_bg'];
  $quote_bg_image = file_load($quote_bg_image_fid);
  if (is_object($quote_bg_image)) {
    // Check to make sure that the file is set to be permanent.
    if ($quote_bg_image->status == 0) {
      // Update the status.
      $quote_bg_image->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($quote_bg_image);
      // Add a reference to prevent warnings.
      file_usage_add($quote_bg_image, 'kurr', 'theme', 1);
    }
  }

  $social_bg_image_fid = $form_state['values']['social_bg'];
  $social_bg_image = file_load($social_bg_image_fid);
  if (is_object($social_bg_image)) {
    // Check to make sure that the file is set to be permanent.
    if ($social_bg_image->status == 0) {
      // Update the status.
      $social_bg_image->status = FILE_STATUS_PERMANENT;
      // Save the update.
      file_save($social_bg_image);
      // Add a reference to prevent warnings.
      file_usage_add($social_bg_image, 'kurr', 'theme', 1);
    }
  }

}
?>
