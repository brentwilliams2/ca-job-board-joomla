<?php
/**
 * FOF model behavior class to add the 'description__intro' attribute (property)
 * to the 'skip check field' list for validation checks on record save,
 * and set the attribute value from state on record save.
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
use \FOF30\Platform\PlatformInterface;
use \Joomla\Registry\Registry;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * To override validation behaviour for a particular model, create a directory
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('DescriptionIntro.php'). The model file cannot go in this
 * directory, it must stay in the root Model folder.
 */
class DescriptionIntro extends Observer
{
  /**
	 * Add the 'description__intro' field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $descriptionIntroField= $model->getFieldAlias('description__intro');

    if ( $model->hasField($descriptionIntroField) )
    {
      $model->addSkipCheckField($descriptionIntroField);
    }
  }


  /**
   * Check the length of the title on calls to applySave method and handle text
   * that is too long according to the current configuration parameters. Set the
   * data object that will be bound to the model in the applySave method to the
   * input state, and update the state with any transformed values of 'description__intro'.
   *
   * @param DataModel $model  The data model associated with this call
   * @param array     $data   An associative array populated by \Joomla\Input\Input from the $_REQUEST global variable
   *
   * @return void
   */
  public function onBeforeSave(DataModel $model, &$data)
  {
    /** @var PlatformInterface $platform */
    $platform = $model->getContainer()->platform;

    $descriptionIntroField = $model->getFieldAlias('description__intro');

    // Return if the $data param isn't set or is empty, or the model doesn't have a 'description__intro' field
    if
    (
      !is_array($data) ||
      !isset($data['description__intro']) ||
      !$description = $data['description__intro'] ||
      !$model->hasField($descriptionIntroField)
    )
		{
			return;
    }

    $requiredFlag = $platform->getConfigOption('description__intro_length_required', true, $model);

    // Subtract three from the maximum length to account for the ellipse (...)
    $maxLength = $platform->getConfigOption('description__intro_length', 280, $model) -3;

    $exceedsMaxLength = strlen($description) > $maxLength;

    if ( $exceedsMaxLength && $requiredFlag == LENGTH_TRUNCATE_ON_EXCEEDED )
    {
      $result = $platform->truncateText($description, $maxLength) . '...';
    }
    elseif ( $exceedsMaxLength && $requiredFlag == LENGTH_REJECT_ON_EXCEEDED )
    {
      throw new LengthExceeded( Text::_('COM_CAJOBBOARD_UCM_FIELD_NAME_DESCRIPTION_INTRO', strtolower( Text::_('COM_CAJOBBOARD_UCM_FIELD_NAME_TITLE') )));
    }

    // Remove HTML
    $result = $platform->filterText($result);

    $data['description__intro'] = $result;

    // Set the state to the (possibly) modified description text string
    $model->setState('description__intro', $result);
  }
}
