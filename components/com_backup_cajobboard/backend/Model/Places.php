<?php
/**
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

/*
 * Places model
 *
 * Describes more of less fixed physical places
 *
 * Fields:
 *
 * @property  int			$job_posting_id           	    Surrogate unique key.
 * @property  string	$slug                           Alias for SEF URL.
 *

 */
class Places extends \FOF30\Model\DataModel
{
	/**
	 * Public constructor. Adds behaviours and sets up the behaviours and the relations
	 *
	 * @param   Container  $container
	 * @param   array      $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // override default table names and primary key id
    $this->tableName = "";
    $this->idFieldName = "";

		// Add the filtering behaviour
		$this->addBehaviour('Filters');
		$this->blacklistFilters([
			'publish_up',
			'publish_down',
		    'created_on',
    ]);

		// Set up relations
		$this->hasOne('user', 'Users', 'user_id', 'user_id');

		// Used for forms
		$this->addKnownField('_noemail', 0, 'int');
  }
