<?php
/**
 * Job Board adapter plugin for OSMap XML Sitemaps
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;


use \Alledia\OSMap\Plugin\Base;
use \Alledia\OSMap\Sitemap\Collector;
use \Alledia\OSMap\Sitemap\Item;
use \Joomla\Registry\Registry;

class PlgOsmapCajobboardSitemaps extends Base
{
    public function getComponentElement()
    {
        return 'com_cajobboard';
    }

    /**
     * Generate any non-menu items that belong under the menuitem represented by $parent.
     *
     * @param Collector $collector
     * @param Item      $parent
     * @param Registry  $params
     *
     * @return void
     */
    public function getTree(Collector $collector, Item $parent, Registry $params)
    {
        // creating a single new node under the current $parent:
        $collector->changeLevel(1); // Advance 1 display level under the current item

        $node = (object)array(
            'id'         => $parent->id, // Usually the parent id
            'name'       => 'This Node Title', // The title of the item being displayed
            'uid'        => $parent->uid . '_' . 'UniqueNodeId', // A unique ID. Duplicates are determined from this
            'modified'   => '2018-02-28 12:00:00', // Optional, last modified date (needed for news sitemaps)
            'browserNav' => $parent->browserNav, // Optional, for the target attribute of the generated link
            'priority'   => .5, // Optional, inherits from parent if not provided
            'changefreq' => 'weekly', // Optional, inherits from parent if not provided
            'link'       => 'index.php?option=com_cajobboard' // The full raw link to the item.
        );

        $collector->printNode($node);

        $collector->changeLevel(-1); // Return to the previous display level
    }
}
