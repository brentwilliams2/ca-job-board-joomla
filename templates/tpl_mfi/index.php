<?php

//  define( '_BASEPATH', dirname(__FILE__) );
//  require( _BASEPATH . DS . "_partials" . DS . "fontSizeToggler.php");
//  require(_BASEPATH . DS . "_partials" . DS . "styleloader.php");

/**
 * @package   Multi Family Insiders Template
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
  // no direct access
  defined( '_JEXEC' ) or die;

  require('includes/params.php');
?>

<!DOCTYPE html>
<html lang="en">
  <!-- Include <head> -->
  <?php require('_partials/head.php'); ?>

  <!-- Body -->
  <body class="site <?php echo $option
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '');
    ?> bc-blue <?php echo $fontstyle; ?>"
    id="ff-<?php echo $fontfamily; ?>"
  >
  
		<div id="page-bg"> <!-- refactor to "id=top" -->
		<div class="wrapper"> <!-- refactor to "class=container" -->

      <?php require('_partials/banner.php'); ?>

			<div class="shadow-left">
				<div class="shadow-right">
					<div class="main-page">
						<div class="main-page2">
							<div class="main-page3">
								<div class="main-page4">

                  <!-- Begin Header Area -->
                  <header>
                    <?php require('_partials/top.php'); ?>
                    <?php require('_partials/introtext.php'); ?>
                    <?php require('_partials/feature.php'); ?>
                    <?php require('_partials/menu_top.php'); ?>
                    <?php require('_partials/breadcrumbs.php'); ?>
                  </header>

									<!-- Begin Main Content Area -->
									<section id="main-section"> <!-- from Rocket template -->
										<div class="padding">

                      <div class="container"> <!-- from Bootstrap template -->
                        <div id="main" class="row show-grid">

                          <?php require('_partials/left.php'); ?>
                          <?php require('_partials/right.php'); ?>

                          <div id="container" class="col-sm-<?php  echo (12-$leftcolgrid-$rightcolgrid); ?>">
                            <?php require('_partials/content_top.php'); ?>
                            <?php require('_partials/content_main.php'); ?>
                            <?php require('_partials/content_bottom_1.php'); ?>
                            <?php require('_partials/content_bottom_2.php'); ?>
                          </div>

    										</div>
                      </div>

                    </div>
									</section>

                  <?php require('_partials/menu_bottom.php'); ?>
                  <?php require('_partials/bottom.php'); ?>
                  <?php require('_partials/footer.php'); ?>
                  <?php require('_partials/copyright.php'); ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="debug">
				<jdoc:include type="modules" name="debug" style="none" />
			</div>
		</div>
		<!-- End Wrapper -->
		</div>

    <!-- Script from the Bootstrap template. Is this to make sure it runs at a certain time? -->
    <!-- This is also loaded by the Bootstrap template in params.php -->
    <script type="text/javascript" src="<?php echo $tpath; ?>/js/template.min.js"></script>

    <!--  Add the google +1 button.  Place this tag after the last plusone tag -->
    <script type="text/javascript">
      (function() {
        var po = document.createElement('script');
        po.type = 'text/javascript';
        po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(po, s);
      })();
    </script>	
	</body>
</html>