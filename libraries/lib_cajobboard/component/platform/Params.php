<?php
/**
 * Overridden platform site configuration params helper class to quickly
 * get the component parameters, using the Job Board's custom Registry class.
 *
 * @package   Calligraphic Job Board
 * @version   September 11, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * usage:  $container->params->methodName();
 */

namespace Calligraphic\Library\Platform;

defined('_JEXEC') or die;

use \Calligraphic\Library\Platform\Registry;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Categories\Categories;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Factory;

class Params extends \FOF30\Params\Params
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var  \Calligraphic\Library\Platform\Registry
	 */
  protected $componentParams;


	/**
	 * Over-ridden public constructor for the params object
	 *
   * The constructor is extended to avoid a database query because the
	 * \FOF30\Params\Params base class calls reload() from it's constructor.
   * The Joomla! Registry object that is initialized in the framework reload()
   * method is re-used, being merged into the Job Board Registry object and
   * set on the 'params' property of this job board registry instance.
	 *
	 * @param  \FOF30\Container\Container $container  The container we belong to
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}


	/**
	 * Reload the params. Over-ridden to use job board custom Registry class.
	 */
	public function reload()
	{
    $db = $this->container->db;

		$sql = $db->getQuery(true)
				  ->select($db->qn('params'))
				  ->from($db->qn('#__extensions'))
				  ->where($db->qn('type') . " = " . $db->q('component'))
          ->where($db->qn('element') . " = " . $db->q($this->container->componentName));

    $json = $db->setQuery($sql)->loadResult();

		$this->params = new Registry($json);
	}


	/**
	 * Returns the component parameters registry object
	 *
	 * @return  array
	 */
	public function getParamsObject()
	{
		return $this->params;
	}


	/**
	 * Sets the component parameters registry object
	 *
	 * @return  array
	 */
	public function setParamsObject(Registry $paramsObject)
	{
		$this->params = $paramsObject;
	}


	/**
	 * Get a configuration option, cascading from highest to lowest priority:
   *
   *   item -> category -> component -> menu item -> global
	 *
	 * @param   string    $option   The option to fetch a value for
   * @param   mixed     $default  A default option for the configuration option
   * @param   DataModel $model    A DataModel instance if retrieving an item-level configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
	public function getConfigOption($option, $default = null, DataModel $model = null)
	{
    if ( $model instanceof DataModel && $value = $this->getItemConfigOption($option, null, $model) )
    {
      return $value;
    }
    elseif ( $model instanceof DataModel && $value = $this->getCategoryConfigOption($option, null, $model) )
    {
      return $value;
    }
    elseif ( $value = $this->getComponentConfigOption($option, null) )
    {
      return $value;
    }
    elseif ( $value = $this->getMenuConfigOption($option, null) )
    {
      return $value;
    }
    elseif ( $value = $this->getGlobalConfigOption($option, null) )
    {
      return $value;
    }

		return $default;
  }


  /**
	 * Get a global configuration option (set in configuration.php)
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
	public function getGlobalConfigOption($option, $default = null)
	{
    return Factory::getConfig()->get($option, $default = null);
  }


  /**
	 * Get a menu configuration option for the current menu.
   * Returns null if option not set or in a CLI application .
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
  public function getMenuConfigOption($option, $default = null)
  {
    if ( $this->container->platform->isCli() )
    {
      return $default;
    }

    // getActive method returns null if an active menu item is not set
    $currentMenuItem = $this->container->platform->getApplication()->getMenu()->getActive();

    if ($currentMenuItem)
    {
      return $currentMenuItem->params->get($option, $default);
    }
    else
    {
      return $default;
    }
  }


 /**
	 * Get a category configuration option
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
	public function getCategoryConfigOption($option, $default = null, $model)
	{
    $categoryField = $model->getFieldAlias('cat_id');

    if ( !$model->hasField($categoryField) )
    {
      return null;
    }

    $categories = Categories::getInstance('Cajobboard');

    /** @var \Joomla\CMS\Categories\CategoryNode */
    $category = $categories->get($categoryField);

    if (!$category)
    {
      return null;
    }

    /** @var \Joomla\Registry\Registry */
    $categoryParams = $category->getParams();

    $value = $categoryParams->get($option);

    $value = $value ? $value : $default;

    return $value;
  }


  /**
	 * Get a component configuration option, accessible from any component
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
  public function getComponentConfigOption($option, $default = null)
  {
    if ( empty($this->componentParams) )
    {
      $this->componentParams = ComponentHelper::getParams('com_cajobboard');
    }

    return $this->componentParams->get($option, $default);
  }


  /**
	 * Get a global configuration option (set in configuration.php)
	 *
	 * @param   string    $option   The option to fetch a value for
   * @param   mixed     $default  A default option for the configuration option
   * @param   DataModel $model    A DataModel instance for retrieving an item-level configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
  public function getItemConfigOption($option, $default = null, DataModel $model)
  {
    $params = $model->getFieldValue( $model->getFieldAlias('params') );

    // Happy path - 'params' field has already been transformed to a Registry object by the attribute getter
    if ( is_object($params) && ($params instanceof Registry) )
    {
      return $params->get($option, $default);
    }

    $jsonObject = json_decode($params);

    // Handle if the 'params' field hasn't been transformed from JSON yet by attribute getter, e.g. when called as CLI
    if
    (
      is_object($jsonObject) &&
      property_exists($jsonObject, $option) &&
      !empty($jsonObject->$option)
    )
    {
      return $jsonObject->$option;
    }

    // Default value
    return $default;
  }
}