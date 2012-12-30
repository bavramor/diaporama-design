<?php
/**
 * @file
 * YAML's implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in page.tpl.php.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 * @see yaml_process_maintenance_page()
 */
?>
<?php if (!empty($xml_prolog)): print $xml_prolog; endif; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <ul class="ym-skiplinks">
    <li><a class="ym-skip" href="#nav"><?php print t('Skip to navigation (Press Enter).') ?></a></li>
    <li><a class="ym-skip" href="#main"><?php print t('Skip to main content (Press Enter).') ?></a></li>
  </ul>

  <div class="ym-wrapper">
    <div class="ym-wbox <?php print $classes; ?>">

      <header>
        <?php print render($page['header']) ?>
        <?php if ($secondary_nav): print $secondary_nav; endif; ?>
        <?php if ($logo): ?>
        <div class="ym-grid">
          <div class="ym-g960-1 ym-gl">
            <div class="ym-gbox">
              <a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img class="site-logo" src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a>
            </div>
          </div>
          <div class="ym-gl">
            <div class="ym-gbox">
              <?php if ($site_name): ?><h1 class="site-name"><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name ?></a></h1><?php endif; ?>
              <?php if ($site_slogan): ?><div class="site-slogan"><?php print $site_slogan ?></div><?php endif; ?>
            </div>
          </div>
        </div>
        <?php else: ?>
        <?php if ($site_name): ?><h1 class="site-name"><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name ?></a></h1><?php endif; ?>
        <?php if ($site_slogan): ?><div class="site-slogan"><?php print $site_slogan ?></div><?php endif; ?>
        <?php endif; ?>
      </header>

      <?php if ($primary_nav || !empty($page['main_navigation'])): ?>
      <nav id="nav">
        <div class="ym-hlist" >
          <?php print $primary_nav; ?>
          <?php print render($page['main_navigation']); ?>
        </div>
      </nav>
      <?php endif; ?>
      <?php print $breadcrumb; ?>

      <div id="main">
        <div class="ym-column linearize-level-1">
          <?php if ($page['sidebar_first']): ?>
          <div class="ym-col1">
            <div class="ym-cbox">
              <div class="ym-contain-dt">
                <?php print render($page['sidebar_first']); ?>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if ($page['sidebar_second']): ?>
          <div class="ym-col2">
            <div class="ym-cbox">
              <div class="ym-contain-dt">
                <?php print render($page['sidebar_second']); ?>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <div class="ym-col3">
            <div class="ym-cbox">
              <div class="ym-contain-dt">

                <?php if ($page['highlighted']): ?>
                <section class="box info">
                  <?php print render($page['highlighted']); ?>
                </section>
                <?php endif; ?>

                <section class="ym-grid">
                  <?php print render($title_prefix); ?>
                  <?php if ($title): ?><h2 class="title"><?php print $title ?></h2><?php endif; ?>
                  <?php print render($title_suffix); ?>
                  <?php if ($tabs): ?><div class="tabs"><?php print render($tabs) ?></div><?php endif; ?>
                  <?php if ($show_messages && $messages): print $messages; endif; ?>
                  <?php print render($page['help']); ?>
                  <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
                  <?php print render($page['content']); ?>
                  <?php print $feed_icons ?>
                </section>

              </div>
            </div>
          </div>

        </div>
      </div>

      <?php if ($page['footer']): ?>
      <footer>
        <?php print render($page['footer']); ?>
      </footer>
      <?php endif; ?>

    </div>
  </div>

</body>
</html>