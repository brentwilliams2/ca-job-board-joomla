<?php
/**
 * FOF model behavior class that acts as a marker interface for models with the
 * 'note' table field, and to do any operations useful for it
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
class Note extends Observer
{
  /**
	 * Add the 'note' field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $noteField= $item->getFieldAlias('note');

    if ( $item->hasField($noteField) )
    {
      $item->addSkipCheckField($noteField);
    }
  }
}