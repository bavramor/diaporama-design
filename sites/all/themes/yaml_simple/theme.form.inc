<?php

/**
 * @file
 * "Yet Another Multicolumn Layout" for Drupal
 *
 * (en) Form theming functions
 *
 * @copyright       Copyright 2006-2012, Alexander Hass
 * @license         http://www.yaml-fuer-drupal.de/en/terms-of-use
 * @link            http://www.yaml-for-drupal.com
 * @package         yaml-for-drupal
 * @version         7.x-4.0.1.16
 * @lastmodified    2012/03/06
 */

/**
 * Implements hook_form_alter().
 *
 * Add some useful HTML5 attributes to forms to make them more user friedly.
 * This are only nice gimicks and 100% optional. If you don't like the
 * searchfields look and feel, just disable the overriding code.
 */
function yaml_simple_form_alter(&$form, &$form_state, $form_id) {
  // D8 backport: Change form items to HTML5 types.
  switch ($form_id) {
    case 'search_form':
      // Replace textfield with searchfield, http://drupal.org/project/elements
      if (module_exists('elements')) {
        // Basic search form.
        if (isset($form['basic']['keys']['#type']) && $form['basic']['keys']['#type'] == 'textfield') {
          $form['basic']['keys']['#type'] = 'searchfield';
        }
        // Advanced search form.
        if (isset($form['advanced']['keywords']['or']['#type']) && $form['advanced']['keywords']['or']['#type'] == 'textfield') {
          $form['advanced']['keywords']['or']['#type'] = 'searchfield';
        }
        if (isset($form['advanced']['keywords']['phrase']['#type']) && $form['advanced']['keywords']['phrase']['#type'] == 'textfield') {
          $form['advanced']['keywords']['phrase']['#type'] = 'searchfield';
        }
        if (isset($form['advanced']['keywords']['negative']['#type']) && $form['advanced']['keywords']['negative']['#type'] == 'textfield') {
          $form['advanced']['keywords']['negative']['#type'] = 'searchfield';
        }
      }
      break;

    case 'search_block_form':
      if (isset($form['search_block_form']['#type']) && $form['search_block_form']['#type'] == 'textfield') {
        // Replace textfield with searchfield, http://drupal.org/project/elements
        if (module_exists('elements')) {
          $form['search_block_form']['#type'] = 'searchfield';
        }
        $form['search_block_form']['#attributes']['placeholder'] = t('Search...');
      }
      break;
  }
}

/**
 * Implements theme_form_required_marker().
 *
 * Override the standard core required marker code.
 */
function yaml_simple_form_required_marker($variables) {
  // This is also used in the installer, pre-database setup.
  $t = get_t();
  $attributes = array(
    'class' => array('form-required', 'ym-required'),
    'title' => $t('This field is required.'),
  );
  return '<span' . drupal_attributes($attributes) . '>*</span>';
}

/**
 * Implements theme_preprocess_button().
 */
function yaml_simple_preprocess_button(&$variables) {
  // Add YAML button class to all buttons (including submit).
  $variables['element']['#attributes']['class'][] = 'ym-button';
}

/**
 * Implements theme_preprocess_container().
 */
function yaml_simple_preprocess_container(&$variables) {
  // Seems not defined for custom content types. Core Bug?
  if (isset($variables['element']['#type'])) {
    switch ($variables['element']['#type']) {
      case 'actions':
        // Add YAML button container class to action wrapper.
        $variables['element']['#attributes']['class'][] = 'ym-fbox-button';
        break;
    }
  }
}

/**
 * Implements theme_preprocess_form().
 */
function yaml_simple_preprocess_form(&$variables) {
  // Customize form style.
  switch ($variables['element']['#form_id']) {
    case 'workbench_moderation_moderate_form':
    case 'lang_dropdown_form':
      // Add no form classes.
      break;

    case 'search_block_form':
      // NOTE: If search block form is not assigned to region main_navigation,
      // this class may need to be removed to make it a standard ym-form form.
      $variables['element']['#attributes']['class'][] = 'ym-searchform';
      break;

    case 'search_form':
      // Forms that do not support form style switching properly.
      $variables['element']['#attributes']['class'][] = 'ym-form';
      break;

    default:
      // Linear style (default)
      $variables['element']['#attributes']['class'][] = 'ym-form';
      $variables['element']['#attributes']['class'][] = 'linearize-form';

      // Switch form style based on theme setting.
      $yaml_form_style = theme_get_setting('yaml_form_style');
      if ($yaml_form_style == 'full') {
        // Full width style.
        $variables['element']['#attributes']['class'][] = 'ym-full';
      }
      elseif ($yaml_form_style == 'columnar') {
        // Columnar style.
        $variables['element']['#attributes']['class'][] = 'ym-columnar';
      }
  }
}

/**
 * Implements theme_preprocess_form_element().
 *
 * BUG: Requires core patch http://drupal.org/node/1114398
 */
function yaml_simple_preprocess_form_element(&$variables) {
  // Add custom form classes to form elements.
  switch ($variables['element']['#type']) {
    case 'date':
    case 'emailfield': // D8: email
    case 'item';
    case 'file':
    case 'numberfield': // D8: number
    case 'rangefield': // D8: range
    case 'searchfield': // D8: search
    case 'telfield': // D8: tel
    case 'textarea':
    case 'textfield':
    case 'password':
    case 'urlfield': // D8: url
      $variables['element']['#attributes']['class'][] = 'ym-fbox-text';
      break;

    case 'select':
      $variables['element']['#attributes']['class'][] = 'ym-fbox-select';
      break;

    case 'checkbox':
    case 'checkboxes':
    case 'radio':
    case 'radios':
      $variables['element']['#attributes']['class'][] = 'ym-fbox-check';
      break;
  }
}

/**
 * Implements theme_preprocess_form_element_label().
 *
 * BUG: Requires core patch http://drupal.org/node/1114398
 */
function yaml_simple_preprocess_form_element_label(&$variables) {
  switch ($variables['element']['#type']) {
    case 'radios':
    case 'checkboxes':
      // Add custom label class to element labels.
      $variables['element']['#attributes']['class'][] = 'ym-label';
      break;
  }
}

/**
 * Implements theme_preprocess_image_button().
 */
function yaml_simple_preprocess_image_button(&$variables) {
  // @todo: Untested, no repro case! Please report with repro case if broken.
  $variables['element']['#attributes']['class'][] = 'ym-button';
}

/**
 * Implements theme_preprocess_searchfield().
 *
 * Requires http://drupal.org/project/elements.
 */
function yaml_simple_preprocess_searchfield(&$variables) {
  switch ($variables['element']['#name']) {
    case 'search_block_form':
      // Add searchfield class to search 'keyword' <input> element.
      // NOTE: If search block form is not assigned to region main_navigation,
      // this class may need to be removed to make it a standard input field.
      $variables['element']['#attributes']['class'][] = 'ym-searchfield';
      break;
  }
}

/**
 * Implements theme_preprocess_textfield().
 */
function yaml_simple_preprocess_textfield(&$variables) {
  switch ($variables['element']['#name']) {
    case 'search_block_form':
      // Add searchfield class to search 'keyword' <input> element.
      // NOTE: If search block form is not assigned to region main_navigation,
      // this class may need to be removed to make it a standard input field.
      $variables['element']['#attributes']['class'][] = 'ym-searchfield';
      break;
  }
}
