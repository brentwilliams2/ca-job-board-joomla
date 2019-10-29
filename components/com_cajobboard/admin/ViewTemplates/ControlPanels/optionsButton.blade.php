<?php
 /**
  * Admin Control Panel Options Button View Template
  *
  * Writes a configuration button and invokes a cancel operation (eg a checkin).
  *
  * @package   Calligraphic Job Board
  * @version   May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Uri\Uri;

  $component = urlencode($this->container->componentName);

  // returns the full path to the current view
  $uri = (string) Uri::getInstance();

  $return = urlencode(base64_encode($uri));
?>

<div class="btn-wrapper" id="toolbar-options">
  <button
    onclick="location.href='index.php?option=com_config&amp;view=component&amp;component={{ $component }}&amp;path=&amp;return={{ $return }};'"
    class="btn btn-small"
  >
	  <span class="icon-options large-icon" aria-hidden="true"> </span>
      @lang('JOPTIONS')
  </button>
</div>
