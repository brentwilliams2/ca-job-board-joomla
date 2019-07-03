<?php
/**
 * Trait to provide overridden check() method
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Joomla\CMS\Factory;
use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyFieldException;

// no direct access
defined('_JEXEC') or die;

trait Validation
{
  /**
   * The Check behaviour is designed to run on the onBeforeCheck event. Any
   * other behaviours interested in the Check events should run on onAfterCheck.
   * The onAfterCheck event is not implemented in FOF30 DataModel as of May 2019.
   *
   * To override a behaviour for a particular model, create a directory
   * named 'Behaviour' in a child directory of a directory named after the model.
   * Move the model file into the directory without renaming it (e.g.
   * 'Model/Answers/Answers.php). Create a behaviour file named after the behaviour
   * it is overriding.
   *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
		if (!$this->autoChecks)
		{
			return $this;
    }

    try
    {
      // Runs the Check behaviour
      $this->triggerEvent('onBeforeCheck');

      // Run the check routine event
      $this->triggerEvent('onAfterCheck');
    }
    catch (\Exception $e)
    {
      if ($e instanceof InvalidFieldException)
      {
        //
        $url = $this->getName();
        $url = 'index.php?option=com_cajobboard&view='. Message . '&id=' . $this->get . '&task=edit';

        // Set a flash message with the problem and redirect to the last page
        $this->container->platform->redirect($url, '500', $e->getMessage(), 'error');
      }

      throw $e;
    }

    return $this;
  }
}
