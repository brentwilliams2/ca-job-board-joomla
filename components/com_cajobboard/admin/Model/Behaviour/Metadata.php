<?php
/**
 * FOF model behavior class to add the 'metadata' attribute (property)
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
 * name as this behaviour ('Metadata.php'). The model file cannot go in this
 * directory, it must stay in the root Model folder.
 */
class Metadata extends Observer
{
  /**
	 * Add the metadata field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $metadataField = $model->getFieldAlias('metadata');

    if ( $model->hasField($metadataField) )
    {
      $model->addSkipCheckField($metadataField);
    }
  }


  /**
   * Check the length of the title on calls to applySave method and handle text
   * that is too long according to the current configuration parameters. Set the
   * data object that will be bound to the model in the applySave method to the
   * input state, and update the state with any transformed values of 'metadata'.
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

    $metadataField = $model->getFieldAlias('metadata');

    // Return if the $data param isn't set or is empty, or the model doesn't have a 'title' field
    if ( !is_array($data) || !$model->hasField($metadataField) )
		{
			return;
    }

    // Set 'metadata' field to new JRegistry object when task is 'add' (bind not called yet)
    if (!is_object($model->metadata) && (!$model->metadata instanceof Registry))
    {
      $model->metadata = new Registry();
    }


    if ( isset($data['metadata_author']) && $author = $data['metadata_author'] )
		{
      // Remove HTML
      $author = $platform->filterText($author);

			$model->metadata->set('author', $author);
    }

    if ( isset($data['robots']) && $robots = $data['robots'] )
    {
      $robots = $this->parseRobots($robots);

      $model->metadata->set('robots', $robots);
    }

    // Set the state to the (possibly) modified metadata registry object
    $model->setState('metadata', $model->metadata);
  }


  /**
   * Parse the 'robots' state variable and format it to Google standards
   *
   * @param string $value   The 'robots' state variable value
   *
   * @return string   The formatted 'robots' text
   */
  private function parseRobots($value)
  {
      $value = strtoupper( str_replace(' ', '', $value) );

      // Default to INDEX
      $shouldIndex = strpos($value, 'NOINDEX') === false;

      // Default to FOLLOW
      $shouldFollow = strpos($value, 'NOFOLLOW') === false;

      $robots = $shouldIndex ? 'INDEX,' : 'NOINDEX,';
      $robots .= $shouldFollow ? 'FOLLOW' : 'NOFOLLOW';

      return $robots;
  }
}
