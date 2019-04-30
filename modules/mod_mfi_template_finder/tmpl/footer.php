<?php
 /**
 * Multi Family Insiders Template Search Module*
 *
 * Template for search box in header
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

HTMLHelper::addIncludePath(JPATH_SITE . '/components/com_finder/helpers/html');

// include Javascript for the search box
include('script.php');
?>

<div class="finder">

  <form
    id="mod-finder-searchform<?php echo $module->id; ?>"
    action="<?php echo Route::_($route); ?>"
    method="get"
    class="form-search"
    role="search"
  >

    <span class="footer-search-icon icon-search"></span>

    <input
      class="footer-search-query search-query input-medium"
      id="mod-finder-searchword<?php echo $module->id; ?>"
      name="q"
      placeholder="<?php echo Text::_('MOD_MFI_TEMPLATE_FINDER_SEARCH_VALUE'); ?>"
      size="25"
      type="text"
      value="<?php htmlspecialchars( Factory::getApplication()->input->get('q', '', 'string'), ENT_COMPAT, 'UTF-8'); ?>"
    />

    <?php echo modFinderHelper::getGetFields($route, (int) $params->get('set_itemid', 0)); ?>

  </form>

</div>
