<?php
/**
 * Custom Joomla! HTMLHelper class for editors
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.editorWidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Editor\Editor;

abstract class HelperEditorWidgets
{
  /*
   *
   */
	public static function editor($fieldName, $value, array $params = [])
	{
		$params = array_merge([
			'id'         => null,
			'editor'     => null,
			'width'      => '100%',
			'height'     => 500,
			'columns'    => 50,
			'rows'       => 20,
			'created_by' => null,
			'asset_id'   => null,
			'buttons'    => true,
			'hide'       => false,
    ], $params);

    $editorType = $params['editor'];

		if (is_null($editorType))
		{
      $editorType = Factory::getConfig()->get('editor');

      $user   = Factory::getUser();

			if (!$user->guest)
			{
				$editorType = $user->getParam('editor', $editorType);
			}
    }

		if (is_null($params['id']))
		{
			$params['id'] = $fieldName;
		}
    $editor = Editor::getInstance($editorType);

		return $editor->display(
      $fieldName, $value,
      $params['width'],
      $params['height'],
      $params['columns'],
      $params['rows'],
      $params['buttons'],
      $params['id'],
      $params['asset_id'],
      $params['created_by'],
      $params
    );
	}
}
