<?php

/**
 * @file
 * "Yet Another Multicolumn Layout" for Drupal
 *
 * (en) Central template for global theme functions
 * (de) Zentrales Template für globale Theme-Funktionen
 *
 * @copyright       Copyright 2006-2012, Alexander Hass
 * @license         http://www.yaml-fuer-drupal.de/en/terms-of-use
 * @link            http://www.yaml-for-drupal.com
 * @package         yaml-for-drupal
 * @version         7.x-4.0.1.16
 * @lastmodified    2012/03/06
 */

/**
 * This snippet will add module styles if module is installed and active.
 * TODO: Add CSS only if page requires the file.
 */
function _yaml_add_css_modules($base_theme_directory = '') {

  // Add module styles if modules exists.
  // The unique module directory name should be used as CSS filename.
  // If you'd like to fully replace a module stylesheet you can simply
  // drop a file with the same name used in the module to the theme.
  // The below code only overrides specific parts of module styles.
  if (module_exists('devel')) {
    drupal_add_css($base_theme_directory . '/css/modules/yaml.devel.css', 'theme');
  }
  if (module_exists('lang_dropdown')) {
    drupal_add_css($base_theme_directory . '/css/modules/yaml.lang_dropdown.css', 'theme');
  }
  if (module_exists('project') && arg(0) == 'project') {
    drupal_add_css($base_theme_directory . '/css/modules/yaml.project.css', 'theme');
  }
  if (module_exists('service_links')) {
    drupal_add_css($base_theme_directory . '/css/modules/yaml.service_links.css', 'theme');
  }
  if (module_exists('site_map') && arg(0) == 'sitemap') {
    drupal_add_css($base_theme_directory . '/css/modules/yaml.site_map.css', 'theme');
  }
  if (module_exists('views')) {
    drupal_add_css($base_theme_directory . '/css/modules/yaml.views.css', 'theme');
  }

  // Add non Drupal.org modules here.
  // To avoid naming conflicts an underscore should be added as prefix
  // to CSS filenames of modules not contributed on drupal.org.
  // if (foo == bar) {
  //   drupal_add_css($base_theme_directory . '/css/modules/_example.css', 'theme');
  // }

}

function _yaml_get_css_themesettings($column_order = '', $page_type = 'page') {

  // Column settings
  $yaml_layout_page_width_col1 = theme_get_setting('yaml_layout_page_width_col1');
  $yaml_layout_page_width_col3 = theme_get_setting('yaml_layout_page_width_col3');

  // Page settings
  $yaml_layout_page_width_min = theme_get_setting('yaml_layout_page_width_min');
  $yaml_layout_page_width_max = theme_get_setting('yaml_layout_page_width_max');
  $yaml_layout_page_align = theme_get_setting('yaml_layout_page_align');

  $settings = '';

  switch ($column_order) {
    case '132':
      // Layouts: screen-132-page-layout.css, screen-132-fullpage-layout.css
      if ($yaml_layout_page_width_col1 != '25%' || $yaml_layout_page_width_col3 != '25%') {
        if (!empty($yaml_layout_page_width_col1)) {
          $settings .= '.sidebar-first .ym-col3 { margin-left: ' . check_plain($yaml_layout_page_width_col1) . '; margin-right: 0; }';
          $settings .= '.ym-col1 { width: ' . check_plain($yaml_layout_page_width_col1) . ' }';
        }
        if (!empty($yaml_layout_page_width_col3)) {
          $settings .= '.sidebar-second .ym-col3 { margin-left: 0; margin-right: ' . check_plain($yaml_layout_page_width_col3) . '; }';
          $settings .= '.ym-col2 { width: ' . check_plain($yaml_layout_page_width_col3) . ' }';
        }
        if (!empty($yaml_layout_page_width_col1) && !empty($yaml_layout_page_width_col3)) {
          $settings .= '.ym-col3 { margin: 0 ' . check_plain($yaml_layout_page_width_col3) . ' 0 ' . check_plain($yaml_layout_page_width_col1) . '; }';
        }
      }
      break;
  }

  if ($page_type == 'page') {
    // screen-132-page-layout.css
    switch ($yaml_layout_page_align) {
      case 'left':
        $settings .= '.ym-wrapper { margin-right: auto; margin-left: 0; min-width: ' . check_plain($yaml_layout_page_width_min) . '; max-width: ' . check_plain($yaml_layout_page_width_max) . '; }';
        break;

      case 'right':
        $settings .= '.ym-wrapper { margin-left: auto; margin-right: 0; min-width: ' . check_plain($yaml_layout_page_width_min) . '; max-width: ' . check_plain($yaml_layout_page_width_max) . '; }';
        break;

      case 'center':
        if ($yaml_layout_page_width_min != '760px' || $yaml_layout_page_width_max != '80em') {
          $settings .= '.ym-wrapper { margin: 0 auto; min-width: ' . check_plain($yaml_layout_page_width_min) . '; max-width: ' . check_plain($yaml_layout_page_width_max) . '; }';
        }
        break;
    }

    if (!empty($settings)) {
      // Set values only for media screen.
      $settings = '@media screen {' . $settings . '}';
      // Reset fallback values in modern browsers.
      $settings .= '@media screen and ( min-width: 0px ) { .ym-wrapper { min-width: 0px; } }';
    }
  }
  elseif ($page_type == 'fullpage') {
    // screen-132-fullpage-layout.css
    switch ($yaml_layout_page_align) {
      case 'left':
        $settings .= '.ym-wrapper { margin-right: auto; margin-left: 0; max-width: ' . check_plain($yaml_layout_page_width_max) . '; }';
        break;

      case 'right':
        $settings .= '.ym-wrapper { margin-left: auto; margin-right: 0; max-width: ' . check_plain($yaml_layout_page_width_max) . '; }';
        break;

      case 'center':
        if ($yaml_layout_page_width_min != '760px' || $yaml_layout_page_width_max != '80em') {
          $settings .= '.ym-wrapper { margin: 0 auto; max-width: ' . check_plain($yaml_layout_page_width_max) . '; }';
          // Fallback for missing media queries support.
          $settings .= 'body > header, body > nav, body > #breadcrumb, body > #main, body > footer { min-width: ' . check_plain($yaml_layout_page_width_min) . '; }';
        }
        break;
    }

    if (!empty($settings)) {
      // Set values only for media screen.
      $settings = '@media screen {' . $settings . '}';
      // Reset fallback values in modern browsers.
      $settings .= '@media screen and ( min-width: 0px ) { body > header, body > nav, body > #breadcrumb, body > #main, body > footer { min-width: 0; } }';
    }
  }

  return $settings;
}

