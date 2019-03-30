<?php
 /**
  * MFI Template Error Page
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  // no direct access
  defined('_JEXEC') or die;

  /** @var \JDocumentError $this */

  // @TODO: Is this code sound? From the Joomla! docs
  if (!isset($this->error))
  {
    $this->error = \JError::raiseWarning(404, \JText::_('JERROR_ALERTNOAUTHOR'));
    $this->debug = false;
  }


  // @TODO: Set headers based on code error:
  if ($this->error->getCode() == '404')
  {
    header("HTTP/1.0 404 Not Found");

    // @TODO: Use an Article for a custom 404 page, need to load on page install,
    //        set to uncategorised category, set to 'unpublished, set "Robots" to
    //        "Noindex", and get article ID for custom 404 page:
    //
    // header('Location: /index.php?option=com_content&view=article&id=75');
    // exit;
  }

  // Load our template for body of error page
  include dirname(__FILE__) . "/index.php";
