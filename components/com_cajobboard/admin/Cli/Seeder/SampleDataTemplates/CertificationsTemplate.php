<?php
/**
 * POPO Object Template for Interviews model sample data seeding
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

class CertificationsTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * he image file for this badge or certification, FK to #__cajobboard_image_objects
	 *
	 * @property    int
   */
  public $about__image_object;


  /**
	 * Additional metadata about this certifications: course taken for the badge, API secrets, etc.
	 *
	 * @property    string
   */
  public $additional_type;


	/**
	 * The URL to access this certification.
	 *
	 * @property    string
   */
  public $url;


	/**
	 * The name of the certification.
	 *
	 * @property    string
   */
  public $role_name;


	/**
	 * The organization that provides this certification, FK to #__cajobboard_vendors
	 *
	 * @property    int
   */
  public $provider;


  /**
	 * Setters for QAPage fields
   */


   // $this->belongsTo('AboutImageObject', 'ImageObjects@com_cajobboard', 'about__image_object', 'image_object_id');
  public function about__image_object ($config, $faker)
  {
    $this->about__image_object = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'ImageObjects');
  }


  public function additional_type ($config, $faker)
  {
    $this->additional_type = '{"api_key":"secret"}';
  }


  public function url ($config, $faker)
  {
    $this->url = $faker->url;
  }


   public function role_name ($config, $faker)
   {
     $this->role_name = $faker->text(100);
   }


   // $this->belongsTo('Provider', 'Vendors@com_cajobboard', 'provider', 'vendor_id');
   public function provider ($config, $faker)
   {
     $this->provider = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Vendors');
   }
}
