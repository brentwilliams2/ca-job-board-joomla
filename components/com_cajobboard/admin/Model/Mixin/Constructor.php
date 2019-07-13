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

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Calligraphic\Library\Platform\RelationManager;
use FOF30\Container\Container;
use \FOF30\Event\Dispatcher;
use \Joomla\CMS\Access\Rules;

// no direct access
defined('_JEXEC') or die;

trait Constructor
{
  /**
	 * @param   Container $container Container instance for this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
  public function constructor($container, $config)
  {
    $this->container = $container;

		// Set the model's name from $config
		if (isset($config['name']))
		{
			$this->name = $config['name'];
    }

		// If $config['name'] is not set, auto-detect the model's name
    $this->name = $this->getName();

    $this->setStateHash($config);

    $this->setModelState($config);

		// Set the internal state marker
		if (!empty($config['use_populate']))
		{
			$this->_state_set = true;
    }

		// Set the internal state marker
		if (!empty($config['ignore_request']))
		{
			$this->_ignoreRequest = true;
		}

    // Should I use a different database object?
    $this->dbo = $container->db;

    // Table name and primary key field name are mandatory configuration options for job board models
    $this->tableName = $config['tableName'];

    $this->idFieldName = $config['idFieldName'];

    $this->setupAutoChecks($config);

    // must be called after primary key field name is set
    $this->knownFields = $this->getTableFields();

    if (isset($config['aliasFields']))
    {
      $this->aliasFields = $config['aliasFields'];
    }

    $this->setConfiguredBehaviours($config);

    $this->setupViewLevelAccessControl();

    $this->setupACL();

    if (isset($config['contentType']))
    {
      $this->contentType = $config['contentType'];
    }

    $this->setConfiguredGuardedFields($config);

    $this->setConfiguredFillableFields($config);

    $this->autoFillFields();

    // logic to handle setting model relations in configuration removed, use magic methods
    $this->relationManager = new RelationManager($this);

    $this->initRecordData();

    $this->triggerEvent('onAfterConstruct');
  }


  /**
   * Configure the state hash
   *
   * @return void
   */
  private function setStateHash($config)
  {
		if (isset($config['hash']) && !empty($config['hash']))
		{
			$this->setHash($config['hash']);
		}
		elseif (isset($config['hash_view']) && !empty($config['hash_view']))
		{
      // sets stateHash property as well as functioning as a getter
			$this->getHash($config['hash_view']);
    }
  }


  /**
   * Set the model state from configuration
   *
   * @return void
   */
  private function setModelState($config)
  {
 		// Set the model state
     if (array_key_exists('state', $config))
     {
       if (is_object($config['state']))
       {
         $this->state = $config['state'];
       }
       elseif (is_array($config['state']))
       {
         $this->state = (object) $config['state'];
       }
       // Protect from malformed state
       else
       {
         $this->state = new \stdClass();
       }
     }
     else
     {
       $this->state = new \stdClass();
     }
  }


  /**
   * Check if automatic data validation is enabled, and set fields to skip checking for from configuration
   *
   * @param   array     $config    Configuration values for this model
   *
   * @return void
   */
  private function setupAutoChecks($config)
  {
    // set auto check enabled status
    if (isset($config['autoChecks']))
    {
      if (!is_bool($config['autoChecks']))
      {
        $config['autoChecks'] = strtolower($config['autoChecks']);

        $config['autoChecks'] = in_array($config['autoChecks'], array('yes', 'true', 'on', 1));
      }

      $this->autoChecks = $config['autoChecks'];
    }

    // set auto check skipped fields
    if (isset($config['fieldsSkipChecks']))
    {
      if (!is_array($config['fieldsSkipChecks']))
      {
        $config['fieldsSkipChecks'] = explode(',', $config['fieldsSkipChecks']);

        $config['fieldsSkipChecks'] = array_map(function ($x) { return trim($x); }, $config['fieldsSkipChecks']);
      }
      $this->fieldsSkipChecks = $config['fieldsSkipChecks'];
    }
  }


  /**
   * Initialize the behaviour dispatcher and add default behaviours from configuration
   *
   * @param   array     $config    Configuration values for this model
   *
   * @return void
   */
  private function setConfiguredBehaviours($config)
  {
    $this->behavioursDispatcher = new Dispatcher($this->container);

    // Add any behaviors passed as a configuration option
    if ( isset($config['behaviours']) && is_array($config['behaviours']) )
    {
      foreach ($config['behaviours'] as $behaviour)
      {
        $this->addBehaviour($behaviour);
      }
    }

    // Add extra behaviours
    foreach (array('Created', 'Modified', 'Filters') as $behaviour)
    {
      $this->addBehaviour($behaviour);
    }
  }


