<?php
/**
 * Admin Job Posting Repository
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Repository;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JLog;

/** @var   \JDatabaseDriver  The database driver for this model */
//protected $dbo = NULL;


/** @var   array  A list of table fields, keyed per table */
//protected static $tableFieldCache = array();

/** @var   array  Associative array of "magic" table field name aliases, defined as aliasFieldName => actualFieldName */
//protected $aliasFields = array();



/** @var   array  A collection of custom, additional where clauses to apply during buildQuery */
//protected $whereClauses = array();

/** @var   array  A list of all eager loaded relations and their attached callbacks */
//protected $eagerRelations = array();

/** @var bool Should rows be tracked as ACL assets? */
//protected $_trackAssets = false;

/** @var bool Does the resource support joomla tags? */
//protected $_has_tags = false;

/** @var  \JAccessRules  The rules associated with this record. */
//protected $_rules;

/**
 * The asset key for items in this table. It's usually something in the
 * com_example.viewname format. They asset name will be this key appended
 * with the item's ID, e.g. com_example.viewname.123
 *
 * @var    string
 */
//protected $_assetKey = '';



/**
 * Class to implement repository for Job Posting model
 */
class JobPostingRepository extends DataModel
{
  use Mixin\QueryHelper;

 /**
  * Public constructor. Overrides the parent constructor.
  *
  * @see DataModel::__construct()
  *
  * @param   Container $container The configuration variables to this model
  * @param   array     $config    Configuration values for this model
  *
  * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
  */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_job_postings';
    $config['idFieldName'] = 'job_posting_id';

    // $key will be column name and $value will be type
    $config['knownFields'] = $this->getKnownFieldsArray();

