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

use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

trait Feature
{
  /**
	 * Unfeature selected item(s)
	 *
	 * @return  void
	 */
	public function feature()
	{
    $this->csrfProtection();

    try
    {
      $this->toggleFeatured(true);
    }
    catch (\Exception $error)
    {
      $this->setRedirect($this->getRedirectUrl(), $error, 'error');
    }

    $this->setRedirect($this->getRedirectUrl(), $this->getRedirectFlashMsg('feature'), 'message');
  }


  /**
	 * Unfeature selected item(s)
	 *
	 * @return  void
	 */
	public function unfeature()
	{
    $this->csrfProtection();

    try
    {
      $this->toggleFeatured(false);
    }
    catch (\Exception $error)
    {
      $this->setRedirect($this->getRedirectUrl(), $error, 'error');
    }

    $this->setRedirect($this->getRedirectUrl(), $this->getRedirectFlashMsg('unfeature'), 'message');
  }


  /**
	 * Toggle the 'feature' field value for the selected item(s)
   *
   * @param  bool $isFeatured   Whether this item should be set to featured, or unfeatured
	 *
	 * @return  void|string   Returns error message on exception
	 */
	public function toggleFeatured($isFeatured = false)
	{
    $model = $this->getModel()->savestate(false);
    $ids   = $this->getIDsFromRequest($model, false);

		try
		{
      $status = true;

			foreach ($ids as $id)
			{
				$model->find($id);
				$model->setFeaturedState($isFeatured);
			}
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
    }
  }
}
