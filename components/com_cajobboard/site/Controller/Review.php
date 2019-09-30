<?php
/**
 * Site Reviews Controller
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\Controller\BaseController;

// no direct access
defined('_JEXEC') or die;

class Review extends BaseController
{
	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'Reviews';

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(

		));

    parent::__construct($container, $config);
  }


  /**
	 * Pull a list of employers for user to choose from in the "Add Review" form.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function onBeforeAdd()
	{
    // @TODO: code for pulling employer list. Should this be here or in view class?
    // @TODO: check if user is a guest. Better place to do this to always catch it for all views?
    /*
    if ($guest)
    {
      // Joomla! requires the URL the user is redirected to after login to be base64 encoded
      $url = 'index.php?option=com_users&view=login&return=' . urlencode(base64_encode('index.php?option=com_cajobboard'));

      $this->setRedirect($url, $msg = null, 'message')->redirect();
    }
    */

		return true;
  }
}
