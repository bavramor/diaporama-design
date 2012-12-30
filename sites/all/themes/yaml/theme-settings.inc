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
 * Form for theme settings configuration.
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 * @param $column_order
 *   The order of layout columns. If the value is blank
 *   there are no inputs shown.
 */
function _yaml_get_themesettings_form(&$form, &$form_state, $column_order = '') {

  // Set the default values for theme variables.
  $defaults = array(
    'yaml_layout_page_width_min' => '760px',
    'yaml_layout_page_width_max' => '80em',
    'yaml_layout_page_width_col1' => '25%',
    'yaml_layout_page_width_col2' => 'auto',
    'yaml_layout_page_width_col3' => '25%',
    'yaml_layout_page_align' => 'center',
  );

  // Create the form using Form API
  $form['layout'] = array(
    '#type' => 'fieldset',
    '#title' => t('Layout'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#description' => t('Leave the following defaults if you edit the screen-foo.css file directly. In this case there will be no extra inline settings added to the page by this configuration module.'),
    '#attributes' => array('id' => 'theme-settings-layout')
  );
  $form['layout']['yaml_layout_page_align'] = array(
    '#type' => 'select',
    '#title' => t('Page alignment'),
    '#default_value' => theme_get_setting('yaml_layout_page_align'),
    '#options' => array(
      'left' => t('left'),
      'center' => t('center'),
      'right' => t('right'),
    ),
    '#description' => t('Align the page to right, center or left. Default: "@default".', array('@default' => $defaults['yaml_layout_page_align'])),
  );
  $form['layout']['yaml_layout_page_width_min'] = array(
    '#type' => 'textfield',
    '#title' => t('Page min-width'),
    '#default_value' => theme_get_setting('yaml_layout_page_width_min'),
    '#description' => t('Defines the minium page width in <em>px</em> or <em>em</em>. Default: "@default".', array('@default' => $defaults['yaml_layout_page_width_min'])),
    '#required' => TRUE,
    '#size' => '10'
  );
  $form['layout']['yaml_layout_page_width_max'] = array(
    '#type' => 'textfield',
    '#title' => t('Page max-width'),
    '#default_value' => theme_get_setting('yaml_layout_page_width_max'),
    '#description' => t('Defines the maximum page width in <em>px</em> or <em>em</em>. Default: "@default".', array('@default' => $defaults['yaml_layout_page_width_max'])),
    '#required' => TRUE,
    '#size' => '10',
    '#suffix' => '<hr />'
  );

  switch ($column_order) {
    case '132':
      $form['layout']['yaml_layout_page_width_col1'] = array(
        '#type' => 'textfield',
        '#title' => t('Left sidebar'),
        '#default_value' => theme_get_setting('yaml_layout_page_width_col1'),
        '#description' => t('Defines the left column width in <em>px</em>, <em>em</em> or <em>%</em>. Default: "@default".', array('@default' => $defaults['yaml_layout_page_width_col1'])),
        '#required' => TRUE,
        '#size' => '10'
      );
      $form['layout']['yaml_layout_page_width_col2'] = array(
        '#type' => 'textfield',
        '#title' => t('Content'),
        '#default_value' => theme_get_setting('yaml_layout_page_width_col2'),
        '#attributes' => array(
          'readonly' => 'readonly',
        ),
        '#disabled' => TRUE,
        '#size' => '10'
      );
      $form['layout']['yaml_layout_page_width_col3'] = array(
        '#type' => 'textfield',
        '#title' => t('Right sidebar'),
        '#default_value' => theme_get_setting('yaml_layout_page_width_col3'),
        '#description' => t('Defines the right column width in <em>px</em>, <em>em</em> or <em>%</em>. Default: "@default".', array('@default' => $defaults['yaml_layout_page_width_col3'])),
        '#required' => TRUE,
        '#size' => '10',
      );
      break;
  }

  $form['navigation'] = array(
    '#type' => 'fieldset',
    '#title' => t('Navigation'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['navigation']['yaml_nav_primary'] = array(
    '#type' => 'select',
    '#title' => t('Menu containing main navigation links'),
    '#default_value' => theme_get_setting('yaml_nav_primary'),
    '#options' => array(
      '0' => 'hlist-drupal.css',
    ),
  );
  $form['navigation']['yaml_nav_vertical'] = array(
    '#type' => 'select',
    '#title' => t('Menu containing vertical navigation links'),
    '#default_value' => theme_get_setting('yaml_nav_vertical'),
    '#options' => array(
      '0' => 'vlist-drupal.css',
    ),
  );

  $form['forms'] = array(
      '#type' => 'fieldset',
      '#title' => t('Forms'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
  );
  $form['forms']['yaml_form_style'] = array(
    '#type' => 'select',
    '#title' => t('Form style'),
    '#default_value' => theme_get_setting('yaml_form_style'),
    '#options' => array(
      'linear' => t('Linear (default)'),
      'full' => t('Full width (.ym-full)'),
      'columnar' => t('Columnar (.ym-columnar)'),
    ),
    '#description' => t('<ul><li>Linear: The default form style provides a stacked view of labels and their related form elements. The width of all form elements is normalized to 60% width.</li><li>Full width: This form style also provides a stacked view of labels and their related form elements, but the width of all form elements is normalized to 100% width. This form style is especially useful for small forms.</li><li>Columnar: This form style provides a columnar arrangement of form elemnts. By default , labels are floated and left aligned.</li><ul>'),
  );

  // Add miscellaneous settings
  $form['misc'] = array(
    '#type' => 'fieldset',
    '#title' => t('Miscellaneous'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['misc']['yaml_display_link_license_yaml'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display YAML Framework link'),
    '#default_value' => theme_get_setting('yaml_display_link_license_yaml'),
    '#description' => t('This back linking maybe only removed, if you possess a YAML Framework license.'),
    '#prefix' => '<p>' . t('<strong>License and terms of use:</strong><br />The YAML Framework and YAML for Drupal are licensed under a <a href="@lic_cc">Creative Commons</a> license. For more information see the following licenses and terms of use.</p><p>YAML Framework - <a href="@lic_yaml">@lic_yaml</a><br />YAML for Drupal - <a href="@lic_yamlfd">@lic_yamlfd</a>', array('@lic_cc' => t('http://creativecommons.org/licenses/by-nc-sa/2.0/'), '@lic_yaml' => t('http://www.yaml.de/en/license/license-conditions.html'), '@lic_yamlfd' => t('http://www.yaml-fuer-drupal.de/en/terms-of-use'))) . '</p>',
  );
  $form['misc']['yaml_display_link_license_yamlfd'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display YAML for Drupal link'),
    '#default_value' => theme_get_setting('yaml_display_link_license_yamlfd'),
    '#description' => t('This back linking maybe only removed, if you have possess a YAML for Drupal license.'),
  );

}
