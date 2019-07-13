<?php
/**
 * FOF model behavior class to add the 'image' attribute (property)
 * to the 'skip check field' list for validation checks on record save,
 * and set the attribute value from state on record save.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Router\Route;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * To override validation behaviour for a particular model, create a directory
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('Image.php'). The model file cannot go in this
 * directory, it must stay in the root Model folder.
 */
class Image extends Observer
{
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
	 * Add the 'image' field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $imageField = $model->getFieldAlias('image');

    if ( $model->hasField($imageField) )
    {
      $model->addSkipCheckField($imageField);
    }
  }


  public function onBeforeSave(DataModel $model, &$data)
  {
    $platform = $this->container->platform;

    $imageField = $model->getFieldAlias('image');

    // Return if the $data param isn't set or is empty, or the model doesn't have a 'image' field
    if
    (
      !is_array($data) ||
      !isset($data['image']) ||
      !$image = $data['image'] ||
      !$model->hasField($imageField)
    )
		{
			return;
    }

    // Set 'image' field to new JRegistry object when applySave is called from the 'add' task
    if (!is_object($model->image) && (!$model->image instanceof Registry))
    {
      $model->image = new Registry();
    }

    $imageParams = array(
      'image_intro',
      'float_intro',
      'image_intro_alt',
      'image_intro_caption',
      'image_fulltext',
      'float_fulltext',
      'image_fulltext_alt',
      'image_fulltext_caption',
    );

    foreach ($imageParams as $param)
    {
      if ( isset($data[$param]) && $value = $data['image'] )
      {
        $func = 'clean' . $container->inflector->camelize($param);

        $value = $this->$func($value);

        $model->image->set($param, $value);
      }
    }

    $model->setState('image', $model->image);
  }


  /**
   * Ensure the item introductory image URL is valid
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanImageIntro($value)
  {
    // fails on internationalized domains
    $options = array(
      FILTER_FLAG_SCHEME_REQUIRED,
      FILTER_FLAG_HOST_REQUIRED,
      FILTER_FLAG_PATH_REQUIRED
    );

    $value = filter_var($value, FILTER_VALIDATE_URL, $options);

    return Route::_($value);
  }


  /**
   *  Set the float for the introductory image (global, left, right, none)
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanFloatIntro($value)
  {
    $value = trim( strtolower($value) );

    if ( in_array($value, $this->validFloatValues) )
    {
      return $value;
    }

    // Inherit from global is a null value
    return null;
  }


  /**
   * Clean item intro image 'alt' text
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanImageIntroAlt($value)
  {
    return $this->container->platform->filterText($value);
  }


  /**
   * Clean item intro image caption
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanImageIntroCaption($value)
  {
    return $this->container->platform->filterText($value);
  }


  /**
   * Ensure the item full text image URL is valid
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanImageFulltext($value)
  {
    // fails on internationalized domains
    $options = array(
      FILTER_FLAG_SCHEME_REQUIRED,
      FILTER_FLAG_HOST_REQUIRED,
      FILTER_FLAG_PATH_REQUIRED
    );

    $value = filter_var($value, FILTER_VALIDATE_URL, $options);

    return Route::_($value);
  }


  /**
   * Set the float for the introductory image (global, left, right, none)
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanFloatFulltext($value)
  {
    $value = trim( strtolower($value) );

    if ( in_array($value, $this->validFloatValues) )
    {
      return $value;
    }

    // Inherit from global is a null value
    return null;
  }


  /**
   * Clean item full text image 'alt' text
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanImageFulltextAlt($value)
  {
    return $this->container->platform->filterText($value);
  }


  /**
   * Clean item full text image caption
   *
   * @param string $value
   *
   * @return string
   */
  protected function cleanImageFulltextCaption($value)
  {
    return $this->container->platform->filterText($value);
  }
}
