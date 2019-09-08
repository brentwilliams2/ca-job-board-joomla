<?php
/**
 * Persons Admin HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\View\Persons;

use \FOF30\Container\Container;

use \Calligraphic\Cajobboard\Admin\View\Common\BaseHtml;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseHtml
{
	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->loadLanguageFileForView('persons');
  }


	/**
	 * Overridden. Executes before rendering the page for the Browse task.
   * Modified to eager load Author relation to Persons model and push the
   * model to the view templates.
	 */
	protected function onBeforeBrowse()
	{
 		/** @var DataModel $model */
    $model = $this->getModel();

		// Persist the state in the session
    $model->savestate(1);

    // Set the current pagination parameters from the state on the model and view
    $this->setPaginationParams($model);

    // Assign items to the view
    // @TODO: Need a way to set user groups into a cache entry early? And set as a discriminator on the model, doing the
    //        full join-table override thing?
    //        filter on the discriminator field (user group). Check menuitem usergroup parameter, set a default if not there.
    //        User groups in table #__usergroups: 'Connectors', 'Employers', 'Job Seekers', 'Recruiters',
    /*
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $active = $menu->getActive();
    $itemId = $active->id;
    $menuparams         = $menu->getParams($itemId);
    $Itemid         = $activeMenu->query['Itemid'];

    onBeforeBrowse() overriden to provide a filter on the discriminator (user group) selected

    Table #__user_usergroup_map
    user_id 	int(10) 		UNSIGNED 	No 	0 	Foreign Key to #__users.id
    group_id 	int(10) 		UNSIGNED 	No 	0 	Foreign Key to #__usergroups.id
    */

    $this->items = $model->get();

    $this->itemCount = $model->count();

    // Create the view's pagination object with results from the model
    $this->pagination = new Pagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);
  }
}
