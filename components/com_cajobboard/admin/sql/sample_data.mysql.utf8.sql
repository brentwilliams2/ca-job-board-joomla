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
  '42',
  '42'
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
  '42',
  '42'
);

/**
 * Image Object table sample data
 */
INSERT INTO `#__cajobboard_image_objects` (image, thumbnail, name, description, caption, content_location, height, width) VALUES
  (
    'media:com_example/images/places/266e84d61e29d12a36860f68879320de.jpg',
    'media:com_example/images/places/thumbs/10003e84a62ba007664ca4ec4ffdb930.jpg',
    'Bellagio Properties',
    'The headquarters of Bellagio Properties',
    'Bellagio Properties',
    1,
    1140,
    760
  ),
  (
    'media:com_example/images/places/36a86d9f88f24294925f827d9485da77.jpg',
    'media:com_example/images/places/thumbs/407ff4303f5bf177766b96f99d1cc938.jpg',
    'Circus Circus',
    'The headquarters of Bellagio Properties',
    'Circus Circus',
    2,
    259,
    194
  ),
  (
    'media:com_example/images/persons/88545549392290bb7d136dbbbd13ec04.png',
    'media:com_example/images/persons/thumbs/thumb.86f675701721e7531e3cd80116c6ab03.png',
    'Sabra Crowden',
    'Dummy Captions',
    'Sabra Crowden',
    3,
    400,
    400
  ),
  (
    'media:com_example/images/persons/7295dba823ca6605f115a385517f8073.png',
    'media:com_example/images/persons/thumbs/thumb.ca1feedd1c5ebc4ec3d32964a40642d3.png',
    'Kerry Aigner',
    'Dummy Caption',
    'Kerry Aigner',
    4,
    400,
    400
  ),
  (
    'media:com_example/images/persons/48ceeada3a22ff130bb42b8bddf673f0.png',
    'media:com_example/images/persons/thumbs/thumb.f67f07e99b25686480177eead4185f6b.png',
    'Jenise Fernando',
    'Dummy Caption',
    'Jenise Fernando',
    5,
    256,
    256
  ),
  (
    'media:com_example/images/persons/d3cce8929e3a0525b453360a0d79f46c.gif',
    'media:com_example/images/persons/thumbs/thumb.bcc2ff3d300a59cb3ef3b6cd742fbebc.gif',
    'Columbus Hathorn',
    'Dummy Caption',
    'Columbus Hathorn',
    6,
    500,
    500
  ),
  (
    'media:com_example/images/persons/03079f1f0a7d5740404768bb5c051f75.jpg',
    'media:com_example/images/persons/thumbs/thumb.86f675701721e7531e3cd80116c6ab03.jpg',
    'Eldridge Raiford',
    'Dummy Caption',
    'Eldridge Raiford',
    7,
    900,
    900
  ),


  (
    'media:com_example/images/organizations/9ce203d4cf9b44218b864f51e82c8ed4.jpg',
    'media:com_example/images/organizations/thumbs/6407e2d6b58b00a69162f875cc25dc35.jpg',
    'Elite Property Management',
    'Nobody does it better.',
    'Elite Property Management',
    1,
    232,
    136
  ),
  (
    'media:com_example/images/organizations/458b8334edf54c056392276cbf18ae4e.jpg',
    'media:com_example/images/organizations/thumbs/f9a399dfb8f45c1013b8e03ba05a81e9.jpg',
    'Action Property Management',
    'An easier way home',
    'Action Property Management',
    2,
    234,
    134
  )

/**
 * Sample Place data
 */
INSERT INTO `#__cajobboard_places` (
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
  2,
  8
),
(
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
  1,
  9
)

/**
 * Sample Place-Images join table data
 */
INSERT INTO `#__cajobboard_places_images` (photo, image_object_id) VALUES
  (1, 2),
  (2, 1);
