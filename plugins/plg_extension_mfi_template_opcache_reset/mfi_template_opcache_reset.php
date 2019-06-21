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

use \Joomla\CMS\Log\Log;
Log::add('Job Occupational Categories model called', Log::NOTICE);

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

    $this->checkPhpConfiguration();
  }


  /**
   * Check if PHP configuration is optimized if executing in production environment
   *
   * @return  void
   */
  public function checkPhpConfiguration()
  {
    if(!JDEBUG)
    {
      $opcacheStatus = opcache_get_status();

      $opcacheConfig = opcache_get_configuration();

      $isOpcacheEnabled = $opcacheConfig["directives"]["opcache.enable"];

      validate_timestamps   // Set to false, unless using revalidate_freq

      save_comments     // Set to false to reduce opcache size

      use_cwd  // defaults to enabled, improves performance to disable. Only issue if multiple different classes with the same name are used.

      memory_consumption    // in megabytes. Check against status?

      max_wasted_percentage   // maximum unused allocated memory in % before cache is reset to free memory, defaults to 5%

      interned_strings_buffer // in megabytes, defaults to 8mb. Maybe 16mb

      // find . -type f -iname '*.php' | wc -l
      max_accelerated_files   // prime number, 16229 or 32531

      enable_file_override  // enable to check cache first on file_exists(), is_file() and is_readable()

      blacklist_filename  // are there any files that need to be excluded from opcache? Maybe Joomla cache files?

      file_update_protection  // files less than this setting seconds old are excluded from caching, set to 0 for performance

      validate_permission // Validates the cached file permissions against the current user (needed?)

      preload // name of a PHP script that may preload other files with include() or opcache_compile_file(), used to prime the cache

      file_cache_consistency_checks  // enabled by default, checksum validation when script loaded from file cache

      fast_shutdown  // If enabled, a fast shutdown sequence is used that doesn’t free each allocated block, but instead relies on the Zend Engine memory manager to deallocate the entire set of request variables in mass (PHP 7+)
    }
  }
}
