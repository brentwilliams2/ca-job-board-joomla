/**
 * Consolidated file for all join table sample data
 */

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
 * Sample Persons - Organizations join table data (Recruiters and Connectors)
 */
INSERT INTO `#__cajobboard_persons_organizations` (
  user_id,
  organization_id
) VALUES
  ('131', '1'),
  ('132', '2');
