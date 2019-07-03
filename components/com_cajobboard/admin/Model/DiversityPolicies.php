<?php
/**
 * Admin Organization Model
 *
 * This is a FOF30 DataModel that uses Joomla!'s default com_content table and schema
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
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

// @TODO: Insert default Diversity Policy to use
// @TODO: Employers should be able to insert their own policy, or fall back on the default

// @TODO: If we need another model that's a wrapper to Joomla!'s com_content, we should factor this into a base class

/**
 * Fields:
 *
 * @property  string	$title
 * @property  string	$introtext
 * @property  string	$fulltext
 * @property  string	$created_by_alias  An alias to display instead of the name of the user who created the article
 * @property  string	$images  e.g. {"image_intro":"","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}
 * @property  string	$urls  e.g. {"urla":null,"urlatext":"","targeta":"","urlb":null,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}
 * @property  string	$attribs  e.g. {"show_title":"","link_titles":"","show_intro":"","info_block_position":"0","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}
 */
class DiversityPolicies extends BaseDataModel
{
  use \FOF30\Model\Mixin\Assertions;

  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
    $config['tableName'] = '#__content';
    $config['idFieldName'] = 'id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.diversity_policies';

    // Map FOF magic fields to com_content table fields
    $config['aliasFields'] = array(
      'diversity_policy_id' => 'id',
      'slug' => 'alias',
      'enabled' => 'state',
      'cat_id' => 'catid',
      'created_on' => 'created',
      'modified_on' => 'modified',
      'locked_by' => 'checked_out',
      'locked_on' => 'checked_out_time'
    );

    parent::__construct($container, $config);

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
      //'ContentHistory', // Add Joomla! content history support
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information
      'Publish',    // Set the publish_on field for new records
      'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty
      //'Tags'        // Add Joomla! Tags support
    );

    /* Set up relations after parent constructor */

    // one-to-one FK to  #__cajobboard_persons
    $this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');
  }


  /**
	 * Perform checks on data for validity
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    // @TODO: Finish validation checks
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_DIVERSITY_POLICIES_ERR_TITLE');
    $this->assertNotEmpty($this->introtext, 'COM_CAJOBBOARD_DIVERSITY_POLICIES_ERR_INTRO_TEXT');
    $this->assertNotEmpty($this->fulltext, 'COM_CAJOBBOARD_DIVERSITY_POLICIES_ERR_FULL_TEXT');

		parent::check();

    return $this;
  }
}
