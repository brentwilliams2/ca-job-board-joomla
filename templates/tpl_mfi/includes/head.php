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

  JHtml::_('jquery.framework');
  JHtml::_('bootstrap.framework');

  // Set viewport recommended by Bootstrap for responsive CSS
  $document = JFactory::getDocument();
  $document->setMetaData('viewport', 'width=device-width, initial-scale=1');
?>

<head>

	<jdoc:include type="head" />
  <!--

  <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

	<!--[if lte IE 8]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<?php  if ($pie == 1) : // CSS3 decorations for Internet Explorer ?>
			<style>
				{behavior:url(<?php  echo $tpath; ?>/js/PIE.htc);}
			</style>
		<?php  endif; ?>
	<![endif]-->

</head>
