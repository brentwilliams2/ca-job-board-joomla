<?php
/**
 * Admin Server-Side Graph Image Helper
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * https://github.com/HuasoFoundries/jpgraph
 * https://jpgraph.net/
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined('_JEXEC') or die;

use \Amenadiel\JpGraph\Graph as JpGraph;
use \Amenadiel\JpGraph\Plot;
use \FOF30\Container\Container;
use \Joomla\CMS\Language\Text;


/**
 * A helper class for generating graph images
 */
abstract class Graph
{
	/**
	 * The component's container
	 *
	 * @var   Container
	 */
  protected static $container;


	/**
	 * Returns the component's container
	 *
	 * @return  Container
	 */
	protected static function getContainer()
	{
		if ( is_null(self::$container) )
		{
			self::$container = Container::getInstance('com_cajobboard');
    }

		return self::$container;
  }


	/**
	 * Create a graph
	 *
	 * @return
	 */
	protected static function getPieGraph()
	{
   // Create the Pie Graph.
   $graph = new JpGraph\PieGraph(350, 250);

   $graph->title->Set("A Simple Pie Plot");

   $graph->SetBox(true);

   $data = array(40, 21, 17, 14, 23);

   $p1   = new Plot\PiePlot($data);

   $p1->ShowBorder();
   $p1->SetColor('black');
   $p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3'));

   $graph->Add($p1);
   $graph->Stroke();
  }
}
