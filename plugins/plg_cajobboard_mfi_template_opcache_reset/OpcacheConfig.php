<?php
/**
 * Logs recommended changes to PHP's configuration based on environment
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

defined('_JEXEC') or die();

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;

class OpcacheConfig
{
  /*
   * @property bool  Flag to indicate that a flash message has been saved for the administrator
   */
  protected $isFlashMssgEnqueued = false;


  /*
   * @property int  The number of PHP files in the Joomla! installation
   */
  protected $fileCount;


  /**
   * Check if PHP configuration is optimized if executing in production environment
   *
   * @return  void
   */
  public function checkOpcacheConfig()
  {
    if(!JDEBUG)
    {
      $conf = opcache_get_configuration()["directives"];

      array_key_exists($conf['opcache.enable']) && $conf['opcache.enable'] != true && self::logRecommendedSetting('opcache.enable', 'true');

      // Not using revalidate_freq to periodically check files for freshness.
      array_key_exists($conf['validate_timestamps']) && $conf['validate_timestamps'] != false && self::logRecommendedSetting('opcache.validate_timestamps', '');

      // Set to false to not cache comments and reduce opcache size. Not compatible with annotations.
      array_key_exists($conf['save_comments']) && $conf['save_comments'] != false && self::logRecommendedSetting('opcache.save_comments', 'false');

      // Prepends cwd to opcache search key when disabled, more performant but conflicts with Joomla!.
      array_key_exists($conf['use_cwd']) && $conf['use_cwd'] != true && self::logRecommendedSetting('opcache.use_cwd', 'true');

      // maximum unused allocated memory in % before cache is reset to free memory, defaults to 5%.
      array_key_exists($conf['max_wasted_percentage']) && $conf['max_wasted_percentage'] >= 10 && self::logRecommendedSetting('opcache.max_wasted_percentage', '>= 10');

      // in megabytes, defaults to 8mb.
      array_key_exists($conf['interned_strings_buffer']) && $conf['interned_strings_buffer'] >= 16 && self::logRecommendedSetting('opcache.interned_strings_buffer', ' >= 16');

      // enable to check cache first on file_exists(), is_file() and is_readable() instead of syscall.
      array_key_exists($conf['enable_file_override']) && $conf['enable_file_override'] != true && self::logRecommendedSetting('opcache.enable_file_override', 'true');

      // files less than this setting seconds old are excluded from caching, set to 0 for performance.
      array_key_exists($conf['file_update_protection']) && $conf['file_update_protection'] != 0 && self::logRecommendedSetting('opcache.file_update_protection', '0');

      // Will be set to next highest prime number (e.g. 16229 or 32531) above the value set
      array_key_exists($conf['max_accelerated_files']) && $conf['max_accelerated_files'] < getFileCount() && self::logRecommendedSetting( 'max_accelerated_files', getFileCount() );

      // Use a blacklist file to prevent caching Joomla!'s /cache and /tmp directories
      array_key_exists($conf['blacklist_filename']) && empty($conf['blacklist_filename']) && self::logRecommendedSetting('opcache.preload', 'not empty');

      // name of a PHP script that may preload other files with include() or opcache_compile_file(), used to prime the cache
      array_key_exists($conf['preload']) && empty($conf['preload']) && self::logRecommendedSetting('opcache.preload', 'not empty');

      if ($this->$isFlashMssgEnqueued)
      {
        $this->$setFlashMessage();
      }
    }
  }


  /**
   * Check count of PHP files in this Joomla! installation to cache
   *
   * @return  int   The number files
   */
  protected function getFileCount()
  {
    // short-circuit if already counted, useful for setting error message
    if ( isset($this->fileCount) )
    {
      return $this->fileCount;
    }

    // Ensure access to shell_exec()
    if (!is_callable('shell_exec') || true == stripos(ini_get('disable_functions'), 'shell_exec'))
    {
      Log::add( Text::printf( 'PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_EXEC_ERROR'), Log::NOTICE );
    }

    try
    {
      $this->fileCount = shell_exec("find . -type f -iname '*.php' | wc -l");
    }
    catch (\Exception $e)
    {
      Log::add( Text::printf( 'PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_FILE_COUNT_ERROR', $e->getMessage() ), Log::NOTICE );
    }

    return $this->fileCount;
  }


  /**
   * Log and send a flash message to the administrator if setting is not recommended
   *
   * @property  string  $configParam          The name of the opcache configuration parameter to log
   * @property  string  $recommendedSetting   The value recommended for the opcache configuration parameter
   *
   * @return  void
   */
  protected function logRecommendedSetting($configParam, $recommendedSetting)
  {
    $mssg = Text::printf('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_LOG_MSSG', $configParam, $conf[$configParam], $recommendedSetting);

    Log::add($mssg, Log::NOTICE);

    $this->$isFlashMssgEnqueued = true;
  }


  /**
   * Log and send a flash message to the administrator if any settings are not at recommended values
   *
   * @return  void
   */
  protected function setFlashMessage()
  {
    Factory::getApplication()->enqueueMessage( Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_LOG_ADMIN_MSSG'), 'warning' );
  }
}
