<?php
/**
 * Trait to provide a single place for table field metadata
 * to use in both BaseDataModel and BaseTreeModel
 *
 * @package   Calligraphic Job Board
 * @version   5 July, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Helper;

use \Calligraphic\Cajobboard\Admin\Model\AddressRegions;
use \Calligraphic\Cajobboard\Admin\Model\AnalyticAggregates;
use \Calligraphic\Cajobboard\Admin\Model\BaseListModel;
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;
use \Calligraphic\Cajobboard\Admin\Model\BaseTreeModel;
use \Calligraphic\Cajobboard\Admin\Model\Categories;
use \Calligraphic\Cajobboard\Admin\Model\EmailMessages;
use \Calligraphic\Cajobboard\Admin\Model\GeoCoordinates;
use \Calligraphic\Cajobboard\Admin\Model\IssueReportCategories;
use \Calligraphic\Cajobboard\Admin\Model\Messages;
use \Calligraphic\Cajobboard\Admin\Model\OrganizationRoles;
use \Calligraphic\Cajobboard\Admin\Model\OrganizationTypes;
use \Calligraphic\Cajobboard\Admin\Model\Persons;
use \Calligraphic\Cajobboard\Admin\Model\Profiles;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;

// no direct access
defined('_JEXEC') or die;

class TableFields
{
  /**
	 * The container attached to the model
	 *
	 * @var Container
	 */
  protected $container;


  /**
	 * Models that use content history and have a 'version' field
	 *
	 * @var array
	 */
  private $historyEnabledModels = array(
    'Answers',
    'ApplicationLetters',
    'AudioObjects',
    'Certifications',
    'Comments',
    'DigitalDocuments',
    'EmailMessageTemplates',
    'ImageObjects',
    'Interviews',
    'IssueReports',
    'JobPostings',
    'Messages',
    'Offers',
    'Places',
    'Questions',
    'References',
    'Reviews',
    'Vendors',
    'VideoObjects'
  );


  /**
  * Public class constructor
 	 *
   * @param   Container  $container  The configuration variables to this model
   */
  public function __construct(Container $container)
  {
    $this->container = $container;
  }


  /**
   * Setup the knownFields model property of database table metadata
   *
   * @param   DataModel   $model   The data model to load field metadata for
   *
   * @return  array  An array of the field metadata.
   */
  public function getTableFieldsMetadata($model)
  {
    $modelMetadata = $this->container->inflector->underscore ( $model->getName() ) . 'TableFieldMetadata';

    // Don't use common fields for models that don't implement all Joomla! UCM fields *AND* don't use content history
    if (
      $model instanceof AddressRegions ||
      $model instanceof AnalyticAggregates ||
      $model instanceof Categories ||
      $model instanceof EmailMessages ||
      $model instanceof GeoCoordinates ||
      $model instanceof IssueReportCategories ||
      $model instanceof OrganizationRoles ||
      $model instanceof OrganizationTypes ||
      $model instanceof Persons ||
      $model instanceof Profiles
    )
    {
      return array_merge(
        $this->getPrimaryKeyTableFieldMetadata($model),
        $this->$modelMetadata()
      );
    }


    // Plain-vanilla base class instances with full Joomla! UCM fields
    if (
      $model instanceof BaseListModel ||
      $model instanceof BaseDataModel
    )
    {
      return array_merge(
        $this->getPrimaryKeyTableFieldMetadata($model),
        $this->ucmTableFieldMetadata(),
        $this->getContentHistoryFieldMetadata($model),
        $this->$modelMetadata()
      );
    }

    if ($model instanceof BaseTreeModel)
    {
      return array_merge(
        $this->getPrimaryKeyTableFieldMetadata($model),
        $this->ucmTableFieldMetadata(),
        $this->getContentHistoryFieldMetadata($model),
        $this->ucmTreeTableFieldMetadata(),
        $this->$modelMetadata()
      );
    }

    throw new \Exception('Could not match the table type in admin\Model\Helper\TableFields, type: ' . $modelMetadata);
  }

  /**
   * Primary key field can vary between models
   */
  private function getPrimaryKeyTableFieldMetadata($model)
  {
    $idField = $model->getIdFieldName();

    return array (
      $idField => (object) ['Field' => 'job_posting_id', 'Type' => 'bigint(20) unsigned',  'Null' => 'NO',   'Default' => NULL]
    );
  }

  /*
    @TODO: Tables that probably don't need 'hits', 'featured', etc.:

    employment_types
    fair_credit_reporting_act
    job_alerts
    occupational_categories
    occupational_category_groups
    analytic_aggregates (don't need enabled, published_on, published_by, meta keys, language)
    email_messages (don't need locked_on, locked_by, meta fields, xreference, hits, featured)
  */


  /**
   * 'version' field for content history
   */
  private function getContentHistoryFieldMetadata($model)
  {
    if ( in_array($model->getName(), $this->historyEnabledModels) )
    {
      return array (
        'version' => (object) ['Field' => 'version',  'Type' => 'int(10) unsigned', 'Null' => 'NO', 'Default' => '1']
      );
    }

    return array();
  }


  /**
	 * Database table field metadata for UCM and core Joomla! schemas
	 */
  private function ucmTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'slug'              => (object) ['Field' => 'slug',           'Type' => 'char(255)',            'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'asset_id'          => (object) ['Field' => 'asset_id',       'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'access'            => (object) ['Field' => 'access',         'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'enabled'           => (object) ['Field' => 'enabled',        'Type' => 'tinyint(4)',           'Null' => 'NO',   'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_on'        => (object) ['Field' => 'created_on',     'Type' => 'datetime',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_by'        => (object) ['Field' => 'created_by',     'Type' => 'int(11)',              'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_on'       => (object) ['Field' => 'modified_on',    'Type' => 'datetime',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_by'       => (object) ['Field' => 'modified_by',    'Type' => 'int(11)',              'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'locked_on'         => (object) ['Field' => 'locked_on',      'Type' => 'datetime',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'locked_by'         => (object) ['Field' => 'locked_by',      'Type' => 'int(11)',              'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'publish_up'        => (object) ['Field' => 'publish_up',     'Type' => 'datetime',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'publish_down'      => (object) ['Field' => 'publish_down',   'Type' => 'datetime',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'ordering'          => (object) ['Field' => 'ordering',       'Type' => 'int(11)',              'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'metadata'          => (object) ['Field' => 'metadata',       'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'metakey'           => (object) ['Field' => 'metakey',        'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'metadesc'          => (object) ['Field' => 'metadesc',       'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'xreference'        => (object) ['Field' => 'xreference',     'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'params'            => (object) ['Field' => 'params',         'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'language'          => (object) ['Field' => 'language',       'Type' => 'char(7)',              'Null' => 'NO',   'Default' => '*'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'cat_id'            => (object) ['Field' => 'cat_id',         'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'hits'              => (object) ['Field' => 'hits',           'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'featured'          => (object) ['Field' => 'featured',       'Type' => 'tinyint(3) unsigned',  'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'note'              => (object) ['Field' => 'note',           'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'name'              => (object) ['Field' => 'name',           'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description'       => (object) ['Field' => 'description',    'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description__intro' => (object) ['Field' => 'description__intro', 'Type' => 'varchar(280)',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Database table field metadata for hierarchical schema
	 */
  private function ucmTreeTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'lft'               => (object) ['Field' => 'lft',            'Type' => 'int(11)',              'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'rgt'               => (object) ['Field' => 'rgt',            'Type' => 'int(11)',              'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'hash'              => (object) ['Field' => 'hash',           'Type' => 'char(40)',             'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Address Regions
	 */
  private function address_regionsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'name'                  => (object) ['Field' => 'name',                   'Type' => ' varchar(64) not null',     'Null' => 'YES',       'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'item_list_element'     => (object) ['Field' => 'item_list_element',      'Type' => ' varchar(6) not null',      'Null' => 'YES',       'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Analytic Aggregates
   *
   * Joomla! UCM keys not included: enabled, published_on, published_by, meta keys, language
	 */
  private function analytic_aggregatesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'slug'                         => (object) ['Field' => 'slug',                         'Type' => 'char(255)',        'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'asset_id'                     => (object) ['Field' => 'asset_id',                     'Type' => 'int(10) unsigned', 'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'access'                       => (object) ['Field' => 'access',                       'Type' => 'int(10) unsigned', 'Null' => 'NO',   'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_on'                   => (object) ['Field' => 'created_on',                   'Type' => 'datetime',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_by'                   => (object) ['Field' => 'created_by',                   'Type' => 'int(11)',          'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_on'                  => (object) ['Field' => 'modified_on',                  'Type' => 'datetime',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_by'                  => (object) ['Field' => 'modified_by',                  'Type' => 'int(11)',          'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'locked_on'                    => (object) ['Field' => 'locked_on',                    'Type' => 'datetime',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'locked_by'                    => (object) ['Field' => 'locked_by',                    'Type' => 'int(11)',          'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'ordering'                     => (object) ['Field' => 'ordering',                     'Type' => 'int(11)',          'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'params'                       => (object) ['Field' => 'params',                       'Type' => 'text',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'cat_id'                       => (object) ['Field' => 'cat_id',                       'Type' => 'int(10) unsigned', 'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'note'                         => (object) ['Field' => 'note',                         'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'name'                         => (object) ['Field' => 'name',                         'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description'                  => (object) ['Field' => 'description',                  'Type' => 'text',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description__intro'           => (object) ['Field' => 'description__intro',           'Type' => 'varchar(280)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_id'      => (object) ['Field' => 'about__foreign_model_id',      'Type' => 'bigint(20)',       'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_name'    => (object) ['Field' => 'about__foreign_model_name',    'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'structured_value'             => (object) ['Field' => 'structured_value',             'Type' => 'json',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Answers
	 */
  private function answersTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_id'     => (object) ['Field' => 'about__foreign_model_id',     'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_name'   => (object) ['Field' => 'about__foreign_model_name',   'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'is_part_of__question'        => (object) ['Field' => 'is_part_of__question',        'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'                        => (object) ['Field' => 'text',                        'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'upvote_count'                => (object) ['Field' => 'upvote_count',                'Type' => 'int(11)',              'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'downvote_count'              => (object) ['Field' => 'downvote_count',              'Type' => 'int(11)',              'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                       => (object) ['Field' => 'image',                       'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * ApplicationLetters
	 */
  private function application_lettersTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_url'                 => (object) ['Field' => 'content_url',              'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_size'                => (object) ['Field' => 'content_size',             'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'encoding_format'             => (object) ['Field' => 'encoding_format',          'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__organization_id'      => (object) ['Field' => 'about__organization_id',   'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Applications
	 */
  private function applicationsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'main_entity_of_page'         => (object) ['Field' => 'main_entity_of_page',      'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__question_list'        => (object) ['Field' => 'about__question_list',     'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Audio Objects
	 */
  private function audio_objectsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_url'                 => (object) ['Field' => 'content_url',              'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_size'                => (object) ['Field' => 'content_size',             'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'bitrate'                     => (object) ['Field' => 'bitrate',                  'Type' => 'int unsigned',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'duration'                    => (object) ['Field' => 'duration',                 'Type' => 'date(0)',                'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'encoding_format'             => (object) ['Field' => 'encoding_format',          'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'caption'                     => (object) ['Field' => 'caption',                  'Type' => 'text',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'transcript'                  => (object) ['Field' => 'transcript',               'Type' => 'text',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                       => (object) ['Field' => 'image',                    'Type' => 'json',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Background Checks
	 */
  private function background_checksTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about'                       => (object) ['Field' => 'about',                  'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'action_status'               => (object) ['Field' => 'action_status',          'Type' => 'tinyint unsigned',       'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'end_time'                    => (object) ['Field' => 'end_time',               'Type' => 'datetime',               'Null' => 'YES',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'result'                      => (object) ['Field' => 'result',                 'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'start_time'                  => (object) ['Field' => 'start_time',             'Type' => 'datetime',               'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'price'                       => (object) ['Field' => 'price',                  'Type' => 'int',                    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'vendor'                      => (object) ['Field' => 'vendor',                 'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Candidates
	 */
  private function candidatesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Categories
	 */
  private function categoriesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'asset_id'          => (object) ['Field' => 'asset_id',       'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'parent_id'         => (object) ['Field' => 'parent_id',      'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'lft'               => (object) ['Field' => 'lft',            'Type' => 'int(11)',              'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'rgt'               => (object) ['Field' => 'rgt',            'Type' => 'int(11)',              'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'level'             => (object) ['Field' => 'level',          'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'path'              => (object) ['Field' => 'path',           'Type' => 'varchar(400)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'extension'         => (object) ['Field' => 'extension',      'Type' => 'varchar(50)',          'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'title'             => (object) ['Field' => 'title',          'Type' => 'varchar(255) ',        'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'alias'             => (object) ['Field' => 'alias',          'Type' => 'varchar(400)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'note'              => (object) ['Field' => 'note',           'Type' => 'varchar(255)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description'       => (object) ['Field' => 'description',    'Type' => 'text',                 'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'published'         => (object) ['Field' => 'published',      'Type' => 'tinyint(1) ',          'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'checked_out'       => (object) ['Field' => 'checked_out',    'Type' => 'int(11) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'checked_out_time'  => (object) ['Field' => 'checked_out_time', 'Type' => 'datetime',           'Null' => 'NO',   'Default' => '0000-00-00 00:00:00'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'access'            => (object) ['Field' => 'access',         'Type' => 'int(11) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'params'            => (object) ['Field' => 'params',         'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'metadata'          => (object) ['Field' => 'metadata',       'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'metakey'           => (object) ['Field' => 'metakey',        'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'metadesc'          => (object) ['Field' => 'metadesc',       'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_user_id'   => (object) ['Field' => 'created_user_id', 'Type' => 'int(10) unsigned',    'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_time'      => (object) ['Field' => 'created_time',   'Type' => 'datetime ',            'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_user_id'  => (object) ['Field' => 'modified_user_id', 'Type' => 'int(10) unsigned',   'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_time'     => (object) ['Field' => 'modified_time',  'Type' => 'datetime ',            'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'hits'              => (object) ['Field' => 'hits',           'Type' => 'int(10) unsigned',     'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'language'          => (object) ['Field' => 'language',       'Type' => 'char(7)',              'Null' => 'NO',   'Default' => '*'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'version'           => (object) ['Field' => 'version',        'Type' => 'int(10) unsigned',     'Null' => 'YES',  'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Certifications
	 */
  private function certificationsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__image_object'       => (object) ['Field' => 'about__image_object',          'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'additional_type'           => (object) ['Field' => 'additional_type',              'Type' => 'json',                 'Null' => 'YES',  'Default' => '{}'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                     => (object) ['Field' => 'image',                        'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'                       => (object) ['Field' => 'url',                          'Type' => 'varchar(2083)',        'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'role_name'                 => (object) ['Field' => 'role_name',                    'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'provider'                  => (object) ['Field' => 'provider',                     'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Comments
	 */
  private function commentsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_id'   => (object) ['Field' => 'about__foreign_model_id',      'Type' => 'bigint(20)',     'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_name' => (object) ['Field' => 'about__foreign_model_name',    'Type' => 'varchar(255)',   'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'is_part_of'                => (object) ['Field' => 'is_part_of',                   'Type' => 'bigint(20)',     'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'upvote_count'              => (object) ['Field' => 'upvote_count',                 'Type' => 'int(11)',        'Null' => 'YES',    'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'downvote_count'            => (object) ['Field' => 'downvote_count',               'Type' => 'int(11)',        'Null' => 'YES',    'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                     => (object) ['Field' => 'image',                        'Type' => 'json',           'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Credit Reports
	 */
  private function credit_reportsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about'                       => (object) ['Field' => 'about',                  'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'action_status'               => (object) ['Field' => 'action_status',          'Type' => 'tinyint unsigned',       'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'end_time'                    => (object) ['Field' => 'end_time',               'Type' => 'datetime',               'Null' => 'YES',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'result'                      => (object) ['Field' => 'result',                 'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'start_time'                  => (object) ['Field' => 'start_time',             'Type' => 'datetime',               'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'price'                       => (object) ['Field' => 'price',                  'Type' => 'int',                    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'vendor'                      => (object) ['Field' => 'vendor',                 'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Data Feeds
	 */
  private function data_feedsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'                         => (object) ['Field' => 'url',                    'Type' => 'varchar(2083)',          'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'data_feed_template'          => (object) ['Field' => 'data_feed_template',     'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'send_dates'                  => (object) ['Field' => 'send_dates',             'Type' => 'datetime',               'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'audience__vendor'            => (object) ['Field' => 'audience__vendor',       'Type' => 'bigint(20) unsigned',    'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'data_feed_element'           => (object) ['Field' => 'data_feed_element',       'Type' => 'json',                  'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'date_created'                => (object) ['Field' => 'date_created',            'Type' => 'datetime',              'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Data Feed Templates
	 */
  private function data_feed_templatesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'xml_template'              => (object) ['Field' => 'xml_template',             'Type' => 'text',                 'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }




  /**
	 * Digital Documents
	 */
  private function digital_documentsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_url'                 => (object) ['Field' => 'content_url',              'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_size'                => (object) ['Field' => 'content_size',             'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'encoding_format'             => (object) ['Field' => 'encoding_format',          'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                       => (object) ['Field' => 'image',                    'Type' => 'json',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Diversity Policies
	 */
  private function diversity_policiesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'             => (object) ['Field' => 'image',          'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Email Messages
   *
   * Joomla! UCM keys not included: locked_on, locked_by, meta fields, xreference, hits, featured
	 */
  private function email_messagesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'slug'                         => (object) ['Field' => 'slug',                         'Type' => 'char(255)',        'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'asset_id'                     => (object) ['Field' => 'asset_id',                     'Type' => 'int(10) unsigned', 'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'access'                       => (object) ['Field' => 'access',                       'Type' => 'int(10) unsigned', 'Null' => 'NO',   'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'enabled'                      => (object) ['Field' => 'enabled',                      'Type' => 'tinyint(4)',       'Null' => 'NO',   'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_on'                   => (object) ['Field' => 'created_on',                   'Type' => 'datetime',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'created_by'                   => (object) ['Field' => 'created_by',                   'Type' => 'int(11)',          'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_on'                  => (object) ['Field' => 'modified_on',                  'Type' => 'datetime',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'modified_by'                  => (object) ['Field' => 'modified_by',                  'Type' => 'int(11)',          'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'params'                       => (object) ['Field' => 'params',                       'Type' => 'text',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'language'                     => (object) ['Field' => 'language',                     'Type' => 'char(7)',          'Null' => 'NO',   'Default' => '*'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'cat_id'                       => (object) ['Field' => 'cat_id',                       'Type' => 'int(10) unsigned', 'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'note'                         => (object) ['Field' => 'note',                         'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'name'                         => (object) ['Field' => 'name',                         'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description'                  => (object) ['Field' => 'description',                  'Type' => 'text',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'                         => (object) ['Field' => 'text',                         'Type' => 'text',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'date_sent'                    => (object) ['Field' => 'date_sent',                    'Type' => 'datetime',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'message_attachment__document' => (object) ['Field' => 'message_attachment__document', 'Type' => 'int(10) unsigned', 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient__additional_name'   => (object) ['Field' => 'recipient__additional_name',   'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient__email'             => (object) ['Field' => 'recipient__email',             'Type' => 'varchar(2083)',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient__family_name'       => (object) ['Field' => 'recipient__family_name',       'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient__given_name'        => (object) ['Field' => 'recipient__given_name',        'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient__honorific_prefix'  => (object) ['Field' => 'recipient__honorific_prefix',  'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient__honorific_suffix'  => (object) ['Field' => 'recipient__honorific_suffix',  'Type' => 'varchar(255)',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'sender'                       => (object) ['Field' => 'sender',                       'Type' => 'int(10) unsigned', 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'email_message_template'       => (object) ['Field' => 'email_message_template',       'Type' => 'int(10) unsigned', 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Email Message Templates
	 */
  private function email_message_templatesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'subject'           => (object) ['Field' => 'subject',         'Type' => 'text',                'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'body'              => (object) ['Field' => 'body',            'Type' => 'text',                'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Employer Aggregate Ratings
	 */
  private function employer_aggregate_ratingsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Employment Types
	 */
  private function employment_typesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'               => (object) ['Field' => 'url',            'Type' => 'varchar(2083)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * FCRA
	 */
  private function fair_credit_reporting_actTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about'                      => (object) ['Field' => 'about',                      'Type' => 'bigint(20) unsigne',     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'action_status'              => (object) ['Field' => 'action_status',              'Type' => 'tinyint  unsigned',      'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'end_time'                   => (object) ['Field' => 'end_time',                   'Type' => 'datetime',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'start_time'                 => (object) ['Field' => 'start_time',                 'Type' => 'datetime',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'result__content_url'        => (object) ['Field' => 'result__content_url',        'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'result__content_size'       => (object) ['Field' => 'result__content_size',       'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'result__encoding_format'    => (object) ['Field' => 'result__encoding_format',    'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Geo Coordinates
	 */
  private function geo_coordinatesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'geo'               => (object) ['Field' => 'geo',            'Type' => 'point',                 'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Image Objects
	 */
  private function image_objectsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'caption'                     => (object) ['Field' => 'caption',                  'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'exif_data'                   => (object) ['Field' => 'exif_data',                'Type' => 'json',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_url'                 => (object) ['Field' => 'content_url',              'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_size'                => (object) ['Field' => 'content_size',             'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'height'                      => (object) ['Field' => 'height',                   'Type' => 'int unsigned',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'width'                       => (object) ['Field' => 'width',                    'Type' => 'int unsigned',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'encoding_format'              => (object) ['Field' => 'encoding_format',         'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_location'            => (object) ['Field' => 'content_location',         'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'aspect_ratio'                => (object) ['Field' => 'aspect_ratio',             'Type' => 'int unsigned',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                       => (object) ['Field' => 'image',                    'Type' => 'json',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Interviews
	 */
  private function interviewsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'main_entity_of_page'         => (object) ['Field' => 'main_entity_of_page',      'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__question_list'        => (object) ['Field' => 'question_list',            'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Issue Report Categories
	 */
  private function issue_report_CategoriesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'category'          => (object) ['Field' => 'category',       'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'               => (object) ['Field' => 'url',            'Type' => 'varchar(2083)',        'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Issue Reports
	 */
  private function issue_reportsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__model'            => (object) ['Field' => 'about__model',             'Type' => 'varchar(50)',              'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__id'               => (object) ['Field' => 'about__id',                'Type' => 'bigint(20) unsigned',      'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'category'                => (object) ['Field' => 'category',                 'Type' => 'bigint(20) unsigned',      'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Job Alerts
	 */
  private function job_alertsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'geo_coordinate'          => (object) ['Field' => 'geo_coordinate',           'Type' => 'bigint(20) unsigned',      'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'geo_radius'              => (object) ['Field' => 'geo_radius',               'Type' => 'int unsigned',             'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'occupational_category'   => (object) ['Field' => 'occupational_category',    'Type' => 'bigint(20) unsigned',      'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'keywords'                => (object) ['Field' => 'keywords',                 'Type' => 'json',                     'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'expires'                 => (object) ['Field' => 'expires',                  'Type' => 'datetime',                 'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Job Postings
	 */
  private function job_postingsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'                        => (object) ['Field' => 'text',                        'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'education_requirements'      => (object) ['Field' => 'education_requirements',      'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'experience_requirements'     => (object) ['Field' => 'experience_requirements',     'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'incentive_compensation'      => (object) ['Field' => 'incentive_compensation',      'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'job_benefits'                => (object) ['Field' => 'job_benefits',                'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'qualifications'              => (object) ['Field' => 'qualifications',              'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'responsibilities'            => (object) ['Field' => 'responsibilities',            'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'skills'                      => (object) ['Field' => 'skills',                      'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'special_commitments'         => (object) ['Field' => 'special_commitments',         'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'work_hours'                  => (object) ['Field' => 'work_hours',                  'Null' => 'YES',   'Type' => 'text',                'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'job_location'                => (object) ['Field' => 'job_location',                'Null' => 'NO',   'Type' => 'bigint(20) unsigned',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'hiring_organization'         => (object) ['Field' => 'hiring_organization',         'Null' => 'NO',   'Type' => 'bigint(20) unsigned',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'relevant_occupation_name'    => (object) ['Field' => 'relevant_occupation_name',    'Null' => 'NO',   'Type' => 'text',                 'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'base_salary__max_value'      => (object) ['Field' => 'base_salary__max_value',      'Null' => 'YES',   'Type' => 'float',               'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'base_salary__value'          => (object) ['Field' => 'base_salary__value',          'Null' => 'YES',   'Type' => 'float',               'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'base_salary__min_value'      => (object) ['Field' => 'base_salary__min_value',      'Null' => 'YES',   'Type' => 'float',               'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'base_salary__currency'       => (object) ['Field' => 'base_salary__currency',       'Null' => 'YES',   'Type' => 'char(6)',             'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'base_salary__duration'       => (object) ['Field' => 'base_salary__duration',       'Null' => 'YES',   'Type' => 'char(32)',            'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'identifier'                  => (object) ['Field' => 'identifier',                  'Null' => 'YES',   'Type' => 'char(255)',           'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'same_as'                     => (object) ['Field' => 'same_as',                     'Null' => 'YES',   'Type'  => 'varchar(2083)',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'employment_type'             => (object) ['Field' => 'employment_type',             'Null' => 'NO',   'Type' => 'bigint(20) unsigned',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'occupational_category'       => (object) ['Field' => 'occupational_category',       'Null' => 'NO',   'Type' => 'bigint(20) unsigned',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                       => (object) ['Field' => 'image',                       'Null' => 'YES',  'Type' => 'json',                 'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Messages
	 */
  private function messagesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_id'   => (object) ['Field' => 'about__foreign_model_id',      'Null' => 'YES',  'Type' => 'bigint(20) unsigned',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_name' => (object) ['Field' => 'about__foreign_model_name',    'Null' => 'YES',  'Type' => 'varchar(255)',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'date_read'                 => (object) ['Field' => 'date_read',                    'Null' => 'YES',  'Type' => 'datetime',              'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'recipient'                 => (object) ['Field' => 'recipient',                    'Null' => 'YES',  'Type' => 'int(11)',               'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'is_part_of'                => (object) ['Field' => 'is_part_of',                   'Null' => 'YES',  'Type' => 'bigint(20)',            'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'attachment_counts'         => (object) ['Field' => 'attachment_counts',            'Null' => 'YES',  'Type' => 'json',                  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Occupational Categories
	 */
  private function occupational_categoriesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'code'              => (object) ['Field' => 'code',           'Type' => 'char(255)',                           'Null' => 'NO',           'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'group'             => (object) ['Field' => 'group',          'Type' => 'bigint(20) unsigned',                 'Null' => 'NO',           'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Occupational Category Groups
	 */
  private function occupational_category_groupsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'               => (object) ['Field' => 'url',            'Type' => 'varchar(2083)',                      'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'group'             => (object) ['Field' => 'group',          'Type' => 'char(96)',                           'Null' => 'NO',           'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Offers
	 */
  private function offersTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__person'                     => (object) ['Field' => 'about__person',                      'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'valid_through'                     => (object) ['Field' => 'valid_through',                      'Type' => 'datetime',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'item_offered'                      => (object) ['Field' => 'item_offered',                       'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'offered_by'                        => (object) ['Field' => 'offered_by',                         'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'includes_object__digital_document' => (object) ['Field' => 'includes_object__digital_document',  'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'includes_object__email_message'    => (object) ['Field' => 'includes_object__email_message',     'Type' => 'bigint(20) unsigned', 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'price__base_salary__value'         => (object) ['Field' => 'price__base_salary__value',          'Type' => 'float',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'price__base_salary__currency'      => (object) ['Field' => 'price__base_salary__currency',       'Type' => 'char(6)',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'price__base_salary__duration'      => (object) ['Field' => 'price__base_salary__duration',       'Type' => 'char(32)',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Organization Roles
	 */
  private function organization_rolesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'role_name'              => (object) ['Field' => 'role_name',           'Type' => 'text',                 'Null' => 'NO',             'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description'            => (object) ['Field' => 'description',         'Type' => 'text',                 'Null' => 'NO',             'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'                    => (object) ['Field' => 'url',                 'Type' => 'varchar(2083)',        'Null' => 'NO',             'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Organizations
	 */
  private function organizationsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'                    => (object) ['Field' => 'url',                    'Type' => 'varchar(2083)',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'role_name'              => (object) ['Field' => 'role_name',              'Type' => 'bigint(20) unsigned',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'organization_type'      => (object) ['Field' => 'organization_type',      'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'legal_name'             => (object) ['Field' => 'legal_name',             'Type' => 'varchar(255)',             'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'email'                  => (object) ['Field' => 'email',                  'Type' => 'varchar(320)',             'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'telephone'              => (object) ['Field' => 'telephone',              'Type' => 'text',                     'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'fax_number'             => (object) ['Field' => 'fax_number',             'Type' => 'varchar(24)',              'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'number_of_employees'    => (object) ['Field' => 'number_of_employees',    'Type' => 'varchar(16)',              'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'location'               => (object) ['Field' => 'location',               'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'logo'                   => (object) ['Field' => 'logo',                   'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'diversity_policy'       => (object) ['Field' => 'diversity_policy',       'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'aggregate_rating'       => (object) ['Field' => 'aggregate_rating',       'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'member_of'              => (object) ['Field' => 'member_of',              'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'parent_organization'    => (object) ['Field' => 'parent_organization',    'Type' => 'bigint(20) unsigned',      'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                  => (object) ['Field' => 'image',                  'Type' => 'json',                     'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Organization Types
	 */
  private function organization_typesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'item_list_element'       => (object) ['Field' => 'item_list_element',      'Type' => 'text',                    'Null' => 'NO',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'item_list_order_type'    => (object) ['Field' => 'item_list_order_type',   'Type' => 'int',                     'Null' => 'NO',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'description'             => (object) ['Field' => 'description',            'Type' => 'text',                    'Null' => 'NO',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'                     => (object) ['Field' => 'url',                    'Type' => 'varchar(2083)',           'Null' => 'NO',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Personally Identifiable Information
	 */
  private function personally_identifiable_informationTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Persons
	 */
  private function personsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'name'              => (object) ['Field' => 'name',           'Type' => 'varchar(400)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'username'          => (object) ['Field' => 'username',       'Type' => 'varchar(150)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'email'             => (object) ['Field' => 'email',          'Type' => 'varchar(100)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'password'          => (object) ['Field' => 'password',       'Type' => 'varchar(100)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'block'             => (object) ['Field' => 'block',          'Type' => 'tinyint(4)',           'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'sendEmail'         => (object) ['Field' => 'sendEmail',      'Type' => 'tinyint(4)',           'Null' => 'YES',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'registerDate'      => (object) ['Field' => 'registerDate',   'Type' => 'datetime',             'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'lastvisitDate'     => (object) ['Field' => 'lastvisitDate',  'Type' => 'datetime',             'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'activation'        => (object) ['Field' => 'activation',     'Type' => 'varchar(100)',         'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'params'            => (object) ['Field' => 'params',         'Type' => 'text',                 'Null' => 'NO',   'Default' => '{}'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'lastResetTime'     => (object) ['Field' => 'lastResetTime',  'Type' => 'text',                 'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'resetCount'        => (object) ['Field' => 'resetCount',     'Type' => 'int(11)',              'Null' => 'NO',   'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'otpKey'            => (object) ['Field' => 'otpKey',         'Type' => 'varchar(1000)',        'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'otep'              => (object) ['Field' => 'otep',           'Type' => 'varchar(1000)',        'Null' => 'NO',   'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'requireReset'      => (object) ['Field' => 'requireReset',   'Type' => 'tinyint(4)',           'Null' => 'ordering', 'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Places
	 */
  private function placesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'branch_code'                   => (object) ['Field' => 'branch_code',                  'Type' => 'varchar(50)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'fax_number'                    => (object) ['Field' => 'fax_number',                   'Type' => 'varchar(30)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'public_access'                 => (object) ['Field' => 'public_access',                'Type' => 'boolean',              'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'geo'                           => (object) ['Field' => 'geo',                          'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'address__street_address'       => (object) ['Field' => 'address__street_address',      'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'address__locality'             => (object) ['Field' => 'address__locality',            'Type' => 'varchar(50)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'address__region'               => (object) ['Field' => 'address__region',              'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'address__postal_code'          => (object) ['Field' => 'address__postal_code',         'Type' => 'varchar(12)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'address__country'              => (object) ['Field' => 'address__country',             'Type' => 'varchar(2)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'telephone'                     => (object) ['Field' => 'telephone',                    'Type' => 'varchar(30)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'opening_hours_specification'   => (object) ['Field' => 'opening_hours_specification',  'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'logo'                          => (object) ['Field' => 'logo',                         'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                         => (object) ['Field' => 'image',                        'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Profiles
	 */
  private function profilesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'user_id'                     => (object) ['Field' => 'user_id',                      'Type' => 'int(11)',              'Null' => 'NO',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'profile_key'                 => (object) ['Field' => 'profile_key',                  'Type' => 'varchar(100)',         'Null' => 'NO',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'profile_value'               => (object) ['Field' => 'profile_value',                'Type' => 'text',                 'Null' => 'NO',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'ordering'                    => (object) ['Field' => 'ordering',                     'Type' => 'int(11)',              'Null' => 'NO',  'Default' => '0'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Q A Pages
	 */
  private function qa_pagesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'main_entity_of_page'          => (object) ['Field' => 'main_entity_of_page',        'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__organization'          => (object) ['Field' => 'about__organization',        'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Question Lists
	 */
  private function question_listsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__organization'         => (object) ['Field' => 'about__organization',       'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about__foreign_model_name'   => (object) ['Field' => 'about__foreign_model_name', 'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Questions
	 */
  private function questionsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'is_part_of'        => (object) ['Field' => 'is_part_of',         'Type' => 'bigint(20) unsigned',          'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'publisher'         => (object) ['Field' => 'publisher',          'Type' => 'bigint(20) unsigned',          'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',               'Type' => 'text',                         'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'accepted_answer'   => (object) ['Field' => 'accepted_answer',    'Type' => 'bigint(20) unsigned',          'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'upvote_count'      => (object) ['Field' => 'upvote_count',       'Type' => 'int(11)',                      'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'downvote_count'    => (object) ['Field' => 'downvote_count',     'Type' => 'int(11)',                      'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'             => (object) ['Field' => 'image',              'Type' => 'json',                         'Null' => 'YES',          'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * References
	 */
  private function referencesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'has_part__digital_document'  => (object) ['Field' => 'has_part__digital_document',  'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'has_part__image_object'      => (object) ['Field' => 'has_part__image_object',      'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'about'                       => (object) ['Field' => 'about',                       'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'                        => (object) ['Field' => 'text',                        'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Reports
	 */
  private function reportsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'repeat_frequency'          => (object) ['Field' => 'repeat_frequency',          'Type' => 'char(32)',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'by_day'                    => (object) ['Field' => 'by_day',                    'Type' => 'int(11) unsigned',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'repeat_count'              => (object) ['Field' => 'repeat_count',              'Type' => 'int(11) unsigned',         'Null' => 'YES',  'Default' => '1'],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'to_recipient'              => (object) ['Field' => 'to_recipient',              'Type' => 'int(11) unsigned',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'date_sent'                 => (object) ['Field' => 'date_sent',                 'Type' => 'datetime',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Resume Alerts
	 */
  private function resume_alertsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'geo_coordinate'          => (object) ['Field' => 'geo_coordinate',           'Type' => 'bigint(20) unsigned',      'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'geo_radius'              => (object) ['Field' => 'geo_radius',               'Type' => 'int unsigned',             'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'occupational_category'   => (object) ['Field' => 'occupational_category',    'Type' => 'bigint(20) unsigned',      'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'keywords'                => (object) ['Field' => 'keywords',                 'Type' => 'json',                     'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'expires'                 => (object) ['Field' => 'expires',                  'Type' => 'datetime',                 'Null' => 'YES',    'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Resumes
	 */
  private function resumesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'main_entity_of_page'      => (object) ['Field' => 'main_entity_of_page',     'Type' => 'bigint(20) unsigned',      'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_url'              => (object) ['Field' => 'content_url',             'Type' => 'varchar(255)',             'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_size'             => (object) ['Field' => 'content_size',            'Type' => 'bigint(20) unsigned',      'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'encoding_format'          => (object) ['Field' => 'encoding_format',         'Type' => 'char(32)',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'resume'                   => (object) ['Field' => 'resume',                  'Type' => 'json',                     'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Reviews
	 */
  private function reviewsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'item_reviewed'         => (object) ['Field' => 'item_reviewed',          'Type' => 'bigint(20) unsigned',        'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'review_body'           => (object) ['Field' => 'review_body',            'Type' => 'text',                       'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'rating_value'          => (object) ['Field' => 'rating_value',           'Type' => 'int(11)',                    'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                 => (object) ['Field' => 'image',                  'Type' => 'json',                       'Null' => 'YES',      'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Schedules
	 */
  private function schedulesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Score Cards
	 */
  private function score_cardsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Search Results Pages
	 */
  private function search_results_pagesTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Tasks
	 */
  private function tasksTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Vendors
	 */
  private function vendorsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'url'                               => (object) ['Field' => 'url',                            'Type' => 'varchar(2083)',        'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'additional_type'                   => (object) ['Field' => 'additional_type',                'Type' => 'json',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'role_name'                         => (object) ['Field' => 'role_name',                      'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'legal_name'                        => (object) ['Field' => 'legal_name',                     'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'email'                             => (object) ['Field' => 'email',                          'Type' => 'varchar(320)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'telephone'                         => (object) ['Field' => 'telephone',                      'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'fax_number'                        => (object) ['Field' => 'fax_number',                     'Type' => 'varchar(24)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'location__address__street_address' => (object) ['Field' => 'address__street_address',        'Type' => 'varchar(255)',         'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'location__address__locality'       => (object) ['Field' => 'location__address__locality',    'Type' => 'varchar(50)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'location__address__region'         => (object) ['Field' => 'location__address__region',      'Type' => 'bigint(20) unsigned',  'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'location__address__postal_code'    => (object) ['Field' => 'location__address__postal_code', 'Type' => 'varchar(12)',          'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'location__address__country'        => (object) ['Field' => 'location__address__country',     'Type' => 'varchar(2)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Video Objects
	 */
  private function video_objectsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_url'                 => (object) ['Field' => 'content_url',              'Type' => 'varchar(255)',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'content_size'                => (object) ['Field' => 'content_size',             'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'height'                      => (object) ['Field' => 'height',                   'Type' => 'int unsigned',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'width'                       => (object) ['Field' => 'width',                    'Type' => 'int unsigned',           'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'bitrate'                     => (object) ['Field' => 'bitrate',                  'Type' => 'bigint(20) unsigned',    'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'duration'                    => (object) ['Field' => 'duration',                 'Type' => 'date(0)',                'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'encoding_format'             => (object) ['Field' => 'encoding_format',          'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'caption'                     => (object) ['Field' => 'caption',                  'Type' => 'text',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'transcript'                  => (object) ['Field' => 'transcript',               'Type' => 'text',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'video_frame_size'            => (object) ['Field' => 'video_frame_size',         'Type' => 'char(32)',               'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'image'                       => (object) ['Field' => 'image',                    'Type' => 'json',                   'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }


  /**
	 * Work Flows
	 */
  private function work_flowsTableFieldMetadata()
  {
    return array(
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
        'text'              => (object) ['Field' => 'text',           'Type' => 'text',                 'Null' => 'YES',  'Default' => NULL],
      //------------------------------------------------------------------------------------------------------------------------------------------------------------
    );
  }
}
