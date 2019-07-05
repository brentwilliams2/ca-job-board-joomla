<?php
/**
 * Overridden data-aware model constructor to use Job Board RelationManager (adds STI relation)
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c) 2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

trait Constructor
{
  /**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
  public function constructor($container, $config)
  {
    // First call the parent constructor.
    parent::__construct($container, $config);

    // Should I use a different database object?
    $this->dbo = $container->db;

    // Do I have a table name?
    if (isset($config['tableName']))
    {
      $this->tableName = $config['tableName'];
    }
    elseif (empty($this->tableName))
    {
      // The table name is by default: #__appName_viewNamePlural (Ruby on Rails convention)
      $viewPlural = $container->inflector->pluralize($this->getName());
      $this->tableName = '#__' . strtolower($this->container->bareComponentName) . '_' . strtolower($viewPlural);
    }

    // Do I have a table key name?
    if (isset($config['idFieldName']))
    {
      $this->idFieldName = $config['idFieldName'];
    }
    elseif (empty($this->idFieldName))
    {
      // The default ID field is: appName_viewNameSingular_id (Ruby on Rails convention)
      $viewSingular = $container->inflector->singularize($this->getName());
      $this->idFieldName = strtolower($this->container->bareComponentName) . '_' . strtolower($viewSingular) . '_id';
    }

    // Do I have a list of known fields?
    if (isset($config['knownFields']) && !empty($config['knownFields']))
    {
      if (!is_array($config['knownFields']))
      {
        $config['knownFields'] = explode(',', $config['knownFields']);
      }
      $this->knownFields = $config['knownFields'];
    }
    else
    {
      // By default the known fields are fetched from the table itself (slow!)
      $this->knownFields = $this->getTableFields();
    }

    if (empty($this->knownFields))
    {
      throw new NoTableColumns(sprintf('Model %s could not fetch column list for the table %s', $this->getName(), $this->tableName));
    }

    // Should I turn on autoChecks?
    if (isset($config['autoChecks']))
    {
      if (!is_bool($config['autoChecks']))
      {
        $config['autoChecks'] = strtolower($config['autoChecks']);
        $config['autoChecks'] = in_array($config['autoChecks'], array('yes', 'true', 'on', 1));
      }
      $this->autoChecks = $config['autoChecks'];
    }

    // Should I exempt fields from autoChecks?
    if (isset($config['fieldsSkipChecks']))
    {
      if (!is_array($config['fieldsSkipChecks']))
      {
        $config['fieldsSkipChecks'] = explode(',', $config['fieldsSkipChecks']);
        $config['fieldsSkipChecks'] = array_map(function ($x) { return trim($x); }, $config['fieldsSkipChecks']);
      }
      $this->fieldsSkipChecks = $config['fieldsSkipChecks'];
    }

    // Do I have alias fields?
    if (isset($config['aliasFields']))
    {
      $this->aliasFields = $config['aliasFields'];
    }

    // Do I have a behaviours dispatcher?
    if (isset($config['behavioursDispatcher']) && ($config['behavioursDispatcher'] instanceof Dispatcher))
    {
      $this->behavioursDispatcher = $config['behavioursDispatcher'];
    }
    // Otherwise create the model behaviours dispatcher
    else
    {
      $this->behavioursDispatcher = new Dispatcher($this->container);
    }

    // Do I have an array of behaviour observers
    if (isset($config['behaviourObservers']) && is_array($config['behaviourObservers']))
    {
      foreach ($config['behaviourObservers'] as $observer)
      {
        $this->behavioursDispatcher->attach($observer);
      }
    }

    // Do I have a list of behaviours?
    if (isset($config['behaviours']) && is_array($config['behaviours']))
    {
      foreach ($config['behaviours'] as $behaviour)
      {
        $this->addBehaviour($behaviour);
      }
    }

    // Add extra behaviours
    foreach (array('Created', 'Modified') as $behaviour)
    {
      $this->addBehaviour($behaviour);
    }

    // Do I have a list of fillable fields?
    if (isset($config['fillable_fields']) && !empty($config['fillable_fields']))
    {
      if (!is_array($config['fillable_fields']))
      {
        $config['fillable_fields'] = explode(',', $config['fillable_fields']);
        $config['fillable_fields'] = array_map(function ($x) { return trim($x); }, $config['fillable_fields']);
      }
      $this->fillable = array();
      $this->autoFill = true;
      foreach ($config['fillable_fields'] as $field)
      {
        if (array_key_exists($field, $this->knownFields))
        {
          $this->fillable[] = $field;
        }
        elseif (isset($this->aliasFields[$field]))
        {
          $this->fillable[] = $this->aliasFields[$field];
        }
      }
    }

    // Do I have a list of guarded fields?
    if (isset($config['guarded_fields']) && !empty($config['guarded_fields']))
    {
      if (!is_array($config['guarded_fields']))
      {
        $config['guarded_fields'] = explode(',', $config['guarded_fields']);
        $config['guarded_fields'] = array_map(function ($x) { return trim($x); }, $config['guarded_fields']);
      }
      $this->guarded = array();
      $this->autoFill = true;
      foreach ($config['guarded_fields'] as $field)
      {
        if (array_key_exists($field, $this->knownFields))
        {
          $this->guarded[] = $field;
        }
        elseif (isset($this->aliasFields[$field]))
        {
          $this->guarded[] = $this->aliasFields[$field];
        }
      }
    }

    // If we are tracking assets, make sure an access field exists and initially set the default.
    $asset_id_field	= $this->getFieldAlias('asset_id');
    $access_field	= $this->getFieldAlias('access');

    if (array_key_exists($asset_id_field, $this->knownFields))
    {
      \JLoader::import('joomla.access.rules');
      $this->_trackAssets = true;
    }

    /**
    if ($this->_trackAssets && array_key_exists($access_field, $this->knownFields) && !($this->getState($access_field, null)))
    {
      $this->$access_field = (int) $this->container->platform->getConfig()->get('access');
    }
    **/

    $assetKey = $this->container->componentName . '.' . strtolower($container->inflector->singularize($this->getName()));

    $this->setAssetKey($assetKey);

    // Set the UCM content type if applicable
    if (isset($config['contentType']))
    {
      $this->contentType = $config['contentType'];
    }

    // Do I have to auto-fill the fields?
    if ($this->autoFill)
    {
      // If I have guarded fields, I'll try to fill everything, using such fields as a "blacklist"
      if (!empty($this->guarded))
      {
        $fields = array_keys($this->knownFields);
      }
      else
      {
        // Otherwise I'll fill only the fillable ones (act like having a "whitelist")
        $fields = $this->fillable;
      }

      foreach ($fields as $field)
      {
        if (in_array($field, $this->guarded))
        {
          // Do not set guarded fields
          continue;
        }

        $stateValue = $this->getState($field, null);

        if (!is_null($stateValue))
        {
          $this->setFieldValue($field, $stateValue);
        }
      }
    }

    // Create a relation manager
    $this->relationManager = new RelationManager($this);

    // Do I have a list of relations?
    if (isset($config['relations']) && is_array($config['relations']))
    {
      foreach ($config['relations'] as $relConfig)
      {
        if (!is_array($relConfig))
        {
          continue;
        }

        $defaultRelConfig = array(
          'type'              => 'hasOne',
          'foreignModelClass' => null,
          'localKey'          => null,
          'foreignKey'        => null,
          'pivotTable'        => null,
          'pivotLocalKey'     => null,
          'pivotForeignKey'   => null,
        );

        $relConfig = array_merge($defaultRelConfig, $relConfig);

        $this->relationManager->addRelation($relConfig['itemName'], $relConfig['type'], $relConfig['foreignModelClass'],
          $relConfig['localKey'], $relConfig['foreignKey'], $relConfig['pivotTable'],
          $relConfig['pivotLocalKey'], $relConfig['pivotForeignKey']);
      }
    }

    // Initialise the data model
    foreach ($this->knownFields as $fieldName => $information)
    {
      // Initialize only the null or not yet set records
      if(!isset($this->recordData[$fieldName]))
      {
        $this->recordData[$fieldName] = $information->Default;
      }
    }

    // Trigger the onAfterConstruct event. This allows you to set up model state etc.
    $this->triggerEvent('onAfterConstruct');
  }
}
