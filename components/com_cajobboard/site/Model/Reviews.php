<?php
/**
 * Site Reviews Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;

/**
 * Fields:
 *
 * @property int      $review_id                  Surrogate primary key
 * @property string   $slug                       Alias for SEF URL
 * FOF "magic" fields
 * @property int      $asset_id                   FK to the #__assets table for access control purposes.
 * @property int      $access                     The Joomla! view access level.
 * @property int      $enabled                    Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string   $created_on                 Timestamp of record creation, auto-filled by save().
 * @property int      $created_by                 User ID who created the record, auto-filled by save().
 * @property string   $modified_on                Timestamp of record modification, auto-filled by save(), touch().
 * @property int      $modified_by                User ID who modified the record, auto-filled by save(), touch().
 * @property string   $locked_on                  Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int      $locked_by                  User ID who locked the record, auto-filled by lock(), unlock().
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string   $publish_up                 Date and time to change the state to published, schema.org alias is datePosted.
 * @property string   $publish_down               Date and time to change the state to unpublished.
 * @property int      $version                    Version of this item.
 * @property int      $ordering                   Order this record should appear in for sorting.
 * @property object   $metadata                   JSON encoded metadata field for this item.
 * @property string   $metakey                    Meta keywords for this item.
 * @property string   $metadesc                   Meta descriptionfor this item.
 * @property string   $xreference                 A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string   $params                     JSON encoded parameters for the content item.
 * @property string   $language                   The language code for the article or * for all languages.
 * @property int      $cat_id                     Category ID for this content item.
 * @property int      $hits                       Number of hits the content item has received on the site.
 * @property int      $featured                   Whether this content item is featured or not.
 * SCHEMA: Thing
 * @property  string  $name                       A name for this review, aliased to title.
 * SCHEMA: Review
 * @property  Organizations		  $ItemReviewed     The employer being reviewed/rated, FK to #__cajobboard_organizations
 * @property  string  $review_body                The actual body of the review.
 * SCHEMA: Review(reviewRating) -> Rating(ratingValue)
 * @property  int		  $rating_value               The rating for the content. Default worstRating 1 and bestRating 5 assumed.
 * SCHEMA: CreateWork
 * @property  JUser		$Author                     The author of this content or rating, FK to #__users
 */
class Reviews extends \Calligraphic\Cajobboard\Admin\Model\Reviews
{
  /*
   * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
