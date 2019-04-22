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

  /*
   * Set the error code in the page title on error pages
   */
  if  ($this->isErrorPage)
  {
    $this->setTitle( $app->getCfg('sitename') . ' - ' . $this->error->getCode() . Text::_('ERROR') );
  }

  // addHeadLink() method of HtmlDocument isn't available on ErrorDocument, so add external links manually for all cases
  ?>

  <head>
    <!-- Add OpenSearch support on normal pages, so web browsers can use their URL bar / search box to search the local site -->
    <link href="<?php echo $this->templatePath ?>/xml/opensearch.xml" rel="search" type="application/opensearchdescription+xml" title="Multi Family Insiders Search">

    <!-- Add Google Font - Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <jdoc:include type="head" />
  </head>
