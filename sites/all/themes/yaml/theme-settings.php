<?php

/**
 * @file
 * "Yet Another Multicolumn Layout" for Drupal
 *
 * (en) Integration of Theme specific settings
 * (de) Integration von Theme spezifischen Einstellungen
 *
 * @copyright       Copyright 2006-2012, Alexander Hass
 * @license         http://www.yaml-fuer-drupal.de/en/terms-of-use
 * @link            http://www.yaml-for-drupal.com
 * @package         yaml-for-drupal
 * @version         7.x-4.0.1.16
 * @lastmodified    2012/03/06
 */

/**
 * Include the global theme-settings.inc.
 */
require_once(realpath(dirname(__FILE__) . '/theme-settings.inc'));

/**
 * Implements hook_form_FORM_ID_alter().
 */
function yaml_form_system_theme_settings_alter(&$form, &$form_state) {
  _yaml_get_themesettings_form($form, $form_state, '132');
}
