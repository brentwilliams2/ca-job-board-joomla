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

abstract class VendorRolesEnum extends BasicEnum
{
  const BACKGROUND_CHECKS;
  const CREDIT_REPORTS;
  const OTHER;

  /**
   * Get available vendor roles as an associative array, with key as role name
   *
   * @return array
   */
  public function getVendorRoleNames()
  {
    return self::getConstants();
  }


  /**
   * Get human-readable available aspect ratios as an array
   *
   * @return array  Returns an associative array of human-readable aspect ratio names
   */
  public static function getHumanReadableVendorRoleNamess()
  {
    $vendorRolesArray = self::getConstants();

    $newVendorRolesArray = array();

    foreach ($vendorRolesArray as $name)
    {
      $humanReadableName = Text::_('COM_CAJOBBOARD_ENUM_VENDOR_ROLES_' . $name);

      array_push($newAspectRatiosArray, $humanReadableName);
    }

    return $newVendorRolesArray;
  }
}
