<?php
/**
 * Job Board Advanced Search Plugin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

use Joomla\Registry\Registry;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\\CMS\Plugin\CMSPlugin;
use \Joomla\CMS\Table\Table;

// no direct access
defined('_JEXEC') or die;

JLoader::register('FinderIndexerAdapter', JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/adapter.php');

/**
 * Smart Search adapter for com_cajobboard.
 */
class PlgFinderCajobboard extends FinderIndexerAdapter
{
	/**
   * The context is somewhat arbitrary but it must be unique or there will be
	 * conflicts when managing plugin/indexer state. A good best practice is to
	 * use the plugin name suffix as the context. For example, if the plugin is
	 * named 'plgFinderContent', the context could be 'Content'.
	 *
	 * @var    string
	 */
  protected $context = 'Cajobboard';


	/**
	 * The extension name.
	 *
	 * @var    string
	 */
  protected $extension = 'com_cajobboard';


	/**
	 * The name of the sublayout that will be used when rendering search results. In core plugins,
   * this is the name of the single item view on the component's front end. By default, the
   * front end logic will search for a default_cajobboard.php template file in the
   * search view of com_finder, and if not present, defaults to the default_result.php file.
   * Add the default_cajobboard.php to the template's html/com_finder/search directory to use custom
	 *
	 * @var    string
	 */
  protected $layout = 'cajobboard';


	/**
	 * The type of content that the adapter indexes.
	 *
	 * @var    string
	 */
  protected $type_title = 'Article';


	/**
	 * The title of the content type being processed by the plugin; this will be used to display the
   * name of the "Type" filtering option when the filters are available. Note that this is tied to a
   * language string as well; see the appropriate language file for details on the structure of the key.
	 *
	 * @var    string
	 */
  protected $table = '#__cajobboard';


	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 */
  protected $autoloadLanguage = true;


	/**
	 * This is fired when the item a category's published state is changed in the admin list view.
   * Triggered at the same time as the onCategoryChangeState event. Used to update index properties
   * of child items of a category. Not needed for components which do not have a category->item structure.
	 *
	 * @param   string   $extension  The extension whose category has been updated.
	 * @param   array    $pks        A list of primary key ids of the content that has changed state.
	 * @param   integer  $value      The value of the state that the content has been changed to.
	 *
	 * @return  void
	 */
	public function onFinderCategoryChangeState($extension, $pks, $value)
	{
		// Make sure we're handling com_cajobboard categories.
		if ($extension === 'com_cajobboard')
		{
			$this->categoryStateChange($pks, $value);
		}
  }


	/**
	 * Method to remove the link information for items that have been deleted,
   * either in the component or in the Smart Search administrator section.
	 *
	 * @param   string  $context  The context of the action being performed.
	 * @param   Table   $table    A Table object containing the record to be deleted
	 *
	 * @return  boolean  True on success.
   *
	 * @throws  \Exception on database error.
	 */
	public function onFinderAfterDelete($context, $table)
	{
		if ($context === 'com_cajobboard.article')
		{
			$id = $table->id;
		}
		elseif ($context === 'com_finder.index')
		{
			$id = $table->link_id;
		}
		else
		{
			return true;
    }

		// Remove item from the index.
		return $this->remove($id);
  }


	/**
	 * Updates the access level information for items when the item's access level is changed or
   * when its parent category's access level is changed. The context check for the single item
   * should include both the backend and frontend single item edit views to work properly.
	 *
	 * @param   string   $context  The context of the content passed to the plugin.
	 * @param   Table   $row      A Table object.
	 * @param   boolean  $isNew    True if the content has just been created.
	 *
	 * @return  boolean  True on success.
   *
   * @throws  \Exception on database error.
	 */
	public function onFinderAfterSave($context, $row, $isNew)
	{
		// We only want to handle articles here.
		if ($context === 'com_cajobboard.article' || $context === 'com_cajobboard.form')
		{
			// Check if the access levels are different.
			if (!$isNew && $this->old_access != $row->access)
			{
				// Process the change.
				$this->itemAccessChange($row);
      }

			// Reindex the item.
			$this->reindex($row->id);
    }

    // Check for access changes in the category.
		if ($context === 'com_categories.category')
		{
			// Check if the access levels are different.
			if (!$isNew && $this->old_cataccess != $row->access)
			{
				$this->categoryAccessChange($row);
			}
    }

		return true;
  }


	/**
	 * Queries for and stores the item or parent category's access level; used in conjunction
   * with onFinderAfterSave to change the index data when the access level is changed
	 *
	 * @param   string   $context  The context of the content passed to the plugin.
	 * @param   Table   $row      A Table object.
	 * @param   boolean  $isNew    If the content is just about to be created.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.5
	 * @throws  \Exception on database error.
	 */
	public function onFinderBeforeSave($context, $row, $isNew)
	{
		// We only want to handle articles here.
		if ($context === 'com_cajobboard.article' || $context === 'com_cajobboard.form')
		{
			// Query the database for the old access level if the item isn't new.
			if (!$isNew)
			{
				$this->checkItemAccess($row);
			}
		}
		// Check for access levels from the category.
		if ($context === 'com_categories.category')
		{
			// Query the database for the old access level if the item isn't new.
			if (!$isNew)
			{
				$this->checkCategoryAccess($row);
			}
		}
		return true;
  }


