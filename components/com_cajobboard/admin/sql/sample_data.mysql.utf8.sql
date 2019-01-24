/**
 * Sample data for Job Board component
 *
 * NOTE: Need to manually adjust the asset_id value to point to the corrent Job Board entry in the asset table
 */

/*
 * Job Posting table data
 */
INSERT INTO `#__cajobboard_job_postings` (
  slug,
  asset_id,
  access,
  enabled,
  created_by,
  title,
  disambiguating_description,
  description,
  education_requirements,
  experience_requirements,
  incentive_compensation,
  job_benefits,
  qualifications,
  responsibilities,
  skills,
  special_commitments,
  work_hours,
  relevant_occupation_name,
  base_salary__max_value,
  base_salary__value,
  base_salary__min_value,
  base_salary__currency,
  base_salary__duration,
  employment_type,
  occupational_category,
  job_location,
  hiring_organization
) VALUES
(
  'leasing-agent-houston',
  '1',
  '2',
  '1',
  '130',
  'Great opportunity for Leasing Agent in Houston!',
  'Join our Houston, Texas regional office as a leasing agent. ',
  'Regency Centers is seeking a Leasing Agent to join our Houston, Texas regional office. This individual will be responsible for the management of the leasing organization of company-owned properties on a project or multi-project level in the surrounding area and for developing and implementing an aggressive property-level leasing program to maximize occupancy and revenues through rental agreements, in accordance with asset goals and objectives.',
  'Bachelor’s degree in Business Management, Finance, Real Estate or related field; coupled with three (3) to five (5) years of relevant experience',
  'Six (6) to eight (8) years of relevant leasing experience preferred',
  'Annual bonus',
  'We recognize people as our most valuable asset. Our competitive compensation and benefits package includes a 401(k) profit sharing plan with company match, medical insurance with prescription drug coverage, dental insurance including coverage for orthodontics, vision insurance, an incentive-based wellness program, flexible spending accounts, company-paid short-term and long-term disability insurance, company-paid life insurance, educational assistance, matching charitable gifts and flexible paid time off.',
  '<ul><li>Quantitative and analytical skills</li><li>Knowledge of retail leasing industry and landlord representation, leases and sales contracts</li><li>Intermediate level proficiency with current Microsoft Office software, email and internet research functionality</li><li>Ability to travel throughout market</li></ul>',
  '<ul><li>Leases new or existing vacant space</li><li><li>Renews existing tenants’ leases to achieve maximum revenues while improving or maintaining tenant retention and satisfaction</li>Identifies prospects and lease space in new and existing developments</li><li>Leases, sells or develops outparcels</li><li>Prepares production reports and annual income budget reports</li><li>Provides research and analytical support</li><li>Creates best-in-class merchandising with retailers that enhance the overall center</li></ol>',
  '<ul><li>Sales and negotiation skills</li><li>High energy level</li><li>Creative merchandising, identifying best in class retailers / tenants that enhance overall center</li><li>Customer focus skills and ability to use humor as appropriate</li><li>Strong oral and written communication skills</li><li>Priority setting, decisiveness, organization and time-management skills</li><li>Trust and integrity</li><ul>',
  'No special commitments',
  'M-F 9-5',
  'Leasing Agent',
  '2000',
  '2500',
  '3000',
  'USD',
  'P2W',
  '3',
  '4',
  '1',
  '1'
),
(
  'maintenance-technician-1',
  '1',
  '2',
  '1',
  '130',
  'Maintenance Technician I',
  'Perform semi-skilled maintenance, troubleshoot and diagnose issues',
  'This position performs semi-skilled maintenance, troubleshoots and diagnoses issues in order to determine the correct course of action. The incumbent performs preventative maintenance and inspects buildings regularly and addresses any maintenance issues immediately, along with providing documentation. In addition, this position assists other maintenance, custodial, and crafts when needed.',
  'HS Diploma or equivalent. Maintenance related or trade specific coursework or willingness to pursue such coursework.',
  'More than one year or more experience of general maintenance or a related field, preferably involving maintenance of commercial buildings, mechanical systems and/or industrial maintenance. Education may not be substituted for the experience requirement.',
  '',
  'Eligible for Overtime and Benefits',
  '<h2>License/Certification Required</h2>Must possess (or have the ability to obtain one within 30 days of hire) and maintain a valid Texas driver’s license with no more than three moving violations and/or at fault accidents within the past 36 months, and no convictions or deferred dispositions for Driving While Intoxicated (DWI) or Driving Under the Influence (DUI) within the past five years.',
  '<h2>Internal / External Contacts</h2>Frequently works with Housing and Dining management and other maintenance and custodial staff. Interfaces with students, faculty, staff, and other campus staff as well as contractors and vendors as work requires. <h2>Physical Demands</h2>Moderate to heavy physical activity which includes the ability to lift and carry objects up to 50 lbs, lift up to 80 lbs, bend, stoop, climb, balance stand, and walk up to 8 hours a day. Must be able to climb ladders and enter low mechanical spaces and be able to work at different height elevations. <h2>Working Conditions</h2>Work environment includes interior and exterior of all buildings and accessibility to resident rooms. Other conditions could include extreme temperatures and environmental conditions on a daily basis. May be required to work in restricted spaces. The incumbent in this position is expected to report to campus, provide the essential services designated and work under the overall direction of the Crisis Management Team for the duration of a campus emergency. This position may be subject to an on-call status and could include weekend schedule or after hour scheduling.',
  '<ul><li>Basic repair skills and proper use of associated tools.</li><li>Communication skills both oral and written.</li><li>Organizational skills.</li><li>Familiarity with different maintenance tools and construction crafts.</li></ul>',
  'No special commitments',
  'M-F 9-5',
  'Maintenance Technician I',
  '13.61',
  '0',
  '17.70',
  'USD',
  'P1H',
  '3',
  '4',
  '2',
  '2'
);


