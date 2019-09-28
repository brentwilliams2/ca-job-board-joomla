<?php
/**
 * POPO Object Template for References model sample data seeding
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

class ReferencesTemplate extends CommonTemplate
{
	/**
	 * A PDF file representing this reference, FK to #__cajobboard_digital_documents
	 *
	 * @property    int
   */
  public $has_part__digital_document;


	/**
	 * An image representing this reference, for example a scan of an original reference letter, FK to #__cajobboard_image_objects
	 *
	 * @property    int
   */
  public $has_part__image_object;


	/**
	 * The user this reference is about, FK to #__cajobboard_persons
	 *
	 * @property    int
   */
  public $about;


	/**
	 * The actual text of the reference.
	 *
	 * @property    string
   */
  public $text;


  /**
	 * Setters for Answer fields
   */

  // BelongsTo($config, $isRequired, $faker, $foreignModelName), is an alias to InverseSideOfHasOne()
  // getFKValue($relationType, $config, $isRequired = true, $faker = null, $foreignModelName = null)

  // $this->inverseSideOfHasOne('DigitalDocument', 'DigitalDocuments@com_cajobboard', 'has_part__digital_document', 'digital_document_id');
  public function has_part__digital_document ($config, $faker)
  {
    $this->has_part__digital_document = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, false, $faker, 'DigitalDocuments');
  }


  // $this->inverseSideOfHasOne('ImageObject', 'ImageObjects@com_cajobboard', 'has_part__image_object', 'image_object_id');
  public function has_part__image_object ($config, $faker)
  {
    // BelongsTo($config, $isRequired, $faker, $foreignModelName)
    $this->has_part__image_object = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, false, $faker, 'ImageObjects');
  }


  // $this->belongsTo('About', 'Persons@com_cajobboard', 'about', 'id');
  public function about ($config, $faker)
  {
    $this->about = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }


  public function text ($config, $faker)
  {
    $this->text = $faker->paragraph;
  }
}
