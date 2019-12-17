<?php
/**
 * Trait to provide a single place for core type of methods to use in both BaseDataModel and BaseTreeModel
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined('_JEXEC') or die;

trait Core
{
  /**
   * The short names of behaviours that have been attached to the BehaviourDispatcher.
   * Can be nested e.g. 'Check\\Image'. Notice that the forward slash has been escaped,
   * the behaviour is added or checked as 'Check/Image'.
   *
   * @var array
   */
  protected $attachedBehaviourShortNames = array();


  /*
   * Getter for known model fields, intended for use in site model behaviors.
   *
   * @TODO: File PR to add getKnownFields getter to DataModel.
   *
   * Core DataModel class has setter for known fields but no getter.
   */
  public function getKnownFields()
	{
    return $this->knownFields;
  }


	/**
	 * Adds a behaviour by its name. Over-ridden to:
   *
   *   1. Escape forward slashes in the behaviour name, so that short names can be used
   *      for behaviour names that are hierarchical like 'Check/Image';
   *
   *   2. Maintain a cache of behaviours by their short name that have been attached to
   *      the BehaviourDispatcher , so that they can be quickly looked up in the TableFields
   *      helper for making table metadata ('hits', 'featured', 'language', 'ordering', and
   *      'version' fields) available based on whether the related behaviour is enabled or not.
   *
   * It will search the following classes, in this order:
   *
	 *   \component_namespace\Model\modelName\Behaviour\behaviourName
	 *   \component_namespace\Model\Behaviour\behaviourName
	 *   \FOF30\Model\DataModel\Behaviour\behaviourName
   *
	 * where:
   *
	 *   component_namespace  is the namespace of the component as defined in the container
	 *   modelName            is the model's name, first character uppercase, e.g. Baz
	 *   behaviourName        is the $behaviour parameter, first character uppercase, e.g. Something
	 *
	 * @param   string $behaviour   The behaviour's name, in short form. Can be nested e.g. 'Check/Image'
	 *
	 * @return  $this  Self, for chaining
	 */
	public function addBehaviour($behaviour)
	{
    $behaviour = str_replace( '/', '\\', $behaviour);

		$prefixes = array(
			$this->container->getNamespacePrefix() . 'Model\\Behaviour\\' . ucfirst($this->getName()),
			$this->container->getNamespacePrefix() . 'Model\\Behaviour',
			'\\FOF30\\Model\\DataModel\\Behaviour',
    );

		foreach ($prefixes as $prefix)
		{
      $className = $prefix . '\\' . ucfirst($behaviour);

			if (class_exists($className, true) && !$this->behavioursDispatcher->hasObserverClass($className))
			{
				/** @var Observer $o */
        $observer = new $className($this->behavioursDispatcher);

        $this->behavioursDispatcher->attach($observer);

        array_push($this->attachedBehaviourShortNames, $behaviour);

				return $this;
			}
    }

		return $this;
  }


	/**
	 * Check if a Behaviour observer object is already registered with the behaviour dispatcher.
   * The \FOF30\Event\Dispatcher has a hasObserver() method to do this but it uses reflection, and
   * the routine is called repeatedly in the TableFields helper.
	 *
	 * @param   string $behaviour   The behaviour's name, in short form. Can be nested e.g. 'Check/Image'
	 *
	 * @return  boolean
	 */
	public function hasBehaviour($behaviour)
	{
    // Handle escaping nested behaviour names
    $behaviour = str_replace( '/', '\\', $behaviour);

		return in_array($behaviour, $this->attachedBehaviourShortNames);
	}


  /**
	 * Method to check if view counts (hits, read / unread totals, etc.) should be incremented
	 *
	 * @return  bool  Returns true if the item should be incremented to indicate a new view of the item has occurred
	 */
  protected function shouldIncrementViewCounts()
  {
    // @TODO: exclude admin views of this item in shouldIncrementViewCounts() in BaseModel

    // @TODO: exclude views other than item views in shouldIncrementViewCounts() in BaseModel

    // @TODO: exclude bind called from save (maybe use a state property and onBeforeSave()?) in shouldIncrementViewCounts() in BaseModel

    // @TODO: exclude access forbidden or other aborts to an item view in shouldIncrementViewCounts() in BaseModel

    return false;
  }
}
