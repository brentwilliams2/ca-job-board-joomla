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

  // variables
  $app = JFactory::getApplication();
  $doc = JFactory::getDocument();
  $tpath = $this->baseurl.'/templates/'.$this->template;

  $module = new stdClass();
  $module->module = 'mod_search';
?>

<!doctype html>
<html lang="<?php echo $this->language; ?>">
  <head>
    <title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> <!-- mobile viewport optimized -->
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/templates/tpl_mfi/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/templates/tpl_mfi/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $tpath; ?>/templates/tpl_mfi/css/template.css" type="text/css" />
  </head>

  <body>
    <div class="error">
      <div class="container">
        <h3><?php echo htmlspecialchars($app->getCfg('sitename')); ?></h3>

        <p><i class="fa fa-github-alt fa-5x"></i></p>

        <h1> <?php echo $this->error->getCode(); ?></h1>

        <h3><?php echo $this->error->getMessage(); ?></h3>

        <p>
          <a class="btn btn-warning btn-lg" href="<?php echo $this->baseurl; ?>/" title="<?php echo JText::_('HOME'); ?>"
            ><?php echo JText::_('Go Back'); ?>
          </a>
        </p>

        <!--Render module mod_search-->
        <?php echo JModuleHelper::renderModule($module); ?>
      </div>
    </div>
  </body>
</html>
