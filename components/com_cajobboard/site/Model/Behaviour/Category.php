<?php
/**
 * FOF model behavior class to set category in new records.
 * Sets the category to the category created for the model.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

use \Calligraphic\Cajobboard\Admin\Helper\Category as CategoryHelper;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Log\Log;

// no direct access
defined( '_JEXEC' ) or die;

class Category extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Category
{

}
