<?php
/**
 * Trait for saving uploaded media files
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined( '_JEXEC' ) or die;

trait MediaUploads
{
  /**
	 * Save uploaded PDF files
	 */
  public function savePdfUploads($object)
  {
    // @TODO: implement
  }


  /**
	 * Save uploaded Image files
	 */
  public function saveImageUploads($object)
  {
    // @TODO: implement
  }
}
