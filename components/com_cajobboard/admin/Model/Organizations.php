<?php
/**
 * Admin Organization Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;

/*
 * Organizations model
 *
 * Describes more of less fixed physical places
 *
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
class Organizations extends \FOF30\Model\DataModel
{
	/**
	 * Public constructor. Adds behaviours and sets up the behaviours and the relations
	 *
	 * @param   Container  $container
	 * @param   array      $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
    $this->tableName = "#__cajobboard_organizations";
    $this->idFieldName = "organization_id";

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.organizations';

    parent::__construct($container, $config);

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');

    /*
     * Set up relations
     */

    // many-to-one FK to  #__cajobboard_places
    $this->belongsTo('Location', 'Places@com_cajobboard', 'location', 'place_id');

    // many-to-many FK to  #__cajobboard_places via join table
    $this->belongsToMany('Branches', 'Places@com_cajobboard', 'organization_id', 'place_id', '#__cajobboard_organizations_places');

    // many-to-one FK to  #__cajobboard_image_objects
    $this->belongsTo('Logo', 'ImageObjects@com_cajobboard', 'logo', 'image_object_id');

    // many-to-many FK to  #__cajobboard_image_objects via join table
    $this->belongsToMany('Images', 'ImageObjects@com_cajobboard', 'image', 'image_object_id', '#__cajobboard_organizations_images');

    // one-to-one FK to  #__content through DiversityPolicies model
    $this->belongsTo('DiversityPolicy', 'DiversityPolicies@com_cajobboard', 'diversity_policy', 'diversity_policy_id');

    // one-to-one FK to  #__cajobboard_employer_aggregate_ratings
    $this->hasOne('AggregateRating', 'EmployerAggregateRatings@com_cajobboard', 'aggregate_rating', 'employer_aggregate_rating_id');

    // one-to-many FK to #__cajobboard_reviews
    $this->hasMany('Reviews', 'Reviews@com_cajobboard', 'organization_id', 'review_id');

    // many-to-many FK to #__cajobboard_persons
    $this->belongsToMany('Employees', 'Persons@com_cajobboard', 'organization_id', 'id', '#__cajobboard_organizations_employees', 'organization_id', 'employee_id');

    // many-to-many FK to #__cajobboard_organizations
    $this->belongsToMany('MemberOf', 'Organizations@com_cajobboard', 'organization_id', 'organization_id', '#__cajobboard_organizations_organizations', 'organization_id', 'member_of_organization_id');

    // one-to-one FK to  #__cajobboard_organizations
    $this->hasOne('ParentOrganization', 'Organizations@com_cajobboard', 'parent_organization', 'organization_id');

    // many-to-one FK to  #__cajobboard_organization_types
    $this->belongsTo('RoleName', 'OrganizationRoles@com_cajobboard', 'role_name', 'organization_role_id');

    // many-to-one FK to  #__cajobboard_organization_types
    $this->belongsTo('OrganizationType', 'OrganizationTypes@com_cajobboard', 'organization_type', 'organization_type_id');
  }
}
