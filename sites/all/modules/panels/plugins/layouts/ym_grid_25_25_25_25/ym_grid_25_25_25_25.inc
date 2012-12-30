<?php
// $Id: ym_grid_25_25_25_25.inc,v 1.2 2012/02/13 17:00:00 hass Exp $

// Plugin definition
$plugin = array(
  'title' => t('4 columns 25/25/25/25'),
  'category' => t('Columns: 4'),
  'icon' => 'ym_grid_25_25_25_25.png',
  'theme' => 'panels_ym_grid_25_25_25_25',
  'regions' => array(
    'left' => t('Left column'),
    'left_middle' => t('Left middle column'),
    'right_middle' => t('Right middle column'),
    'right' => t('Right column')
  ),
);
