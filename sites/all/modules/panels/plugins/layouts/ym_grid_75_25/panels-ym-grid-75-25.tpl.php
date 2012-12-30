<?php
// $Id: panels-ym-grid-75-25.tpl.php,v 1.2 2012/02/13 17:00:00 hass Exp $
/**
 * @file
 * Template for the 2 column panel layout.
 *
 * This template provides a two column 75%-25% panel display layout.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['left']: Content in the left column.
 *   - $content['right']: Content in the right column.
 */
?>
<!-- Gridtemplate: 2 columns 75/25 -->
<div class="ym-grid" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="ym-g75 ym-gl">
    <div class="ym-gbox">
      <!-- left content block -->
      <?php print $content['left']; ?>
    </div>
  </div>
  <div class="ym-g75 ym-gr">
    <div class="ym-gbox">
      <!-- right content block -->
      <?php print $content['right']; ?>
    </div>
  </div>
</div>
