<?php
/**
 * FOF model behavior class to add the 'Title' attribute (property) to the
 * 'skip check field' list for validation checks on record save, and set
 * the attribute value from state and title case the value on record save.
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\Check;

use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyField;
use \Calligraphic\Cajobboard\Admin\Model\Exception\CheckFieldMissing;
use \Calligraphic\Cajobboard\Admin\Model\Exception\LengthExceeded;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;
use \Joomla\Registry\Registry;

// no direct access
defined( '_JEXEC' ) or die;

class Title extends Observer
{
  /**
   * Check the length of the title on calls to applySave method and handle text
   * that is too long according to the current configuration parameters. Set the
   * data object that will be bound to the model in the applySave method to the
   * input state, and update the state with any transformed values of 'title'.
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return void
   */
	public function onCheck(DataModel $model)
	{
    $titleField = $model->getFieldAlias('title');

    // Sanity check
    if ( !$model->hasField($titleField) )
    {
      throw new CheckFieldMissing( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_MODEL_CHECK_FIELD_MISSING_MSSG', 'title') );
    }

    $this->shouldTitleCase($model);

    $this->isRequiredLength($model);

    $this->escapeHtml($model);
  }


  /**
   * Ensure title text is in Title Case format if set a configuration option
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return  string    The title-cased title text
   */
  public function shouldTitleCase(DataModel $model)
	{
    $titleField = $model->getFieldAlias('title');

    $titleValue = $model->getFieldValue($titleField);

    if ( $model->getContainer()->params->getConfigOption('should_titlecase_title', false, $model) )
    {
      $titleValue = ucwords($titleValue);
    }

    $model->setFieldValue($titleField, $titleValue);
  }


  /**
   * Validate that the title field is set as required
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @throws LengthExceeded
   *
   * @return void
   */
  public function isRequiredLength(DataModel $model)
	{
    /** @var \FOF30\Container\Container $container */
    $container = $model->getContainer();

    $titleField = $model->getFieldAlias('title');

    $titleValue = $model->getFieldValue($titleField);

    // Configuration options

    $requiredFlag = $container->params->getConfigOption('title_length_required', true, $model);

    $maxLength = $container->params->getConfigOption('title_length', 70, $model);

    // Calculation

    $exceedsMaxLength = strlen($titleValue) > $maxLength;

    // Constants defined in Dispatcher for 'title_length_required' config.xml parameter value

    if ( $exceedsMaxLength && $requiredFlag == LENGTH_TRUNCATE_ON_EXCEEDED )
    {
      $result = $container->Text->truncateText($titleValue, $maxLength);
    }
    elseif ( $exceedsMaxLength && $requiredFlag == LENGTH_REJECT_ON_EXCEEDED )
    {
      throw new LengthExceeded( Text::_('COM_CAJOBBOARD_EXCEPTION_FIELD_LENGTH_EXCEEDED', strtolower( Text::_('COM_CAJOBBOARD_UCM_FIELD_NAME_TITLE') )));
    }
  }


  /**
   * Escape the string for HTML characters
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return  string    The title-cased title text
   */
  public function escapeHtml(DataModel $model)
	{
    $titleField = $model->getFieldAlias('title');

    $titleValue = $model->getFieldValue($titleField);

    if (!$titleValue)
    {
      return;
    }

    // Remove HTML
    $filteredTitle = $model->getContainer()->Text->filterText($titleValue);

    $model->setFieldValue($titleField, $filteredTitle);
  }
}
