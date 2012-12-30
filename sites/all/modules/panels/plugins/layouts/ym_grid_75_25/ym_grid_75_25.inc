<?php
// $Id: ym_grid_75_25.inc,v 1.2 2012/02/13 17:00:00 hass Exp $

// Plugin definition
$plugin = array(
  'title' => t('2 columns 75/25'),
  'category' => t('Columns: 2'),
  'icon' => 'ym_grid_75_25.png',
  'theme' => 'panels_ym_grid_75_25',
  'regions' => array(
    'left' => t('Left column'),
    'right' => t('Right column')
  ),
);
