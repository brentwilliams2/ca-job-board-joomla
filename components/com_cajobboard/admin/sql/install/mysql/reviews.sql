/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Example table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_example' (
  'id' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT=0,
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

