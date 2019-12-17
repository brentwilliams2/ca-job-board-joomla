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
class Tree extends Observer
{
  /**
	 * Add the hierarchical nested tree model fields to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in using TreeModel methods on save.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    if ( $item->hasField('lft') )
    {
      $this->addSkipCheckField('lft');
    }

    if ( $item->hasField('rgt') )
    {
      $this->addSkipCheckField('rgt');
    }

    if ( $item->hasField('hash') )
    {
      $this->addSkipCheckField('hash');
    }
  }
}