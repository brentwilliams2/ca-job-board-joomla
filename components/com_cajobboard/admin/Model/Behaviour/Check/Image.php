<?php
/**
 * FOF model behavior class to validate the attribute value from state on record save.
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\Check;

use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidUrl;
use \Calligraphic\Library\Platform\Registry;
use \FOF30\Container\Container;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Router\Route;

// no direct access
defined( '_JEXEC' ) or die;


class Image extends Observer
{
  use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check\Mixin\Utility;

  /**
   * Possible values for the float parameter
   *
   * @var array
   */
  protected $validFloatValues = array(
    'left',
    'right',
    'none'
  );


  /**
   * Validate the 'metadata' field on save. This is a Registry object, with validation callbacks
   * for the Registry paths specified in an array of callbacks keyed by path name. The 'metadata',
   * 'metakey', and 'metadesc' Joomla! UCM table fields are transformed to HTML <meta> tags in
   * site's Semantic helper.
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return void
	 */
	public function onCheck(DataModel $model)
	{
    $this->executeCheck($model, 'image');
  }


  /**
	 * Provides an array of keys of the same name as the Registry object (e.g. Image, Metadata, or Params) this
   * array will be used with. Each array value should have a corresponding validation method in this class,
   * named in the pattern 'checkForValidArrayValueField', where 'ArrayValue' is the camelcased Registry path name.
   *
	 * @return  void
	 */
  public function getFieldArray()
  {
    return array (
      'float_fulltext',
      'float_intro',
      'image_fulltext',
      'image_fulltext_alt',
      'image_fulltext_caption',
      'image_intro',
      'image_intro_alt',
      'image_intro_caption',
    );
  }


  /**
   * Ensure the item introductory image URL is valid
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidImageIntroField(DataModel $model) 
  {
    $this->validateImageUrlField($model, 'image_intro');
  }


  /**
   *  Set the float for the introductory image (global, left, right, none)
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidFloatIntroField(DataModel $model)
  {
    $this->validateFloat($model, 'float_intro');
  }


  /**
   * Clean item intro image 'alt' text
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidImageIntroAltField(DataModel $model)
  {
    $this->validateText($model, 'image_intro_alt');
  }


  /**
   * Clean item intro image caption
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidImageIntroCaptionField(DataModel $model)
  {
    $this->validateText($model, 'image_intro_caption');
  }


  /**
   * Ensure the item full text image URL is valid
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidImageFulltextField(DataModel $model)
  {
    $this->validateImageUrlField($model, 'image_fulltext');
  }


  /**
   * Set the float for the introductory image (global, left, right, none)
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidFloatFulltextField(DataModel $model)
  {
    $this->validateFloat($model, 'float_fulltext');
  }


  /**
   * Clean item full text image 'alt' text
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidImageFulltextAltField(DataModel $model)
  {
    $this->validateText($model, 'image_fulltext_alt');
  }


  /**
   * Clean item full text image caption
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return   void
   */
  protected function checkForValidImageFulltextCaptionField(DataModel $model)
  {
    $this->validateText($model, 'image_fulltext_caption');
  }


  /**
   * Clean text
   *
   * @param   DataModel  $model       The data model associated with this call, with the input $data already bound to it
   * @param   string     $pathName    The name of the image registry path with text to validate
   *
   * @return   void
   */
  protected function validateText(DataModel $model, $pathName)
  {
    $imageRegistry = $model->getFieldValue('image');

    $registryPathValue = $imageRegistry->get($pathName);

    // Do nothing if the path's value isn't set in the registry
    if (!$registryPathValue)
    {
      return;
    }

    $text = $model->getContainer()->Text->filterText($registryPathValue);

    $imageRegistry->set($pathName, $text);
  }


  /**
   * Set the float for the image (global, left, right, none)
   *
   * @param   DataModel  $model       The data model associated with this call, with the input $data already bound to it
   * @param   string     $pathName    The name of the image registry path with text to validate
   *
   * @return   void
   */
  protected function validateFloat(DataModel $model, $pathName)
  {
    $imageRegistry = $model->getFieldValue('image');

    $value = trim( strtolower( $imageRegistry->get($pathName) ) );

    if ( in_array($value, $this->validFloatValues) )
    {
      $imageRegistry->set($pathName, $value);
    }
    else
    {
      // Inherit from global is a null value
      $imageRegistry->set($pathName, null);
    }
  }


  /**
   * Ensure the item full text image URL is valid
   *
   * @param   DataModel  $model       The data model associated with this call, with the input $data already bound to it
   * @param   string     $pathName    The name of the image registry path with text to validate
   *
   * @return   void
   */
  protected function validateImageUrlField(DataModel $model, $pathName)
  {
    $imageRegistry = $model->getFieldValue('image');

    $registryPathValue = $imageRegistry->get($pathName);

    // Remove escaping from JSON-style escaped forward slashes
    $registryPathValue = str_replace( '\\/', '/', $registryPathValue);

    // Do nothing if the path's value isn't set in the registry
    if (!$registryPathValue)
    {
      return;
    }

    // Failure in validating the relative file path from the host root for the image.
    if ( false ) // @TODO: implement logic to check if file path is valid, probably a regexp. realpath() check is the file actually exists.
    {
      throw new InvalidUrl();
    }

    $imageRegistry->set( $pathName, Route::_($registryPathValue) );
  }
}
