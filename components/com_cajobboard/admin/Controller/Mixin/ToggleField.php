<?php
/**
 * Admin Toggle a field's state Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   July 5, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Controller\Exception\ToggleFailure;

// no direct access
defined('_JEXEC') or die;

trait ToggleField
{
   /**
    * Toggle a field value for the selected item(s). Provide a method
    * in the model to toggle the field's state with a name in the format:
    *   setTasknameState(boolean $state)
    *
    * @param  string  $fieldName  The name of the model field to toggle (e.g. 'feature', 'unfeature')
    * @param  bool    $state      Whether this item should be set to true or false
    *
    * @throws
    *
    * @return  void
    */
    public function toggleField(string $fieldName, bool $state = false)
    {
     $this->csrfProtection();

      $model = $this->getModel()->savestate(false);
      $ids   = $this->getIDsFromRequest($model, false);

      try
      {
        foreach ($ids as $id)
        {
          $model->find($id);
          $model->setFieldState($fieldName, $state);
        }
      }
      catch (\Exception $e)
      {
        // COM_CAJOBBOARD_EXCEPTION_TASKNAME_TOGGLE_FAILURE in en-GB.exceptions.ini
        throw new ToggleFailure( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_'. strtoupper($fieldName) . '_TOGGLE_FAILURE') );
      }

     $this->setRedirect($this->getRedirectUrl(), $this->getRedirectFlashMsg($fieldName), 'message');
    }
}
