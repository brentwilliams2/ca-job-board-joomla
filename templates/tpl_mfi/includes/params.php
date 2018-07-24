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

	// Getting params from template
	$params = JFactory::getApplication()->getTemplate(true)->params;
	$app = JFactory::getApplication();
  $doc = JFactory::getDocument();

	// Column widths
	$leftcolgrid = ($this->countModules('left') == 0) ? 0 :	$this->params->get('leftColumnWidth', 3);
  $rightcolgrid = ($this->countModules('right') == 0) ? 0 :	$this->params->get('rightColumnWidth', 3);

  // Add javascript files
  $doc->addScript('templates/' . $this->template . '/js/jui/jquery-migrate.min.js');
	$doc->addScript('templates/' . $this->template . '/js/holder.js');
  if ($headroom == 1) $doc->addScript('templates/' . $this->template . '/js/headroom.min.js');
	if ($modernizr == 1) $doc->addScript($tpath . '/js/modernizr-2.8.3.js');

  // Add Stylesheets
	$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.min.css');
	$doc->addStyleSheet('templates/' . $this->template . '/css/icons.css');
	$doc->addStyleSheet('templates/' . $this->template . '/css/template.min.css');
  if ($fontawesome == 1) $doc->addStyleSheet($tpath . '/css/font-awesome.min.css');

  // Variables
	$menu = $app->getMenu();
	$active = $app->getMenu()->getActive();
	$pageclass = $params->get('pageclass_sfx');
	$tpath = $this->baseurl . '/templates/' . $this->template;

  // Parameter
	$frontpageshow = $this->params->get('frontpageshow', 0);
	$modernizr = $this->params->get('modernizr');
	$fontawesome = $this->params->get('fontawesome');
	$pie = $this->params->get('pie');

  // Generator tag
	$this->setGenerator(null);

  // Force latest IE & chrome frame
	$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');

  // Use of Google Font
  if ($this->params->get('googleFont'))
  {
    JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
    $this->addStyleDeclaration("
    h1, h2, h3, h4, h5, h6, .site-title {
      font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
    }");
  }

  //Body Font
  if( $this->params->get('bodyFont') )
  {
        JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('bodyFontName'));
      $this->addStyleDeclaration("
        body {
      font-family: '" . str_replace('+', ' ', $this->params->get('bodyFontName')) . "', sans-serif;
    }");
  }

  //Navigation Font
  if( $this->params->get('navigationFont') )
  {
        JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('navigationFontname'));
      $this->addStyleDeclaration("
        nav {
      font-family: '" . str_replace('+', ' ', $this->params->get('navigationFontname')) . "', sans-serif;
    }");
  }
