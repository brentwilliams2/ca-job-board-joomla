<?php
/**
 * Admin Email Messages Model
 *
 * There is no site-side counterpart to EmailMessages, because it is a send-
 * only feature and the admin views are only for setting configuration to allow
 * non-developer updates to the HTML e-mail templates.
 *
 * This MVC triad allows using an HTML editor to modify the available
 * e-mail templates for tasks. It does not allow adding additional
 * templates to the database. Adding tasks requires adding appropriate
 * methods to the plg_cajobboard_mail plugin, and adding controller code
 * to dispatch events to the plugin task method.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use FOF30\Model\DataModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $reference_id     Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this reference is featured or not.
 * @property int            $hits             Number of hits this reference has received.
 * @property int            $created_by       Userid of the creator of this reference.
 * @property string         $createdOn        Date this reference was created.
 * @property int            $modifiedBy       Userid of person that last modified this reference.
 * @property string         $modifiedOn       Date this reference was last modified.
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
 * @property int            $version          Version of this item.
 * @property int            $ordering         Order this record should appear in for sorting.
 * @property string         $params           JSON encoded parameters for this item.
 * @property string         $language         The language code for the article or * for all languages.
 * @property int            $note             A note to save with this answer in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name             Machine name for this e-mail template. Aliased by title property.
 * @property string         $description      Description of this e-mail template.
 *
 * SCHEMA: none (internal use only)
 * @property string         $subject          Text template with shortcodes for the subject field of the e-mail.',
 * @property string         $body             HTML template with shortcodes for the body field of the e-mail.',
 */
class EmailMessages extends DataModel
{
	/**
	 * Overrides the constructor to add the Filters behaviour
	 *
	 * @param Container $container
	 * @param array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);
		$this->addBehaviour('Filters');
  }

  //  @TODO: Need to send both HTML and text emails in the same message, for Outlook

	/**
	 * Unpublish the newly copied item
	 *
	 * @param EmailMessages $copy
	 */
	protected function onAfterCopy(EmailTemplates $copy)
	{
		// Unpublish the newly copied item
		if ($copy->enabled)
		{
			$this->publish(0);
		}
	}
}