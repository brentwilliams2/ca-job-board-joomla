<?php
/**
 * Answers Site Controller
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\Controller\BaseController;

// no direct access
defined('_JEXEC') or die;

class Answer extends BaseController
{
	use \Calligraphic\Cajobboard\Site\Controller\Mixin\Votes;

	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

		$this->setModelName('Answers');

		$this->addPredefinedTaskList(array(
			'downvote_count',
			'upvote_count'
		));
	}
}
