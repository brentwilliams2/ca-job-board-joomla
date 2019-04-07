<?php
/**
 * Site Organization Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;

/*
 * Fields:
 *
 * @property int            $organization_id      Surrogate primary key
 * @property string         $slug                 Alias for SEF URL
 *
 * FOF "magic" fields
 *
 * @property int            $asset_id             FK to the #__assets table for access control purposes.
 * @property int            $access               The Joomla! view access level.
 * @property int            $enabled              Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string         $created_on           Timestamp of record creation, auto-filled by save().
 * @property int            $created_by           User ID who created the record, auto-filled by save().
 * @property string         $modified_on          Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by          User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on            Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by            User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 *
 * @property string         $publish_up           Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down         Date and time to change the state to unpublished.
 * @property int            $version              Version of this item.
 * @property int            $ordering             Order this record should appear in for sorting.
 * @property object         $metadata             JSON encoded metadata field for this item.
 * @property string         $metakey              Meta keywords for this item.
 * @property string         $metadesc             Meta descriptionfor this item.
 * @property string         $xreference           A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string         $params               JSON encoded parameters for the content item.
 * @property string         $language             The language code for the article or * for all languages.
 * @property int            $cat_id               Category ID for this content item.
 * @property int            $hits                 Number of hits the content item has received on the site.
 * @property int            $featured             Whether this content item is featured or not.
 *
 * SCHEMA: Organization
 *
 * @property string         $legal_name           The official name of the employer.
 * @property string         $email                RFC 3696 Email address.
 * @property array          $telephone            The E.164 PSTN telephone number, array with required "default" key and optional alternative numbers
 * @property string         $fax_number           The E.164 PSTN fax number.
 * @property string         $number_of_employees  The number of employees in an organization e.g. business.
 * @property Places         $Location             Where the organization is located, FK to Places
 * @property ImageObjects   $Logo                 A logo for this organization, FK to ImageObjects table
 * @property DiversityPolicies $DiversityPolicy	  Statement on diversity policy of the employer,  FK to #__content table via DiversityPolicies model
 * @property Person         $Employees            Someone working for this organization. Supersedes employees, FK to user table
 * @property AggregateRatings	  $AggregateRating  The overall rating, based on a collection of reviews or ratings, of the item, FK to employer_reviews table
 * @property Reviews        $Reviews              A review of the item. Supersedes reviews.
 * @property Organization   $member_of            An Organization (or ProgramMembership) to which this Person or Organization belongs.
 * @property Organization   $ParentOrganization   The larger organization that this organization is a subOrganization of, if any.
 *
 * SCHEMA: Thing
 *
 * @property string         $name                 The name of this organization.
 * @property string         $disambiguating_description    A short description of the employer, for example to use on listing pages.
 * @property string         $description          A description of the item.
 * @property string         $url                  URL of employer's website.
 * @property ImageObjects   $Images               Images of the employer, FK to ImageObjects table
 *
 * SCHEMA: Thing(additionalType) -> Role(roleName)
 *
 * @property string         $RoleName             The role of the organization e.g. Employer, Recruiter, etc., FK to #__cajobboard_organization_role
 *
 * SCHEMA: Thing(additionalType) -> extended types in private namespace (default)
 *
 * @property string         $OrganizationType     The type of organization e.g. Employer, Recruiter, etc., FK to #__cajobboard_organization_types
 *
 * SCHEMA: Thing(additionalType) -> extended types in private namespace (default)
 *
 * @property string         $Branches             Properties managed by this organization, FK to #__cajobboard_places
 */
class Organizations extends \Calligraphic\Cajobboard\Admin\Model\Organizations
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
