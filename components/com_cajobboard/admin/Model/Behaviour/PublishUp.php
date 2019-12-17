<?php
/**
 * FOF model behavior class to set the publish_up field on new items. This class
 * is intended for use when the model doesn't have a 'publish_down' field, so that
 * the Model/Helper/TableFields helper correctly adds fields based on the classname.
 *
 * @package   Calligraphic Job Board
 * @version   November 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 201 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Publish;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * To override validation behaviour for a particular model, create a directory
 * named named after the model in the 'Behaviour' directory and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class PublishUp extends Publish
{
}
