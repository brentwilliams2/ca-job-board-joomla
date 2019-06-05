<?php
/**
 * Admin Question and Answer Pages Model
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
defined('_JEXEC') or die;

use FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/**
 * Fields:
 *
 * UCM
 * @property int                $qapage_id          Surrogate primary key.
 * @property string             $slug               Alias for SEF URL.
 * @property bool               $featured           Whether this question and answer page is featured or not.
 * @property int                $hits               Number of hits this question and answer page has received.
 * @property int                $created_by         Userid of the creator of this question and answer page.
 * @property string             $created_on         Date this question and answer page was created.
 * @property int                $modified_by        Userid of person that last modified this question and answer page.
 * @property string             $modified_on        Date this question and answer page was last modified.
 *
 * SCHEMA: Thing
 * @property string             $name               A name for this question and answer page.
 * @property string             $description        A long description of this question and answer page.
 * @property Questions          $MainEntityOfPage   The Question this page is about.
 *
 * SCHEMA: CreativeWork
 * @property Organizations      $About              The organization this question-and-answer page is about. FK to #__cajobboard_organizations(organization_id).
 * @property string             $text                Long description of the question and answer page.
 *
 * SCHEMA: QAPage
 * @property QAPageCategories   $Specialty          A category to which this question and answer page's content applies. FK to #__cajobboard_qapage_categories(qapage_category_id).
 */
class QAPages extends BaseModel
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_qapages';
    $config['idFieldName'] = 'qapage_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.qapages';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

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

    parent::__construct($container, $config);

    /*
     * Set up relations
     */

    // many-to-many FK to #__cajobboard_questions using join table #__cajobboard_questions_qapages
    $this->belongsToMany('HasPart', 'Questions@com_cajobboard', 'has_part', 'is_part_of', '#__cajobboard_questions_qapages');

    // one-to-one FK to  #__cajobboard_questions
    $this->hasOne('MainEntityOfPage', 'Questions@com_cajobboard', 'main_entity_of_page', 'question_id');

    // Many-to-one FK to  #__cajobboard_organizations
    $this->belongsTo('About', 'Organizations@com_cajobboard', 'about', 'organization_id');
  }


	/**
	 * Override to add join field for #__cajobboard_qapage_categories as $Specialty
	 *
	 * @param   boolean $overrideLimits Should I override limits
	 *
	 * @return  \JDatabaseQuery  The database query to use
	 */
  public function buildQuery($overrideLimits = false)
	{
		// Join category table specialty field to QAPages table
    $db = $this->getDbo();

		$query = $db->getQuery(true)
      ->select(array(
        $db->quoteName('qapages.*'),
        $db->quoteName('category.name', 'Specialty')
      ))
      ->from($db->quoteName('#__cajobboard_qapages', 'qapages'))
      ->join('INNER', $db->quoteName('#__cajobboard_qapage_categories', 'category') . ' ON (' . $db->quoteName('qapages.specialty') . ' = ' . $db->quoteName('category.qapage_category_id') . ')');

      // @TODO: main_entity_of_page -> accepted_answer -> answer_id: name, description, upvote_count, downvote_count
      // @TODO: remove is_part_of column from #__cajobboard_answers

    // Apply custom WHERE clauses
		if (count($this->whereClauses))
		{
			foreach ($this->whereClauses as $clause)
			{
				$query->where($clause);
			}
    }

    // Handle checking state for order and setting it if needed
    $order = $this->getState('filter_order', null, 'cmd');

		if (!array_key_exists($order, $this->knownFields))
		{
			$order = $this->getIdFieldName();
			$this->setState('filter_order', $order);
    }

    $order = $db->qn($order);

    $dir = strtoupper($this->getState('filter_order_Dir', null, 'cmd'));

		if (!in_array($dir, array('ASC', 'DESC')))
		{
			$dir = 'ASC';
			$this->setState('filter_order_Dir', $dir);
    }

		$query->order($order . ' ' . $dir);

  	return $query;
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
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_QAPAGE_ERR_TITLE');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_QAPAGE_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_QAPAGE_ERR_URL');

		parent::check();

    return $this;
  }
}


