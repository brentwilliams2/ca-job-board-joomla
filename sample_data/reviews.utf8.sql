/**
 * Sample Reviews table data
 */

INSERT INTO `#__cajobboard_reviews` (
  slug,
  item_reviewed, /* FK to #__cajobboard_organizations */
  review_body,
  rating_value,
  author /* FK to #__users */
) VALUES
  (
    'Elite Property Management',
    '1',
    'This was a good work environment for a period of time but after a new supervisor started he made it confrontational and hostile. The onsite management was always nice and we never had any issues and got along just fine. After realizing that the supervisor was not going anywhere and neither was my career I moved on.',
    '4',
    '133'
  ),
  (
    'Action Property Management',
    '2',
    'Great Benefits! Good Pay!<br />I have been with Action for 1 year and 3 months today. I enjoy coming to work everyday. Our work is very appreciated. We are learning new things all the time. My manager is great and gives us much credit for what we do. Our company is very proactive in us staying abreast of all Fair Housing Laws. Education is key in this business. I enjoyed this company very much.',
    '5',
    '134'
  );
