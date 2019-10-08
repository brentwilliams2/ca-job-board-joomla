<?php
/**
 * Site 'downvote' and 'upvote' Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   October 3, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only

 */

namespace Calligraphic\Cajobboard\Site\Controller\Mixin;

use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Site\Controller\Exception\VoteUpdateFailure;

// no direct access
defined('_JEXEC') or die;

// NOTE: Depends on Trait \Calligraphic\Cajobboard\Admin\Controller\Mixin\SetFieldOnModels

trait Votes
{
  /**
	 * Downvote (an) item(s)
	 *
	 * @return  void
	 */
	public function downvote_count()
	{
    // @TODO: need a "completed" state variable and set is so the front-end can display
    //        it differently then the user's done something allowed only one time
    
    $callback = function ($oldValue) {
      return $oldValue++;
    };

    $this->setFieldOnModels('downvote_count', null, true, $callback);
  }


  /**
	 * Upvote (an) item(s)
	 *
	 * @return  void
	 */
	public function upvote_count()
	{
    $callback = function ($oldValue) {
      return $oldValue++;
    };

    $this->setFieldOnModels('upvote_count', null, true, $callback);
  }
}