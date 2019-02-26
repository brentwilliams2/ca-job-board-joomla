/**
 * Sample Reports table data
 */
INSERT INTO `#__cajobboard_reports`(
  report_id,
  slug,
  keywords,
  `text`,
  about__model,
  about__id
)
VALUES
  (
    '1',
    'the-worst-part-of-buying-a-new-golf-club',
    'COM_CAJOBBOARD_REPORTS_REASON_INAPPROPRIATE_LANGUAGE',
    'You know the worst part of buying a new golf club? Having to wait to use it, ugh!',
    'Reviews',
    '1'
  ),
  (
    '2',
    'my-car-is-not-white',
    'COM_CAJOBBOARD_REPORTS_REASON_SPAM',
    "I can't stand that people think my car is white! It\'s ivory!",
    'Comments',
    '2'
  ),
  (
    '3',
    'berries-and-avocados',
    'COM_CAJOBBOARD_REPORTS_REASON_DOX',
    "I don't understand how people can only spend $100 a week on groceries. Berries and avocados alone runs us $42 a week!",
    'Questions',
    '1'
  ),
  (
    '4',
    'tesselated-cheese',
    'COM_CAJOBBOARD_REPORTS_REASON_ILLEGAL',
    "The person at Subway didn't tesselate my cheese. Ohio sucks!",
    'Answers',
    '3'
  ),
  (
    '5',
    'natural-disaster-and-games',
    'COM_CAJOBBOARD_REPORTS_REASON_IRRELEVANT',
    'Yes you had an issue with a natural disaster, but I paid money for your game and I expect it to work. ',
    'JobPostings',
    '2'
  ),
  (
    '6',
    'waiters-and-servers',
    'COM_CAJOBBOARD_REPORTS_REASON_CRITICISM',
    'A message to all waiters/servers. You are all over-privileged spoiled brats. You are making more money per hour than most teachers make. Stop complaining.',
    'Places',
    '1'
  );
