<?php
/**
 * FOF model behavior class to manage the 'featured' field, for example
 * to handle billing / subscription integration for allowing employers 
 * to feature a job posting
 *
 * @package   Calligraphic Job Board
 * @version   November 6, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

// no direct access
defined( '_JEXEC' ) or die;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;

/**
 * To override validation behaviour for a particular model, create a directory
 * named named after the model in the 'Behaviour' directory and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class Featured extends Observer
{
  /**
	 * Add the 'featured' field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $featuredField= $item->getFieldAlias('featured');

    if ( $item->hasField($featuredField) )
    {
      $item->addSkipCheckField($featuredField);
    }
  }


	/**
   * @TODO: add behaviour for allowing employers to feature a job posting based on subscription status
   *
   * @param DataModel $item  The data model associated with this call
   * @param array     $data   An associative array populated by \Joomla\Input\Input from the $_REQUEST global variable
   *
   * @return void
   */
  public function onBeforeSave(DataModel $item, &$data)
	{

	}
}