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
              <?php if ($frontpageshow) { // show on all pages ?>
                <div id="main-box">
                  <jdoc:include type="message" />
                  <jdoc:include type="component" />
                </div>
              <?php } elseif ($notFrontPage) { // show on all pages but the default page ?>
                <div id="main-box">
                  <jdoc:include type="component" />
                </div>
              <?php } ?>
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
