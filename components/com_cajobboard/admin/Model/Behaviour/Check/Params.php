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

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\Registry\Registry;

// no direct access
defined( '_JEXEC' ) or die;


class Params extends Observer
{
  use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check\Mixin\Utility;

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
    $this->executeCheck($model, 'params');
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
    return array ();
  }

  // NOTE: implement methods for each field array value, with naming like 'checkForValidArrayValueField',
  //       where 'ArrayValue' is the camelcased Registry path name, and call the Joomla! form field validators from there.

  /**
	 * Validator for Joomla! standard form field types, e.g. 'text', 'radio', 'spacer', 'number', 'email', 'menuitem', and 'rules'
	 *
	 * @return  void
	 */
  public function validateRadio(DataModel $model)
  {
    return true;
  }
}