<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Calligraphic Job Board plugin class.
 *
 * @package     Joomla.plugin
 * @subpackage  System.cajobboard
 */
class plgSystemCajobboard extends JPlugin
{
  /**
   * Method to register custom library.
   *
   * return  void
   */
  public function onAfterInitialise()
  {
    if (!@include_once(JPATH_LIBRARIES . '/calligraphic/cajobboard.php'))
    {
      throw new RuntimeException(JText::_('PLG_CAJOBBOARD_ERROR_LIBRARY_NOT_FOUND'), 500);
    }
  }
}
