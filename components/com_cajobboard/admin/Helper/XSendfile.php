<?php
/**
 * Admin Helper for Apache and Nginx Webserver X-Sendfile / X-Accel module
 *
 * This allows storing media files with random filenames (MD5 hashes), and
 * serving them with SEF-friendly filenames when the appropriate webserver
 * module is enabled. It also enables access control on media files.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined( '_JEXEC' ) or die;

use \FOF30\Container\Container;


/*
  @TODO: access control: sudo apt-get install libapache2-mod-xsendfile

  httpd.conf:

  #
  # X-Sendfile
  #
  LoadModule xsendfile_module modules/mod_xsendfile.so
  XSendFile On
  # enable sending files from parent dirs of the script directory
  XSendFileAllowAbove On

  header('X-Sendfile: ' . $absoluteFilePath);

  // The Content-Disposition header allows you to tell the browser if
  // it should download the file or display it. Use "inline" instead of
  // "attachment" if you want it to display in the browser. You can
  // also set the filename the browser should use.
  header('Content-Disposition: attachment; filename="somefile.jpg"');

  // The Content-Type header tells the browser what type of file it is.
  header('Content-Type: image/jpeg');

  // Nginx uses x-accel.redirect
*/

class XSendfile
{

}
