<?php
/**
 * Site Analytic Aggregates Model
 *
 * @package   Calligraphic Job Board
 * @version   September 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;

/**
 * Fields:
 *
 * UCM
 * @property int            $analytic_aggregate_id   Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id                     FK to the #__assets table for access control purposes.
 * @property int            $access                       The Joomla! view access level.
 * @property string         $created_on                   Timestamp of record creation, auto-filled by save().
 * @property int            $created_by                   User ID who created the record, auto-filled by save().
 * @property string         $modified_on                  Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by                  User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on                    Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by                    User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s           UCM when using the FOF ContentHistory behaviour
 * @property int            $ordering                   Order this record should appear in for sorting.
 * @property string         $params                     JSON encoded parameters for this item.
 * @property int            $cat_id                     Category ID for this item.
 * @property string         $note                       A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name                       A title to use for the analytic.
 * @property string         $description                A description of the analytic.
 * @property string         $description__intro         Short description of the item, used for the text shown on social media via shares and search engine results.
 * @property int            $about__foreign_model_id    The foreign model primary key that this comment belongs to
 * @property string         $about__foreign_model_name  The name of the foreign model this comment belongs to, discriminator field for single-table inheritance
 *
 * @property json           $structured_value           The values for this analytic aggregate, in a JSON string.
 */
class AnalyticAggregates extends \Calligraphic\Cajobboard\Admin\Model\AnalyticAggregates
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
