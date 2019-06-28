<?php
/**
 * Exception class for cli script to populate sample data using FOF "ORM"
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Exception;

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/**
 * Define a custom exception class
 */
class UploadException extends \Exception
{
  public function __construct($code) {
    $message = $this->codeToMessage($code);
    parent::__construct($message, $code);
  }

  private function codeToMessage($code)
  {
    switch ($code) {
      case UPLOAD_ERR_INI_SIZE:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_INI_SIZE');
        break;

      case UPLOAD_ERR_FORM_SIZE:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_FORM_SIZE');
        break;

      case UPLOAD_ERR_PARTIAL:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_PARTIAL');
        break;

      case UPLOAD_ERR_NO_FILE:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_NO_FILE');
        break;

      case UPLOAD_ERR_NO_TMP_DIR:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_NO_TMP_DIR');
        break;

      case UPLOAD_ERR_CANT_WRITE:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_CANT_WRITE');
        break;

      case UPLOAD_ERR_EXTENSION:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_UPLOAD_ERR_EXTENSION');
        break;

      default:
        $message = Text::_('COM_CAJOBBOARD_UPLOAD_EXCEPTION_OTHER');
        break;
    }

    return $message;
  }
}
