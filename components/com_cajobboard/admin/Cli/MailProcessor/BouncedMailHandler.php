<?php
/**
 * CLI Script for handling bounced system-generated e-mails, like Reference and Recommendation requests
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

include realpath(__DIR__ . '/../CliApplication.php');

use \FOF30\Container\Container;
use \Joomla\CMS\Input\Cli;
use \Joomla\Registry\Registry;
use \Malas\BounceHandler\BounceHandler;
use \Calligraphic\Cajobboard\Admin\Helper\EmailIncoming;

// @TODO: need to include the lib_cajobboard autoloader for access to Malas\BounceHandler

// @TODO: Implement bounced email handler CLI script


/**
 * Calligraphic Job Board Sample Data Seeder CLI Application
 *
 * @var    \JInput                       $input
 * @var    \Joomla\Registry\Registry    $config
 */
class BouncedMailHandler extends CliApplication
{
  /**
	 * @property IMAPMailImport
	 */
  protected $bounceHandler;


  /**
	 * @property \Malas\BounceHandler\Model\Result
	 */
  protected $result;


 /**
	 * @property \Calligraphic\Cajobboard\Admin\Helper\EmailIncoming
	 */
  protected $imapHandler;


	/**
	 * Class constructor
	 */
  public function __construct()
  {
    parent::__construct();

    try
    {
      $this->bounceHandler = new IMAPMailImport([
        // imap_open mailbox string
        'mailbox' => '{imap.example.com:143/imap/notls}INBOX',
        'username' => 'user@example.com',
        'password' => 'secret-password',
        // do you want to delete the emails after processing true|false
        'delete_mail' => true,
        'options' => CL_EXPUNGE,
      ]);
    }
    catch (\Exception $e)
    {
      // @TODO: log the error
    }
  }


  /**
	 * Main method of class
   *
   * @return void
	 */
  public function execute()
  {
    // Create the FOF Container object
    parent::execute();

    $this->result = getBouncedMessages()
  }


  /**
	 * Method to get all bounced messages in the system e-mail user's IMAP 'BOUNCED' mailbox
   *
   * @return void
	 */
  public function getResult()
  {
    // array of Malas\BounceHandler\Model\Message objects ready for parsing
    $mails = $import->import(100);

    $handler = new BounceHandler();

    // final object with the parsed results, see Malas\BounceHandler\Model\Result for more details
    return $handler->parse($mails);
  }


  // The RFC code and reason for the bounce (according to the RFC, hard bounces are depicted by a 5XX code and soft bounces by a 4XX code


  /**
	 * Method to notify appropriate entities of bounced email messages
   *
   * @return void
	 */
  public function notify()
  {
    // @TODO: Needs to handle the various types of bounces: References, Recommendations, and general bounces that should be purged
  }


   /**
	 *
   *
   * @return void
	 */
  public function getBouncedEmailOriginalRecipient()
  {
    // Need a way to discover emails that were rejected by the recipient MTA (and thus didn't create a bounce message)

    // headers for a bounce email address (see EmailIncoming helper):

    // @TODO: Also needs soft-bounce handling: resend emails when the server is temporarily unavailable (drive full, mailbox full, message too large, etc.)

    // mailbox that all human replies should be addressed too. This wouldn't work when the system needs people to respond to the e-mail.
    $headers .= "Reply-To: bounce@example.com\r\n";

    // where non-delivery receipts (bounce messages) are to be sent. "Only the recipient's mail server is
    // supposed to add a Return-Path header to the top of the email. If a Return-Path header already exists
    // in the message, then that header is removed and replaced by the recipient's mail server."
    $headers .= "Return-Path: bounce@example.com\r\n";

    // Custom headers to identify who it was sent to:
    $headers .= "X-user-id: XXXXX\r\n";
    $headers .= "X-campaign-id: YYYYYY\r\n";
    $headers .= "X-recipient-id: SSSSSSSSS\r\n";

    /*
    Variable Envelope Return Path (VERP) approach, original email:

      envelope sender: wikipedians-owner+bob=example.org@example.net
      recipient: bob@example.org

    Bounce message:

      envelope sender: empty
      recipient: wikipedians-owner+bob=example.org@example.net
      contents: example.org was unable to deliver the following message to bob: ...
    */
  }


  /**
	 * Method to delete bounced emails
   *
   * @return void
	 */
  public function deleteBouncedEmails($id)
  {
    if (!$this->imapHandler)
    {
      $imapHandler = new EmailIncoming();
    }

    $imapHandler->deleteMessage($id);
  }


  /**
	 * Checks if PCNTL support is available for parallel async processing of tasks with spatie/async, not available in Windows environment
   *
   * @return boolean
	 */
  public function isPcntlAvailable()
  {
    // Need
    return extension_loaded('pcntl');

    /*
      Call from client code:

      // handle making sure there's permission to run the script
      whoiam()

      if ( substr( php_uname(), 0, 7 ) == "Windows" )
      {
        // Windows doesn't have Pcntl
        pclose( popen("start /B ". $cmd, "r") );
      }
      else
      {
        // Run the script as a background process so that it's async, and redirect STDOUT and STDERR with double-redirect
        exec($cmd . " &> /dev/null &");
      }
    */
  }
}

// Execute this CLI application
$app = CliApplication::getInstance('MediaProcesor');
\JFactory::$application = $app;
$app->execute();
