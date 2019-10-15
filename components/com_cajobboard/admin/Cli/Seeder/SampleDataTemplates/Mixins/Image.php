<?php
/**
 * Trait for adding the 'image' field for social sharing in model sample data templates
 *
 * @package   Calligraphic Job Board
 * @version   September 11, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins;

use \Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die;

trait Image
{
	/**
	 * A description of the item.
	 *
	 * @var    \Joomla\Registry\Registry
   */
  public $image;


  /**
	 * Setter for 'image' field
   */
  public function image ($config, $faker)
  {
      $this->image = new Registry();

      $imageArray = array (
      'image_intro' => 'images\/sampledata\/fruitshop\/apple.jpg',
      'float_intro' => 'right',
      'image_intro_alt' => 'Sample intro image alt get',
      'image_intro_caption' => 'A job board image',
      'image_fulltext' => 'images\/sampledata\/parks\/banner_cradle.jpg',
      'float_fulltext' => '',
      'image_fulltext_alt' => 'Sample fulltext image alt text',
      'image_fulltext_caption' => 'a park!'
      );

      foreach ($imageArray as $path => $value)
      {
        $this->image->set($path, $value);
      }
  }
}