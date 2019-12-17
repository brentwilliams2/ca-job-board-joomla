<?php
/**
 * FOF model behavior class for model validation
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\CreditReports;

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
    parent::onCheck($model);

    $this->checkForValidDayOfWeek($model);
    $this->checkForValidRepeatFrequency($model);
  }


  /**
   * Checks for valid ENUM DaysOfWeekEnum values in the 'by_day' field
   *
   * @param   DataModel  $model
	 */
	protected function checkForValidDayOfWeek(DataModel $model)
	{
    // Action Status enum keys and values are the same text string
    $actionStatusName = $model->getFieldValue('by_day');

    if ( !ActionStatusEnum::isValidEnumValue($actionStatusName) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_REPORTS_REPEAT_FREQUENCY_INVALID_VALUE') );
    }
  }


  /**
   * Checks for valid ISO 8601 duration format values in the 'repeat_frequency' field,
   * e.g. PM1 for monthly, PW1 for weekly, PD1 for daily, PT0S for never-recurring.
   *
   * @param   DataModel  $model
	 */
	protected function checkForValidRepeatFrequency(DataModel $model)
	{
    // Action Status enum keys and values are the same text string
    $repeatFrequencyValue = $model->getFieldValue('repeat_frequency');

    // @TODO: Regex for valid value might be something like:
    // ^P(?!$)(\d+Y)?(\d+M)?(\d+W)?(\d+D)?(T(?=\d)(\d+H)?(\d+M)?(\d+S)?)?$

    $isValidValue = true;

    if (!$isValidValue)
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_REPORTS_REPEAT_FREQUENCY_INVALID_VALUE') );
    }

    $model->setFieldValue('repeat_frequency', repeatFrequencyValue);
  }
}
