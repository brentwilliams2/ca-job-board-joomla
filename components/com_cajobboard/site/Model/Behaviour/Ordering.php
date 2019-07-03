<?php
/**
 * FOF model behavior class to order items owned by
 * (1) Featured status and (2) Created On date
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \JDatabaseQuery;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * To override ordering behaviour for a particular model, create a directory
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('Ordering.php'). Move the model file into the directory
 * without renaming it (e.g. 'Model/Answers/Answers.php)
 *
 * Ordering and order direction are checked for validity in the DataModel
 * before use so no danger here of setting them to request state
 */
class Ordering extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Ordering
{

}
