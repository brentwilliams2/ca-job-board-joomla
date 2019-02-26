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
)
VALUES
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
