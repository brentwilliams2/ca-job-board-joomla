<?php
/**
 * Comments Admin Controller
 *
 * @package   Calligraphic Job Board
 * @version   September 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

 namespace Calligraphic\Cajobboard\Admin\Controller;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Controller\BaseController;

class Comment extends BaseController
{
	/*
	 * Overridden. Limit the tasks that are allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

    $this->setModelName('Comments');

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(

		));
	}


	/**
	 * Create a new record with the provided data. It is inserted as the last child of the current node's parent
	 *
	 * @param   array $data The data to use in the new record
	 *
	 * @return  static  The new node
	 */
	public function create($data)
	{
		$newNode = $this->getClone();
		$newNode->reset();
		$newNode->bind($data);

		if ($this->isRoot())
		{
			return $newNode->insertAsChildOf($this);
		}
		else
		{
			$parentNode = $this->getParent();

			return $newNode->insertAsChildOf($parentNode);
		}
	}


	/**
	 * Over-ridden to use TreeModel methods for nodes. Save a record, creating it if it doesn't
	 * exist or updating it if it exists. By default it uses the currently set data, unless you
	 * provide a $data array.
	 *
	 * @param   null|array  $data            [Optional] Data to bind
	 * @param   string      $orderingFilter  A WHERE clause used to apply table item reordering
	 * @param   array       $ignore          A list of fields to ignore when binding $data
	 * @para    boolean     $resetRelations  Should I automatically reset relations if relation-important fields are changed?
	 *
	 * @return   static  Self, for chaining
	 */
	public function save($data = null, $orderingFilter = '', $ignore = null, $resetRelations = true)
	{
		// Stash the primary key
		$oldPKValue = $this->getId();

		// Call the onBeforeSave event
		$this->triggerEvent('onBeforeSave', array(&$data));

//----- RELATION HANDLING START --------------------------------------------------------

		// Get the relation to local field map and initialise the relationsAffected array
		// calls relation manager, and returns an array like: ['Author' => 'id']
		$relationImportantFields = $this->getRelationFields();

		$dataBeforeBind = array();

		// If we have relations we keep a copy of the data before bind.
		if (count($relationImportantFields))
		{
			$dataBeforeBind = array_merge($this->recordData);
		}

//----- RELATION HANDLING END ----------------------------------------------------------

		// Bind any (optional) data. If no data is provided, the current record data is used
		if (!is_null($data))
		{
			$this->bind($data, $ignore);
		}

		// Is this a new record?
		if (empty($oldPKValue))
		{
			$isNewRecord = true;
		}
		else
		{
			$isNewRecord = $oldPKValue != $this->getId();
		}

		// Check the validity of the data
		$this->check();

		// Get the database object
		$db = $this->getDbo();

		// Insert or update the record. Note that the object we use for insertion / update is the copy holding
		// the transformed data.
		$dataObject = $this->recordDataToDatabaseData();

		$dataObject = (object)$dataObject;

		if ($isNewRecord)
		{
			$this->triggerEvent('onBeforeCreate', array(&$dataObject));

			// Insert the new record
			//$db->insertObject($this->tableName, $dataObject, $this->idFieldName);
			if ( property_exists($dataObject, 'parent_id') )
			$rootNode = $model->getRoot();


			// Update ourselves with the new ID field's value
			$this->{$this->idFieldName} = $db->insertid();

//----- RELATION HANDLING START --------------------------------------------------------

			// Rebase the relations with the newly created model
			// Necessary in case the  new record is a clone?
			if ($resetRelations)
			{
				$this->relationManager->rebase($this);
			}

//----- RELATION HANDLING END ----------------------------------------------------------

			$this->triggerEvent('onAfterCreate');
		}
		else
		{
			$this->triggerEvent('onBeforeUpdate', array(&$dataObject));

			$db->updateObject($this->tableName, $dataObject, $this->idFieldName, true);

			$this->triggerEvent('onAfterUpdate');
		}

		// If an ordering filter is set, attempt reorder the rows in the table based on the filter and value.
		if ($orderingFilter)
		{
			$filterValue = $this->$orderingFilter;

			$this->reorder($orderingFilter ? $db->qn($orderingFilter) . ' = ' . $db->q($filterValue) : '');
		}

//----- RELATION HANDLING START --------------------------------------------------------

		// One more thing... Touch all relations in the $touches array
		// which is... A list of the relations which will be auto-touched by save() and touch() methods
		if (!empty($this->touches))
		{
			foreach ($this->touches as $relation)
			{
				$records = $this->getRelations()->getData($relation);

				if (!empty($records))
				{
					if ($records instanceof DataModel)
					{
						$records = array($records);
					}

					/** @var DataModel $record */
					foreach ($records as $record)
					{
						$record->touch();
					}
				}
			}
		}

		// If we have relations we compare the data to the copy of the data before bind.
		if (count($relationImportantFields) && $resetRelations)
		{
			// Since array_diff_assoc doesn't work recursively we have to do it the EXCRUCIATINGLY SLOW WAY. Sad panda :(
			$keysRecord = (is_array($this->recordData) && !empty($this->recordData)) ? array_keys($this->recordData) : array();
			$keysBefore = (is_array($dataBeforeBind) && !empty($dataBeforeBind)) ? array_keys($dataBeforeBind) : array();

			$keysAll = array_merge($keysRecord, $keysBefore);
			$keysAll = array_unique($keysAll);

			$modifiedFields = array();

			foreach ($keysAll as $key)
			{
				if (!isset($dataBeforeBind[$key]) || !isset($this->recordData[$key]))
				{
					$modifiedFields[] = $key;
				}
				elseif ($dataBeforeBind[$key] != $this->recordData[$key])
				{
					$modifiedFields[] = $key;
				}
			}

			unset ($dataBeforeBind);

			if (count($modifiedFields))
			{
				$relationsAffected = array();

				unset($modifiedData);

				foreach ($relationImportantFields as $relationName => $fieldName)
				{
					if (in_array($fieldName, $modifiedFields))
					{
						$relationsAffected[] = $relationName;
					}
				}

				// Reset the relations which are affected by the save. This will force-reload the relations when you try to
				// access them again.
				$this->relationManager->resetRelationData($relationsAffected);
			}

//----- RELATION HANDLING END ----------------------------------------------------------

		}

		// Finally, call the onAfterSave event
		$this->triggerEvent('onAfterSave');

		return $this;
	}
}
