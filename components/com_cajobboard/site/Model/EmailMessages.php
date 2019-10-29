<?php
/**
 * Site Email Messages Model
 *
 * This is used for managing outgoing e-mail messages for various system events, like Job Alerts
 *
 * @package   Calligraphic Job Board
 * @version   October 26, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;

/**
 * Fields:
 *
 * UCM
 * @property int            $email_message_id     Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id           FK to the #__assets table for access control purposes.
 * @property int            $access             The Joomla! view access level.
 * @property int            $enabled            Send status: -2 for trashed and marked for deletion, -1 for mail delivery failure, 0 for not yet mailed, and 1 for mailed.
 * @property string         $created_on         Timestamp of record creation, auto-filled by save().
 * @property int            $created_by         User ID who created the record, auto-filled by save().
 * @property string         $modified_on        Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by        User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on          Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by          User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $params           JSON encoded parameters for this item.
 * @property string         $language         The language code for the article or * for all languages.
 * @property int            $cat_id           Category ID for this item.
 * @property string         $note             A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the email message.
 * @property string         $description      A description of the email message.
 *
 * SCHEMA: CreativeWork
 * @property string         $text             Body field of the e-mail.
 *
 * SCHEMA: Message
 * @property string         $date_sent                      The date/time at which the message was sent via the MTA.
 * @property string         $recipient__additional_name     An additional name for  of the recipient, can be used for a middle name.
 * @property string         $recipient__email               Email address of the recipient.
 * @property string         $recipient__family_name         Family name of the recipient. In the U.S., the last name of an Person.
 * @property string         $recipient__given_name          Given name of the recipient. In the U.S., the first name of a Person.
 * @property string         $recipient__honorific_prefix    An honorific prefix preceding the recipient's name such as Dr. / Mrs. / Mr.
 * @property string         $recipient__honorific_suffix    An honorific suffix preceding the recipient's name such as M.D. / PhD / MSCSW.
 */
class EmailMessages extends \Calligraphic\Cajobboard\Admin\Model\EmailMessages
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}