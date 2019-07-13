<?php
/**
 * Admin Email Messages Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 *
 * Usage for sending emails:
 *
 * $this->container->platform->runPlugins('onAKSubscriptionChange', array($this, $info));
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller;

// no direct access
defined('_JEXEC') or die;

use Akeeba\Subscriptions\Admin\Helper\Email;
use Akeeba\Subscriptions\Admin\Model\EmailTemplates;
use Akeeba\Subscriptions\Admin\Model\Subscriptions;
use FOF30\Controller\DataController;
use FOF30\Model\DataModel;
use \FOF30\Container\Container;
use \Joomla\CMS\Language\Text;

class EmailTemplate extends DataController
{
  // Added to toolbar in admin, sends test email
	public function testTemplate()
	{
		$id = $this->input->getInt('akeebasubs_emailtemplate_id', 0);

    // Redirect if no ID
		if (!$id)
		{
			$this->setRedirect('index.php?option=com_akeebasubs&view=EmailTemplates', Text::_('COM_AKEEBASUBS_EMAILTEMPLATES_CHOOSE_TEMPLATE'), 'notice');
			$this->redirect();
		}

    $url = 'index.php?option=com_akeebasubs&view=EmailTemplates&task=edit&id=' . $id;

    /** @var EmailTemplates $template */
		$template = $this->getModel()->getClone()->savestate(false)->setIgnoreRequest(true);

    $template->findOrFail($id);

    // grab the first published level
		/** @var DataModel $levelsModel */
    $levelsModel = $this->container->factory->model('Levels')->tmpInstance();

    $level = $levelsModel->enabled(1)->firstOrFail();

		// Redirect if no level is set
		if (!$level)
		{
			$this->setRedirect($url, Text::_('COM_AKEEBASUBS_EMAILTEMPLATES_NOENABLEDLEVELS'), 'notice');
			$this->redirect();
    }

		// get a dummy subscription
		/** @var Subscriptions $sub */
    $sub = $this->container->factory->model('Subscriptions')->tmpInstance();

		$sub->akeebasubs_subscription_id = 999999;
		$sub->user_id                    = $this->container->platform->getUser()->id;
		$sub->akeebasubs_level_id        = $level;
		$sub->publish_up                 = date('Y-m-d H:i:s');
		$sub->publish_down               = date('Y-m-d H:i:s', strtotime('+1 month'));
		$sub->notes                      = 'This is just a dummy subscription for email testing';
		$sub->enabled                    = 1;
		$sub->processor                  = 'Dummy processor';
		$sub->processor_key              = 'Dummy processor key';
		$sub->setFieldValue('state', 'C'); // Can't use ->state because of a naming collision
		$sub->net_amount                 = 1234.56;
		$sub->tax_amount                 = 123.456;
		$sub->gross_amount               = 1358.016;
		$sub->tax_percent                = 10;
    $sub->created_on                 = date('Y-m-d H:i:s');

    $mailer = Email::getPreloadedMailer($sub, 'plg_akeebasubs_' . $template->key);

    $mailer->addRecipient($this->container->platform->getUser()->email);

		if ($mailer->Send())
		{
			$this->setRedirect($url, Text::_('COM_AKEEBASUBS_EMAILTEMPLATES_TEST_SENT'));
		}
		else
		{
			$this->setRedirect($url, Text::_('COM_AKEEBASUBS_EMAILTEMPLATES_TEST_ERROR'), 'notice');
		}
	}
}
