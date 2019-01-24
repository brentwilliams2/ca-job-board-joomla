<?php
/**
 * Admin Control Panel Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Model\Model;

/**
 * This model handles the admin Control Panel
 */
 class ControlPanel extends Model
 {
   /**
    * Public constructor.
    *
    * @param   Container  $container
    * @param   array      $config
    */
   public function __construct(Container $container, array $config = array())
   {
     parent::__construct($container, $config);
   }
}
