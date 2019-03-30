<?php
/**
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  // no direct access
  defined('_JEXEC') or die;

  include 'includes/params.php';

  $notFrontPage = $menu->getActive() !== $menu->getDefault();

  // @TODO: You can't use <jdoc:include > on error pages, so need to get modules on error pages like so:
  /*
  $modules = JModuleHelper::getModules('footer_3');
  $attribs['style'] = 'xhtml';
  foreach ($modules as $module)
  {
    echo JModuleHelper::renderModule( $module, $attribs );
  }
  */
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
  <?php include 'includes/head.php'; ?>

  <body>
    <div id="wrap">

      <!--Navigation-->
      <header id="header" class="header header--fixed hide-from-print" >

        <!--TEMPLATE POSITION: top-->
        <?php  if($this->countModules('top')) : ?>
          <div id="top" class="navbar-inverse">
            <div class="container">
              <div class="row">
                <jdoc:include type="modules" name="top" style="none" />
              </div>
            </div>
          </div>
        <?php  endif; ?>

        <!--top-->
        <div id="navigation">
          <div class="navbar navbar-default">
            <div class="container">

              <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div id="brand">
                  <a href="<?php  echo $this->params->get('logo_link')   ?>">
                    <img style="width:<?php  echo $this->params->get('logo_width') ?>px; height:<?php  echo $this->params->get('logo_height') ?>px; " src="<?php echo $this->params->get('logo_file') ?>" alt="Logo" />
                  </a>
                </div>

              </div>
              <!--END navbar-header-->

              <div class="navbar-collapse collapse">
                <?php  if ($this->countModules('navigation')) : ?>
                  <nav class="navigation">
                    <jdoc:include type="modules" name="navigation" style="none" />
                  </nav>
                <?php  endif; ?>
              </div>
              <!--END navigation template position-->

            </div>
            <!--END container-->
          </div>
          <!--END navbar-->
        </div>
        <!--END navigation-->

      </header>

      <div class="clearfix"></div>

      <section>
        <!--TEMPLATE POSITION: fullwidth-->
        <?php  if($this->countModules('fullwidth')) : ?>
        <div id="fullwidth">
          <div class="row">
            <jdoc:include type="modules" name="fullwidth" style="block"/>
          </div>
        </div>
        <?php  endif; ?>
        <!--END fullwidth-->

        <!--TEMPLATE POSITION: showcase-->
        <?php  if($this->countModules('showcase')) : ?>
          <div id="showcase">
            <div class="container">
              <div class="row">
                <jdoc:include type="modules" name="showcase" style="block"/>
              </div>
            </div>
          </div>
        <?php  endif; ?>
        <!--END showcase-->

        <!--TEMPLATE POSITION: seature-->
        <?php  if($this->countModules('feature')) : ?>
          <div id="feature">
            <div class="container">
              <div class="row">
                <jdoc:include type="modules" name="feature" style="block" />
              </div>
            </div>
          </div>
        <?php  endif; ?>
        <!--END feature-->

        <!--TEMPLATE POSITION: breadcrumb-->
        <?php  if($this->countModules('breadcrumbs')) : ?>
        <div id="breadcrumbs">
          <div class="container">
            <div class="row">
              <jdoc:include type="modules" name="breadcrumbs" style="block" />
            </div>
          </div>
        </div>
        <?php  endif; ?>
        <!--END breadcrumb-->

        <!-- Main Content -->
        <div class="container">
          <div id="main" class="row show-grid">

            <!--TEMPLATE POSITION: left -->
            <?php  if($this->countModules('left')) : ?>
              <div id="sidebar" class="col-sm-<?php  echo $leftcolgrid; ?>">
                <jdoc:include type="modules" name="left" style="block" />
              </div>
            <?php  endif; ?>
            <!--END left column-->

            <!--Center Content Column-->
            <div id="container" class="col-sm-<?php  echo (12-$leftcolgrid-$rightcolgrid); ?>">

              <!--TEMPLATE POSITION: content-top-->
              <?php  if($this->countModules('content-top')) : ?>
                <div id="content-top">
                  <div class="row">
                    <jdoc:include type="modules" name="content-top" style="block" />
                  </div>
                </div>
              <?php endif; ?>
              <!--END content center column top-->

              <!--TEMPLATE POSITION: message and component with front page show or hide -->
              <div id="main-box">
                <?php if ($frontpageshow) : // show on all pages ?>
                  <jdoc:include type="message" />
                <?php endif; ?>

                <!--Use MFI template for error pages-->
                <?php if ($this->error->getCode()) : /* check if we are on error page, if yes - display error message */ ?>
                  <p><strong><?php echo $this->error->getCode() ?> - <?php echo $this->error->message ?></strong></p>

                  <p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>

                  <ol>
                    <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
                  </ol>

                  <p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>

                  <ul>
                    <li>
                      <a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
                        <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?>
                      </a>
                    </li>
                  </ul>

                  <p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?>.</p>
                <?php else : ?>
                  <jdoc:include type="component" />
                <?php endif; ?>
              </div>
              <!--END component-->

              <!--TEMPLATE POSITION: content-bottom-->
              <?php  if($this->countModules('content-bottom')) : ?>
                <div id="content-bottom">
                  <div class="row">
                    <jdoc:include type="modules" name="content-bottom" style="block" />
                  </div>
                </div>
              <?php  endif; ?>
              <!--END content center column bottom-->

            </div>
            <!--END Center Content Column-->

            <!--TEMPLATE POSITION: right-->
            <?php  if($this->countModules('right')) : ?>
              <div id="sidebar-2" class="col-sm-<?php  echo $rightcolgrid; ?>">
                <jdoc:include type="modules" name="right" style="block" />
              </div>
            <?php  endif; ?>
            <!--END right column-->

          </div>
        </div>
        <!--END Main Content-->

        <!--TEMPLATE POSITION:  bottom -->
        <?php  if($this->countModules('bottom')) : ?>
          <div id="bottom">
            <div class="container">
              <div class="row">
              <jdoc:include type="modules" name="bottom" style="block" />
              </div>
            </div>
          </div>
        <?php  endif; ?>
        <!--END bottom -->

        <!--TEMPLATE POSITION:  footer -->
        <?php  if($this->countModules('footer')) : ?>
        <div id="footer">
        <div class="container">
          <div class="row">
            <jdoc:include type="modules" name="footer" style="block" />
          </div>
        </div>
        </div>
        <?php  endif; ?>
        <!--END footer -->

         <!--TEMPLATE POSITION: copyright-->
        <?php  if($this->countModules('copy')) : ?>
          <div id="copy"  class="well">
            <div class="container">
              <div class="row">
                <jdoc:include type="modules" name="copyright" style="block" />
              </div>
            </div>
          </div>
        <?php  endif; ?>
        <!--END copyright -->

        <!--TEMPLATE POSITION: menu slider-->
        <?php  if($this->countModules('menuslider')): ?>
          <div id="panelnav">
              <jdoc:include type="modules" name="menuslider" style="none" />
          </div>
        <?php  endif; ?>
        <!--END menu slider-->

        <!--Back To Top-->
        <a href="#" class="back-to-top">Back to Top</a>

        <!--TEMPLATE POSITION: debug-->
        <jdoc:include type="modules" name="debug" />
      </section>
    </div>
    <!-- page -->

    <!-- JS -->
    <script type="text/javascript" src="<?php echo $tpath; ?>/js/template.min.js"></script>
    <!-- JS -->
  </body>
</html>
