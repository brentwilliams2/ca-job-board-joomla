<?php
/**
 * Question and Answer Pages Model
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
use FOF30\Model\DataModel;

/**
 * Model class description
 *
 * Fields:
 *
 * @property int                $qapage_id    Surrogate primary key
 * SCHEMA: Thing
 * @property string             $name         A name for this question and answer page.
 * @property string             $description  A long description of this question and answer page.
 * SCHEMA: CreativeWork
 * @property Organizations      $About        The organization this question-and-answer page is about. FK to #__cajobboard_organizations(organization_id)
 * SCHEMA: QAPage
 * @property QAPageCategories   $Specialty    A category to which this question and answer page's content applies. FK to #__cajobboard_qapage_categories(qapage_category_id)
 *
 * RELATIONS
 * @property Questions          $Question     The Question this page is about
 * @property Answers            $Answers      The Answers for the question of this page
 *
 */
class QAPages extends DataModel
{
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
		$config['tableName'] = '#__cajobboard_qapages';
    $config['idFieldName'] = 'qapage_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.qapages';

    // Add behaviours to the model
    $config['behaviours'] = array('Filters', 'Language', 'Tags');

    parent::__construct($container, $config);

    /*
     * Set up relations
     */

    // Many-to-one FK to  #__cajobboard_organizations
    $this->belongsTo('About', 'Organizations@com_cajobboard', 'about', 'organization_id');

    // $Specialty    A category to which this question and answer page's content applies. FK to #__cajobboard_qapage_categories(qapage_category_id)

    // one-to-one FK to  #__cajobboard_questions
    $this->hasOne('Question', 'Questions@com_cajobboard', 'question', 'question_id');

    // many-to-one FK to #__cajobboard_answers
    $this->hasMany('Answer', 'Answers@com_cajobboard', 'qapage_id', 'is_part_of');
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
