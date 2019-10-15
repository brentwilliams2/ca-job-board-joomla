<?php
/**
 * Output from jdoc:include for message type
 *
 * Provides the jdoc:include 'message' output for user flash message (e.g. persistent in session state)
 *
 * @package     Calligraphic Job Board
 *
 * @version     May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  // no direct access
  defined('_JEXEC') or die;

  // @TODO: Joomla's $this->countModules('message') never returns true here, so can't
  //        use classes like Bootstrap's 'well' or it always shows
?>

<div id="content-message-container" class="content-message-container">
  <jdoc:include type="message" />
</div>
