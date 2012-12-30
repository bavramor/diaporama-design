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
    $output = '<aside id="block-yaml-links" class="block block-system">';
    $output .= '<div class="content">';
    $output .= '<span>' . t('Layout based on <a href="@yaml">YAML</a> and <a href="@yamlfd">YAML for Drupal</a>', array('@yaml' => 'http://www.yaml.de', '@yamlfd' => 'http://www.yaml-fuer-drupal.de')) . '</span>';
    $output .= '</aside>';
    return $output;
  }
}
