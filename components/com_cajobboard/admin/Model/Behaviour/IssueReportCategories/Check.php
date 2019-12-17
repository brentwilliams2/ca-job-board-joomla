<?php
/**
 * FOF model behavior class for model validation
 *
 * Checks for empty fields that are set to NOT NULL in the database table,
 * and if the field is empty and has a default value, set it.
 *
 * @package   Calligraphic Job Board
 * @version   October 30, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\IssueReportCategories;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Exception\EnumException;
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
    //die('mark model onCheck');
    parent::onCheck($model);

    $this->assertNotEmpty( $model->getFieldValue('category'), 'COM_CAJOBBOARD_ISSUE_REPORT_CATEGORIES_ERR_CATEGORY' );
    $this->assertNotEmpty( $model->getFieldValue('url'), 'COM_CAJOBBOARD_ISSUE_REPORT_CATEGORIES_ERR_URL' );
  }
}
