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

// no direct access
defined('_JEXEC') or die;

trait Validation
{
  /**
   * The onCheck and onAfterCheck event is not implemented in FOF30 DataModel as of May 2019.
   *
   * To override validation behaviour for a particular model, create a directory
   * named 'Behaviour' in a directory named after the model and use the same file
   * name as the behaviour ('Check.php'). The model file cannot go in this
   * directory, it must stay in the root Model folder.
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

    // Runs before the Check behaviour, use to add fields to the 'skip check field' list
    $this->triggerEvent('onBeforeCheck');

    // Runs the Check behaviour
    $this->triggerEvent('onCheck');

    // Runs field-specific validation behaviours performed after the base checks
    $this->triggerEvent('onAfterCheck');

    return $this;
  }
}
