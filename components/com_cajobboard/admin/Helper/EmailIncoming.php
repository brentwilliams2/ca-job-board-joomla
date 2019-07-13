<?php
/**
 * Admin Email Messages Helper class for handling incoming emails
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// @TODO: Implement incoming email helper

// no direct access
defined('_JEXEC') or die;

use \Ddeboer\Imap\Server;
use \Ddeboer\Imap\SearchExpression;
use \Ddeboer\Imap\Search\Email\To;
use \Ddeboer\Imap\Search\Text\Body;

class EmailIncoming
{
  /**
	 * The container attached to the model
	 *
	 * @var Container
	 */
  protected $container;


  /**
  * Public class constructor
 	 *
   * @param   Container  $container  The configuration variables to this model
   */
  public function __construct(Container $container)
  {
    $this->container = $container;
  }


  public function checkPhpConfig()
  {
    if ( !extension_loaded('imap') )
    {
      throw new \Exception('need IMAP'); // @TODO: Use translation key
    }

    if ( !ini_get('imap.enable_insecure_rsh') )
    {
      // log that this option should be enabled to allow SSH / RSH to the mail server
    }
  }


  public function getEmailConfig()
  {
    /*
    Global config:

    public $mailonline = '1';
    public $mailer = 'mail';
    public $mailfrom = 'admin@joomla.test';
    public $fromname = 'MFI';
    public $sendmail = '/usr/sbin/sendmail';
    public $smtpauth = '0';
    public $smtpuser = '';
    public $smtppass = '';
    public $smtphost = 'localhost';
    public $smtpsecure = 'none';
    public $smtpport = '25';
    */
  }


  public function connect()
  {
    $server = new Server(
      $hostname, // required
      $port,     // defaults to '993'
      $flags,    // defaults to '/imap/ssl/validate-cert'
      $parameters
    );

    // $connection is instance of \Ddeboer\Imap\Connection
    $connection = $server->authenticate('my_username', 'my_password');
  }


  public function getMailbox()
  {
    return $connection->getMailbox('INBOX');
  }


  public function getMessages()
  {
    $messages = $mailbox->getMessages();

    // $message is instance of \Ddeboer\Imap\Message
    foreach ($messages as $message)
    {
      $message->getNumber();
      $message->getId();
      $message->getSubject();
      $message->getFrom();    // \Ddeboer\Imap\Message\EmailAddress
      $message->getTo();      // array of \Ddeboer\Imap\Message\EmailAddress
      $message->getDate();    // DateTimeImmutable
      $message->isAnswered();
      $message->isDeleted();
      $message->isDraft();
      $message->isSeen();
      $message->getHeaders(); //  \Ddeboer\Imap\Message\Headers
      $message->getBodyHtml();    // Content of text/html part, if present
      $message->getBodyText();    // Content of text/plain part, if present
    }
  }


  public function findMessage()
  {
    $search = new SearchExpression();

    $search->addCondition(new To('me@here.com'));
    $search->addCondition(new Body('contents'));

    $messages = $mailbox->getMessages($search);
  }


  public function markMessageAsSeen()
  {
    $message->markAsSeen();
    // or using flags \Seen, \Answered, \Flagged, \Deleted, and \Draft
    $message->setFlag('\\Seen \\Flagged');
    $message->clearFlag('\\Flagged');
  }


  public function moveMessageToSent()
  {
    $mailbox = $connection->getMailbox('SENT');
    $message->move($mailbox);
    $connection->expunge();
  }


  public function deleteMessage($id)
  {
    $mailbox->getMessage($id)->delete();

    $connection->expunge();
  }


  public function getAttachment()
  {
    $attachments = $message->getAttachments();

    // $attachment is instance of \Ddeboer\Imap\Message\Attachment
    foreach ($attachments as $attachment)
    {
      // Download attachment to local file
      // getDecodedContent() decodes the attachment’s contents automatically:
      file_put_contents(
        '/my/local/dir/' . $attachment->getFilename(),
        $attachment->getDecodedContent()
      );
    }
  }
}