	/**
	 * Method to update the link information for items that have been changed
	 * from outside the edit screen. This is fired when the item is published,
	 * unpublished, archived, or unarchived from the list view.
	 *
	 * @param   string   $context  The context for the content passed to the plugin.
	 * @param   array    $pks      An array of primary key ids of the content that has changed state.
	 * @param   integer  $value    The value of the state that the content has been changed to.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function onFinderChangeState($context, $pks, $value)
	{
		// We only want to handle articles here.
		if ($context === 'com_cajobboard.article' || $context === 'com_cajobboard.form')
		{
			$this->itemStateChange($pks, $value);
    }

		// Handle when the plugin is disabled.
		if ($context === 'com_plugins.plugin' && $value === 0)
		{
			$this->pluginDisable($pks);
		}
  }


  /**
	 * Method to setup the indexer to be run.
	 *
	 * @return  boolean  True on success.
	 */
	protected function setup()
	{
    // Load dependent classes. @TODO: Set this to cajobboard's route helper
    //JLoader::register('ContactHelperRoute', JPATH_SITE . '/components/com_contact/helpers/route.php');

		// This is a hack to get around the lack of a route helper.
    FinderIndexerHelper::getContentPath('index.php?option=com_cajobboard');

		return true;
	}


	/**
	 * Method to index an item. The item must be a FinderIndexerResult object.
	 *
	 * @param   FinderIndexerResult  $item    The item to index as a FinderIndexerResult object.
	 * @param   string               $format  The item format.  Not used.
	 *
	 * @return  void
	 *
	 * @throws  \Exception on database error.
	 */
	protected function index(FinderIndexerResult $item, $format = 'html')
	{
    $item->setLanguage();

		// Check if the extension is enabled.
		if (ComponentHelper::isEnabled($this->extension) === false)
		{
			return;
    }

    $item->context = 'com_cajobboard.article';

		// Initialise the item parameters.
    $registry = new Registry($item->params);

    $item->params = ComponentHelper::getParams('com_cajobboard', true);

    $item->params->merge($registry);

    $item->metadata = new Registry($item->metadata);

		// Trigger the onContentPrepare event.
    $item->summary = FinderIndexerHelper::prepareContent($item->summary, $item->params, $item);

    $item->body    = FinderIndexerHelper::prepareContent($item->body, $item->params, $item);

		// Build the necessary route and path information.
    $item->url = $this->getUrl($item->id, $this->extension, $this->layout);

    $item->route = ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language);

    $item->path = FinderIndexerHelper::getContentPath($item->route);

		// Get the menu title if it exists.
    $title = $this->getItemMenuTitle($item->url);

		// Adjust the title if necessary.
		if (!empty($title) && $this->params->get('use_menu_title', true))
		{
			$item->title = $title;
    }

		// Add the meta author.
    $item->metaauthor = $item->metadata->get('author');

		// Add the metadata processing instructions.
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metakey');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metadesc');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'metaauthor');
		$item->addInstruction(FinderIndexer::META_CONTEXT, 'author');
    $item->addInstruction(FinderIndexer::META_CONTEXT, 'created_by_alias');

		// Translate the state. Articles should only be published if the category is published.
    $item->state = $this->translateState($item->state, $item->cat_state);

		// Add the type taxonomy data.
    $item->addTaxonomy('Type', 'Article');

		// Add the author taxonomy data.
		if (!empty($item->author) || !empty($item->created_by_alias))
		{
			$item->addTaxonomy('Author', !empty($item->created_by_alias) ? $item->created_by_alias : $item->author);
    }

		// Add the category taxonomy data.
    $item->addTaxonomy('Category', $item->category, $item->cat_state, $item->cat_access);

		// Add the language taxonomy data.
    $item->addTaxonomy('Language', $item->language);

		// Get content extras.
    FinderIndexerHelper::getContentExtras($item);

		// Index the item.
		$this->indexer->index($item);
  }


	/**
	 * Sets a JDatabaseQuery object with a query to pull the data that should be indexed.
	 *
	 * @param   mixed  $query  A \JDatabaseQuery object or null.
	 *
	 * @return  \JDatabaseQuery  A database object.
	 *
	 * @since   2.5
	 */
	protected function getListQuery($query = null)
	{
    $db = JFactory::getDbo();

		// Check if we can use the supplied SQL query.
		$query = $query instanceof \JDatabaseQuery ? $query : $db->getQuery(true)
			->select('a.id, a.title, a.alias, a.introtext AS summary, a.fulltext AS body')
			->select('a.images')
			->select('a.state, a.catid, a.created AS start_date, a.created_by')
			->select('a.created_by_alias, a.modified, a.modified_by, a.attribs AS params')
			->select('a.metakey, a.metadesc, a.metadata, a.language, a.access, a.version, a.ordering')
			->select('a.publish_up AS publish_start_date, a.publish_down AS publish_end_date')
      ->select('c.title AS category, c.published AS cat_state, c.access AS cat_access');

		// Handle the alias CASE WHEN portion of the query
		$case_when_item_alias = ' CASE WHEN ';
		$case_when_item_alias .= $query->charLength('a.alias', '!=', '0');
		$case_when_item_alias .= ' THEN ';
		$a_id = $query->castAsChar('a.id');
		$case_when_item_alias .= $query->concatenate(array($a_id, 'a.alias'), ':');
		$case_when_item_alias .= ' ELSE ';
		$case_when_item_alias .= $a_id . ' END as slug';
		$query->select($case_when_item_alias);
		$case_when_category_alias = ' CASE WHEN ';
		$case_when_category_alias .= $query->charLength('c.alias', '!=', '0');
		$case_when_category_alias .= ' THEN ';
		$c_id = $query->castAsChar('c.id');
		$case_when_category_alias .= $query->concatenate(array($c_id, 'c.alias'), ':');
		$case_when_category_alias .= ' ELSE ';
		$case_when_category_alias .= $c_id . ' END as catslug';
		$query->select($case_when_category_alias)
			->select('u.name AS author')
			->from('#__content AS a')
			->join('LEFT', '#__categories AS c ON c.id = a.catid')
      ->join('LEFT', '#__users AS u ON u.id = a.created_by');

		return $query;
	}
}
