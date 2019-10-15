<?php
/**
 * Persons Site HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Persons;

use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseHtml
{
  /**
   * Overridden. Executes before rendering the page for the Browse task.
   */
  protected function getBrowseViewEagerRelations()
  {
    return array(
      'GeoCoordinates',
      'Profiles'
    );
  }


	/**
	 * Overridden. Filter on user group ('Connectors', 'Job Seekers', 'Employers', or 'Recruiters').
	 */
	protected function getBrowseViewWhereClause()
	{
    /*
      @TODO: Need a way to set user groups into a cache entry early? And set as a discriminator on the model, doing the
      full join-table override thing?
      filter on the discriminator field (user group). Check menuitem usergroup parameter, set a default if not there.
      User groups in table #__usergroups: 'Connectors', 'Employers', 'Job Seekers', 'Recruiters',

      $app = JFactory::getApplication();
      $menu = $app->getMenu();
      $active = $menu->getActive();
      $itemId = $active->id;
      $menuparams = $menu->getParams($itemId);  // NOTE: Params library may have this cached
      $Itemid = $activeMenu->query['Itemid'];

      onBeforeBrowse() overriden to provide a filter on the discriminator (user group) selected

      Table #__user_usergroup_map
      user_id 	int(10) 		UNSIGNED 	No 	0 	Foreign Key to #__users.id
      group_id 	int(10) 		UNSIGNED 	No 	0 	Foreign Key to #__usergroups.id

      $db = $model->getDbo();
      return $db->qn('price') . ' = ' . $db->q(12.34);
    */
  }
}
