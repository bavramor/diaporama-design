<?php
// $Id: panels-ym-grid-33-33-33.tpl.php,v 1.2 2012/02/13 17:00:00 hass Exp $
/**
 * @file
 * Template for the 3 column panel layout.
 *
 * This template provides a three column 33%-33%-33% panel display layout.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['left']: Content in the left column.
 *   - $content['middle']: Content in the middle column.
 *   - $content['right']: Content in the right column.
 */
?>
<!-- Gridtemplate: 3 columns 33/33/33 -->
<div class="ym-grid" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="ym-g33 ym-gl">
    <div class="ym-gbox">
      <!-- left content block -->
      <?php print $content['left']; ?>
    </div>
  </div>
  <div class="ym-g33 ym-gl">
    <div class="ym-gbox">
      <!-- middle content block -->
      <?php print $content['middle']; ?>
    </div>
  </div>
  <div class="ym-g33 ym-gr">
    <div class="ym-gbox">
      <!-- right content block -->
      <?php print $content['right']; ?>
    </div>
  </div>
</div>
