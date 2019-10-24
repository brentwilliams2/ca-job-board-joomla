<?php
/**
 * Trait to provide overridden check() method
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\Check\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Library\Platform\Registry;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

trait Utility
{
  /**
   * Applies the validation array with validation methods to the Registry object for this model
   * property, for the Registry paths specified in an array of callbacks keyed by path name.
   *
   * @param   DataModel  $model       The data model associated with this call, with the input $data already bound to it.
   * @param   string     $fieldName   The name of the model property (field) this check instance is being applied to (e.g. 'metadata').
   *
   * @return void
	 */
	public function executeCheck(DataModel $model, $fieldName)
	{
    /** @var \FOF30\Container\Container $container */
    $container = $model->getContainer();

    $fieldAlias = $model->getFieldAlias($fieldName);

    // Sanity check
    if ( !$model->hasField($fieldAlias) )
    {
      return;
    }

    $registry = $model->getFieldValue($fieldAlias);

    // Set default values
    $paths = $this->getFieldArray();

    // Set field to new JRegistry object when task is 'add' (bind not called yet)
    if (!is_object($registry) && (!$registry instanceof Registry))
    {
      $registry = new Registry($paths);

      $model->setFieldValue($fieldAlias, $registry);
    }

    foreach ($paths as $path)
    {
      // callback method, e.g. 'checkForValidAuthorField()'
      $callbackMethodName = 'checkForValid' . $container->inflector->camelize($path) . 'Field';

      if ( !method_exists($this, $callbackMethodName) )
      {
        throw new \Exception( 'Logic error in Model/Behaviour/Check/Mixin/Utility: %s method does not exist in class %s.', $callbackMethodName, $model->getName() );
      }

      $this->$callbackMethodName($model);
    }


  }
}