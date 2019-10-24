<?php
/**
 * Custom Joomla! HTMLHelper class for site enum HTML widgets for all views
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.editwidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system, and class
// names have to be lower-cased and follow a naming convention for the JLoader scheme to work.

use \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum;
use \Calligraphic\Cajobboard\Site\Helper\Html\Utility;
use \Joomla\CMS\Language\Text;

abstract class HelperEnumwidgets
{
  /**
   * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view.
	 *
   * @param   string    $currentActionStatus  The current status of the item, as a valid ENUM
   * @param 	string 		$prefix               A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud                 The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function actionStatus($currentActionStatus, $prefix = null, $crud = null)
	{
    $selectClass = Utility::getAttributeClass('action-status', $prefix, $crud);

    // Returns array of human-readable enum constants keys with the enum constant's value, e.g. array('Active' => 'ACTIVE')
    $actionStatusEnums = ActionStatusEnum::getHumanReadableConstants();

    $html  = '<label for="action-status-select">' . Text::_('COM_CAJOBBOARD_ACTION_STATUS_SELECT_LABEL') . '</label>';
    $html .= '<select name="action_status" id="action-status-select" class="' . $selectClass . ' form-control">';

    foreach ($actionStatusEnums as $key => $value)
    {
      $selected = ($currentActionStatus == $key) ? 'selected ' : '';

      $html .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
    }

    $html .= '</select>';

    return $html;
  }
}