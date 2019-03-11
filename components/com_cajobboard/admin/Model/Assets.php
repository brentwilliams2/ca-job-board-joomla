<?php
/**
 * Admin Assets Model
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
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;
use FOF30\Model\TreeModel;

/**
 * Model class for Job Board assets
 *
 * Fields:
 *
 * @property  int     $parent_id    Primary key for the asset record
 * @property  string  $level        Cached level of this asset record
 * @property  string  $name         The unique name of this asset record, e.g. com_cajobboard.jobpostings.5
 * @property  string  $title        The descriptive title for the asset, defaults to `name` field value except for Root asset
 * @property  string  $rules        A JSON-encoded string of rules for this asset record, e.g.:
 *
 *                                  {"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}
 *
 * Example cached levels in the nested tree:
 *
 *   Level 1:  com_content
 *
 *   Level 2:  com_content.category.12
 *             com_content.fieldgroup.1
 *
 *   Level 3:  com_content.article.2
 *             com_content.field.2
 */
class Assets extends TreeModel
{
  /*
   * Overridden constructor
   */
	public function __construct(Container $container, array $config = array())
	{
		$config['tableName'] = '#__assets';
    $config['idFieldName'] = 'id';

    parent::__construct($container, $config);

		// Do not run automatic value validation of data before saving it.
    $this->autoChecks = false;
  }

  protected function getRulesAttribute($value)
  {
    var_dump($value);
    die();

      // Return the data transformed to a JRegistry object
      return new \JRegistry($value);
  }
}
