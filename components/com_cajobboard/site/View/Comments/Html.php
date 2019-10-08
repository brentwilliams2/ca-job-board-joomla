<?php
/**
 * Comments Site HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Comments;

use \FOF30\Container\Container;
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
			'Author',
			'Image'
		);
	}


	/**
	 * Add a 'where' clause to the browse view item query to
	 * exclude the root node in queries for a nested class.
	 *
	 * @return string		The 'where' clause string to use
	 */
	protected function getBrowseViewWhereClause()
	{
		// @TODO: Move this to a filter so it's reusable

		$model = $this->getModel();

		$db = $model->getDbo();

    return $db->quoteName( $model->getIdFieldName() ) . ' > 1';
  }
}
