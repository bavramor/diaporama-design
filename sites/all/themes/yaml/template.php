<?php

/**
 * @file
 * "Yet Another Multicolumn Layout" for Drupal
 *
 * (en) Central template for theme specific functions
 * (de) Zentrales Template für theme spezifische Funktionen
 *
 * @copyright       Copyright 2006-2012, Alexander Hass
 * @license         http://www.yaml-fuer-drupal.de/en/terms-of-use
 * @link            http://www.yaml-for-drupal.com
 * @package         yaml-for-drupal
 * @version         7.x-4.0.1.16
 * @lastmodified    2012/03/06
 */

/**
 * Include the central template.inc with global theme functions
 */
require_once(DRUPAL_ROOT . '/' . drupal_get_path('theme', 'yaml') . '/template.inc');
require_once(DRUPAL_ROOT . '/' . drupal_get_path('theme', 'yaml') . '/theme.form.inc');

/**
 * Override or insert variables into the maintenance page template.
 */
function yaml_preprocess_maintenance_page(&$variables) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // yaml_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  yaml_preprocess_html($variables);
}

/**
 * Override or insert variables into the html template.
 */
function yaml_preprocess_html(&$variables) {
  global $user, $theme;
  $theme_path = drupal_get_path('theme', 'yaml');

  // Load the XML prolog for standard compliant browsers if caching is inactive.
  // The function page_set_cache() does not cache pages if $user->uid has a value.
  // Additional the XML prolog can only added to YAML for Drupal if a user is
  // logged into Drupal (caching inactive) or caching is globaly disabled on the site.
  if ((_yaml_browser_xml_prolog_compliant() && $user->uid) || (_yaml_browser_xml_prolog_compliant() && !(variable_get('cache', 0)))) {
    $variables['xml_prolog'] = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
  }

  // Add mobile viewport optimisation.
  $viewport = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1.0',
    )
  );
  drupal_add_html_head($viewport, 'viewport');

  // Add YAML Theme styles.
  $yaml_css_function = '_' . $theme . '_add_css';
  if (function_exists($yaml_css_function)) {
    $yaml_css_function($variables);
  }

  // html5shim:
  // HTML5 is supported by all modern browsers. To enable Internet Explorer 6-8
  // to render HTML5 elements correctly, JavaScript is mandatory to register
  // the new elements so that the browser allows them to be styled with CSS.
  //drupal_add_js('//html5shim.googlecode.com/svn/trunk/html5.js', array('type' => 'external', 'browsers' => array('IE' => 'lt IE 9', '!IE' => FALSE)));
  drupal_add_js($theme_path . '/js/html5shiv-printshiv.js', array('type' => 'file', 'browsers' => array('IE' => 'lt IE 9', '!IE' => FALSE)));

  // Add YAML focusFix.
  drupal_add_js($theme_path . '/js/yaml-focusfix.js', array('type' => 'file', 'scope' => 'footer'));
}

/**
 * Alter some Drupal variables required by Theme.
 */
