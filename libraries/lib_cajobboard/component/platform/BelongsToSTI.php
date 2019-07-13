<?php
/**
 * "Belongs To" relation for single-table inheritance
 *
 * @package   Calligraphic Job Board
 * @version   July 7, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;

class BelongsToSTI
{
	/** @var   DataModel  The data model we are attached to */
  protected $parentModel = null;

	/** @var   string  The class name of the foreign key's model */
  protected $foreignModelClass = null;

	/** @var   string  The application name of the foreign model */
  protected $foreignModelComponent = null;

	/** @var   string  The bade name of the foreign model */
  protected $foreignModelName = null;

	/** @var   string   The local table key for this relation */
  protected $localKey = null;

	/** @var   string   The foreign table key for this relation */
  protected $foreignKey = null;

	/** @var   null  For many-to-many relations, the pivot (glue) table */
  protected $pivotTable = null;

	/** @var   null  For many-to-many relations, the pivot table's column storing the local key */
  protected $pivotLocalKey = null;

	/** @var   null  For many-to-many relations, the pivot table's column storing the foreign key */
  protected $pivotForeignKey = null;

	/** @var   Collection  The data loaded by this relation */
  protected $data = null;

	/** @var  array  Maps each local table key to an array of foreign table keys, used in many-to-many relations */
  protected $foreignKeyMap = array();

	/** @var  Container  The component container for this relation */
  protected $container = null;


	/**
	 * Public constructor. Initialises the relation.
	 *
	 * @param   DataModel $parentModel       The data model we are attached to
	 * @param   string    $foreignModelName  The name of the foreign key's model in the format "modelName@com_something"
	 * @param   string    $localKey          The local table key for this relation, usually the primary key of the foreign model and stored in this table
	 * @param   string    $foreignKey        The foreign key for this relation, the primary key of the foreign model used in the foreign model
	 * @param   string    $pivotTable        For many-to-many relations, the pivot (glue) table
	 * @param   string    $pivotLocalKey     For many-to-many relations, the pivot table's column storing the local key
	 * @param   string    $pivotForeignKey   For many-to-many relations, the pivot table's column storing the foreign key
	 */
	public function __construct(DataModel $parentModel, $foreignModelName, $localKey = null, $foreignKey = null, $pivotTable = null, $pivotLocalKey = null, $pivotForeignKey = null)
	{
    $this->container = $parentModel->getContainer();

		$this->parentModel = $parentModel;
		$this->foreignModelClass = $foreignModelName;
		$this->localKey = $localKey;
		$this->foreignKey = $foreignKey;
		$this->pivotTable = $pivotTable;
		$this->pivotLocalKey = $pivotLocalKey;
    $this->pivotForeignKey = $pivotForeignKey;

		if (strpos($foreignModelName, '@') === false)
		{
			$this->foreignModelComponent = null;
			$this->foreignModelName = $foreignModelName;
		}
		else
		{
      $foreignParts = explode('@', $foreignModelName, 2);

			$this->foreignModelComponent = $foreignParts[1];
			$this->foreignModelName = $foreignParts[0];
		}

		if (empty($localKey))
		{
			$this->localKey = $parentModel->getIdFieldName();
    }

		if (empty($foreignKey))
		{
			/** @var DataModel $foreignModel */
      $foreignModel = $this->getForeignModel();

      $foreignModel->setIgnoreRequest(true);

			$this->foreignKey = $foreignModel->getIdFieldName();
    }

    /* BelongsTo constructor ends here */

		if (empty($pivotLocalKey))
		{
			$this->pivotLocalKey = $this->localKey;
    }

		if (empty($pivotForeignKey))
		{
			$this->pivotForeignKey = $this->foreignKey;
    }

		if (empty($pivotTable))
		{
			// Get the local model's name (e.g. "users")
      $localName = $parentModel->getName();

      $localName = strtolower($localName);

			// Get the foreign model's name (e.g. "groups")
			if (!isset($foreignModel))
			{
				/** @var DataModel $foreignModel */
        $foreignModel = $this->getForeignModel();

				$foreignModel->setIgnoreRequest(true);
      }

      $foreignName = $foreignModel->getName();

      $foreignName = strtolower($foreignName);

			// Get the local model's app name
      $parentModelBareComponent = $parentModel->getContainer()->bareComponentName;

      $foreignModelBareComponent = $foreignModel->getContainer()->bareComponentName;

			// There are two possibilities for the table name: #__component_local_foreign or #__component_foreign_local.
			// There are also two possibilities for a component name (local or foreign model's)
      $db = $parentModel->getDbo();

      $prefix = $db->getPrefix();

			$tableNames = array(
				'#__' . strtolower($parentModelBareComponent) . '_' . $localName . '_' . $foreignName,
				'#__' . strtolower($parentModelBareComponent) . '_' . $foreignName . '_' . $localName,
				'#__' . strtolower($foreignModelBareComponent) . '_' . $localName . '_' . $foreignName,
				'#__' . strtolower($foreignModelBareComponent) . '_' . $foreignName . '_' . $localName,
      );

      $allTables = $db->getTableList();

      $this->pivotTable = null;

			foreach ($tableNames as $tableName)
			{
        $checkName = $prefix . substr($tableName, 3);

				if (in_array($checkName, $allTables))
				{
					$this->pivotTable = $tableName;
				}
      }

			if (empty($this->pivotTable))
			{
				throw new DataModel\Relation\Exception\PivotTableNotFound("Pivot table for many-to-many relation between '$localName and '$foreignName' not found'");
			}
		}


	/**
	 * Reset the relation data
	 *
	 * @return $this For chaining
	 */
	public function reset()
	{
    $this->data = null;

    $this->foreignKeyMap = array();

		return $this;
  }


	/**
	 * Rebase the relation to a different model
	 *
	 * @param DataModel $model
	 *
	 * @return $this For chaining
	 */
	public function rebase(DataModel $model)
	{
    $this->parentModel = $model;

		return $this->reset();
  }


  /*
    eager load calls relationManager:

    $relation->getData
    $relation->getForeignKeyMap

    foreach ($dataCollection as $item)
    {
      $item->relation->setDataFromCollection($relation, $relationData, $foreignKeyMap);
    }
  */


	/**
	 * Get the relation data.
	 *
	 * If you want to apply additional filtering to the foreign model, use the $callback. It can be any function,
	 * static method, public method or closure with an interface of function(DataModel $foreignModel). You are not
	 * supposed to return anything, just modify $foreignModel's state directly. For example, you may want to do:
	 * $foreignModel->setState('foo', 'bar')
	 *
	 * @param callable   $callback The callback to run on the remote model.
	 * @param Collection $dataCollection
	 *
	 * @return Collection|DataModel
	 */
	public function getData($callback = null, Collection $dataCollection = null)
	{
		if (is_null($this->data))
		{
			// Initialise
      $this->data = new Collection();

			// Get a model instance
      $foreignModel = $this->getForeignModel();

      $foreignModel->setIgnoreRequest(true);

      // Add 'where' clauses if set on the foreign model
      $filtered = $this->filterForeignModel($foreignModel, $dataCollection);

			if (!$filtered)
			{
        if (is_null($dataCollection))
        {
          // gets the first item from the collection
          return $this->data->first();
        }
        else
        {
          return $this->data;
        }
      }

			// Apply the callback, if applicable
			if (!is_null($callback) && is_callable($callback))
			{
				call_user_func($callback, $foreignModel);
      }

			// Get the list of items from the foreign model and cache in $this->data
			$this->data = $foreignModel->get(true);
    }

    if (is_null($dataCollection))
		{
      // gets the first item from the collection
			return $this->data->first();
		}
		else
		{
			return $this->data;
		}
  }


	/**
	 * Populates the internal $this->data collection from the contents of the provided collection. This is used by
	 * DataModel to push the eager loaded data into each item's relation.
	 *
	 * @param Collection $data   The relation data to push into this relation
	 * @param mixed      $keyMap Used by many-to-many relations to pass around the local to foreign key map
	 *
	 * @return void
	 */
	public function setDataFromCollection(Collection &$data, $keyMap = null)
	{
    $this->data = new DataModel\Collection();

		if (!is_array($keyMap))
		{
			return;
    }

		if (!empty($data))
		{
			// Get the local key value
      $localKeyValue = $this->parentModel->getFieldValue($this->localKey);

			// Make sure this local key exists in the (cached) pivot table
			if (!isset($keyMap[$localKeyValue]))
			{
				return;
      }

			/** @var DataModel $item */
			foreach ($data as $key => $item)
			{
				// Only accept foreign items whose key is associated in the pivot table with our local key
				if (in_array($item->getFieldValue($this->foreignKey), $keyMap[$localKeyValue]))
				{
					$this->data->add($item);
				}
			}
		}
  }


  /**
	 * Applies the relation filters ('where' clause) to the foreign model when getData is called
	 *
	 * @param DataModel  $foreignModel   The foreign model you're operating on
	 * @param DataModel\Collection $dataCollection If it's an eager loaded relation, the collection of loaded parent records
	 *
	 * @return boolean Return false to force an empty data collection
	 */
	protected function filterForeignModel(DataModel $foreignModel, DataModel\Collection $dataCollection = null)
	{
    $db = $this->parentModel->getDbo();

		// Decide how to proceed, based on eager or lazy loading
		if (is_object($dataCollection))
		{
			// Eager loaded relation
			if (!empty($dataCollection))
			{
				// Get a list of local keys from the collection
        $values = array();

				/** @var $item DataModel */
				foreach ($dataCollection as $item)
				{
          $v = $item->getFieldValue($this->localKey, null);

					if (!is_null($v))
					{
						$values[] = $v;
					}
        }

				// Keep only unique values
        $values = array_unique($values);

        $values = array_map(function ($x) use (&$db)

				{
          return $db->q($x);

        }, $values);

				// Get the foreign keys from the glue table
        $query = $db->getQuery(true);

        $query
					->select(array($db->qn($this->pivotLocalKey), $db->qn($this->pivotForeignKey)))
					->from($db->qn($this->pivotTable))
          ->where($db->qn($this->pivotLocalKey) . ' IN(' . implode(',', $values) . ')');

        $db->setQuery($query);

        $foreignKeysUnmapped = $db->loadRowList();

        $this->foreignKeyMap = array();

        $foreignKeys = array();

				foreach ($foreignKeysUnmapped as $unmapped)
				{
          $local = $unmapped[0];

          $foreign = $unmapped[1];

					if (!isset($this->foreignKeyMap[$local]))
					{
						$this->foreignKeyMap[$local] = array();
					}
          $this->foreignKeyMap[$local][] = $foreign;

					$foreignKeys[] = $foreign;
        }

				// Keep only unique values. However, the array keys are all screwed up. See below.
        $foreignKeys = array_unique($foreignKeys);

				// This looks stupid, but it's required to reset the array keys. Without it where() below fails.
        $foreignKeys = array_merge($foreignKeys);

				// Apply the filter
				if (!empty($foreignKeys))
				{
					$foreignModel->where($this->foreignKey, 'in', $foreignKeys);
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			// Lazy loaded relation; get the single local key
      $localKey = $this->parentModel->getFieldValue($this->localKey, null);

			if (is_null($localKey) || ($localKey === ''))
			{
				return false;
      }

      $query = $db->getQuery(true);

      $query
				->select($db->qn($this->pivotForeignKey))
				->from($db->qn($this->pivotTable))
				->where($db->qn($this->pivotLocalKey) . ' = ' . $db->q($localKey));
      $db->setQuery($query);

      $foreignKeys = $db->loadColumn();

      $this->foreignKeyMap[$localKey] = $foreignKeys;

			// If there are no foreign keys (no foreign items assigned to our item) we return false which then causes
			// the relation to return null, marking the lack of data.
			if (empty($foreignKeys))
			{
				return false;
      }

			$foreignModel->where($this->foreignKey, 'in', $this->foreignKeyMap[$localKey]);
		}
		return true;
	}


  /**
	 * Returns the count subquery for DataModel's has() and whereHas() methods.
	 *
	 * @param   string  $tableAlias  The alias of the local table in the query. Leave blank to use the table's name.
	 *
	 * @return \JDatabaseQuery
	 */
	public function getCountSubquery($tableAlias = null)
	{
		/** @var DataModel $foreignModel */
    $foreignModel = $this->getForeignModel();

    $foreignModel->setIgnoreRequest(true);

    $db = $foreignModel->getDbo();

		if (empty($tableAlias))
		{
			$tableAlias = $this->parentModel->getTableName();
    }

    $query = $db->getQuery(true);

    $query
			->select('COUNT(*)')
			->from($db->qn($foreignModel->getTableName()) . ' AS ' . $db->qn('reltbl'))
			->innerJoin(
				$db->qn($this->pivotTable) . ' AS ' . $db->qn('pivotTable') . ' ON('
				. $db->qn('pivotTable') . '.' . $db->qn($this->pivotForeignKey) . ' = '
				. $db->qn('reltbl') . '.' . $db->qn($foreignModel->getFieldAlias($this->foreignKey))
				. ')'
			)
			->where(
				$db->qn('pivotTable') . '.' . $db->qn($this->pivotLocalKey) . ' ='
				. $db->qn($tableAlias) . '.'
				. $db->qn($this->parentModel->getFieldAlias($this->localKey))
      );

		return $query;
	}


	/**
	 * This is not supported by the belongsTo relation
	 *
	 * @throws DataModel\Relation\Exception\NewNotSupported when it's not supported
	 */
	public function getNew()
	{
    /* HasMany logic:

  		// Get a model instance
      $foreignModel = $this->getForeignModel();

      $foreignModel->setIgnoreRequest(true);

      // Prime the model
      $foreignModel->setFieldValue($this->foreignKey, $this->parentModel->getFieldValue($this->localKey));

      // Make sure we do have a data list
      if (!($this->data instanceof DataModel\Collection))
      {
        $this->getData();
      }

      // Add the model to the data list
      $this->data->add($foreignModel);

      return $this->data->last();
    */

		throw new \FOF30\Model\DataModel\Relation\Exception\NewNotSupported("getNew() is not supported by the many-to-may relations. Please add/remove items from the relation data and use push() to effect changes");
	}


	/**
	 * Saves all related items. For many-to-many relations there are two things we have to do:
	 * 1. Save all related items; and
	 * 2. Overwrite the pivot table data with the new associations
	 */
	public function saveAll()
	{
		// Save all related items
    parent::saveAll();

    $this->saveRelations();
  }


	/**
	 * Overwrite the pivot table data with the new associations
	 */
	public function saveRelations()
	{
		// Get all the new keys
    $newKeys = array();

		if ($this->data instanceof DataModel\Collection)
		{
			foreach ($this->data as $item)
			{
				if ($item instanceof DataModel)
				{
					$newKeys[] = $item->getId();
				}
				elseif (!is_object($item))
				{
					$newKeys[] = $item;
				}
			}
    }

    $newKeys = array_unique($newKeys);

    $db = $this->parentModel->getDbo();

    $localKeyValue = $this->parentModel->getFieldValue($this->localKey);

		// Kill all existing relations in the pivot table
    $query = $db->getQuery(true);

    $query
			->delete($db->qn($this->pivotTable))
			->where($db->qn($this->pivotLocalKey) . ' = ' . $db->q($localKeyValue));
		$db->setQuery($query);
    $db->execute();


		// Write the new relations to the database
    $protoQuery = $db->getQuery(true);

    $query
			->insert($db->qn($this->pivotTable))
      ->columns(array($db->qn($this->pivotLocalKey), $db->qn($this->pivotForeignKey)));

		$i = 0;
    $query = null;

		foreach ($newKeys as $key)
		{
      $i++;

			if (is_null($query))
			{
				$query = clone $protoQuery;
      }

      $query->values($db->q($localKeyValue) . ', ' . $db->q($key));

			if (($i % 50) == 0)
			{
				$db->setQuery($query);
				$db->execute();
				$query = null;
			}
    }


		if (!is_null($query))
		{
			$db->setQuery($query);
			$db->execute();
		}
  }


	/**
	 * Returns the foreign key map of a many-to-many relation, used for eager loading many-to-many relations
	 *
	 * @return array
	 */
	public function &getForeignKeyMap()
	{
		return $this->foreignKeyMap;
  }


	/**
	 * Gets an object instance of the foreign model
	 *
	 * @param  array  $config  Optional configuration information for the Model
	 *
	 * @return DataModel
	 */
	public function &getForeignModel(array $config = array())
	{
		// If the model comes from this component go through our Factory
		if (is_null($this->foreignModelComponent))
		{
			$model = $this->container->factory->model($this->foreignModelName, $config)->tmpInstance();
			return $model;
		}
		// The model comes from another component. Create a container and go through its factory.
		$foreignContainer = Container::getInstance($this->foreignModelComponent, array('tempInstance' => true));
		$model = $foreignContainer->factory->model($this->foreignModelName, $config)->tmpInstance();
		return $model;
  }


	/**
	 * Returns the name of the local key of the relation
	 *
	 * @return  string
	 */
	public function getLocalKey()
	{
		return $this->localKey;
	}
}
