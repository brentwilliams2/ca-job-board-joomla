<?php
/**
 * Persons HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\Persons;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;

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
  }


  /**
   * Overridden. Relations to eager load in the browse view models.
   *
   * @return array	The names of the relations to eager load, e.g. the $name parameter that sets up the relation in constructor.
   */
  protected function getBrowseViewEagerRelations()
  {
    return array(
      'GeoCoordinates',
      'Profiles'
    );
  }
}
