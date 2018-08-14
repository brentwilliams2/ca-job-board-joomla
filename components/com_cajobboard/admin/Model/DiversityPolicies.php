<?php
/**
 * Admin Organization Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;

/**
 * Model class for Job Board Diversity Policies
 *
 * @property  array		$
 * @property  string	$
 * @property  int		  $
 *
 */
class DiversityPolicies extends DataModel
{
  /*
   * Overridden constructor
   */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

		// Load the Filters behaviour
    $this->addBehaviour('Filters');
  }

	/**
	 *
	 *
	 * @param   array|\stdClass  $data  Source data
	 *
	 * @return  bool
	 */
	function onBeforeSave(&$data)
	{

  }

	/**
	 * Build the SELECT query for returning records.
	 *
	 * @param   \JDatabaseQuery  $query           The query being built
	 * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
	{
    $db = $this->getDbo();

    // search functionality was in here, as well as in FrameworkUsers
  }
}



JLoader::register('ContentHelperRoute', JPATH_BASE . '/components/com_content/helpers/route.php');

$attribs          = array();
$attribs['class'] = 'modal';
$attribs['rel']   = '{handler: \'iframe\', size: {x:800, y:500}}';

$db    = JFactory::getDbo();

$query = $db->getQuery(true);

$query
  ->select('id, alias, catid, language')
  ->from('#__content')
  ->where('id = ' . $tosArticle);

$db->setQuery($query);

$article = $db->loadObject();

if (JLanguageAssociations::isEnabled())
{
  $tosAssociated = JLanguageAssociations::getAssociations('com_content', '#__content', 'com_content.item', $tosArticle);
}

$currentLang = JFactory::getLanguage()->getTag();

if (isset($tosAssociated) && $currentLang !== $article->language && array_key_exists($currentLang, $tosAssociated))
{
  $url = ContentHelperRoute::getArticleRoute(
    $tosAssociated[$currentLang]->id,
    $tosAssociated[$currentLang]->catid,
    $tosAssociated[$currentLang]->language
  );

  $link = JHtml::_('link', JRoute::_($url . '&tmpl=component'), $text, $attribs);
}
else
{
  $slug = $article->alias ? ($article->id . ':' . $article->alias) : $article->id;
  $url  = ContentHelperRoute::getArticleRoute($slug, $article->catid, $article->language);
  $link = JHtml::_('link', JRoute::_($url . '&tmpl=component'), $text, $attribs);
}
