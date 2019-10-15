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

use \Calligraphic\Cajobboard\Site\Controller\Exception\VoteUpdateFailure;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Router\Route;

// no direct access
defined('_JEXEC') or die;

trait Votes
{
  /**
	 * Downvote (an) item(s) via XHR
	 *
	 * @return  void
	 */
	public function downvote_count()
	{
    // @TODO: need a "completed" state variable and set is so the front-end can display: $canVote in 
    //        it differently then the user's done something allowed only one time

    // @TODO: this needs to return a JSON response, either an updated 'count' or an error message to flash

    $callback = function (DataModel $model, $oldValue) {
      return $oldValue++;
    };

    $this->setField('downvote_count', null, true, $callback);

    return $AResponse;
  }


  /**
	 * Upvote (an) item(s) via XHR
	 *
	 * @return  void
	 */
	public function upvote_count()
	{
    // @TODO: see downvote_count()
  }
}
