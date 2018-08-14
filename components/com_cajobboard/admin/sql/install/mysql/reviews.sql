/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Reviews table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_reviews' (
  /* UCM (unified content model) properties for internal record metadata */
  organization_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to the #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '0' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
  locked_on DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record locking, auto-filled by lock(), unlock().',
  locked_by INT DEFAULT '0' COMMENT 'User ID who locked the record, auto-filled by lock(), unlock().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  publish_up DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time to change the state to published, schema.org alias is datePosted.',
  publish_down DATETIME COMMENT 'Date and time to change the state to unpublished.',
  version INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Version of this item.',
  ordering INT NOT NULL DEFAULT '0' COMMENT 'Order this record should appear in for sorting.',
  metadata JSON COMMENT 'JSON encoded metadata field for this item.',
  metakey TEXT COMMENT 'Meta keywords for this item.',
  metadesc TEXT COMMENT 'Meta descriptionfor this item.',
  xreference TEXT COMMENT 'A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.',
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  language CHAR(7) NOT NULL DEFAULT '*' COMMENT 'The language code for the article or * for all languages.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  hits INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Number of hits the content item has received on the site.',
  featured TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Whether this content item is featured or not.',

  /* SCHEMA: */


  PRIMARY KEY ('id')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

/*
Joomla!

jos_content_rating

+--------------+------------------+------+-----+
| Field        | Type             | Null | Key |
+--------------+------------------+------+-----+
| content_id   | int(11)          | NO   | PRI |
| rating_sum   | int(10) unsigned | NO   |     |
| rating_count | int(10) unsigned | NO   |     |
| lastip       | varchar(50)      | NO   |     |
+--------------+------------------+------+-----+
*/


Review  A review of an item

itemReviewed 	Thing 	The item that is being reviewed/rated.
reviewAspect 	Text 	  This Review or Rating is relevant to this part or facet of the itemReviewed.
reviewBody 	  Text 	  The actual body of the review.
reviewRating  Rating  The rating given in this review. Note that reviews can themselves be rated. The reviewRating applies to rating given by the review. The aggregateRating property applies to the review itself, as a creative work.

AggregateRating   The average rating based on multiple ratings or reviews.

itemReviewed 	Thing 	  The item that is being reviewed/rated.
ratingCount 	Integer 	The count of total number of ratings.
reviewCount 	Integer 	The count of total number of reviews.

pending extension to AggregateRating: EmployerAggregateRating  An aggregate rating of an Organization related to its role as an employer.

no new properties

Rating    A rating is an evaluation on a numeric scale, such as 1 to 5 stars.

author 	    Organization or Person	The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
bestRating    Number or Text        The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
ratingValue   Number or Text	      The rating for the content.
reviewAspect	Text                  This Review or Rating is relevant to this part or facet of the itemReviewed.
worstRating	  Number or Text	      The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
