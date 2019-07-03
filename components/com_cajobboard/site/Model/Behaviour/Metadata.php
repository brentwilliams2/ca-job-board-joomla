<?php
/**
 * FOF model behavior class to set the 'metadata' JSON field on record save
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\Registry\Registry;

// no direct access
defined( '_JEXEC' ) or die;

class Metadata extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Metadata
{

}
