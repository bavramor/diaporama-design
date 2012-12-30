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
require_once(DRUPAL_ROOT . '/' . drupal_get_path('theme', 'yaml_simple') . '/template.inc');
require_once(DRUPAL_ROOT . '/' . drupal_get_path('theme', 'yaml_simple') . '/theme.form.inc');

/**
 * Override or insert variables into the maintenance page template.
 */
function yaml_simple_preprocess_maintenance_page(&$variables) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // yaml_simple_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  yaml_simple_preprocess_html($variables);
}

/**
 * Override or insert variables into the html template.
 */
function yaml_simple_preprocess_html(&$variables) {
  global $user, $theme;
  $theme_path = drupal_get_path('theme', 'yaml_simple');

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
  // Add conditional CSS for IE7 and below.
  $file_suffix = (variable_get('preprocess_css', FALSE) ? '.min' : '');
  drupal_add_css($theme_path . '/css/core/iehacks' . $file_suffix . '.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'weight' => 999, 'preprocess' => FALSE));

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
function yaml_simple_preprocess_page(&$variables) {
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
function yaml_simple_breadcrumb($variables) {
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
function yaml_simple_links__node($variables) {

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
function yaml_simple_links__locale_block($variables) {
  $variables['attributes']['class'][] = 'inline';
  $variables['attributes']['class'][] = 'float-right';

  return theme('links', $variables);
}

/**
 * Implements theme_field__field_type().
 */
function yaml_simple_field__taxonomy_term_reference($variables) {
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
function yaml_simple_preprocess_block(&$variables) {
  $block = $variables['elements']['#block'];

  // D8 Backport: Add default class for block content.
  // See bug http://drupal.org/node/1286532
  $variables['content_attributes_array']['class'][] = 'content';

  switch ($variables['block_html_id']) {
    case 'block-system-navigation':
    case 'block-system-user-menu':
    case 'block-shortcut-shortcuts':
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
function yaml_simple_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];

  // D8 Backport: Add default class for comment content.
  // See bug http://drupal.org/node/1286532 (releated)
  $variables['classes_array'][] = 'ym-clearfix';
  $variables['content_attributes_array']['class'][] = 'content';
}

/**
 * Override or insert variables into the node template.
 */
function yaml_simple_preprocess_node(&$variables) {
  $node = $variables['elements']['#node'];

  // D8 Backport: Add default class for node content.
  // See bug http://drupal.org/node/1286532 (releated)
  $variables['classes_array'][] = 'ym-clearfix';
  $variables['content_attributes_array']['class'][] = 'content';
}

/**
 * Returns HTML for a wrapper for a menu sub-tree.
 */
function yaml_simple_menu_tree($variables) {
  return '<ul class="ym-menu">' . $variables['tree'] . '</ul>';
}
