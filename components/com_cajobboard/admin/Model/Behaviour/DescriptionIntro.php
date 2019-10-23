<?php
/**
 * FOF model behavior class to add the 'description__intro' attribute (property)
 * to the 'skip check field' list for validation checks on record save,
 * and set the attribute value from state on record save.
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
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
 * named named after the model in the 'Behaviour' directory and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class DescriptionIntro extends Observer
{
  /**
	 * Add the 'description__intro' field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $descriptionIntroField= $item->getFieldAlias('description__intro');

    if ( $item->hasField($descriptionIntroField) )
    {
      $item->addSkipCheckField($descriptionIntroField);
    }
  }


  /**
   * Check the length of the title on calls to applySave method and handle text
   * that is too long according to the current configuration parameters. Set the
   * data object that will be bound to the model in the applySave method to the
   * input state, and update the state with any transformed values of 'description__intro'.
   *
   * @param DataModel $item  The data model associated with this call
   * @param array     $data   An associative array populated by \Joomla\Input\Input from the $_REQUEST global variable
   *
   * @return void
   */
  public function onBeforeSave(DataModel $item, &$data)
  {
    // $data is a nullable parameter to save(), this method is only concerned
    // with user input so return if there is none (e.g. no $data)
    if ( !is_array($data) )
    {
      return;
    }

    /** @var \FOF30\Container\Container $container */
    $container = $item->getContainer();

    $descriptionIntroFieldAlias = $item->getFieldAlias('description__intro');

    // Return if the $data param isn't set or is empty, or the model doesn't have a 'description__intro' field
    if (
      !$item->hasField($descriptionIntroFieldAlias) ||
      !array_key_exists($descriptionIntroFieldAlias, $data) ||
      empty( $data[$descriptionIntroFieldAlias] )
      )
		{
			return;
    }

    $descriptionIntro = $data[$descriptionIntroFieldAlias];

    $requiredFlag = $container->params->getConfigOption('description__intro_length_required', true, $item);

    // Subtract three from the maximum length to account for the ellipse (...)
    $maxLength = $container->params->getConfigOption('description__intro_length', 280, $item) -3;

    $exceedsMaxLength = strlen($descriptionIntro) > $maxLength;

    if ( $exceedsMaxLength && $requiredFlag == LENGTH_TRUNCATE_ON_EXCEEDED )
    {
      $descriptionIntroTruncated = $container->Text->truncateText($descriptionIntro, $maxLength) . '...';
    }
    elseif ( $exceedsMaxLength && $requiredFlag == LENGTH_REJECT_ON_EXCEEDED )
    {
      throw new LengthExceeded( Text::_('COM_CAJOBBOARD_DESCRIPTION_INTRO_LENGTH_REQUIRED_FOR_SOCIAL_SHARES_LABEL') );
    }

    // Remove HTML
    $descriptionIntroFiltered = $container->Text->filterText($descriptionIntroTruncated);

    $data[$descriptionIntroFieldAlias] = $descriptionIntroFiltered;
  }
}
