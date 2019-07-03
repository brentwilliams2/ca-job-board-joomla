<?php
/**
 * Helper class for formatting data for display
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use \Calligraphic\Cajobboard\Admin\Model\Persons;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \Joomla\CMS\Language\Text;
use \Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die;

/**
 * A helper class for getting and updating aggrete total and unread Messages counts
 */
class MessageCounts
{
	/**
	 * The container attached to the model
	 *
	 * @var Container
	 */
  protected $container;


	/**
	 * A cache of user message counts
	 *
	 * @var array   $cachedMessageCounts   Assoc array of cached message counts, indexed by user ID
	 */
  protected $cachedMessageCounts = array();


  /**
  * Public class constructor
 	 *
   * @param   Container  $container  The configuration variables to this model
   */
  public function __construct(Container $container)
  {
    $this->container = $container;
  }


  /**
	 * Update the 'messagesTotal' and 'messagesUnread' keys in the Person model 'params' field
   *
   * @throws \Exception  Throws Exception object on failed save
   *
   * @param   int   $userId   The ID of the user to return message counts for
	 */
  protected function updateMessageCounts($userId)
  {
    $personModel = $this->getPersonModel($userId);

    $params = $personModel->get('params');

    $messagesTotal  = $params->get('messagesTotal', 1);
    $messagesUnread = $params->get('messagesUnread', 1);

    if ( $this->shouldIncrementViewCounts() )
    {
      $params->set('messagesTotal', $messagesTotal++);

      $params->set('messagesUnread', $this->calculateMessagesUnread($messagesUnread));
    }

    $personModel->setParam( 'params', $params->toString('JSON') );

    $success = $personModel->save();

    if (!$success)
    {
      throw new \Exception( Text::sprintf('COM_CAJOBBOARD_MESSAGE_COUNTS_EXCEPTION_USER_SAVE_FAILED', $userId));
    }
  }


  /**
	 * Calculate unique views (when user has already viewed the message) and return value
	 *
	 * @return  int  The updated 'messagesUnread' parameter
	 */
  protected function calculateMessagesUnread($messagesUnread)
  {
    // @TODO: implement calculateMessagesUnread() in MessageCounts helper

    return $messagesUnread;
  }


  /**
	 * Get the message counts from the message
   *
   * @param   int   $userId   The ID of the user to return message counts for
	 *
	 * @return  array  Returns assoc array with keys 'messagesTotal' and 'messagesUnread'
	 */
  public function getMessageCounts($userId)
  {
    if ( array_key_exists ($userId , $this->$cachedMessageCounts) )
    {
      return $this->$cachedMessageCounts[$userId];
    }

    $params = $this->getPersonModel($userId)->get('params');

    return $this->$cachedMessageCounts[$userId] = array( 'messagesTotal' => $params->get('messagesTotal'), 'messagesUnread' => $params->get('messagesUnread') );
  }


  /**
	 * Get the Persons model of the user
   *
   * @param   int   $userId   The ID of the user to return message counts for
   *
   * @throws  RecordNotLoaded
	 *
	 * @return  Persons   A Persons model of the user
	 */
  public function getPersonModel($userId)
  {
    $config = array();

    $config['modelTemporaryInstance'] = true;
    $config['modelTemporaryInstance'] = false;
    $config['modelClearState']        = true;
    $config['modelClearInput']        = true;

    /** @var Persons $personModel */
    $personModel = $this->container->factory->model('Persons', $config);

    try
    {
      return $personModel->findOrFail($userId);
    }
    catch (\Exception $e)
    {
      throw new RecordNotLoaded( Text::sprintf('COM_CAJOBBOARD_MESSAGE_COUNTS_EXCEPTION_RECORD_NOT_LOADED', $userId) . ' ' . $e );
    }
  }
}
