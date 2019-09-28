<?php
/**
 * Overridden model behavior class to order comments based on about__foreign_model_id / about__foreign_model_name fields
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Site\Model\Behaviour\Comments;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Ordering and order direction are checked for validity in the DataModel
 * before use so no danger here of setting them to request state
 */
class Ordering extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Comments\Ordering
{

}
