<?php
/**
 * Model behaviour to restrict access for Personally Identifiable Information (PII)
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
use \Joomla\CMS\Application\ApplicationHelper;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;


class PII extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\PII
{

}
