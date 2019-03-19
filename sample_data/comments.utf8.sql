/**
 * Sample Comments table data
 */

INSERT INTO `#__cajobboard_comments`(
  comment_id,
  slug,
  `text`,
  parentItem,
  about__model,
  about__id,
  upvoteCount,
  downvoteCount
)
VALUES
  (
    '1',
    'slow-internet',
    "Slow internet is my generation's Vietnam.",
    '0',
    'JobPostings',
    '1',
    '9',
    '3'
  ),
  (
    '2',
    'book-out-of-battery',
    "I'm on the last thirty pages of Game of Thrones, but my book ran out of battery!",
    '1',
    'JobPostings',
    '1',
    '8',
    '3'
  ),
  (
    '3',
    'bahamas-a-billion-times',
    "I just got back from this boring trip with my dad. I was like Dad I've been to the Bahamas a billion times, why can't we go to Mexico this year? and he just said no, effing rude.",
    '0',
    'Organizations',
    '2',
    '78',
    '0'
  ),
  (
    '4',
    'i-wish',
     'I wish I was more enthused about this pomegranate.',
    '0',
    'Organizations',
    '2',
    '112',
    '89'
  ),
  (
    '5',
    'no-wifi-in-church',
    "This church doesn't have wifi. #churchtweets",
    '0',
    'Places',
    '1',
    '4',
    '9'
  ),
  (
    '6',
    'egyptian-in-france',
    "The words on the statute were written in Egyptian. I don't read Egyptian, and didn't think I'd have to in France.",
    '0',
    'QAPages',
    '2',
    '2',
    '12'
  ),
  (
    '7',
    'covfefe',
    'Despite the constant negative press covfefe',
    '0',
    'Questions',
    '2',
    '14',
    '7'
  ),
  (
    '8',
    'new-amazing-diet',
    'The flu can be an amazing diet. So glad it came in time for the party.',
    '0',
    'Answers',
    '3',
    '3',
    '7'
  );
