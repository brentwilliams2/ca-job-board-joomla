<?php
/**
 * Admin Email Messages Helper class for sending out emails
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// @TODO: implement outgoing email helper

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Model\EmailMessages;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Filesystem\File;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Mail\Mail;
use \Joomla\CMS\Plugin\PluginHelper;
use \Joomla\CMS\User\User;
use \Joomla\Registry\Registry;

/*
  E-mails should use tables and in-line CSS. Outlook has problems with <ol> tags.

  Three ways to include images in an email:

  1. In-line, use base-64 encoding: <img src="data:image/jpg;base64,{{base64-data-string here}}" />

      * Blocked in Outlook, and (often if more than one image) in webmail clients, OK with Apple Mail

  2. Hosted on remote server, and pulled in. May need to use a CDN depending on size of mailing list: <img src="http://example.com/image_file.jpg" />

      * Blocked in both desktop and webmail clients.

  3. Embedded as an attachment, and referenced using Content-ID: <img src="cid:image_file.jpg" />  Find examples for content type (3 boundaries needed: multipart/mixed, multipart/related, and multipart/alternative)

      * Works in Outlook, Gmail, blocked in Apple Mail (shows as a "download attachment" link).
      * Many spam filters will increase the spam rating for your message and possibly place it in the junk folder.

  4.  Using CSS background images: <div id="myImage"></div> with a css rule #myImage { background-image:  url('data:image/png;base64,iVBOR...[some more encoding]...rkggg=='); width: [the-actual-image-width]; height: [the-actual-image-height]; }

      * Not supported in Outlook
  */


  /*
    Add headers to enable detecting who the recipient was for bounced emails:

    // Need a way to discover emails that were rejected by the recipient MTA (and thus didn't create a bounce message)

    // Set headers to send to a bounce email address:

    $headers .= "Reply-To: bounce@example.com\r\n";
    $headers .= "Return-Path: bounce@example.com\r\n";
    $headers .= "X-Mailer: PHP\r\n";

    // Custom headers to identify who it was sent to:
    $headers .= "X-user-id: XXXXX\r\n";
    $headers .= "X-campaign-id: YYYYYY\r\n";
    $headers .= "X-recipient-id: SSSSSSSSS\r\n";

  */

class EmailOutgoing
{
	/**
	 * The component's container
	 *
	 * @var   Container
	 */
  protected $container;


	/**
	 * Returns the component's container
	 *
	 * @return  Container
	 */
	protected function getContainer()
	{
		if ( is_null(self::$container) )
		{
			self::$container = Container::getInstance('com_cajobboard');
    }

		return self::$container;
  }


	/**
	 * Creates a PHPMailer instance
	 *
	 * @param   boolean $isHTML
	 *
	 * @return  \JMail  A mailer instance
	 */
	private function &getMailer($isHTML = true)
	{
    $mailer = clone Factory::getMailer();

    $mailer->IsHTML($isHTML);

		// Required in order not to get broken characters
    $mailer->CharSet = 'UTF-8';

		return $mailer;
  }


	/**
	 * Gets the email keys currently known to the component
	 *
	 * @param   int  $style  0 = raw sections list, 1 = grouped list options, 2 = key/description array
	 *
	 * @return  array|string
	 */
	public function getEmailKeys($style = 0)
	{
    $rawOptions = null;

    $htmlOptions = null;

    $shortlist = null;

		if (is_null($rawOptions))
		{
      $rawOptions = array();

      PluginHelper::importPlugin('calligraphic');

      $app = Factory::getApplication();

      // 'section' => 'plugin-name',
			// 'title'   => 'Subscriber',
      // 'keys' => array( 'paid' => Text::_('PLG_AKEEBASUBS_SUBSCRIPTIONEMAILS_EMAIL_PAID') )
      $jResponse = $app->triggerEvent('onAKGetEmailKeys', array());

			if (is_array($jResponse) && !empty($jResponse))
			{
				foreach ($jResponse as $pResponse)
				{
					if (!is_array($pResponse))
					{
						continue;
          }

					if (empty($pResponse))
					{
						continue;
          }

          // $rawOptions['plugin-name'] = array( 'paid' => Text::_('PLG_AKEEBASUBS_SUBSCRIPTIONEMAILS_EMAIL_PAID') );
					$rawOptions[ $pResponse['section'] ] = $pResponse;
				}
			}
    }

    // raw sections list
		if ($style == 0)
		{
			return $rawOptions;
    }

		if (is_null($htmlOptions))
		{
      $htmlOptions = array();

			foreach ($rawOptions as $section)
			{
        $htmlOptions[] = HTMLHelper::_('select.option', '<OPTGROUP>', $section['title']);

				foreach ($section['keys'] as $key => $description)
				{
          $htmlOptions[] = HTMLHelper::_('select.option', $section['section'] . '_' . $key, $description);

					$shortlist[ $section['section'] . '_' . $key ] = $section['title'] . ' - ' . $description;
        }

				$htmlOptions[] = HTMLHelper::_('select.option', '</OPTGROUP>');
			}
    }

    // grouped list options
		if ($style == 1)
		{
			return $htmlOptions;
    }

		return $shortlist;
  }


