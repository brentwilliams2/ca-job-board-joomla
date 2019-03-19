<?php
/**
 * Site Answers Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use FOF30\Container\Container;
use FOF30\Controller\DataController;
use FOF30\View\Exception\AccessForbidden;
use JLog;

// no direct access
defined('_JEXEC') or die;

class Answer extends DataController
{
  // Should be able to use:
  // $categories = JCategories::getInstance('Cajobboard');
  // $subCategories = $categories->get()->getChildren(true);

	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'Answers';

    $this->predefinedTaskList = ['browse', 'read', 'edit', 'add', 'save'];

    parent::__construct($container, $config);
  }

  // Overridden, model which use asset tracking don't work with read tasks
  protected function checkACL($area)
  {
    return ($area == 'read') ? true : parent::checkACL($area);
  }

  // @TODO: Necessary with the above?
  public function onBeforeExecute($task)
  {
    // Avoiding ACL check done in triggerEvent() when there isn't a method to call for the 'execute' task
    // This because sample data doesn't have asset_id field with FK and #__assets entry for the item
    return true;
  }


  public function onBeforeRead()
  {
    // Avoiding ACL check done in triggerEvent() when there isn't a method to call for the 'read' task
    // This because sample data doesn't have asset_id field with FK and #__assets entry for the item
    return true;
  }


  public function onBeforeEdit()
  {
    // Avoiding ACL check done in triggerEvent() when there isn't a method to call for the 'edit' task
    // This because sample data doesn't have asset_id field with FK and #__assets entry for the item
    return true;
  }
}
