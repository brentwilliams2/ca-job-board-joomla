<?php
/**
 * Base class for POPO templates to use in seeding model sample data
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

class BaseTemplate
{
  /**
	 * Generate model property values to bind to model.
   *
	 * @param   stdClass  $config   A configuration object with the following properties:
   *
	 *    int               $seed         Provide a seed for the random number generator to ensure deterministic results
   *    JoinTableManager  $joinMapper   A Join Table Manager object
   *    void              $tags         Not implemented
   *    Array             categories    An array of category records for the Job Board. Each array item is a stdClass object with properties:
   *                                      $id, $title, $language, $level
   *
   *
   * @return  AnswerTemplate
	 *
	 * @since   0.0.1
	 */
	public function generate($config)
	{
    $faker = Faker\Factory::create();

    // This provider overrides Faker's default Lorem Ipsum generator with more readable text
    $faker->addProvider(new \NewAgeIpsum\NewAgeProvider($faker));

    // Provider for default images. The method returns the full path to the image's
    // file, e.g. '/tmp/13b73edae8443990be1aa8f1a483bc27.png':
    // $image = $faker->imageGenerator(
    //   $dir = null, $width = 640, $height = 480, $format = 'png', $fullPath = true, $text = null, $backgroundColor = null, $textColor = null
    // );
    // Color parameters are hex values e.g. '#ff2222' or 'ff2222', $text is text to
    // add on top of the image, $dir must be writable
    $faker->addProvider(new \bheller\ImagesGenerator\ImagesGeneratorProvider($faker));

    // Provider for realistic company names:  $faker->companyName
    $faker->addProvider(new \CompanyNameGenerator\FakerProvider($faker));

    if($config->seed)
    {
      $faker->seed($config->seed);
    }

    foreach (array_keys(get_object_vars($this)) as $property)
    {
      $this->$property($config, $faker);
    }

    return $this;
  }
}
