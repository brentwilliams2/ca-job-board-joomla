/**
 * Sample Answers table data
 */

INSERT INTO `#__cajobboard_answers` (
  answer_id,
  `name`,
  `description`,
  slug,
  is_part_of,
  publisher,
  `text`,
  parent_item,
  upvote_count,
  downvote_count
) VALUES
  (
    '1',
    'Difficult work environment',
    'An insider',
    'the_work_environment_and_lack_of_proper_office_equipment',
    '1',
    '134',
    'The work environment and lack of proper office equipment',
    '1',
    '4',
    '1'
  ),
  (
    '2',
    'Short staffed',
    'Quit a year ago',
    'i_wanted_to_retire_from_this_place',
    '1',
    '135',
    'I wanted to retire from this place but the management made my job so impossible, always calling us into office, to write us up because we had to work so short handed, we couldn\'t get everything done',
    '1',
    '5',
    '0'
  ),
  (
    '3',
    'Salary issues',
    'Still employed here',
    'no_one_i_work_with_has_received_a_raise',
    '2',
    '136',
    'No one I work with has received a raise and i have worked here for a year and a half. Other than $0.10 after 90 days, had to ask for that.',
    '2',
    '11',
    '2'
  ),
  (
    '4',
    'Annual wage increases',
    'Worked there years ago',
    'hardly_much_of_a_living_expenses_increase',
    '2',
    '137',
    'Once a year at 1.5%. Hardly much of a living expenses increase.',
    '2',
    '5',
    '0'
  ),
  (
    '5',
    'Work-life balance',
    'Job hunting now',
    'worked_through_lunch',
    '3',
    '138',
    '9.5 went in at 7:45 worked through lunch (not by choice) and usually worked until 5-5:15pm sometimes 5:30',
    '3',
    '4',
    '7'
  ),
  (
    '6',
    'Rating on a scale of 1 to 10',
    'Laid off in \'08.',
    'seven_or_nine',
    '3',
    '135',
    'Seven or nine',
    '3',
    '1',
    '0'
  ),
  (
    '7',
    'Great residents',
    'Still on staff',
    'i_go_to_work_each_day_because_the_residents_are_counting_on_me',
    '4',
    '136',
    'I go to work each day, because the residents are counting on me. I\'m at my wits end with the management in the bldg. and I\'m currently looking for other employment.',
    '4',
    '8',
    '2'
  ),
  (
    '8',
    'Management plays favorites',
    'Thinking of quitting.',
    'never_no_if_you_will_be_back_the_next_day',
    '4',
    '137',
    'Never no if you will be back the next day. They have their favorite employees. If they don\'t like you they make your life miserable Training sucks that\'s even if you get any. They lie. Not a good place to work at. They need new management.',
    '4',
    '9',
    '1'
  );