/**
 * Image Object table sample data
 */
INSERT INTO `#__cajobboard_image_objects` (content_url, name, slug, description, caption, content_location, height, width) VALUES
  (
    'media://com_cajobboard/images/places/266e84d61e29d12a36860f68879320de.jpg',
    'Bellagio Properties',
    'bellagio-properties',
    'The headquarters of Bellagio Properties',
    'Bellagio Properties',
    1,
    1140,
    760
  ),
  (
    'media://com_cajobboard/images/places/36a86d9f88f24294925f827d9485da77.jpg',
    'Circus Circus',
    'circus-circus',
    'The headquarters of Bellagio Properties',
    'Circus Circus',
    2,
    259,
    194
  ),
  (
    'media://com_cajobboard/images/persons/88545549392290bb7d136dbbbd13ec04.png',
    'Employer Tom',
    'employer-tom',
    'Employer Tom\'s Captions',
    'Employer Tom',
    3,
    400,
    400
  ),
  (
    'media://com_cajobboard/images/persons/7295dba823ca6605f115a385517f8073.png',
    'Employer Janice',
    'employer-janice',
    'Employer Janice\'s Caption',
    'Employer Janice',
    4,
    400,
    400
  ),
  (
    'media://com_cajobboard/images/persons/48ceeada3a22ff130bb42b8bddf673f0.png',
    'Job Seeker Tim',
    'job-seeker-tim',
    'Job Seeker Tim\'s Caption',
    'Job Seeker Tim',
    5,
    256,
    256
  ),
  (
    'media://com_cajobboard/images/persons/d3cce8929e3a0525b453360a0d79f46c.gif',
    'Job Seeker Susan',
    'job-seeker-susan',
    'Job Seeker Susan\'s Caption',
    'Job Seeker Susan',
    6,
    500,
    500
  ),
  (
    'media://com_cajobboard/images/persons/03079f1f0a7d5740404768bb5c051f75.jpg',
    'Recruiter Tony',
    'recruiter-tony',
    'Recruiter Tony\'s Caption',
    'Recruiter Tony',
    7,
    900,
    900
  ),
  (
    'media://com_cajobboard/images/organizations/9ce203d4cf9b44218b864f51e82c8ed4.jpg',
    'Elite Property Management',
    'elite-property-management',
    'Nobody does it better.',
    'Elite Property Management',
    1,
    232,
    136
  ),
  (
    'media://com_cajobboard/images/organizations/458b8334edf54c056392276cbf18ae4e.jpg',
    'Action Property Management',
    'action-property-management',
    'An easier way home',
    'Action Property Management',
    2,
    234,
    134
  );


