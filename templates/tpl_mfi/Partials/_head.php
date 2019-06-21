<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Template partial for <head></head>
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Factory;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  /** @var \Joomla\CMS\Document\Document $this */

  // These are overridden in the template with Bootstrap v3 files
  HTMLHelper::_('jquery.framework');
  HTMLHelper::_('bootstrap.framework');

  $app = Factory::getApplication();

/* @TODO: Uncomment if unnecessary files loading
  // Make sure all Joomla core script and css is not loaded
  $unwantedAssets = array (
    '/media/system/js/mootools-more.js',
    '/media/system/js/mootools-core.js',
    '/media/system/js/core.js',
    '/media/system/js/modal.js',
    '/media/system/js/caption.js',
    '/media/jui/js/jquery.min.js',
    '/media/jui/js/jquery-noconflict.js',
    '/media/jui/js/bootstrap.min.js'
  );

  foreach ($unwantedAssets as $asset)
  {
    unset($this->_scripts[JURI::root(true) . $asset]);
  }
*/

  /*
   * Set viewport recommended by Bootstrap for responsive CSS
   * width:           Sets the width of the layout viewport, overrides Apples default 960px.
   * initial-scale:   Sets the initial zoom of the page and the width of the layout viewport.
   */
  $this->setMetaData('viewport', 'width=device-width, initial-scale=1.0;');

  /*
   * Force latest IE & chrome frame
   */
  $this->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');

  /*
   * Add javascript files
   */
  $this->addScript($this->templatePath . '/js/holder.js');

  /*
   * Add Stylesheets
   */
	$this->addStyleSheet($this->templatePath . '/css/bootstrap.min.css'); // Bootstrap 3
	$this->addStyleSheet($this->templatePath . '/css/icons.css');
  $this->addStyleSheet($this->templatePath . '/css/glyphicons.min.css');

  if ($app->get('debug', '0') == '1')
  {
    $this->addStyleSheet($this->templatePath . '/css/template.css');
  }
  else
  {
    $this->addStyleSheet($this->templatePath . '/css/template.min.css');
  }

  /*
   * Don't show the Joomla! generator tag
   */
  $this->setGenerator(null);

  // addHeadLink() method of HtmlDocument isn't available on ErrorDocument, so add external links manually for all cases
  ?>

  <head>
    <!-- Add OpenSearch support on normal pages, so web browsers can use their URL bar / search box to search the local site -->
    <link href="<?php echo $this->templatePath ?>/xml/opensearch.xml" rel="search" type="application/opensearchdescription+xml" title="Multi Family Insiders Search">

    <!-- Add Google Font - Source Sans Pro -->
    <?php if ($app->get('debug', '0') == '1') : ?>

      <link href="<?php echo $this->templatePath ?>/fonts/SourceSansPro-Regular.ttf" rel="stylesheet">

    <?php else : ?>

      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <?php endif; ?>

    <?php if (!$this->isErrorPage) : ?>

      <jdoc:include type="head" />

    <?php else: // render static HTML for error pages ?>

      <meta http-equiv="content-type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0;">
      <meta name="x-ua-compatible" content="IE=edge,chrome=1">

      <title><?php echo Text::_('ERROR') . ': ' . $app->getCfg('sitename') . ' - ' . $this->error->getCode(); ?></title>

      <link href="<?php echo $this->templatePath ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
      <link href="<?php echo $this->templatePath ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <link href="/media/cms/css/debug.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $this->templatePath ?>/css/icons.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $this->templatePath ?>/css/glyphicons.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo $this->templatePath ?>/css/template.css" rel="stylesheet" type="text/css">

    <?php endif; ?>
  </head>
