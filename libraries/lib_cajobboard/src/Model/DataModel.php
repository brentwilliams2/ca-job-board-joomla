<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Model;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Data-aware model, implementing a convenient ORM
 *
 */
class DataModel extends FOF30\Model\DataModel implements \JTableInterface
{
  public function __construct(Container $container, array $config = array())
	{
		// First call the parent constructor.
		parent::__construct($container, $config);
  }

  
}