function yaml_preprocess_page(&$variables) {
  // Theme primary menu.
  if (isset($variables['main_menu'])) {
    $variables['primary_nav'] = theme('links__system_main_menu', array(
        'links' => $variables['main_menu'],
        'attributes' => array(
          'class' => array('main-menu', 'links'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $variables['primary_nav'] = FALSE;
  }

  // Theme secondary menu.
  if (isset($variables['secondary_menu'])) {
    $variables['secondary_nav'] = theme('links__system_secondary_menu', array(
        'links' => $variables['secondary_menu'],
        'attributes' => array(
          'class' => array('secondary-menu', 'links', 'inline', 'float-right'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $variables['secondary_nav'] = FALSE;
  }

  // Add YAML footer links required for CC license.
  $variables['page']['footer']['yaml_backlinks'] = array(
    '#type' => 'markup',
    '#markup' => _yaml_backlinks(),
  );
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function yaml_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    $output .= '<div class="breadcrumb"><span>' . implode(' › ', $breadcrumb) . '</span></div>';
    return $output;
  }
}

/**
 * Implements theme_links__content_type().
 *
 * Styling the node links shown in the node footer by adding CSS classes.
 */
function yaml_links__node($variables) {

  foreach ($variables['links'] as $name => $values) {
    switch ($name) {
      case 'node-readmore':
        $variables['links'][$name]['attributes']['class'][] = 'ym-button';
        $variables['links'][$name]['attributes']['class'][] = 'ym-next';
        break;

      case 'comment-add':
        $variables['links'][$name]['attributes']['class'][] = 'ym-button';
        $variables['links'][$name]['attributes']['class'][] = 'ym-add';
        break;

      case 'comment-comments':
        $variables['links'][$name]['attributes']['class'][] = 'ym-button';
        $variables['links'][$name]['attributes']['class'][] = 'ym-edit';
        break;

      default:
        //$variables['links'][$name]['attributes']['class'][] = 'ym-button';
    }
  }

  return theme('links', $variables);
}

/**
 * Implements theme_links__locale_block().
 *
 * Styling the language switcher block.
 */
function yaml_links__locale_block($variables) {
  $variables['attributes']['class'][] = 'inline';
  $variables['attributes']['class'][] = 'float-right';

  return theme('links', $variables);
}

/**
 * Implements theme_field__field_type().
 */
function yaml_field__taxonomy_term_reference($variables) {
  $output = '<ul class="links inline">';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<li class="field-label">' . $variables['label'] . ':</li>';
  }

  // Render the items.
  foreach ($variables['items'] as $delta => $item) {
    $output .= '<li class="taxonomy-term-references taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }
  $output .= '</ul>';

  return $output;
}

/**
 * Override or insert variables into the block template.
 */
function yaml_preprocess_block(&$variables) {
  $block = $variables['elements']['#block'];

  // D8 Backport: Add default class for block content.
  // See bug http://drupal.org/node/1286532
  $variables['content_attributes_array']['class'][] = 'content';

  switch ($variables['block_html_id']) {
    case 'block-system-navigation':
    case 'block-system-user-menu':
      $variables['classes_array'][] = 'ym-noprint';
      $variables['title_attributes_array']['class'][] = 'ym-vtitle';
      $variables['content_attributes_array']['class'][] = 'ym-vlist';
      break;

    case 'block-user-login':
      $variables['classes_array'][] = 'ym-noprint';
      // Hide the title in these self explaining form.
      $variables['title_attributes_array']['class'][] = 'element-invisible';
      break;
  }

}

/**
 * Override or insert variables into the comment template.
 */
function yaml_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];

  // D8 Backport: Add default class for comment content.
  // See bug http://drupal.org/node/1286532 (releated)
  $variables['classes_array'][] = 'ym-clearfix';
  $variables['content_attributes_array']['class'][] = 'content';

  // Add custom date created block.
  //$variables['submitted'] = _yaml_build_created_date($comment->created);
}

/**
 * Override or insert variables into the node template.
 */
function yaml_preprocess_node(&$variables) {
  $node = $variables['elements']['#node'];

  // D8 Backport: Add default class for node content.
  // See bug http://drupal.org/node/1286532 (releated)
  $variables['classes_array'][] = 'ym-clearfix';
  $variables['content_attributes_array']['class'][] = 'content';

  // Add custom date created block.
  //$variables['submitted'] = _yaml_build_created_date($node->created);
}

/**
 * Returns HTML for a wrapper for a menu sub-tree.
 */
function yaml_menu_tree($variables) {
  return '<ul class="ym-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Returns HTML for for a custom date block.
 *
 * @param int $timestamp
 * 	A timestamp that should be themed.
 */
function _yaml_build_created_date($timestamp) {
  if (is_numeric($timestamp)) {
    $output = '<div class="date">';
    $output .= '<span class="month">' . format_date($timestamp, 'custom', 'M') . '</span>';
    $output .= '<span class="day">' . format_date($timestamp, 'custom', 'd') . '</span>';
    $output .= '<span class="year">' . format_date($timestamp, 'custom', 'Y') . '</span>';
    $output .= '</div>';
    return $output;
  }
}

/**
 * Implements hook_css_alter().
 *
 * Remove CSS files that may clash with the yaml theme.
 */
function yaml_css_alter(&$css) {
  // Drupal Core
  //unset($css[drupal_get_path('module', 'system') . '/system.base.css']);
  //unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
  //unset($css[drupal_get_path('module', 'system') . '/system.messages.css']);
  //unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
}

/**
 * Add theme CSS files
 */
function _yaml_add_css($variables = array()) {

  $theme_path = drupal_get_path('theme', 'yaml');

  // Override Drupal Core.
  drupal_add_css($theme_path . '/css/modules/system.menus.css');
  drupal_add_css($theme_path . '/css/modules/system.theme.css');

  // Add Google Font
  //drupal_add_css('http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700|Droid+Sans:700', array('group' => CSS_THEME, 'type' => 'external'));
  drupal_add_css($theme_path . '/css/fonts/droidserif.css');

  // Add YAML Core and layout specific styles.
  drupal_add_css($theme_path . '/css/core/base.css', array('group' => CSS_THEME));

  // Add horizontal navigations.
  $yaml_nav_primary = theme_get_setting('yaml_nav_primary');
  if ($yaml_nav_primary == 1) {
    // There are currently no additional navigations available, add here if you create your own.
  }
  else {
    drupal_add_css($theme_path . '/css/navigation/hlist-drupal.css', array('group' => CSS_THEME));
  }

  // Add vertical navigations.
  $yaml_nav_vertical = theme_get_setting('yaml_nav_vertical');
  if ($yaml_nav_vertical == 1) {
    // There are currently no additional navigations available, add here if you create your own.
  }
  else {
    drupal_add_css($theme_path . '/css/navigation/vlist-drupal.css', array('group' => CSS_THEME));
  }

  drupal_add_css($theme_path . '/css/forms/gray-theme-drupal.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/add-ons/microformats/microformats.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/screen/typography.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/screen/screen-132-page-layout.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/screen/screen-dynamic-layout-switching.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/screen/screen-drupal.css', array('group' => CSS_THEME));

  // Add custom module styles.
  _yaml_add_css_modules($theme_path);

  // Add print CSS files.
  drupal_add_css($theme_path . '/css/print/print.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/print/print_drupal.css', array('group' => CSS_THEME));

  // Add your custom style if you do not like to alter the existing styles.
  // NOTE: Expect flashing predefined styles with CSS compression disabled.
  //drupal_add_css($theme_path . '/css/screen/screen-mysite.css', array('group' => CSS_THEME, 'weight' => (CSS_THEME + 100)));

  // Add conditional CSS for IE7 and below.
  $file_suffix = (variable_get('preprocess_css', FALSE) ? '.min' : '');
  drupal_add_css($theme_path . '/css/core/iehacks' . $file_suffix . '.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'weight' => 999, 'preprocess' => FALSE));

  // Add theme settings.
  $settings = _yaml_get_css_themesettings('132', 'page');
  if (!empty($settings)) {
    drupal_add_css($settings, array('type' => 'inline', 'group' => CSS_THEME, 'weight' => 999));
  }
}