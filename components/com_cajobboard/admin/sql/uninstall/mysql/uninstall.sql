/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

/* Tables in com_cajobboard.employer.install.sql */
DROP TABLE IF EXISTS '#__cajobboard_organizations';
DROP TABLE IF EXISTS '#__cajobboard_organization_employee';

/* Tables in com_cajobboard.jobpostings.install.sql */
DROP TABLE IF EXISTS `#__cajobboard_job_postings`;
DROP TABLE IF EXISTS `#__cajobboard_job_occupational_category_groups`;
DROP TABLE IF EXISTS `#__cajobboard_job_occupational_categories`;
DROP TABLE IF EXISTS `#__cajobboard_job_employment_types`;

/* Tables in com_cajobboard.media.install.sql */
DROP TABLE IF EXISTS '#__cajobboard_media_image';

/* Tables in com_cajobboard.places.install.sql */
DROP TABLE IF EXISTS '#__cajobboard_places';
DROP TABLE IF EXISTS '#__cajobboard_places_open_hours';

/* Tables in com_cajobboard.ucm.install.sql */
DROP TABLE IF EXISTS `#__cajobboard_ucm`;

/* Tables in com_cajobboard.utilities.install.sql */
DROP TABLE IF EXISTS '#__cajobboard_util_day_of_week';
DROP TABLE IF EXISTS '#__cajobboard_util_places';
DROP TABLE IF EXISTS '#__cajobboard_util_address_region';
DROP TABLE IF EXISTS '#__cajobboard_util_telephone';
