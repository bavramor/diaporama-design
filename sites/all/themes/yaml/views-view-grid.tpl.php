<?php
/**
 * @file views-view-grid.tpl.php
 * YAML simple view template to display rows in a grid responsible.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $row_number => $columns): ?>
  <?php foreach ($columns as $column_number => $item): ?>
    <?php $column_width = floor(100 / count($columns)); ?>
    <?php if ($column_number == 0) : ?>
      <div class="ym-grid linearize-level-2">
        <div class="ym-gl ym-g<?php print $column_width; ?> <?php print $column_classes[$row_number][$column_number]; ?>">
          <div class="ym-gbox-left">
          <?php print $item; ?>
          </div>
        </div>
    <?php elseif ($column_number == count($columns)-1): ?>
        <div class="ym-gr ym-g<?php print $column_width; ?> <?php print $column_classes[$row_number][$column_number]; ?>">
          <div class="ym-gbox-right">
          <?php print $item; ?>
          </div>
        </div>
      </div>
    <?php else: ?>
        <div class="ym-gl ym-g<?php print $column_width; ?> <?php print $column_classes[$row_number][$column_number]; ?>">
          <div class="ym-gbox">
          <?php print $item; ?>
          </div>
        </div>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endforeach; ?>
