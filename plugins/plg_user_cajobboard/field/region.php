<?php
/**
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

// The field name must always be the same as the filename JFormField<FieldName>
class JFormFieldRegion extends JFormField {

	//The field class must know its own type through the variable $type.
	protected $type = 'Region';

  // Override base class to pull select options from database query
	public function getOptions() {
    $db = JFactory::getDbo();

    $query = $db->getQuery(true)
      ->select($db->quoteName('name'))
      ->from($db->quoteName('#__cajobboard_address_regions'));

    $regions = $db->setQuery($query)->loadColumn();

    // Merge any additional options in the XML definition.
    $options = array_merge(parent::getOptions(), $regions);

    return $options;
}
}
