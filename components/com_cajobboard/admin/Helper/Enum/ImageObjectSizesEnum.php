<?php
/**
 * Admin Image Objects Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\BasicEnum;

/*
 * ENUM class for system image object sizes. Each value corresponds to a directory
 * in Joomla!'s site /media/com_cajobboard/{category name}/ folder (note that category
 * and model names are the same so the model name can be denormalized after lowercasing)
 */
abstract class ImageObjectSizesEnum extends BasicEnum
{
  const Original = 'original';
  const Thumb = 'thumb';
  const Small = 'small';
  const Medium = 'medium';
  const Large = 'large';
}
