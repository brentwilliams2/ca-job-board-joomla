<?php
/**
 * Admin "Featured" Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Controller\Exception\FeatureToggleFailure;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// NOTE: Depends on Trait \Calligraphic\Cajobboard\Admin\Controller\Mixin\SetFieldOnModels

trait Feature
{
  /**
	 * Unfeature selected item(s)
	 *
	 * @return  void
	 */
	public function feature()
	{
    $this->setFieldOnModels('featured', true);
  }


  /**
	 * Unfeature selected item(s)
	 *
	 * @return  void
	 */
	public function unfeature()
	{
    $this->setFieldOnModels('featured', false);
  }
}