  /**
   * Set fields that are blacklisted for auto-fill from configuration. If used, disables
   * whitelisting fields for auto-fill with 'fillable_fields' configuration option.
   * Enables filling fields from the model state and by extent, the request.
   *
   * @param   array     $config    Configuration values for this model
   *
   * @return void
   */
  private function setConfiguredGuardedFields($config)
  {
    if (!isset($config['guarded_fields']) || ( isset($config['guarded_fields']) && empty($config['guarded_fields']) ))
    {
      return;
    }

    if (!is_array($config['guarded_fields']))
    {
      $config['guarded_fields'] = explode(',', $config['guarded_fields']);

      $config['guarded_fields'] = array_map( function ($x) { return trim($x); }, $config['guarded_fields'] );
    }

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


  /**
   * Set fields that are whitelisted for auto-fill from configuration. If the
   * 'guarded_fields' configuration option is used, this option is disabled.
   * Enables filling fields from the model state and by extent, the request.
   *
   * @param   array     $config    Configuration values for this model
   *
   * @return void
   */
  private function setConfiguredFillableFields($config)
  {
    // Fields that should be auto-filled from the model state and by extent, the request
    if ($this->guarded || !isset($config['fillable_fields']) || ( isset($config['fillable_fields']) && empty($config['fillable_fields']) ))
    {
      return;
    }

    if (!is_array($config['fillable_fields']))
    {
      $config['fillable_fields'] = explode(',', $config['fillable_fields']);
      $config['fillable_fields'] = array_map(function ($x) { return trim($x); }, $config['fillable_fields']);
    }

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


  /**
   * Automatically fill fields that are either whitelisted, or not blacklisted
   *
   * @return void
   */
  private function autoFillFields()
  {
    if ($this->autoFill)
    {
      // Guarded fields are used as a blacklist if present
      if (!empty($this->guarded))
      {
        $fields = array_keys($this->knownFields);
      }
      // If no guarded fields are present, use fillable fields configuration option as a whitelist
      else
      {
        $fields = $this->fillable;
      }

      foreach ($fields as $field)
      {
        // Do not set guarded fields
        if (in_array($field, $this->guarded))
        {
          continue;
        }

        $stateValue = $this->getState($field, null);

        // Set non-guarded fields from the state
        if (!is_null($stateValue))
        {
          $this->setFieldValue($field, $stateValue);
        }
      }
    }
  }

  /**
   * Enable view level access control if supported by the database table
   *
   * @return void
   */
  private function setupViewLevelAccessControl()
  {
    // @TODO: check if view levels are handled correctly, this code was commented out
    return;

    $access_field	= $this->getFieldAlias('access');

    if ($this->_trackAssets && array_key_exists($access_field, $this->knownFields) && !($this->getState($access_field, null)))
    {
      $this->$access_field = (int) $this->container->platform->getConfig()->get('access');
    }
  }


  /**
   * Enable per-item access control if supported by the database table and if so set the default asset key
   *
   * @return void
   */
  private function setupACL()
  {
    $asset_id_field	= $this->getFieldAlias('asset_id');

    if (array_key_exists($asset_id_field, $this->knownFields))
    {
      $this->_trackAssets = true;
    }

    // e.g. com_cajobboard.answer
    $assetKey = $this->container->componentName . '.' . strtolower( $this->container->inflector->singularize( $this->getName() ));

    $this->setAssetKey($assetKey);
  }


  /**
   * Initialise the instance data model fields from the known fields. Known fields are either
   * initialized from the database or set in the model. The key is the field name (e.g. 'enabled'),
   * and the value is a \stdClass object with (at least) the properties 'Field' (duplicate of
   * database table field name), 'Type' (e.g. 'char(7)'), and 'Default' (e.g. NULL or '0').
   *
   * @return  void
   */
  private function initRecordData()
  {
    foreach ($this->knownFields as $fieldName => $metadata)
    {
      // Initialize only the null or not yet set records
      if(!isset($this->recordData[$fieldName]))
      {
        $this->recordData[$fieldName] = $metadata->Default;
      }
    }
  }
}