/**
 * We will detect if client is Internet Explorer. Then we are able to add
 * the XML prolog for XHTML Standard Compliance Mode for other browsers.
 *
 * Today IE is the only known software we need to workaround and therefor we
 * only detect IE browser and suppose all other browsers render correctly with
 * XML prolog.
 */
function _yaml_browser_xml_prolog_compliant() {
  $ua = $_SERVER['HTTP_USER_AGENT'];

  if (preg_match('/msie/i', $ua) && !preg_match('/opera/i', $ua)) {
    // This is not an Opera pose as IE.
    $clientdata = explode(' ', stristr($ua, 'msie'));
    $client['version'] = $clientdata[1];

    if ($client['version'] >= 7) {
      // IE >= 7.0: http://blogs.msdn.com/ie/archive/2005/09/15/467901.aspx
      $xml_prolog_compliant = TRUE;
    }
    else {
      // IE <= 6.0
      $xml_prolog_compliant = FALSE;
    }
  }
  else {
    // All other browsers
    $xml_prolog_compliant = TRUE;
  }

  return $xml_prolog_compliant;
}

/**
 * Return the YAML projects backlinks.
 *
 * (en) CC licenses annotations:
 * For the free use of YAML for Drupal, a backlink to the
 * YAML for Drupal homepage (http://www.yaml-fuer-drupal.de)
 * and YAML homepage (http://www.yaml.de) in a suitable place
 * (e.g.: footer of the website or in the imprint) is required.
 *
 * For more information read the "YAML" and "YAML for Drupal" license, please.
 *
 * (de) Anmerkung zu den CC Lizenzen:
 * Für die kostenfreie Nutzung von YAML für Drupal ist die
 * Namensnennung der Autoren/Rechtsinhaber bzw. eine Rückverlinkung
 * zur YAML für Drupal-Homepage (http://www.yaml-fuer-drupal.de)
 * und YAML-Homepage (http://www.yaml.de) an geeigneter Stelle
 * (z.B.: Fußzeile der Website oder im Impressum) vorgeschrieben.
 *
 * Nähere Informationen befinden sich in der "YAML" und "YAML für Drupal" Lizenz.
 *
 * Licenses:
 * YAML - http://www.yaml.de
 * YAML for Drupal - http://www.yaml-for-drupal.com
 */
function _yaml_backlinks() {
  if (theme_get_setting('yaml_display_link_license_yaml') !== 0 && (theme_get_setting('yaml_display_link_license_yamlfd') !== 0)) {
    $output = '<div class="region region-footer">';
    $output .= '<div id="block-yaml-backlinks" class="block block-system">';
    $output .= '<div class="content">';
    $output .= '<span>' . t('Layout based on <a href="@yaml">YAML</a> and <a href="@yamlfd">YAML for Drupal</a>', array('@yaml' => 'http://www.yaml.de', '@yamlfd' => 'http://www.yaml-fuer-drupal.de')) . '</span>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
  }
}
