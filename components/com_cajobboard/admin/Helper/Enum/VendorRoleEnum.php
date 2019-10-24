<?php
/**
 * Admin Vendor Model Vendor Roles Enum Helper, e.g. 'Background Checks', 'Credit Reports', etc.
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\BasicEnum;
use \Joomla\CMS\Language\Text;

abstract class VendorRoleEnum extends BasicEnum
{
  const BACKGROUND_CHECKS = 'BACKGROUND_CHECKS';
  const CREDIT_REPORTS = 'CREDIT_REPORTS';
  const OTHER = 'OTHER';

  /**
   * Get available vendor roles as an associative array, with key as role name
   *
   * @return array
   */
  public static function getVendorRoleNames()
  {
    return self::getConstants();
  }
}
