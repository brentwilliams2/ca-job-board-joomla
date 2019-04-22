<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * This partial renders the main HTML5 body tag and all scaffolding
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Access template parameters in partials like:
 *
 *   $this->params->get('header_logo_link');
 */

  // no direct access
  defined('_JEXEC') or die;

  require_once realpath(  dirname(__FILE__) . '/../Includes/PositionRenderer.php' );

  $positionRenderer = new PositionRenderer($this);

  // This partial may be either an Html or Error Document, parameters not available on ErrorDocuments
  if ( !$this->isErrorPage )
  {
    $showMssgsOnHomePage = $this->params->get('show_mssgs_on_home_page');
    $leftColumnWidth = $this->params->get('left_column_width');
    $rightColumnWidth = $this->params->get('right_column_width');
  }
  else
  {
    $showMssgsOnHomePage = false;
    $leftColumnWidth = 2;
    $rightColumnWidth = 2;
  }
?>
<body>

  <header id="header" class="header hide-from-print">
    <div class="container-fluid">

      <div class="header-top row">

        <?php /* Start at 100% width on phone, then 50% width on desktop */ ?>
        <div class="header-top-left col-xs-4">

          <?php /* logo-header-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('logo-header'); ?>

        </div>

        <div class="header-top-right col-xs-8">

          <!--div class="header-top-right-secondary-nav row"-->

          <nav id="header-top-right-secondary-nav" class="header-top-right-secondary-nav navbar" aria-labelledby="secondary-navigation">
            <div class="secondary-navigation container-fluid">
              <ul class="nav row">

                <?php /* search-header-container */ ?>
                <?php echo $positionRenderer->withColumnWrapper('search-header', 'col-xs-2'); ?>

                <?php /* nav-secondary-container */ ?>
                <?php echo $positionRenderer->withNoWrapper('nav-secondary'); ?>

                <?php /* login-container */ ?>
                <?php echo $positionRenderer->withColumnWrapper('login', 'col-xs-2'); ?>

                <?php /* shopping-cart-container */ ?>
                <?php echo $positionRenderer->withColumnWrapper('shopping-cart', 'col-xs-2'); ?>

              </ul>
            </div>
          </nav>

          <nav id="header-top-right-primary-nav" class="header-top-right-primary-nav navbar" aria-labelledby="primary-navigation">
            <div class="primary-navigation container-fluid">
              <ul class="nav row">

              <?php /* nav-primary-container */ ?>
              <?php echo $positionRenderer->withNoWrapper('nav-primary'); ?>

              </ul>
            </div>
          </nav>

        </div>
      </div>

      <?php if ( $this->moduleCount['nav-component'] || $this->moduleCount['nav-component-action'] ) : ?>

        <nav class="header-middle navbar" aria-labelledby="component-navigation">
          <div class="component-navigation container-fluid">
            <ul class="nav">

              <?php /* nav-component-container */ ?>
              <?php echo $positionRenderer->withNoWrapper('nav-component'); ?>

              <?php /* nav-component-action-container */ ?>
              <?php echo $positionRenderer->withDivWrapper('nav-component-action', 'container pull-right'); ?>

            </ul>
          </div>
        </nav>

      <?php endif; ?>

      <div class="header-bottom row">

        <?php /* breadcrumbs-container */ ?>
        <?php echo $positionRenderer->withColumnWrapper('breadcrumbs', 'col-xs-12'); ?>

      </div>

    </div>
  </header>

  <div class="clearfix"></div>

  <section id="content" class="content">

    <div id="container-full-width" class="container-full-width">

      <?php /* Full-width position, showcase-container */ ?>
      <?php echo $positionRenderer->withDivWrapper('showcase'); ?>

      <?php /* Full-width position, feature-container */ ?>
      <?php echo $positionRenderer->withDivWrapper('feature'); ?>

    </div>

    <?php /* Content */ ?>
    <div class="container-fluid">

      <div id="container-content" class="container-content row">

        <aside id="aside-left-sidebar" class="aside-left-sidebar col-xs-<?php echo $leftColumnWidth ?>">

          <?php /* content-left-sidebar-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-left-sidebar'); ?>

        </aside>

        <?php /* Center content column */ ?>
        <div id="content-center" class="content-center col-xs-<?php  echo (12-$leftColumnWidth-$rightColumnWidth); ?>">

          <?php /* banner-top-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('banner-top'); ?>

          <?php if ($showMssgsOnHomePage) : // Whether to show message box on the front page or not ?>
            <?php /* content-message-container */ ?>
            <?php echo $positionRenderer->withDivWrapper('content-message'); ?>
          <?php endif; ?>

          <?php /* Both component and error pages use this template */ ?>
          <?php if ($this->isErrorPage) : ?>
            <?php /* content-error-container */ ?>
            <?php echo $positionRenderer->withDivWrapper('content-error'); ?>
          <?php else : ?>
            <?php /* content-component-container */ ?>
            <?php echo $positionRenderer->withDivWrapper('content-component-output'); ?>
          <?php endif; ?>

          <?php /* content-info-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-info'); ?>

          <?php /* content-social-share-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-social-share'); ?>

          <?php /* content-references-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-references'); ?>

          <?php /* content-sponsored-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-sponsored'); ?>

          <?php /* content-related-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-related'); ?>

          <?php /* content-share-reactions-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-share-reactions'); ?>

          <?php /* banner-bottom-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('banner-bottom'); ?>

        </div>

        <aside id="aside-right-sidebar" class="aside-right-sidebar col-xs-<?php echo $rightColumnWidth ?>">

          <?php /* content-right-sidebar-container */ ?>
          <?php echo $positionRenderer->withDivWrapper('content-right-sidebar'); ?>

        </aside>

      </div>
    </div>

    <?php /* debug-container */ ?>
    <?php echo $positionRenderer->withDivWrapper('debug'); ?>
  </section>

  <footer id="footer" class="footer hide-from-print">
    <div class="container-fluid">

      <div class="footer-left col-xs-4">

        <?php /* logo-footer-container */ ?>
        <?php echo $positionRenderer->withDivWrapper('logo-footer'); ?>

        <?php /* copyright-container */ ?>
        <?php echo $positionRenderer->withDivWrapper('copyright'); ?>

      </div>

      <div class="footer-right col-xs-8">

        <?php /* social-icons-container */ ?>
        <?php echo $positionRenderer->withDivWrapper('social-icons'); ?>

        <?php /* search-footer-container */ ?>
        <?php echo $positionRenderer->withDivWrapper('search-footer'); ?>

        <?php /* nav-footer-container */ ?>
        <?php echo $positionRenderer->withDivWrapper('nav-footer'); ?>

      </div>

    </div>
  </footer>

  <?php /* Preserve as last element in body */ ?>
  <script type="text/javascript" src="<?php echo $this->templatePath; ?>/js/template.min.js"></script>
<body>
