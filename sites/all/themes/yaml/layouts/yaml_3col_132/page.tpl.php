<?php

/**
 * @file
 * YAML's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see yaml_process_page()
 */
?>
<header>
  <div class="ym-wrapper">
    <div class="ym-wbox <?php print $classes; ?>">
      <?php print render($page['header']) ?>
      <?php if ($secondary_nav): print $secondary_nav; endif; ?>
      <?php if ($logo): ?>
      <div class="ym-grid linearize-level-2">
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
      </div>
  </div>
</header>

<?php if ($primary_nav || !empty($page['main_navigation'])): ?>
<nav id="nav">
  <div class="ym-wrapper">
    <div class="ym-hlist" >
      <?php print $primary_nav; ?>
      <?php print render($page['main_navigation']); ?>
    </div>
  </div>
</nav>
<?php endif; ?>

<?php if (!empty($breadcrumb)): ?>
<div id="breadcrumb">
  <div class="ym-wrapper">
    <?php print $breadcrumb; ?>
  </div>
</div>
<?php endif; ?>

<div id="main">
  <div class="ym-wrapper">
    <div class="ym-wbox">
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
  </div>
</div>

<?php if ($page['footer']): ?>
<footer>
  <div class="ym-wrapper">
    <div class="ym-wbox">
      <?php print render($page['footer']); ?>
    </div>
  </div>
</footer>
<?php endif; ?>