/**
 * Sample Place data
 */
INSERT INTO `#__cajobboard_places` (
  slug,
  name,
  description,
  branch_code,
  telephone,
  fax_number,
  public_access,
  geo,
  address__street_address,
  address__address_locality,
  address_region,
  address__postal_code,
  address__address_country,
  openingHoursSpecification,
  logo,
  photo
) VALUES
(
  'circus-circus-las-vegas',
  'Circus Circus',
  'A family favorite Las Vegas residential complex.',
  'LV-101',
  '1-800-634-3450',
  '702-691-5950',
  1,
  ST_GEOMFROMTEXT('POINT(115.1654 36.1378)'),
  '2880 Las Vegas Blvd S.',
  'Las Vegas',
  28,
  '89109',
  'US',
  'M-F 9 to 5',
  8,
  2
),
(
  'bellagio-las-vegas',
  'Bellagio Las Vegas',
  'Inspired by the villages of Europe',
  '1234',
  '702.369.0828',
  '702.693.8585',
  1,
  ST_GEOMFROMTEXT('POINT(115.1767 36.1126)'),
  '3600 Las Vegas Boulevard South',
  'Las Vegas',
  28,
  '89109',
  'US',
  'M-F 9 to 5',
  9,
  1
);


/**
 * Sample Place-Images join table data
 */
INSERT INTO `#__cajobboard_places_images` (photo, image_object_id) VALUES
  (1, 2),
  (2, 1);


/**
 * Sample Organizations-Places join table data
 */
INSERT INTO `#__cajobboard_organizations_places` (organization_id, place_id) VALUES
  (1, 2),
  (2, 1);



/**
 * Sample Organization table data
 */
INSERT INTO `#__cajobboard_organizations` (
  slug,
  legal_name,
  email,
  telephone,
  fax_number,
  number_of_employees,
  location,
  logo,
  diversity_policy,
  aggregate_rating,
  member_of,
  parent_organization,
  name,
  disambiguating_description,
  description,
  url,
  image,
  role_name,
  organization_type
) VALUES
(
  'elite-property-management',
  'Elite Property Management, Inc.',
  'admin@elite-property.test',
  '1-800-555-1212',
  '702-555-0000',
  '5000',
  '1',
  '8',
  '8',
  '1',
  '1',
  '1',
  'Elite Property West',
  'Elite can be the best job of your life!',
  'Founded in 1995, Elite Property Management is a family owned and operated business with headquarters in Virginia Beach, Virginia.',
  'http://elite-property.test',
  '1',
  '1',
  '3'
),
(
  'action-property-management',
  'Action Property Management, LLC',
  'admin@action-property.text',
  '1-800-222-1234',
  '702-555-7890',
  '40',
  '2',
  '9',
  '9',
  '2',
  '2',
  '2',
  'Action Property',
  'Action Property is a Gold-Star employer. Join us!',
  'At Action Property, exceptional, personalized living comes full of amenities with none of the stress of homeownership. We do it through the programs we offer, a commitment to local neighborhoods and innovative green living opportunities. Our award-winning apartments are managed and staffed by award-winning teams. Residents rent with us, and stay with us, because our life\'s work is helping people feel at home, over and over again. Building and maintaining strong relationships with our residents, employees, investors and partners matters to us. We\'ve got the depth of experience and financial foundation to provide stability and peace of mind to our renters.',
  'http://action-property.text',
  '2',
  '1',
  '4'
);


/**
 * Sample Organization - Employee join table data
 */
INSERT INTO `#__cajobboard_organizations_employees` (
  organization_id,
  employee_id
) VALUES
  ('1', '131'),
  ('2', '132');


/**
 * Sample Organizations - ImageObjects join table data
 */
INSERT INTO `#__cajobboard_organizations_images` (
  image, /* FK to #__organizations */
  image_object_id
) VALUES
  ('1', '1'),
  ('2', '2');


/**
 * Sample Organization - Organization join table data
 */
INSERT INTO `#__cajobboard_organizations_organizations` (
  member_of_organization_id,
  organization_id
) VALUES
  ('1', '1'),
  ('2', '2');


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


/**
 * Sample User Geo table data
 */