	/**
	 * Load language overrides for a specific extension. Used to load the
	 * custom languages for each plugin, if necessary.
	 *
	 * @param   string  $extension  The extension to load translations for
	 * @param   User   $user       The user whose preferred language we'll also be loading
	 */
	private function loadLanguageOverrides($extension, $user = null)
	{
		if (!($user instanceof User))
		{
			$user = self::getContainer()->platform->getUser();
    }

		// Load the language files and their overrides
    $jlang = Factory::getLanguage();

		// -- English (default fallback)
		$jlang->load($extension, JPATH_ADMINISTRATOR, 'en-GB', true);
    $jlang->load($extension . '.override', JPATH_ADMINISTRATOR, 'en-GB', true);

		// -- Default site language
		$jlang->load($extension, JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
    $jlang->load($extension . '.override', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);

		// -- Current site language
		$jlang->load($extension, JPATH_ADMINISTRATOR, null, true);
    $jlang->load($extension . '.override', JPATH_ADMINISTRATOR, null, true);

		// -- User's preferred language
    $uparams  = is_object($user->params) ? $user->params : new Registry($user->params);

    $userlang = $uparams->get('language', '');

		if (!empty($userlang))
		{
      $jlang->load($extension, JPATH_ADMINISTRATOR, $userlang, true);

			$jlang->load($extension . '.override', JPATH_ADMINISTRATOR, $userlang, true);
		}
  }


	/**
	 * Loads an email template from the database or, if it doesn't exist, from
	 * the language file.
	 *
	 * @param   string   $key    The language key, in the form PLG_LOCATION_PLUGINNAME_TYPE
	 * @param   integer  $level  The subscription level we're interested in
	 * @param   User    $user   The user whose preferred language will be loaded
	 *
	 * @return  array  isHTML: If it's HTML override from the db; text: The unprocessed translation string
	 */
	private function loadEmailTemplate($key, $level = null, $user = null)
	{
    $loadedLanguagesForExtensions = array();

		if (is_null($user))
		{
			$user = self::getContainer()->platform->getUser();
    }

		// Parse the key
		$key      = strtolower($key);
		$keyParts = explode('_', $key, 4);
		$extension = $keyParts[0] . '_' . $keyParts[1] . '_' . $keyParts[2];
    $keyInDatabase     = $keyParts[2] . '_' . $keyParts[3];

		// Initialise
		$templateText = '';
		$subject      = '';
		$loadLanguage = null;
    $isHTML       = false;

		// Look for desired languages
    $jLang     = Factory::getLanguage();

    $userLang  = $user->getParam('language', '');

		$languages = array(
			$userLang,
			$jLang->getTag(),
			$jLang->getDefault(),
			'en-GB',
			'*'
    );

		// Look for an override in the database
		/** @var EmailTemplates $templatesModel */
    $templatesModel = Container::getInstance('com_akeebasubs')->factory->model('EmailTemplates')->tmpInstance();

    $allTemplates = $templatesModel->key($keyInDatabase)->enabled(1)->get(true);

		if (!empty($allTemplates))
		{
			// Pass 1 - Give match scores to each template
			$preferredIndex = null;
      $preferredScore = 0;

			/** @var EmailTemplates $template */
			foreach ($allTemplates as $template)
			{
				// Get the language and level of this template
				$myLang  = $template->language;
        $myLevel = $template->subscription_level_id;

				// Make sure the language matches one of our desired languages, otherwise skip it
        $langPos = array_search($myLang, $languages);

				if ($langPos === false)
				{
					continue;
        }

        $langScore = (5 - $langPos);

				// Make sure the level matches the desired or "*", otherwise skip it
        $levelScore = 5;

				if (!is_null($level))
				{
					if ($myLevel == $level)
					{
						$levelScore = 10;
					}
					elseif ($myLevel != 0)
					{
						$levelScore = 0;
					}
				}
				elseif ($myLevel != 0)
				{
					$levelScore = 0;
        }

				if ($levelScore == 0)
				{
					continue;
        }

				// Calculate the score. If it's winning, use it
        $score = $langScore + $levelScore;

				if ($score > $preferredScore)
				{
					$loadLanguage   = $myLang;
					$subject        = $template->subject;
					$templateText   = $template->body;
					$preferredScore = $score;
					$isHTML = true;
				}
			}
    }

		// If no match is found in the database (or if this is the Core release)
		// we fall back to the legacy method of using plain text emails and
		// translation strings.
		if (!$isHTML)
		{
      $isHTML = false;

			if (!array_key_exists($extension, $loadedLanguagesForExtensions))
			{
				self::loadLanguageOverrides($extension, $user);
      }

			$subjectKey = $extension . '_HEAD_' . $keyParts[3];
      $subject    = Text::_($subjectKey);

			if ($subject == $subjectKey)
			{
				$subjectKey = $extension . '_SUBJECT_' . $keyParts[3];
				$subject    = Text::_($subjectKey);
      }

      $templateTextKey = $extension . '_BODY_' . $keyParts[3];

      $templateText    = Text::_($templateTextKey);

			$loadLanguage = '';
    }

		if ($isHTML)
		{
			// Because SpamAssassin demands there is a body and surrounding html tag even though it's not necessary.
			if (strpos($templateText, '<body') == false)
			{
				$templateText = '<body>' . $templateText . '</body>';
      }

			if (strpos($templateText, '<html') == false)
			{
				$templateText = <<< HTML
<html>
  <head>
    <title>{$subject}</title>
  </head>
  $templateText
</html>
HTML;
			}
    }

		return array($isHTML, $subject, $templateText, $loadLanguage);
  }


	/**
	 * Creates a mailer instance, preloads its subject and body with your email
	 * data based on the key and extra substitution parameters and waits for
	 * you to send a recipient and send the email.
	 *
	 * @param   Subscriptions  $sub     The subscription record against which the email is sent
	 * @param   string         $key     The email key, in the form PLG_LOCATION_PLUGINNAME_TYPE
	 * @param   array          $extras  Any optional substitution strings you want to introduce
	 *
	 * @return  \JMail|boolean False if something bad happened, the PHPMailer instance in any other case
	 */
	public function getPreloadedMailer(Subscriptions $sub, $key, array $extras = array())
	{
		// Load the template
    list($isHTML, $subject, $templateText, $loadLanguage) = self::loadEmailTemplate($key, $sub->akeebasubs_level_id, self::getContainer()->platform->getUser($sub->user_id));

		if (empty($subject))
		{
			return false;
    }

    // This is where the embedded tags are being parsed, e.g. [USEREMAIL] in the subject and body templates stored in the database
		$templateText = ShortCode::processSubscriptionTags($templateText, $sub, $extras);
    $subject      = ShortCode::processSubscriptionTags($subject, $sub, $extras);

		// Get the mailer
		$mailer = self::getMailer($isHTML);
    $mailer->setSubject($subject);

		// Include inline images
    $pattern           = '/(src)=\"([^"]*)\"/i';

    $number_of_matches = preg_match_all($pattern, $templateText, $matches, PREG_OFFSET_CAPTURE);

		if ($number_of_matches > 0)
		{
			$substitutions = $matches[2];
			$last_position = 0;
      $temp          = '';

			// Loop all URLs
			$imgidx    = 0;
      $imageSubs = array();

			foreach ($substitutions as &$entry)
			{
				// Copy unchanged part, if it exists
				if ($entry[1] > 0)
				{
					$temp .= substr($templateText, $last_position, $entry[1] - $last_position);
        }

				// Examine the current URL
        $url = $entry[0];

				if ((substr($url, 0, 7) == 'http://') || (substr($url, 0, 8) == 'https://'))
				{
					// External link, skip
					$temp .= $url;
				}
				else
				{
          $ext = strtolower(File::getExt($url));

					if (!File::exists($url) || !in_array($ext, array('jpg', 'png', 'gif')))
					{
						// Not an image or inexistent file
						$temp .= $url;
					}
					else
					{
						// Image found, substitute
						if (!array_key_exists($url, $imageSubs))
						{
							// First time I see this image, add as embedded image and push to
							// $imageSubs array.
              $imgidx ++;

              $mailer->AddEmbeddedImage($url, 'img' . $imgidx, basename($url));

							$imageSubs[ $url ] = $imgidx;
						}
						// Do the substitution of the image
						$temp .= 'cid:img' . $imageSubs[ $url ];
					}
				}
				// Calculate next starting offset
				$last_position = $entry[1] + strlen($entry[0]);
			}
			// Do we have any remaining part of the string we have to copy?
			if ($last_position < strlen($templateText))
			{
				$temp .= substr($templateText, $last_position);
			}
			// Replace content with the processed one
			$templateText = $temp;
		}
    $mailer->setBody($templateText);

		return $mailer;
	}
}
