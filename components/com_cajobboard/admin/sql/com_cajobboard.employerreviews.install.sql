/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */


/*
 AggregateRating

itemReviewed 	Thing 	The item that is being reviewed/rated.
ratingCount 	Integer 	The count of total number of ratings.
reviewCount 	Integer 	The count of total number of reviews.

 */


/*
Rating

author 	Organization  or Person 	The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
bestRating 	Number  or Text 	The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
ratingValue 	Number  or Text 	The rating for the content.
reviewAspect 	Text 	This Review or Rating is relevant to this part or facet of the itemReviewed.
worstRating 	Number  or Text 	The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
*/

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

 /**
 * Example table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_example' (
  'id' bigint unsigned NOT NULL AUTO_INCREMENT=0,
  PRIMARY KEY ('id')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