INSERT INTO `#__cajobboard_person_geos` (geo) VALUES
  (ST_GEOMFROMTEXT('POINT(115.1632 36.1478)')),
  (ST_GEOMFROMTEXT('POINT(115.1775 36.1388)')),
  (ST_GEOMFROMTEXT('POINT(115.1482 36.1398)')),
  (ST_GEOMFROMTEXT('POINT(115.1932 36.1428)')),
  (ST_GEOMFROMTEXT('POINT(115.1332 36.1458)')),
  (ST_GEOMFROMTEXT('POINT(115.1242 36.1237)'));


/**
 * Sample Persons - Organizations join table data (Recruiters and Connectors)
 */
INSERT INTO `#__cajobboard_persons_organizations` (
  user_id,
  organization_id
) VALUES
  ('131', '1'),
  ('132', '2');


/**
 * Sample User Profiles table data
 */
INSERT INTO `#__user_profiles` (user_id, profile_key, profile_value) VALUES
  ('131', 'cajobboard.description', 'I’ve learned I don’t know anything.  Have also learned that people will pay for what I know.  Life is good.'),
  ('131', 'cajobboard.main_entity_of_page', 'http://www.centurycommunications.com'),
  ('131', 'cajobboard.given_name', 'Tom'),
  ('131', 'cajobboard.additional_name', 'Yuki'),
  ('131', 'cajobboard.family_name', 'Whobrey'),
  ('131', 'cajobboard.telephone', '602-277-4385'),
  ('131', 'cajobboard.fax_number', '602-953-6360'),
  ('131', 'cajobboard.job_title', 'HR Director'),
  ('131', 'cajobboard.address__street_address', '73 State Road 434 E	Phoenix	'),
  ('131', 'cajobboard.address__locality', 'Maricopa'),
  ('131', 'cajobboard.address__postal_code', '85013'),
  ('131', 'cajobboard.address__address_country', 'US'),
  ('131', 'cajobboard.role_name', 'Employer'),
  ('131', 'cajobboard.image', '3'),
  ('131', 'cajobboard.address_region', '3'),
  ('131', 'cajobboard.geo', '8'),
  ('131', 'cajobboard.worksFor', '1'),
  ('132', 'cajobboard.description', 'Living one day at a time, with a fresh baked cookie. Okay.  And with a coffee.  And maybe some chocolate. But I promise to take my vitamins.'),
  ('132', 'cajobboard.main_entity_of_page', 'http://www.boltonwilburesq.com'),
  ('132', 'cajobboard.given_name', 'Janice'),
  ('132', 'cajobboard.additional_name', 'Fletcher'),
  ('132', 'cajobboard.family_name', 'Flosi'),
  ('132', 'cajobboard.telephone', '931-313-9635'),
  ('132', 'cajobboard.fax_number', '931-235-7959'),
  ('132', 'cajobboard.job_title', 'Human Resources Manager'),
  ('132', 'cajobboard.address__street_address', '69734 E Carrillo St'),
  ('132', 'cajobboard.address__locality', 'Warren'),
  ('132', 'cajobboard.address__postal_code', '37110'),
  ('132', 'cajobboard.address__address_country', 'US'),
  ('132', 'cajobboard.role_name', 'Employer'),
  ('132', 'cajobboard.image', '4'),
  ('132', 'cajobboard.address_region', '42'),
  ('132', 'cajobboard.geo', '7'),
  ('132', 'cajobboard.worksFor', '2'),
  ('133', 'cajobboard.description', 'Nerdfighter.  Determined dreamer.  Has ambitions to be crazy cat lady if marrying various celebrity crushes proves impossible.'),
  ('133', 'cajobboard.main_entity_of_page', 'http://www.tmbyxbeecompanypc.com'),
  ('133', 'cajobboard.given_name', 'Tim'),
  ('133', 'cajobboard.additional_name', 'Gladys'),
  ('133', 'cajobboard.family_name', 'Rim'),
  ('133', 'cajobboard.telephone', '414-661-9598'),
  ('133', 'cajobboard.fax_number', '414-377-2880'),
  ('133', 'cajobboard.job_title', 'Maintenance Technician'),
  ('133', 'cajobboard.address__street_address', '322 New Horizon Blvd'),
  ('133', 'cajobboard.address__locality', 'Milwaukee'),
  ('133', 'cajobboard.address__postal_code', '53207'),
  ('133', 'cajobboard.address__address_country', 'US'),
  ('133', 'cajobboard.role_name', 'Job Seeker'),
  ('133', 'cajobboard.image', '5'),
  ('133', 'cajobboard.address_region', '49'),
  ('133', 'cajobboard.geo', '1'),
  ('133', 'cajobboard.worksFor', 'NULL'),
  ('134', 'cajobboard.description', 'Insert pretentious crap about myself here.'),
  ('134', 'cajobboard.main_entity_of_page', 'http://www.farmersinsurancegroup.com'),
  ('134', 'cajobboard.given_name', 'Susan'),
  ('134', 'cajobboard.additional_name', 'Bette'),
  ('134', 'cajobboard.family_name', 'Nicka'),
  ('134', 'cajobboard.telephone', '313-288-7937'),
  ('134', 'cajobboard.fax_number', '313-341-4470'),
  ('134', 'cajobboard.job_title', 'Leasing Agent'),
  ('134', 'cajobboard.address__street_address', '1 State Route 27 Taylor'),
  ('134', 'cajobboard.address__locality', 'Wayne'),
  ('134', 'cajobboard.address__postal_code', '48180'),
  ('134', 'cajobboard.address__address_country', 'US'),
  ('134', 'cajobboard.role_name', 'Job Seeker'),
  ('134', 'cajobboard.image', '6'),
  ('134', 'cajobboard.address_region', '22'),
  ('134', 'cajobboard.geo', '2'),
  ('134', 'cajobboard.worksFor', 'NULL'),
  ('135', 'cajobboard.description', '90% of your problems can be solved by marketing.  Solving the other 10% just requires good procrastination skills.'),
  ('135', 'cajobboard.main_entity_of_page', 'http://www.postboxservicesplus.com'),
  ('135', 'cajobboard.given_name', 'Tony'),
  ('135', 'cajobboard.additional_name', 'Meaghan'),
  ('135', 'cajobboard.family_name', 'Garufi'),
  ('135', 'cajobboard.telephone', '815-828-2147'),
  ('135', 'cajobboard.fax_number', '815-426-5657'),
  ('135', 'cajobboard.job_title', 'Recruitment Specialist'),
  ('135', 'cajobboard.address__street_address', '394 Manchester Blvd	Rockford'),
  ('135', 'cajobboard.address__locality', 'Winnebago'),
  ('135', 'cajobboard.address__postal_code', '61109	'),
  ('135', 'cajobboard.address__address_country', 'US'),
  ('135', 'cajobboard.role_name', 'Recruiter'),
  ('135', 'cajobboard.image', '7'),
  ('135', 'cajobboard.address_region', '13'),
  ('135', 'cajobboard.geo', '3'),
  ('135', 'cajobboard.worksFor', '1'),
  ('136', 'cajobboard.description', 'I’m really a giant cupcake.  Afraid of roller coasters and dry ice'),
  ('136', 'cajobboard.main_entity_of_page', 'http://www.sportenart.com'),
  ('136', 'cajobboard.given_name', 'Amy'),
  ('136', 'cajobboard.additional_name', 'Mattie'),
  ('136', 'cajobboard.family_name', 'Poquette'),
  ('136', 'cajobboard.telephone', '610-545-3615'),
  ('136', 'cajobboard.fax_number', '610-492-4643'),
  ('136', 'cajobboard.job_title', 'Director of Recruiting'),
  ('136', 'cajobboard.address__street_address', '6 S 33rd St	Aston'),
  ('136', 'cajobboard.address__locality', 'Delaware'),
  ('136', 'cajobboard.address__postal_code', '19014'),
  ('136', 'cajobboard.address__address_country', 'US'),
  ('136', 'cajobboard.role_name', 'Recruiter'),
  ('136', 'cajobboard.image', 'NULL'),
  ('136', 'cajobboard.address_region', '38'),
  ('136', 'cajobboard.geo', '4'),
  ('136', 'cajobboard.worksFor', '2'),
  ('137', 'cajobboard.description', 'Coffee-Drinker, eReader Addict, Mom, Blogger.  I’m very busy and important'),
  ('137', 'cajobboard.main_entity_of_page', 'http://www.internationaleyeletsinc.com'),
  ('137', 'cajobboard.given_name', 'Mike'),
  ('137', 'cajobboard.additional_name', 'Allene'),
  ('137', 'cajobboard.family_name', 'Iturbide'),
  ('137', 'cajobboard.telephone', '913-413-4604'),
  ('137', 'cajobboard.fax_number', '913-645-8918'),
  ('137', 'cajobboard.job_title', 'Secretary'),
  ('137', 'cajobboard.address__street_address', '7219 Woodfield Rd	Overland Park'),
  ('137', 'cajobboard.address__locality', 'Johnson'),
  ('137', 'cajobboard.address__postal_code', '66204'),
  ('137', 'cajobboard.address__address_country', 'US'),
  ('137', 'cajobboard.role_name', 'Connector'),
  ('137', 'cajobboard.image', 'NULL'),
  ('137', 'cajobboard.address_region', '16'),
  ('137', 'cajobboard.geo', '5'),
  ('137', 'cajobboard.worksFor', '1'),
  ('138', 'cajobboard.description', 'Buddy, can you paradigm?'),
  ('138', 'cajobboard.main_entity_of_page', 'http://www.rapidtradingintl.com'),
  ('138', 'cajobboard.given_name', 'Julie'),
  ('138', 'cajobboard.additional_name', 'Alisha'),
  ('138', 'cajobboard.family_name', 'Slusarski'),
  ('138', 'cajobboard.telephone', '907-231-4722'),
  ('138', 'cajobboard.fax_number', '907-335-6568'),
  ('138', 'cajobboard.job_title', 'Trainer'),
  ('138', 'cajobboard.address__street_address', '1048 Main St'),
  ('138', 'cajobboard.address__locality', 'Fairbanks'),
  ('138', 'cajobboard.address__postal_code', '99708'),
  ('138', 'cajobboard.address__address_country', 'US'),
  ('138', 'cajobboard.role_name', 'Connector'),
  ('138', 'cajobboard.image', 'NULL'),
  ('138', 'cajobboard.address_region', '2'),
  ('138', 'cajobboard.geo', '6'),
  ('138', 'cajobboard.worksFor', '2');


