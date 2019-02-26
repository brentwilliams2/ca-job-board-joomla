/**
 * Sample Aggregate rating table data
 */

INSERT INTO `#__cajobboard_employer_aggregate_ratings` (
  employer_aggregate_rating_id,
  item_reviewed, /* FK to #__cajobboard_organizations */
  rating_count,
  review_count,
  rating_value
) VALUES
 (
   '1',
   '1',
   '1',
   '1',
   '4'
 ),
 (
   '2',
   '2',
   '1',
   '1',
   '5'
 )
