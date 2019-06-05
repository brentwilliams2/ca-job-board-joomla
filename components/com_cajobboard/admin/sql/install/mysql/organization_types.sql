/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Organization Type table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organization_types` (
  /* UCM (unified content model) properties for internal record metadata */
  organization_type_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  /* SCHEMA: Organizaton (OrganizationType) -> ItemList */
  item_list_element TEXT NOT NULL COMMENT 'The type of organization, e.g. Non-Profit, Sole Proprietorship, etc.',
  item_list_order_type INT COMMENT 'The order this item should appear in the list',
  /* SCHEMA: Thing */
  description TEXT NOT NULL COMMENT 'A description of the type of organization',
  url VARCHAR(2083) NOT NULL COMMENT 'Link to schema for organization type, e.g. wikipedia page on Non-Profits.',
  PRIMARY KEY (organization_type_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

/**
 * Initial organization types
 */
INSERT INTO `#__cajobboard_organization_types` (item_list_element, item_list_order_type, description, url) VALUES
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_SOLE_PROPRIETORSHIP', 1, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_SOLE_PROPRIETORSHIP_DESC', 'https://en.wikipedia.org/wiki/Sole_proprietorship'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_PARTNERSHIP', 2, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_PARTNERSHIP_DESC', 'https://en.wikipedia.org/wiki/Partnership'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_LIMITED_LIABILITY_COMPANY', 3, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_LIMITED_LIABILITY_COMPANY_DESC', 'https://en.wikipedia.org/wiki/Limited_liability_company'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_CORPORATION', 4, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_CORPORATION_DESC', 'https://en.wikipedia.org/wiki/Corporation'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_EDUCATIONAL_INSTITUTION', 5,'COM_CAJOBBOARD_ORGANIZATION_TYPE_EDUCATIONAL_INSTITUTION_DESC', 'https://en.wikipedia.org/wiki/Educational_institution'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_GOVERNMENT', 6, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_GOVERNMENT_DESC', 'https://en.wikipedia.org/wiki/Government'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_NON_PROFIT_ORGANIZATION', 7, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_NON_PROFIT_ORGANIZATION_DESC', 'https://en.wikipedia.org/wiki/Nonprofit_organization'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_FRANCHISE', 8, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_FRANCHISE_DESC', 'https://en.wikipedia.org/wiki/Franchising'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_OTHER', 9, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_OTHER_DESC', 'https://en.wiktionary.org/wiki/other');