/**
 * Sample Questions table data
 */
INSERT INTO `#__cajobboard_questions` (
  question_id,
  slug,
  is_part_of,
  publisher,
  `text`,
  accepted_answer,
  upvote_count,
  downvote_count
) VALUES
  (
    '1',
    'what-is-the-most-stressful-part-about-working-at-elite-property-management',
    '1',
    '132',
    'What is the most stressful part about working at Elite Property Management?',
    '1',
    '4',
    '1'
  ),
  (
    '2',
    'how-often-do-raises-occur-at-elite-property-management',
    '2',
    '133',
    'How often do raises occur at Elite Property Management?',
    '3',
    '11',
    '2'
  ),
  (
    '3',
    'what-is-the-interview-process-like',
    '3',
    '134',
    'What is the interview process like?',
    '5',
    '2',
    '0'
  ),
  (
    '4',
    'how-do-you-feel-about-going-to-work-each-day',
    '4',
    '135',
    'How do you feel about going to work each day?',
    '7',
    '6',
    '2'
  );


/**
 * Sample Answers table data
 */
INSERT INTO `#__cajobboard_answers` (
  answer_id,
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
    'never_no_if_you_will_be_back_the_next_day',
    '4',
    '137',
    'Never no if you will be back the next day. They have their favorite employees. If they don\'t like you they make your life miserable Training sucks that\'s even if you get any. They lie. Not a good place to work at. They need new management.',
    '4',
    '9',
    '1'
  );


/**
 * Sample QAPage question-and-answer table data
 */
INSERT INTO `#__cajobboard_qapages` (
  qapage_id,
  about,
  specialty,
  main_entity_of_page
) VALUES
  (
    '1',
    '1',
    '5',
    '1'
  ),
  (
    '2',
    '1',
    '4',
    '2'
  ),
  (
    '3',
    '2',
    '11',
    '3'
  ),
  (
    '4',
    '2',
    '11',
    '4'
  );


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
