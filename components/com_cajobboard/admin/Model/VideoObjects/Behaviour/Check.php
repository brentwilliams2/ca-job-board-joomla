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
 * @copyright Copyright (C) 2019 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\VideoObjects\Behaviour;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\VideoObjectAspectRatioEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Exception\EnumException;
use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check as BaseCheck;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

class Check extends BaseCheck
{
  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onCheck(DataModel $model)
	{
    parent::onCheck($model);

    $this->checkForValidVideoFrameSize($model);
  }


  /**
   * Checks for valid ENUM values in the 'video_frame_size' field
   *
   * @param   DataModel  $model
	 */
	protected function checkForValidVideoFrameSize(DataModel $model)
	{
    $videoFrameSizeName = $model->getFieldValue('video_frame_size');

    if ( is_string($videoFrameSizeName) )
    {
      $videoFrameSizeName = self::getValueForConstant($videoFrameSizeName);
    }

    if ( VideoObjectAspectRatioEnum::isValidEnumValue($videoFrameSizeName) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_VIDEO_OBJECT_ASPECT_RATIOS_INVALID_CONSTANT') );
    }

    $model->setFieldValue('video_frame_size', $videoFrameSizeName);
  }
}


