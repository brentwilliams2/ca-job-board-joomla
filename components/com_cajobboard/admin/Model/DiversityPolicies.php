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
use JLog;

JLog::add('Diversity Policies model called', JLog::DEBUG, 'cajobboard');
/**
 * Model class for Job Board Diversity Policies
 *
 * @property  string	$title
 * @property  string	$introtext
 * @property  string	$fulltext
 * @property  string	$created_by_alias  An alias to display instead of the name of the user who created the article
 * @property  string	$images  e.g. {"image_intro":"","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}
 * @property  string	$urls  e.g. {"urla":null,"urlatext":"","targeta":"","urlb":null,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}
 * @property  string	$attribs  e.g. {"show_title":"","link_titles":"","show_intro":"","info_block_position":"0","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}
 */
class DiversityPolicies extends DataModel
{
  /*
   * Overridden constructor
   */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
    $this->tableName = "#__content";
    $this->idFieldName = "id";

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

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');
  }

	/**
	 *
	 *
	 * @param   array|\stdClass  $data  Source data
	 *
	 * @return  bool
	 */
	function onBeforeSave(&$data)
	{

  }

	/**
	 * Build the SELECT query for returning records.
	 *
	 * @param   \JDatabaseQuery  $query           The query being built
	 * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
	{
    $db = $this->getDbo();

    // search functionality was in here, as well as in FrameworkUsers
  }
}
