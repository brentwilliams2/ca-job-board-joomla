<?php
/**
 * FOF model behavior class for model validation
 *
 * Checks for empty fields that are set to NOT NULL in the database table,
 * and if the field is empty and has a default value, set it.
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\OrganizationTypes;

use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check as BaseCheck;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

class Check extends BaseCheck
{
  /* Trait methods to include in class */
  use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Mixin\Assertions;

  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onCheck(DataModel $model)
	{
    parent::onCheck($model);

    $this->assertNotEmpty( $model->getFieldValue('item_list_element'), 'COM_CAJOBBOARD_ORGANIZATION_TYPES_ERR_ITEM_LIST_ELEMENT' );
		$this->assertNotEmpty( $model->getFieldValue('item_list_order_type'), 'COM_CAJOBBOARD_ORGANIZATION_TYPES_ERR_ITEM_LIST_ORDER_TYPE' );
		$this->assertNotEmpty( $model->getFieldValue('url'), 'COM_CAJOBBOARD_ORGANIZATION_TYPES_ERR_URL' );
  }
}
