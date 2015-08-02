<?php

function kurr_preprocess_html(&$variables)
{
  // Add variables for path to theme.
  $variables['base_path'] = base_path();
  $variables['path_to_theme'] = drupal_get_path('theme', 'kurr');

  // Make regions available in html.tpl.php, use: print render($region_name)
  $variables['hero'] = block_get_blocks_by_region('hero');

}


/**
 * Unset core and contrib JS and CSS files.
 */
function kurr_css_alter(&$css) {
  // Unset Drupal core CSS files to avoid conflicts; we'll style these in the main stylesheets
  unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
  unset($css[drupal_get_path('module', 'user') . '/user.css']);
  unset($css[drupal_get_path('module', 'field') . '/theme/field.css']);
}


/**
 * Override or insert variables into the page template for specific content types.
 */
function kurr_preprocess_page(&$variables) {
  if (isset($variables['node']->type)) {
    $nodetype = $variables['node']->type;
    $variables['theme_hook_suggestions'][] = 'page__' . $nodetype;
  }
}

/**
 * Override or insert variables into the node template.
 */
function kurr_preprocess_node(&$variables)
{
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
  $stats = statistics_get($variables['node']->nid);
  $variables['stats_total_count'] = $stats['totalcount'];
}

/**
 * Override or insert variables into the block template.
 */
function kurr_preprocess_block(&$variables)
{
  // In the header region visually hide block titles.
  if ($variables['block']->region == 'header') {
    $variables['title_attributes_array']['class'][] = 'element-invisible';
  }
}

/**
 * Implements theme_field__field_type().
 */
function kurr_field__taxonomy_term_reference($variables)
{
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
  }

  // Render the items.
  $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }
  $output .= '</ul>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '"' . $variables['attributes'] . '>' . $output . '</div>';

  return $output;
}

/**
 * Implements theme_menu_tree().
 */
function kurr_menu_tree($variables)
{
  return '<ul class="menu clearfix">' . $variables['tree'] . '</ul>';
}

// Disabling the default system main menu
function kurr_links__system_main_menu() {
  return null;
}

// main-menu: Adding classes to main <ul>
function kurr_menu_tree__main_menu($variables) {
  return '<ul class="menu">'.$variables['tree'].'</ul>';
}

// main-menu: Adding classes to dropdown <ul>
function kurr_menu_tree__main_menu_inner($variables) {
    return '<ul class="dropdown-menu" role="menu">' . $variables['tree'] . '</ul>';
}

// main-menu: Theming menu links
function kurr_menu_link__main_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    foreach ($element['#below'] as $key => $val) {
      if (is_numeric($key)) {             
        $element['#below'][$key]['#theme'] = 'menu_link__main_menu_inner'; // Second level <li>
      }
    }
    $element['#below']['#theme_wrappers'][0] = 'menu_tree__main_menu_inner';  // Second level <ul>
    $sub_menu = drupal_render($element['#below']);
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '><span class="dropdown-toggle" data-toggle="dropdown">' . $output . '<b class="caret"></b></span>' . $sub_menu . "</li>\n";
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

