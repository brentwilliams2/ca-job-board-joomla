<?php
/**
 * FOF model behavior class to backfill the slug field with the
 * 'title' property or its fieldAlias if the slug field is empty.
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

// no direct access
defined( '_JEXEC' ) or die;

class Slug extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Slug
{

}
