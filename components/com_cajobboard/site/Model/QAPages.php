<?php
/**
 * Site Question and Answer Pages Model
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
defined('_JEXEC') or die;

use FOF30\Container\Container;

/**
 * Fields:
 *
 * UCM
 * @property int                $qapage_id          Surrogate primary key
 * @property string             $slug               Alias for SEF URL.
 * @property bool               $featured           Whether this answer is featured or not.
 * @property int                $hits               Number of hits this answer has received.
 * @property int                $created_by         Userid of the creator of this answer.
 * @property string             $created_on         Date this answer was created.
 * @property int                $modified_by        Userid of person that last modified this answer.
 * @property string             $modified_on        Date this answer was last modified.
 *
 * SCHEMA: Thing
 * @property string             $name               A name for this question and answer page.
 * @property string             $description        A long description of this question and answer page.
 * @property int                $mainEntityOfPage   FK to question this page is about
 *
 * SCHEMA: CreativeWork
 * @property Organizations      $About              The organization this question-and-answer page is about. FK to #__cajobboard_organizations(organization_id)
 *
 * SCHEMA: QAPage
 * @property QAPageCategories   $Specialty          A category to which this question and answer page's content applies. FK to #__cajobboard_qapage_categories(qapage_category_id)
 *
 * RELATIONS
 * @property Questions          $Question           The Question this page is about
 */
class QAPages extends \Calligraphic\Cajobboard\Admin\Model\QAPages
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}


