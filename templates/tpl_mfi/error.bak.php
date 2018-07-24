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

  $app  = JFactory::getApplication();
  $user = JFactory::getUser();

  // Getting params from template
  $params = $app->getTemplate(true)->params;

  // Detecting Active Variables
  $option   = $app->input->getCmd('option', '');
  $view     = $app->input->getCmd('view', '');
  $layout   = $app->input->getCmd('layout', '');
  $task     = $app->input->getCmd('task', '');
  $itemid   = $app->input->getCmd('Itemid', '');
  $sitename = $app->get('sitename');

  if ($task === 'edit' || $layout === 'form')
  {
    $fullWidth = 1;
  }
  else
  {
    $fullWidth = 0;
  }

  // Add JavaScript Frameworks
  JHtml::_('jquery.framework');
  JHtml::_('bootstrap.framework');

  // Logo file or site title param
  if ($params->get('logo_file'))
  {
    <a href="<?php  echo $this->params->get('logo_link')   ?>">
      <img
        style="width:<?php  echo $this->params->get('logo_width') ?>px; height:<?php  echo $this->params->get('logo_height') ?>px; "
        src="<?php echo $this->params->get('logo_file') ?>"
        alt="Logo"
      />
    </a>
  }
  elseif ($params->get('sitetitle'))
  {
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($params->get('sitetitle')) . '</span>';
  }
  else
  {
    $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
  }
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <meta charset="utf-8" />

    <title><?php echo $this->title; ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--load Google Fonts if set in preferences-->
    <?php if ($params->get('googleFont')) : ?>
      <link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('googleFontName'); ?>" rel="stylesheet" />
      <style>
        h1, h2, h3, h4, h5, h6, .site-title {
          font-family: '<?php echo str_replace('+', ' ', $params->get('googleFontName')); ?>', sans-serif;
        }
      </style>
    <?php endif; ?>

    <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.min.css" rel="stylesheet" />

    <!--load language debugging CSS if set-->
    <?php if ($app->get('debug_lang', '0') == '1' || $app->get('debug', '0') == '1') : ?>
      <link href="<?php echo JUri::root(true); ?>/media/cms/css/debug.css" rel="stylesheet" />
    <?php endif; ?>

    <!--enable RTL language if set-->
    <?php if ($this->direction === 'rtl') : ?>
      <link href="<?php echo JUri::root(true); ?>/media/jui/css/bootstrap-rtl.css" rel="stylesheet" />
    <?php endif; ?>

    <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->
  </head>

  <body class="site <?php echo $option
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($this->direction === 'rtl' ? ' rtl' : '');
  ?>">

    <!-- Body -->
    <div class="body">
      <div class="container-fluid">

        <!-- Header -->
        <header class="header" role="banner">
          <div class="header-inner clearfix">
            <a class="navbar-brand pull-left" href="<?php echo $this->baseurl; ?>/">
              <?php echo $logo; ?>
            </a>
            <div class="header-search pull-right">
              <?php echo $this->getBuffer('modules', 'position-0', array('style' => 'none')); ?>
            </div>
          </div>
        </header>

        <div class="navigation">
          <?php echo $this->getBuffer('modules', 'position-1', array('style' => 'none')); ?>
        </div>

        <!-- Banner -->
        <div class="banner">
          <?php echo $this->getBuffer('modules', 'banner', array('style' => 'xhtml')); ?>
        </div>

        <div class="row">
          <div id="content" class="col-md-12">
            <!-- Begin Content -->
            <h1 class="page-header"><?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h1>

            <div class="well">
              <div class="row">

                <div class="col-md-6">
                  <p><strong><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
                  <p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
                  <ul>
                    <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                    <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                  </ul>
                </div>

                <div class="col-md-6">
                  <?php if (JModuleHelper::getModule('mod_search')) : ?>
                    <p><strong><?php echo JText::_('JERROR_LAYOUT_SEARCH'); ?></strong></p>
                    <p><?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?></p>
                    <?php $module = JModuleHelper::getModule('mod_search'); ?>
                    <?php echo JModuleHelper::renderModule($module); ?>
                  <?php endif; ?>

                  <p><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>

                  <p>
                    <a href="<?php echo $this->baseurl; ?>/index.php" class="btn btn-default">
                      <span class="glyphicon-home" aria-hidden="true"></span>
                      <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?>
                    </a>
                  </p>
                </div>
              </div>

              <hr />

              <p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>

              <blockquote>
                <span class="label label-inverse"><?php echo $this->error->getCode(); ?></span>
                <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8');?>

                <?php if ($this->debug) : ?>
                  <br/>
                  <?php echo htmlspecialchars($this->error->getFile(), ENT_QUOTES, 'UTF-8');?>:<?php echo $this->error->getLine(); ?>
                <?php endif; ?>
              </blockquote>

              <?php if ($this->debug) : ?>
                <div>
                  <?php echo $this->renderBacktrace(); ?>
                  <!--check if there are more Exceptions and render their data as well-->

                  <?php if ($this->error->getPrevious()) : ?>
                    <?php $loop = true; ?>
                    <?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
                    <?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
                    <?php $this->setError($this->_error->getPrevious()); ?>

                    <?php while ($loop === true) : ?>
                      <p><strong><?php echo JText::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
                      <p>
                        <?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
                        <br/><?php echo htmlspecialchars($this->_error->getFile(), ENT_QUOTES, 'UTF-8');?>:<?php echo $this->_error->getLine(); ?>
                      </p>
                      <?php echo $this->renderBacktrace(); ?>
                      <?php $loop = $this->setError($this->_error->getPrevious()); ?>
                    <?php endwhile; ?>

                    <?php // Reset the main error object to the base error ?>
                    <?php $this->setError($this->error); ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
            <!-- End Content -->
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
        <hr />

        <?php echo $this->getBuffer('modules', 'footer', array('style' => 'none')); ?>

        <p class="pull-right">
          <a href="#top" id="back-top">
            <?php echo JText::_('TPL_MFI_BACKTOTOP'); ?>
          </a>
        </p>

        <p>
          &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
        </p>
      </div>
    </div>

    <?php echo $this->getBuffer('modules', 'debug', array('style' => 'none')); ?>
  </body>
</html>
