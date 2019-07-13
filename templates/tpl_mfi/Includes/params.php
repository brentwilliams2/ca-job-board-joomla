<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Factory;

  /*
   * Whether we are on an error page or not
   *
   * @var   Boolean   $isErrorPage
   */
  if ( is_a($this, '\Joomla\CMS\Document\ErrorDocument') )
  {
    $this->isErrorPage = true;
  }
  elseif (is_a($this, '\Joomla\CMS\Document\Document'))
  {
    $this->isErrorPage = false;
  }
  else
  {
    die("\$this in MFI template params.php file is not a Joomla! Document object, we are probably in a CLI environment (should have been caught in the exception handler):\n" . var_dump($this) );
  }

  /* @var  \Joomla\CMS\Application\SiteApplication */
  $app = Factory::getApplication();

  /* @var  \Joomla\Registry\Registry */
  $menu = $app->getMenu();

  /* @var   string   */
  $this->templatePath = Factory::getURI()->base() . 'templates/' . $app->getTemplate();

   /* @var   bool   */
  $this->isFrontPage = ( $menu->getActive() === $menu->getDefault() );
