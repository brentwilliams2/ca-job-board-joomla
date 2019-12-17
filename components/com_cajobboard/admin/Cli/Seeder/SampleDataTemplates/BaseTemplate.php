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

use \Faker;
use \Joomla\CMS\Factory;

// no direct access
defined('_JEXEC') or die;

class BaseTemplate extends \ArrayObject
{
  /**
   * Magic getter for  \ArrayObject implementation
   *
   * @param   mixed   $value
   * @return  mixed
   */
  /*
  public function __get($name)
  {
    return $this->$name;
  }
*/

  /**
   * Magic setter for  \ArrayObject implementation
   *
   * @param   mixed   $value
   * @return  mixed
   */
  /*public function __set($name, $value)
  {
    $this->$name = $value;
    die($name . ' and ' . $value);
  }*/


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
   * @return  BaseTemplate  Returns self for chaining
	 *
	 * @since   0.0.1
	 */
	public function generate($config, $seed = null)
	{
    $faker = \Faker\Factory::create();

    // This provider overrides Faker's default Lorem Ipsum generator with more readable text
    $faker->addProvider(new \NewAgeIpsum\NewAgeProvider($faker));

    // Provider for default images. The method returns the full path to the image's
    // file, e.g. '/tmp/13b73edae8443990be1aa8f1a483bc27.png':
    // $image = $faker->imageGenerator(
    //   $dir = null, $width = 640, $height = 480, $format = 'png', $fullPath = true, $text = null, $backgroundColor = null, $textColor = null
    // );
    // Color parameters are hex values e.g. 'ff2222', $text is text to
    // add on top of the image, $dir must be writable
    $faker->addProvider(new \bheller\ImagesGenerator\ImagesGeneratorProvider($faker));

    // Provider for realistic company names:  $faker->companyName
    $faker->addProvider(new \CompanyNameGenerator\FakerProvider($faker));

    if($seed)
    {
      $faker->seed($seed);
    }

    foreach (array_keys( get_class_vars( get_class($this) ) ) as $property)
    {
      // skip 'hasRoot' property used in tree data models
      if ($property == 'hasRoot')
      {
        continue;
      }

      if ( !method_exists($this, $property) )
      {
        throw new \Exception('Exception calling property function in CLI seeder BaseTemplate generate() method, $property: ' . $property);
      }

      $this->$property($config, $faker);
    }

    return $this;
  }


  /**
   * Get the primary key value for a category by its human-readable name
   *
   * @param   string  $category
   *
   * @return  int
   */
  public function getCategoryId ($category)
  {
    $db = Factory::getDbo();

    $query = $db->getQuery(true);

    $query
      ->select('id')
      ->from($db->quoteName('#__categories'))
      ->where($db->quoteName('title') . ' LIKE '. $db->quote( ucfirst($category) ));

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    $result = $db->loadResult();

    return $result;
  }


	/**
   * Convenience method, copied from Inflector
   *
	 * Converts PascalCase or camelCase to hyphenate, overridden to handle acronyms
	 *
	 * @param   string  $word  Word to hyphenate
	 *
	 * @return string hyphenated-word
	 */
	public function hyphenate($word)
	{
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $word, $matches);

    $ret = $matches[0];

    foreach ($ret as &$match)
    {
      $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }

    return implode('-', $ret);
  }
}
