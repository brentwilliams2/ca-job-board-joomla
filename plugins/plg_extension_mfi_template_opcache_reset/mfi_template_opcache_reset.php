<?php
/**
 * Extension Plugin for Multi Family Insiders Template to manage PHP Opcache
 *
 * Resets PHP 7+ opcache after extensions install/update/removal, and
 * logs recommended changes to PHP's configuration based on environment
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

defined('_JEXEC') or die();

use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;

// no autoload for namespaces in Joomla! plugins
include('./OpcacheConfig.php');

class plgExtensionMfiTemplateOpcacheReset extends JPlugin
{

  /**
   * Handle post extension install opcache reset
   *
   * @param   JInstaller  $installer  Installer object
   * @param   integer     $eid        Extension Identifier
   *
   * @return  void
   */
  public function onExtensionAfterInstall($installer, $eid )
  {
    opcache_reset();

    $this->triggerCacheWarming();

    $this->checkPhpConfiguration();
  }


  /**
   * Handle post extension uninstall opcache reset
   *
   * @param   JInstaller  $installer  Installer instance
   * @param   integer     $eid        Extension id
   * @param   boolean     $result     Installation result
   *
   * @return  void
   */
  public function onExtensionAfterUninstall($installer, $eid, $result)
  {
    opcache_reset();

    $this->triggerCacheWarming();

    $this->checkPhpConfiguration();
  }

  /**
   * Handle post extension update opcache reset
   *
   * @param   JInstaller  $installer  Installer object
   * @param   integer     $eid        Extension identifier
   *
   * @return  void
   */
  public function onExtensionAfterUpdate($installer, $eid)
  {
    opcache_reset();

    $this->triggerCacheWarming();

    $this->checkPhpConfiguration();
  }


  /**
   * Check that the PHP opcache configuration in php.ini is correctly configured
   *
   * This is a task that needs to run infrequently, but would be helpful to leave
   * a log trace. Joomla! extension installation / updates / uninstalls is as good
   * a place as any.
   *
   * @return  void
   */
  protected function checkPhpConfiguration()
  {
    // @TODO: needs to use a Joomla! configuration.php variable to save the last time
    //        the check ran, and not do it to prevent flooding the log file when
    //        multiple extensions are installed at once.

    $opcacheConfig = new OpcacheConfig();

    $opcacheConfig->checkPhpConfiguration();
  }


  /**
   * Call the CLI script to warm the cache
   *
   * @return  void
   */
  protected function triggerCacheWarming()
  {
    // @TODO: implement cache warmer after upgrades / installs
  }
}
