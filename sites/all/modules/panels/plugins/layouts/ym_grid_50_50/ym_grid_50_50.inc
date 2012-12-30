<?php
// $Id: ym_grid_50_50.inc,v 1.2 2012/02/13 17:00:00 hass Exp $

// Plugin definition
$plugin = array(
  'title' => t('2 columns 50/50'),
  'category' => t('Columns: 2'),
	'icon' => 'ym_grid_50_50.png',
  'theme' => 'panels_ym_grid_50_50',
  'regions' => array(
    'left' => t('Left column'),
    'right' => t('Right column')
  ),
);
