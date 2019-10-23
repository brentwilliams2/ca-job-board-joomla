<?php
/**
 * Site Model behavior class to filter access to items based on the enabled status,
 * over-ridden to handle TreeModel errors with 'ambiguous query field'
 *
 * @package   Calligraphic Job Board
 * @version   October 16, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

defined('_JEXEC') or die;

class Enabled extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Enabled
{

}