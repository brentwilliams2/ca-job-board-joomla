<?php
/**
 * POPO Object Template for QAPage model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;

class QAPagesTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * The question this page is about. FK to #__cajobboard_questions.
	 *use \Joomla\CMS\Factory;
	 * @property    int
   */
  public $main_entity_of_page;


	/**
	 * The organization this question-and-answer page is about. FK to #__cajobboard_organizations.
	 *
	 * @property    int
   */
  public $about__organization;


  /**
	 * Setters for QAPage fields
   */


  public function cat_id ($config, $faker)
  {
    if ( !property_exists($config, 'qapage_categories') )
    {
      $parent_cat_id = null;

      foreach ($config->categories as $categoryObj)
      {
        if ($categoryObj->title == 'QAPages')
        {
          $parent_cat_id = $categoryObj->id;
          break;
        }
      }

      // Get the 'QAPages' categories
      $db = Factory::getDbo();

      $query = $db->getQuery(true);

      $query
        ->select('id')
        ->from($db->quoteName('#__categories'))
        ->where($db->quoteName('parent_id')." = ".$db->quote($parent_cat_id));

      // Reset the query using our newly populated query object.
      $db->setQuery($query);

      $config->qapage_categories = $db->loadColumn();
    }

    $this->cat_id = $config->qapage_categories[$faker->numberBetween(0, count($config->qapage_categories) - 1 )];
  }


  // $this->hasOne('MainEntityOfPage', 'Questions@com_cajobboard', 'main_entity_of_page', 'question_id');
  public function main_entity_of_page ($config, $faker)
  {
    $this->main_entity_of_page = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'Questions');
  }


  // $this->belongsTo('About', 'Organizations@com_cajobboard', 'about', 'organization_id');
  public function about__organization ($config, $faker)
  {
    $this->about__organization = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }
}
