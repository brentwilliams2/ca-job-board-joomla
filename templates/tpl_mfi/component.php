<?php
/**
 * @package     Calligraphic Job Board
 *
 * This template is for print-only page views
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  // no direct access
  defined('_JEXEC') or die;

  $app   = JFactory::getApplication();
  $doc   = JFactory::getDocument();

  // Add Stylesheets
  $doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="head" />
    <!--[if lt IE 9]>
      <script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
    <![endif]-->
  </head>

  <body id="print">
    <div id="overall">
      <jdoc:include type="message" />
      <jdoc:include type="component" />
    </div>
  </body>
</html>
