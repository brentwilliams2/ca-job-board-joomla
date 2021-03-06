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
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\ImageObjects;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\ImageObjectAspectRatioEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Exception\EnumException;
use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check as BaseCheck;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

class Check extends BaseCheck
{
  /**
	 * @param   DataModel  $model
	 */
	public function onCheck(DataModel $model)
	{
    parent::onCheck($model);

    $this->checkForValidImageAspectRatio($model);
  }


  /**
   * Checks for valid ENUM values in the 'aspect_ratio' field
   *
   * @param   DataModel  $model
	 */
	protected function checkForValidImageAspectRatio(DataModel $model)
	{
    // Image Object Aspect Ratio enum keys and values are the same text string
    $imageObjectAspectRatioName = $model->getFieldValue('aspect_ratio');

    if ( !ImageObjectAspectRatioEnum::isValidEnumValue($imageObjectAspectRatioName) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_IMAGE_OBJECT_ASPECT_RATIO_INVALID_CONSTANT') );
    }
  }
}


