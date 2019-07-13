<?php
/**
 * Installation script for Analytics Action Log plugin
 *
 * @package   Calligraphic Job Board
 * @version   July 7, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\Answers;

use \Joomla\CMS\Factory;

// no direct access
defined('_JEXEC') or die;

class plgCajobboardCajobboard_analyticsInstallerScript
{
  /**
   * @param \Joomla\CMS\Application\CMSApplication $application
   */
  private $application = null;

  /**
   * @param \JDatabaseDriver $dbo
   */
  private $dbo = null;


	/**
	 * @param   JAdapterInstance  $adapter  @deprecated
	 */
  public function __construct(JAdapterInstance $adapter)
  {
    $this->application = Factory::getApplication();

    $this->dbo = Factory::getDbo();
  }


	/**
	 * Plugin installation routine
	 *
	 * @param   JAdapterInstance  $adapter  @deprecated
	 *
	 * @return  boolean  True on success
	 */
  public function install(JAdapterInstance $adapter)
  {
    try
    {
      if ( !$this->existsActionLogExtensionRecord() )
      {
        $this->addActionLogExtensionRecord();
      }

      if ( !$this->existsActionLogConfigRecord() )
      {
        $this->addActionLogConfigRecord();
      }
    }
    catch (RuntimeException $e)
    {
      $this->application->enqueueMessage( $e->getMessage() );

      return false;
    }

    return true;
  }


	/**
	 * Plugin removal routine
	 *
	 * @param   JAdapterInstance  $adapter  @deprecated
	 */
  public function uninstall(JAdapterInstance $adapter)
  {
    try
    {
      if ( $this->existsActionLogExtensionRecord() )
      {
        $this->removeActionLogExtensionRecord();
      }

      if ( $this->existsActionLogConfigRecord() )
      {
        $this->removeActionLogConfigRecord();
      }
    }
    catch (RuntimeException $e)
    {
      $this->application->enqueueMessage( $e->getMessage() );

      return false;
    }

    return true;
  }


  private function existsActionLogExtensionRecord()
  {
    $query = $this->dbo->getQuery(true);

    $query
      ->select('COUNT(*)')
      ->from  ($this->dbo->quoteName('#__action_logs_extensions'))
      ->where ($this->dbo->quoteName('extension') . ' LIKE '. $this->dbo->quote('\'com_cajobboard%\''));

    // Reset the query using our newly populated query object.
    $this->dbo->setQuery($query);

    return $this->dbo->loadResult();
  }


  private function addActionLogExtensionRecord()
  {
    // id, extension
    $this->dbo->setQuery(' INSERT into #__action_logs_extensions (extension) VALUES ('.$db->Quote($extension).') ' );

    $this->dbo->execute();
  }


  private function removeActionLogExtensionRecord()
  {
    $query = $this->dbo->getQuery(true);

    $query
      ->delete($db->quoteName('#__action_logs_extensions'))
      ->where ($this->dbo->quoteName('extension') . ' LIKE ' . $this->dbo->quote('\'com_cajobboard%\''));

    // Reset the query using our newly populated query object.
    $this->dbo->setQuery($query);

    $this->dbo->execute();
  }


  private function existsActionLogConfigRecord()
  {
    $query = $this->dbo->getQuery(true);

    $query
      ->select('COUNT(*)')
      ->from  ($this->dbo->quoteName('#__action_log_config'))
      ->where ($this->dbo->quoteName('table_name') .  ' LIKE '. $this->dbo->quote('\'com_cajobboard%\''));

    // Reset the query using our newly populated query object.
    $this->dbo->setQuery($query);

    return $this->dbo->loadResult();
  }


  private function addActionLogConfigRecord()
  {
    $logConf = new stdClass();
    $logConf->id = 0;
    $logConf->type_title = 'article'; // used in #__content_types, gives a descriptive title for the table being versioned in content history
    $logConf->type_alias = 'com_content.article';
    $logConf->id_holder = 'id';   // alias for table primary key
    $logConf->title_holder = 'title';   // alias for table title field
    $logConf->table_name = '#__content';
    $logConf->text_prefix = 'PLG_ACTIONLOG_JOOMLA'; // convenience method, used like: Text::_($this->text_prefix . '_N_ITEMS_ARCHIVED');

    $this->dbo->insertObject('#__action_log_config', $logConf);
  }


  private function removeActionLogConfigRecord()
  {
    $query = $this->dbo->getQuery(true);

    $query
      ->delete($db->quoteName('#__action_log_config'))
      ->where ($this->dbo->quoteName('table_name') . ' LIKE ' . $this->dbo->quote('\'com_cajobboard%\''));

    // Reset the query using our newly populated query object.
    $this->dbo->setQuery($query);

    $this->dbo->execute();
  }
}
