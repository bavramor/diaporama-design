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
 * Include the central template.inc with global theme functions.
 */
require_once(DRUPAL_ROOT . '/' . drupal_get_path('theme', 'yaml') . '/template.inc');

/**
 * Add theme CSS files.
 */
function _yaml_3col_132_add_css($variables = array()) {

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
  drupal_add_css($theme_path . '/css/screen/screen-132-fullpage-layout.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/screen/screen-dynamic-layout-switching.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/screen/screen-drupal.css', array('group' => CSS_THEME));

  // Add custom module styles
  _yaml_add_css_modules($theme_path);

  // Add print CSS files
  drupal_add_css($theme_path . '/css/print/print.css', array('group' => CSS_THEME));
  drupal_add_css($theme_path . '/css/print/print_drupal.css', array('group' => CSS_THEME));

  // Add your custom style if you do not like to alter the existing styles.
  // NOTE: Expect flashing predefined styles with CSS compression disabled.
  //drupal_add_css($theme_path . '/css/screen/screen-mysite.css', array('group' => CSS_THEME, 'weight' => (CSS_THEME + 100)));

  // Add conditional CSS for IE7 and below.
  $file_suffix = (variable_get('preprocess_css', FALSE) ? '.min' : '');
  drupal_add_css($theme_path . '/css/core/iehacks' . $file_suffix . '.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'weight' => 999, 'preprocess' => FALSE));

  // Add theme settings.
  $settings = _yaml_get_css_themesettings('132', 'fullpage');
  if (!empty($settings)) {
    drupal_add_css($settings, array('type' => 'inline', 'group' => CSS_THEME, 'weight' => 999));
  }
}