<?php
/**
 * Extend Category model for the Job Board
 * boilerplate file required by Joomla!
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Allows using:
 *
 * $categories = JCategories::getInstance('Cajobboard');
 * $subCategories = $categories->get()->getChildren(true);
 */

// no direct access
defined('_JEXEC') or die;

// @TODO: This can only be used with one table per component?

/**
 * Content Component Category Tree
 *
 * @since  1.6
 */
class CajobboardCategories extends JCategories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   1.7.0
	 */
	public function __construct($options = array())
	{
    // Name of the extension the categories belong to.
    $options['extension'] = 'com_cajobboard';

    // Name of the linked content table to get category content count
    $options['table'] = '#__cajobboard';

		parent::__construct($options);
	}
}