    parent::__construct($container, $config);
  }

  public function onAfterConstruct()
	{
    // JLog::add(xdebug_var_dump($this->knownFields), JLog::DEBUG, 'cajobboard');
  }



  /*
   * From save() method:
   * 
   * Special note if you are using a custom buildQuery with JOINs or field aliases:
   * 
   * You will need to override the recordDataToDatabaseData method. Make sure that you _remove_ or rename any fields
   * which do not exist in the table defined in $this->tableName. Otherwise Joomla! will not know how to insert /
   * update the data on the table and will throw an Exception denoting a database error. It is generally a BAD idea
   * using JOINs instead of relations. If unsure, use relations.
   * 
   * From bind() method:
   * 
	 * Special note if you are using a custom buildQuery with JOINs or field aliases:
	 * You will need to use addKnownField to let FOF know that the fields from your JOINs and the aliased fields should
	 * be bound to the record data. If you are using aliased fields you may also want to override the
	 * databaseDataToRecordData method. Generally, it is a BAD idea using JOINs instead of relations.
   * 
   * From addKnownFields() method:
   * 
   * Adds a known field to the DataModel. This is only necessary if you are using a custom buildQuery with JOINs or
	 * field aliases. Please note that you need to make further modifications for bind() and save() to work in this
	 * case. Please refer to the documentation blocks of these methods for more information. It is generally considered
	 * a very BAD idea using JOINs instead of relations. It complicates your life and is bound to cause bugs that are
	 * very hard to track back.
	 *
	 * Basically, if you find yourself using this method you are probably doing something very wrong or very advanced.
	 * If you do not feel confident with debugging FOF code STOP WHATEVER YOU'RE DOING and rethink your Model. Why are
	 * you using a JOIN? If you want to filter the records by a field found in another table you can still use
	 * relations and whereHas with a callback.
   * 
   * From canDelete() method:
   * 
   * Generic check for whether dependencies exist for this object in the db schema. This method is NOT used by
	 * default. If you want to use it you will have to override your delete(), trash() or forceDelete() method,
	 * or create an onBeforeDelete and/or onBeforeTrash event handler. Takes $join parameter: Any joins to foreign
   * table, used to determine if dependent records exist
   * 
   * from recordDataToDatabaseData():
   * 
	 * If you are using custom knownFields to cater for table JOINs you need to override this method and _remove_ the
	 * fields which do not belong to the table you are saving to. It's generally a bad idea using JOINs instead of
	 * relations. You have been warned!
   */

  /**
	 * Build the query to fetch data from the database, overridden to use joins
	 *
	 * @param   boolean $overrideLimits Override limits?
	 *
	 * @return  \JDatabaseQuery  The database query to use
	 */
	public function buildQuery($overrideLimits = false)
	{
		// Get a "select all" query
    $db = $this->getDbo();
    
    // Set overriden browse view query
    $query = $db
      ->getQuery(true)
      ->select($this->quoteColumnNames(array(
        'job_posting_id',
        'slug',
        'asset_id',
        'access',
        'enabled',
        'created_on',
        'modified_on',
        'ordering',
        'language',
        'cat_id',
        'hits',
        'featured',
        'title',
        'disambiguating_description',
        'incentive_compensation',
        'job_benefits',
        'work_hours',
        'job_location',
        'hiring_organization',
        'relevant_occupation_name',
        'base_salary__max_value',
        'base_salary__value',
        'base_salary__min_value',
        'base_salary__currency',
        'base_salary__duration',
        'name' => 'employmentType',
        'title' => 'occupationalCategory',
        'group' => 'occupationalCategoryGroup'
      )))
      ->from($db->qn($this->getTableName(), 'job_postings'))
      ->leftJoin($db->qn('#__cajobboard_job_employment_types', 'job_types') . ' ON (' . $db->qn('job_postings.job_posting_id') . ' = ' . $db->qn('job_types.job_employment_type_id') . ')')
      ->leftJoin($db->qn('#__cajobboard_job_occupational_categories', 'job_cat') . ' ON (' . $db->qn('job_postings.job_posting_id') . ' = ' . $db->qn('job_cat.job_occupational_category_id') . ')')

      ->leftJoin($db->qn('#__', 'table') . ' ON (' . $db->qn('job_postings.job_posting_id') . ' = ' . $db->qn('table.id') . ')')

            // many-to-one FK to  #__cajobboard_places
      $this->belongsTo('jobLocation', 'Places@com_cajobboard', 'job_location', 'place_id');



      ->leftJoin($db->qn('#__', 'table') . ' ON (' . $db->qn('job_postings.job_posting_id') . ' = ' . $db->qn('table.id') . ')')

      // many-to-one FK to  #__cajobboard_organizations
      $this->belongsTo('hiringOrganization', 'Organizations@com_cajobboard', 'hiring_organization', 'organization_id');



      
  













      
    // Run the "before build query" hook and behaviours
    $this->triggerEvent('onBeforeBuildQuery', array(&$query, $overrideLimits));

    // Add any WHERE clauses defined in the model to the query
    $this->applyWhereClauses($query);

    // Set ordering to table column set in table's filter_order field, or if absent default
    // to id field, and set order direction to value in table's filter_order_Dir field
    // (ASC or DESC), or if absent / invalid, default to ASC
    $this->applyQueryOrder($query);

    // Run the "before after query" hook and behaviours
    $this->triggerEvent('onAfterBuildQuery', array(&$query, $overrideLimits));

    return $query;
  }
  


	/**
	 * Applies the setSomethingAttribute methods to $this->recordData, converting the record representation to database
	 * representation. It does not modify $this->recordData, it returns a copy of the data array.
	 *
	 * @return  array
	 */
	public function recordDataToDatabaseData()
	{
    $copy = array_merge($this->recordData);
    
		foreach ($copy as $name => $value)
		{
      $method = $this->container->inflector->camelize('set_' . $name . '_attribute');
      
			if (method_exists($this, $method))
			{
				$copy[$name] = $this->{$method}($value);
			}
    }
    
		return $copy;
	}


	/**
	 * Get the number of all items
	 *
	 * @return  integer
	 */
	public function count()
	{
		// Get a "count all" query
		$db = $this->getDbo();
		$query = $this->buildQuery(true);
		$query->clear('select')->clear('order')->select('COUNT(*)');
		// Run the "before build query" hook and behaviours
		$this->triggerEvent('onBuildCountQuery', array(&$query));
		$total = $db->setQuery($query)->loadResult();
		return $total;
	}


 /*
  * Array of table columns and attributes
  *
  * Necessary because PHP can't do runtime typecasts for class properties
  * and alternative syntax to construct array is ugly.
  */
  private function getKnownFieldsArray() 
  {
    return array(
      'job_posting_id' => (object) [
        'Field' => 'job_posting_id',
        'Type' => 'bigint(20) unsigned',
        'Default' => NULL
      ],
      'slug' => (object) [
        'Field' => 'slug',
        'Type' => 'char(255)',
        'Default' => NULL
      ],
      'asset_id' => (object) [
        'Field' => 'asset_id',
        'Type' => 'int(10) unsigned',
        'Default' => '0'
      ],
      'access' => (object) [
        'Field' => 'access',
        'Type' => 'int(10) unsigned',
        'Default' => '0'
      ],
      'enabled' => (object) [
        'Field' => 'enabled',
        'Type' => 'tinyint(4)',
        'Default' => '0'
      ],
      'created_on' => (object) [
        'Field' => 'created_on',
        'Type' => 'datetime',
        'Default' => NULL
      ],
      'created_by' => (object) [
        'Field' => 'created_by',
        'Type' => 'int(11)',
        'Default' => '0'
      ],
      'modified_on' => (object) [
        'Field' => 'modified_on',
        'Type' => 'datetime',
        'Default' => NULL
      ],
      'modified_by' => (object) [
        'Field' => 'modified_by',
        'Type' => 'int(11)',
        'Default' => '0'
      ],
      'locked_on' => (object) [
        'Field' => 'locked_on',
        'Type' => 'datetime',
        'Default' => NULL
      ],
      'locked_by' => (object) [
        'Field' => 'locked_by',
        'Type' => 'int(11)',
        'Default' => '0'
      ],
      'publish_up' => (object) [
        'Field' => 'publish_up',
        'Type' => 'datetime',
        'Default' => NULL
      ],
      'publish_down' => (object) [
        'Field' => 'publish_down',
        'Type' => 'datetime',
        'Default' => NULL
      ],
      'version' => (object) [
        'Field' => 'version',
        'Type' => 'int(10) unsigned',
        'Default' => '1'
      ],
      'ordering' => (object) [
        'Field' => 'ordering',
        'Type' => 'int(11)',
        'Default' => '0'
      ],
      'metadata' => (object) [
        'Field' => 'metadata',
        'Type' => 'json',
        'Default' => NULL
      ],
      'metakey' => (object) [
        'Field' => 'metakey',
        'Type' => 'text',
        'Default' => NULL
      ],
      'metadesc' => (object) [
        'Field' => 'metadesc',
        'Type' => 'text',
        'Default' => NULL
      ],
      'xreference' => (object) [
        'Field' => 'xreference',
        'Type' => 'text',
        'Default' => NULL
      ],
      'params' => (object) [
        'Field' => 'params',
        'Type' => 'text',
        'Default' => NULL
      ],
      'language' => (object) [
        'Field' => 'language',
        'Type' => 'char(7)',
        'Default' => '*'
      ],
      'cat_id' => (object) [
        'Field' => 'cat_id',
        'Type' => 'int(10) unsigned',
        'Default' => '0'
      ],
      'hits' => (object) [
        'Field' => 'hits',
        'Type' => 'int(10) unsigned',
        'Default' => '0'
      ],
      'featured' => (object) [
        'Field' => 'featured',
        'Default' => '0'
      ],
      'title' => (object) [
        'Field' => 'title',
        'Type' => 'char(255)',
        'Default' => NULL
      ],
      'disambiguating_description' => (object) [
        'Field' => 'disambiguating_description',
        'Type' => 'text',
        'Default' => NULL
      ],
      'description' => (object) [
        'Field' => 'description',
        'Type' => 'text',
        'Default' => NULL
      ],
      'education_requirements' => (object) [
        'Field' => 'education_requirements',
        'Type' => 'text',
        'Default' => NULL
      ],
      'experience_requirements' => (object) [
        'Field' => 'experience_requirements',
        'Type' => 'text',
        'Default' => NULL
      ],
      'incentive_compensation' => (object) [
        'Field' => 'incentive_compensation',
        'Type' => 'text',
        'Default' => NULL
      ],
      'job_benefits' => (object) [
        'Field' => 'job_benefits',
        'Type' => 'text',
        'Default' => NULL
      ],
      'qualifications' => (object) [
        'Field' => 'qualifications',
        'Type' => 'text',
        'Default' => NULL
      ],
      'responsibilities' => (object) [
        'Field' => 'responsibilities',
        'Type' => 'text',
        'Default' => NULL
      ],
      'skills' => (object) [
        'Field' => 'skills',
        'Type' => 'text',
        'Default' => NULL
      ],
      'special_commitments' => (object) [
        'Field' => 'special_commitments',
        'Type' => 'text',
        'Default' => NULL
      ],
      'work_hours' => (object) [
        'Field' => 'work_hours',
        'Type' => 'text',
        'Default' => NULL
      ],
      'job_location' => (object) [
        'Field' => 'job_location',
        'Type' => 'bigint(20) unsigned',
        'Default' => NULL
      ],
      'hiring_organization' => (object) [
        'Field' => 'hiring_organization',
        'Type' => 'bigint(20) unsigned',
        'Default' => NULL
      ],
      'relevant_occupation_name' => (object) [
        'Field' => 'relevant_occupation_name',
        'Type' => 'text',
        'Default' => NULL
      ],
      'base_salary__max_value' => (object) [
        'Field' => 'base_salary__max_value',
        'Type' => 'float',
        'Default' => NULL
      ],
      'base_salary__value' => (object) [
        'Field' => 'base_salary__value',
        'Type' => 'float',
        'Default' => NULL
      ],
      'base_salary__min_value' => (object) [
        'Field' => 'base_salary__min_value',
        'Type' => 'float',
        'Default' => NULL
      ],
      'base_salary__currency' => (object) [
        'Field' => 'base_salary__currency',
        'Type' => 'char(6)',
        'Default' => NULL
      ],
      'base_salary__duration' => (object) [
        'Field' => 'base_salary__duration',
        'Type' => 'char(32)',
        'Default' => NULL
      ],
      'identifier' => (object) [
        'Field' => 'identifier',
        'Type' => 'char(255)',
        'Default' => NULL
      ],
      'sameAs' => (object) [
        'Field' => 'sameAs',
        'Type' => 'varchar(2083)',
        'Default' => NULL
      ],
      'employment_type' => (object) [
        'Field' => 'employment_type',
        'Type' => 'bigint(20) unsigned',
        'Default' => NULL
      ],
      'occupational_category' => (object) [
        'Field' => 'occupational_category',
        'Type' => 'bigint(20) unsigned',
        'Default' => NULL
      ]
    );
  }
}
