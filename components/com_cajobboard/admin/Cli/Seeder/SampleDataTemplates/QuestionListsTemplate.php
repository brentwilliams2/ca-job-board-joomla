<?php
/**
 * POPO Object Template for Question Lists model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

class QuestionListsTemplate extends CommonTemplate
{
	/**
	 * The Organization that created this question_list.
	 *
	 * @property    int
   */
  public $about__organization;


	/**
	 * The name of the foreign model this question list belongs to.
	 *
	 * @property    int
   */
  public $about__foreign_model_name;


  /**
	 * Setters for QAPage fields
   */


   // $this->belongsTo('AboutOrganization', 'Organizations@com_cajobboard', 'about__organization', 'organization_id');
  public function about__organization ($config, $faker)
  {
    $this->about__organization = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }


  public function about__foreign_model_name ($config, $faker)
  {
    $foreignModels = array(
      'Applications',
      'Interviews',
      'QAPages'
    );

    $this->about__foreign_model_name = $foreignModels[$faker->numberBetween( 0, count($foreignModels) - 1 )];
  }
}
