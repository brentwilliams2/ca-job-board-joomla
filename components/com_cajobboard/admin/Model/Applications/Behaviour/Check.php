<?php
/**
 * FOF model behavior class for model validation
 *
 * Checks for empty fields that are set to NOT NULL in the database table,
 * and if the field is empty and has a default value, set it.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Applications\Behaviour;

use \FOF30\Model\DataModel;
use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyField;

// no direct access
defined( '_JEXEC' ) or die;

class Check extends \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check
{
  /**
	 * @param   DataModel  $model
	 */
	public function onAfterCheck(DataModel $model)
	{
    $this->checkForEmptyMandatoryAnswers($model);
  }


  /**
	 * Checks for mandatory answers from Answers model as a relation that are empty.
   * These are not detected by parent checkForEmpty() method as there is no database
   * table metadata for dynamic fields.
	 *
	 * @param   DataModel  $model
	 */
	protected function checkForEmptyMandatoryAnswers(DataModel $model)
	{
    // @TODO: implement application mandatory field check
  }
}
