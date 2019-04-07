<?php
/**
 * Site Diversity Policies Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;

/**
 * Fields:
 *
 * @property  string	$title
 * @property  string	$introtext
 * @property  string	$fulltext
 * @property  string	$created_by_alias  An alias to display instead of the name of the user who created the article
 * @property  string	$images  e.g. {"image_intro":"","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}
 * @property  string	$urls  e.g. {"urla":null,"urlatext":"","targeta":"","urlb":null,"urlbtext":"","targetb":"","urlc":null,"urlctext":"","targetc":""}
 * @property  string	$attribs  e.g. {"show_title":"","link_titles":"","show_intro":"","info_block_position":"0","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}
 */
class DiversityPolicies extends \Calligraphic\Cajobboard\Admin\Model\DiversityPolicies
{
  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