// main-menu: Theming inner menu links
function kurr_menu_link__main_menu_inner(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  $element['#localized_options']['html'] = TRUE;
  $linktext = '<span>' . $element['#title'] . '</span>';

  $output = l($linktext, $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Form alter
 */
function kurr_form_alter(&$form, &$form_state, $form_id)
{
  // Main contact form
  if ($form_id == 'contact_site_form') {
    $form['#attributes'] = array('class' => 'col-md-6 col-md-offset-3 text-center wow fadeInUp animated');
    $form['name']['#attributes']['placeholder'] = t('Name');
    $form['mail']['#attributes']['placeholder'] = t('Email');
    $form['subject']['#attributes']['placeholder'] = t('Subject');
    $form['message']['#attributes']['placeholder'] = t('Message');
    unset($form['name']['#title']);
    unset($form['mail']['#title']);
    unset($form['subject']['#title']);
    unset($form['message']['#title']);
    $form['message']['#resizable'] = FALSE;
  }
  // Search page form
  if ($form_id == 'search_form') {
    // Adding placeholders to fields
    $form['basic']['keys']['#attributes']['placeholder'] = t('Enter some terms...');
    $form['advanced']['keywords']['or']['#attributes']['placeholder'] = t('e.g. bike, shed');
    $form['advanced']['keywords']['phrase']['#attributes']['placeholder'] = t('e.g. outside the bike shed');
    $form['advanced']['keywords']['negative']['#attributes']['placeholder'] = t('e.g. bicycle');
    unset($form['basic']['keys']['#title']);
  }
  // Search form block 
  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#attributes']['placeholder'] = t('Search Blog');
    $form['search_block_form']['#attributes']['class'][] = 'form-control search';

    // Hide main search button, but don't unset
    hide($form['actions']['submit']);

    $form['button'] = array(
      '#prefix' => '<span class="input-group-btn"><button type="submit" id="edit-submit" name="op" class="btn search-button"><span class="ion-search">',
      '#suffix' => '</span></button></span>',
      '#markup' => '', // Required to force the element to render
      '#weight' => 1000,
    );
  }
  // SIMPLENEWS SUBSCRIPTION FORM (FOOTER NEWSLETTER BLOCK: 1)
  $newsletter_subscription_id = theme_get_setting('newsletter_subscription_id');

  if ($form_id == 'simplenews_block_form_' . $newsletter_subscription_id) {
    $form['mail']['#attributes']['placeholder'] = t('Your Email Address');
    $form['submit']['#attributes']['class'][] = 'subscribe-form-submit btn-primary-full';
    $form['submit']['#attributes']['data-loading-text'] = 'Loading...';
    $form['submit']['#ajax'] = array(
      //'callback' => 'simplenews_block_form_ajax_submit_' . $newsletter_subscription_id,
      'callback' => 'simplenews_block_form_ajax_submit_1',
      'wrapper' => 'block-simplenews-' . variable_get('simplenews_id', $newsletter_subscription_id),
      'method' => 'replace',
      'effect' => 'fade',
      'progress' => array('type' => 'none'),
      'event' => 'click',
    );
    $form['submit']['#executes_submit_callback'] = TRUE;
    unset($form['#submit']);
    unset($form['#validate']);
    unset($form['mail']['#title']);
  }
  // SIMPLENEWS SUBSCRIPTION FORM (LAUNCH PAGE BLOCK: 2)
  $launch_list_subscription_id = theme_get_setting('launch_list_subscription_id');

  if ($form_id == 'simplenews_block_form_' . $launch_list_subscription_id) {
    $form['#attributes']['class'][] = 'input-group';
    $form['mail']['#attributes']['placeholder'] = t('Your Email Address');
    $form['submit']['#attributes']['class'][] = 'subscribe-form-submit btn-primary-full';
    $form['submit']['#attributes']['data-loading-text'] = 'Loading...';
    $form['submit']['#prefix'] = '<span class="input-group-btn sign-btn">';
    $form['submit']['#suffix'] = '</span>';
    $form['submit']['#ajax'] = array(
      'callback' => 'simplenews_block_form_ajax_submit_2',
      'wrapper' => 'block-simplenews-' . variable_get('simplenews_id', $launch_list_subscription_id),
      'method' => 'replace',
      'effect' => 'fade',
      'progress' => array('type' => 'none'),
      'event' => 'click',
    );
    $form['submit']['#executes_submit_callback'] = TRUE;
    unset($form['#submit']);
    unset($form['#validate']);
    unset($form['mail']['#title']);
  }
}

/**
 * AJAX CALLBACK: SIMPLENEWS SUBSCRIPTION FORM (FOOTER NEWSLETTER BLOCK: 1)
 */
function simplenews_block_form_ajax_submit_1($form, $form_state) {
  $newsletter_subscription_id = theme_get_setting('newsletter_subscription_id');

  $return = '<div id="block-simplenews-'. $newsletter_subscription_id.' " class="block block-simplenews">';
  $return .= '<h2>' . t('Newsletter') . '</h2>';
  if (!valid_email_address($form_state['values']['mail'])) {
    $return .= '<div class="form-validation alert alert-danger">' . t('The e-mail address is not valid.') . '</div>';
    return $return . render($form);
  }
  else {
    if (module_exists('simplenews')) {
      module_load_include('inc', 'simplenews', 'views/simplenews.subscription');
      $tid = $form['#tid'];
      $account = simplenews_load_user_by_mail($form_state['values']['mail']);
      $confirm = simplenews_require_double_opt_in($tid, $account);

      switch ($form_state['values']['action']) {
        case 'subscribe':
          simplenews_subscribe_user($form_state['values']['mail'], $tid, $confirm, 'website');
          if ($confirm) {
            $return .= '<div class="form-validation alert alert-success">' . t('Success! Please check your e-mail to complete your subscription.') . '</div>';
            return $return . render($form);
          }
          else {
            $return .= '<div class="form-validation alert alert-success">' . t('Success! You\'ve been subscribed to our newsletter.') . '</div>';
            return $return . '<input disabled class="subscribe-form-submit btn-primary-full btn submit ajax-processed" data-loading-text="Loading..." type="submit" id="edit-submit" name="op" value="Subscribed">';
          }
        break;
        case 'unsubscribe':
          simplenews_unsubscribe_user($form_state['values']['mail'], $tid, $confirm, 'website');
          if ($confirm) {
            $return .= '<div class="form-validation alert alert-success">' . t('You\'re nearly there. Please check your e-mail to confirm.') . '</div>';
            return $return . render($form);
          }
          else {
            $return .= '<div class="form-validation alert alert-success">' . t('OK, you\'re unsubscribed. Sorry to see you go.') . '</div>';
            return $return . '<input disabled class="subscribe-form-submit btn-primary-full btn submit ajax-processed" data-loading-text="Loading..." type="submit" id="edit-submit" name="op" value="Unsubscribed">';
          }
        break;
      }
    }
  }
  $return .= render($form);
  $return .= '</div>';
}

/**
 * AJAX CALLBACK: SIMPLENEWS SUBSCRIPTION FORM (FOOTER NEWSLETTER BLOCK: 2)
 */
function simplenews_block_form_ajax_submit_2($form, $form_state) {
  $launch_list_subscription_id = theme_get_setting('launch_list_subscription_id');

  $return = '<div id="block-simplenews-'. $launch_list_subscription_id.'" class="block block-simplenews home-signin input-group wow fadeIn animated home-signin-return">';
  //$return .= '<h2>' . t('Newsletter') . '</h2>';
  if (!valid_email_address($form_state['values']['mail'])) {
    $return .= '<div class="form-validation alert alert-danger">' . t('The e-mail address is not valid.') . '</div>';
    return $return . render($form);
  }
  else {
    if (module_exists('simplenews')) {
      module_load_include('inc', 'simplenews', 'views/simplenews.subscription');
      $tid = $form['#tid'];
      $account = simplenews_load_user_by_mail($form_state['values']['mail']);
      $confirm = simplenews_require_double_opt_in($tid, $account);

      switch ($form_state['values']['action']) {
        case 'subscribe':
          simplenews_subscribe_user($form_state['values']['mail'], $tid, $confirm, 'website');
          if ($confirm) {
            $return .= '<div class="form-validation alert alert-success">' . t('Success! Please check your e-mail to complete your subscription.') . '</div>';
            return $return . render($form);
          }
          else {
            $return .= '<div class="form-validation alert alert-success">' . t('Success! You\'ve been subscribed to our newsletter.') . '</div>';
            return $return . '<input disabled class="subscribe-form-submit btn-primary-full btn submit ajax-processed" data-loading-text="Loading..." type="submit" id="edit-submit" name="op" value="Subscribed">';
          }
        break;
        case 'unsubscribe':
          simplenews_unsubscribe_user($form_state['values']['mail'], $tid, $confirm, 'website');
          if ($confirm) {
            $return .= '<div class="form-validation alert alert-success">' . t('You\'re nearly there. Please check your e-mail to confirm.') . '</div>';
            return $return . render($form);
          }
          else {
            $return .= '<div class="form-validation alert alert-success">' . t('OK, you\'re unsubscribed. Sorry to see you go.') . '</div>';
            return $return . '<input disabled class="subscribe-form-submit btn-primary-full btn submit ajax-processed" data-loading-text="Loading..." type="submit" id="edit-submit" name="op" value="Unsubscribed">';
          }
        break;
      }
    }
  }
  $return .= render($form);
  $return .= '</div>';
}

// Theming comment form
function kurr_form_comment_form_alter(&$form, &$form_state) {
  $form['comment_body'][$form['comment_body']['#language']][0]['#resizable'] = false;
  $form['comment_body']['#after_build'][] = 'kurr_configure_comment_form';
  $form['actions']['#attributes']['class'][] = 'text-center';
  $form['actions']['submit']['#attributes']['value'][] = t('SEND');
  unset($form['actions']['preview']);
  $form['author']['homepage']['#access'] = FALSE;
}

function kurr_configure_comment_form(&$form) {
  unset($form[LANGUAGE_NONE][0]['format']);
  return $form;
}

/* Theming all submit buttons */
function kurr_button($variables) {
  $element = $variables ['element'];
  $element ['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));
  $element ['#attributes']['class'][] = 'button submit';
  if (!empty($element ['#attributes']['disabled'])) {
    $element ['#attributes']['class'][] = 'form-button-disabled';
  }
  return '<input' . drupal_attributes($element ['#attributes']) . ' />';
}

/* Pager */
function kurr_pager_link($variables) {
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  // @todo l() cannot be used here, since it adds an 'active' class based on the
  //   path only (which is always the current path for pager links). Apparently,
  //   none of the pager links is active at any time - but it should still be
  //   possible to use l() here.
  // @see http://drupal.org/node/1410574
  $attributes['href'] = url($_GET['q'], array('query' => $query));
  return '<a' . drupal_attributes($attributes) . '>' . $text . '</a>';
}


/* System Tabs */
function kurr_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}
