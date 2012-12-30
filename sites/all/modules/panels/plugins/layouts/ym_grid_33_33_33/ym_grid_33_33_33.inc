<?php
// $Id: ym_grid_33_33_33.inc,v 1.2 2012/02/13 17:00:00 hass Exp $

// Plugin definition
$plugin = array(
  'title' => t('3 columns 33/33/33'),
  'category' => t('Columns: 3'),
  'icon' => 'ym_grid_33_33_33.png',
  'theme' => 'panels_ym_grid_33_33_33',
  'regions' => array(
    'left' => t('Left column'),
    'middle' => t('Middle column'),
    'right' => t('Right column')
  ),
);
