<?php
/** @var JDocumentHtml $this */
/**
* Paramters for template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
defined('_JEXEC') or die;

/*
*  Framework objects
*/
$app = JFactory::getApplication();
$params = $app->getTemplate(true)->params;
$user = JFactory::getUser();
$doc = JFactory::getDocument();

// Output as HTML5
$this->setHtml5(true);

// Generator tag
$this->setGenerator(null);

// Force latest IE & chrome frame
$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');

/*
*  Column widths
*/
$leftcolgrid = ($this->countModules('left') == 0) ? 0 :
$this->params->get('leftColumnWidth', 3);
$rightcolgrid = ($this->countModules('right') == 0) ? 0 :
$this->params->get('rightColumnWidth', 3);

/*
*  Vendor Assets
*/
$modernizr = $this->params->get('modernizr');
$fontawesome = $this->params->get('fontawesome');

/*
*  Add javascript files
*/
if ($modernizr == 1) {
  $doc->addScript($tpath . '/js/modernizr-2.8.3.js');
}
$doc->addScript('templates/' . $this->template . '/js/holder.js');
$doc->addScript('templates/' . $this->template . '/js/jquery-2.1.3.min.js');
$doc->addScript('templates/' . $this->template . '/js/template.min.js');

/*
*  Add Stylesheets
*/
if ($fontawesome == 1) {
  $doc->addStyleSheet($tpath . '/css/font-awesome.min.css');
}
// @TODO: Selectively load Joomla JUI's Chosen CSS
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.min.css');
// @TODO: Do we need to load Joomla's IcoMoon icons? 
$doc->addStyleSheet('templates/' . $this->template . '/css/icons.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/template.min.css');

/*
*  Template Parameters
*/
$active = $app->getMenu()->getActive();
$frontpageshow = $this->params->get('frontpageshow', 0);
$headdata = $doc->getHeadData();
$layout = $this->params->get('layout');
$menu = $app->getMenu();
$pageclass = $params->get('pageclass_sfx');
$templatepath = $this->baseurl . '/templates/' . $this->template;

// @TODO: decide how to handle web fonts, and set them from template paramters
$fontstyle = 'arial';
$fontfamily = 'sans-serif';

// @TODO: some template variables that need defined programmatically or factored out
$show_breadcrumbs = 1;
$sidenav = 0;
$span = 8; // used in content_top partial

/*
*  User Input Variables
*
*  Jinput->getCmd(mixed $name, \= $default) : string
*  Allow a-z, 0-9, underscore, dot, dash. Also remove leading dots from result. 
*/
$itemid   = $app->input->getCmd('Itemid', '');
// $layout = $app->input->getCmd('layout', '');
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$sitename = $app->get('sitename');
$task     = $app->input->getCmd('task', '');

// @TODO: Remove pattern implementation from template
// Pattern options
// $pattern = $this->params->get('pattern');

// @TODO: Two definitions for ("$layout"), one from URL input values,
// one from the template options in the DB. Are the template parameter
// different than what would be passed in Joomla! URL as option?

// @TODO: Removed but still have boolean $sidenav and
// $splitmenu_col with values "leftcol", $show_breadcrumbs

/*
*  Google Font
*/
if ($this->params->get('googleFont')) {
  JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
  $this->addStyleDeclaration("
  h1, h2, h3, h4, h5, h6, .site-title {
    font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
  }");
}

/*
*  Body Font
*/
if($this->params->get('bodyFont')) {
      JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('bodyFontName'));
    $this->addStyleDeclaration("
      body {
    font-family: '" . str_replace('+', ' ', $this->params->get('bodyFontName')) . "', sans-serif;
  }");
}

/*
*  Navigation Font
*/
if($this->params->get('navigationFont')) {
      JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('navigationFontname'));
    $this->addStyleDeclaration("
      nav {
    font-family: '" . str_replace('+', ' ', $this->params->get('navigationFontname')) . "', sans-serif;
  }");
}