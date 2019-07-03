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
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

/**
 * Fields:
 *
 * UCM
 * @property int                $qapage_id          Surrogate primary key.
 * @property string             $slug               Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id           FK to the #__assets table for access control purposes.
 * @property int            $access             The Joomla! view access level.
 * @property int            $enabled            Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string         $created_on         Timestamp of record creation, auto-filled by save().
 * @property int            $created_by         User ID who created the record, auto-filled by save().
 * @property string         $modified_on        Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by        User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on          Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by          User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
 * @property int            $version          Version of this item.
 * @property int            $ordering         Order this record should appear in for sorting.
 * @property object         $metadata         JSON encoded metadata field for this item.
 * @property string         $metakey          Meta keywords for this item.
 * @property string         $metadesc         Meta description for this item.
 * @property string         $xreference       A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string         $params           JSON encoded parameters for this item.
 * @property string         $language         The language code for the article or * for all languages.
 * @property int            $cat_id           Category ID for this item.
 * @property int            $hits             Number of hits the item has received on the site.
 * @property int            $featured         Whether this item is featured or not.
 * @property string         $note             A note to save with this item for use in the back-end interface.
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
class QAPages extends BaseDataModel
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

  /*
  @TODO: implement a "Can you answer this question?" feature like Quora (email to users) for job posting QA Pages / questions,
         also "Request an Answer from User x" button to message / email a request
  */

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


