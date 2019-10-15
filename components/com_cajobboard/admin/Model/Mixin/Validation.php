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

    // handle TreeModel logic in it's over-ridden check() method
    if ($this->hasField('lft') && $this->hasField('rgt'))
		{
			// Create the SHA-1 hash of the slug for faster searching (make sure the hash column is CHAR(64) to take
      // advantage of MySQL's optimised searching for fixed size CHAR columns)
      if ($this->hasField('hash') && $this->hasField('slug'))
      {
        $this->hash = sha1($this->slug);
      }

      // Reset cached values
      $this->resetTreeCache();
		}

    // Runs before the Check behaviour, use to add fields to the 'skip check field' list
    $this->triggerEvent('onBeforeCheck');

    // Runs the Check behaviour, throw exception in observer classes if validation check fails
    $this->triggerEvent('onCheck');

    // Runs field-specific validation behaviours performed after the base checks
    $this->triggerEvent('onAfterCheck');

    return $this;
  }
}
