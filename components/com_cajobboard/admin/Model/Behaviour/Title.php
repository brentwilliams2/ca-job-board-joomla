<?php
/**
 * FOF model behavior class to add the 'Title' attribute (property) to the
 * 'skip check field' list for validation checks on record save, and set
 * the attribute value from state and title case the value on record save.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Model\Exception\LengthExceeded;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * To override validation behaviour for a particular model, create a directory
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('title.php'). The model file cannot go in this
 * directory, it must stay in the root Model folder.
 */
class Title extends Observer
{
  /**
	 * Add the title field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $titleField = $model->getFieldAlias('title');

    if ( $model->hasField($titleField) )
    {
      $model->addSkipCheckField($titleField);
    }
  }


  /**
   * Check the length of the title on calls to applySave method and handle text
   * that is too long according to the current configuration parameters. Set the
   * data object that will be bound to the model in the applySave method to the
   * input state, and update the state with any transformed values of 'title'.
   *
   * @param DataModel $model  The data model associated with this call
   * @param array     $data   An associative array populated by \Joomla\Input\Input from the $_REQUEST global variable
   *
   * @return void
   */
  public function onBeforeSave(DataModel $model, &$data)
  {
    $platform = $this->container->platform;

    $titleField = $model->getFieldAlias('title');

    // Return if the $data param isn't set or is empty, or the model doesn't have a 'title' field
    if
    (
      !is_array($data) ||
      !isset($data['title']) ||
      !$title = $data['title'] ||
      !$model->hasField($titleField)
    )
		{
			return;
    }

    if ( $platform->getConfigOption('should_titlecase_title', false, $model) )
    {
      $title = ucwords($title);
    }

    $requiredFlag = $platform->getConfigOption('title_length_required', true, $model);

    $maxLength = $platform->getConfigOption('title_length', 70, $model);

    $exceedsMaxLength = strlen($title) > $maxLength;

    if ( $exceedsMaxLength && $requiredFlag == LENGTH_TRUNCATE_ON_EXCEEDED )
    {
      $result = $platform->truncateText($title, $maxLength);
    }
    elseif ( $exceedsMaxLength && $requiredFlag == LENGTH_REJECT_ON_EXCEEDED )
    {
      throw new LengthExceeded( Text::_('COM_CAJOBBOARD_EXCEPTION_FIELD_LENGTH_EXCEEDED', strtolower( Text::_('COM_CAJOBBOARD_UCM_FIELD_NAME_TITLE') )));
    }

    // Remove HTML
    $result = $platform->filterText($result);

    $data['title'] = $result;

    // Set the state to the (possibly) modified title string
    $model->setState('title', $result);
  }
}
