<?php
/**
 * Base Admin Hierarchical Nested List Model for all Job Board Models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c) 2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Model\DataModel;

/**
 * Model class description
 */
class BaseTreeModel extends TreeModel
{
  // Traits to include in the class
  use Mixin\Archive;
  use Mixin\Assertions;
  use Mixin\Asset;
  use Mixin\Attributes;
  use Mixin\Comments;
  use Mixin\Core;
  use Mixin\JsonData;
  use Mixin\Validation;


 	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    /* Parent constructor */
    parent::__construct($container, $config);
  }


  /**
	 * Alias for belongsTo() relation. FOF has a hasOne() relation, where the relation field is
   * in the foreign table. You can do the inverse (relation field in this model's table) by
   * using belongsTo().
	 *
	 * @return   $this  For chaining
	 */
  public function inverseSideOfHasOne(string $name, string $foreignModelClass = null, string $localKey = null, string $foreignKey = null)
  {
    $this->belongsTo($name, $foreignModelClass, $localKey, $foreignKey);
  }
}
