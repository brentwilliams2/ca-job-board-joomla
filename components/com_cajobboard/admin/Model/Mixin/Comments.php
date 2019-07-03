<?php
/**
 * Trait to provide methods for handling comments
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

trait Comments
{
  /**
   * An indexed array of models that should have comments enabled
   *
   * @property array $commentEnabledModels
   */
  public $commentEnabledModels = array();


  /**
	 * Enable comments for a model
	 *
	 * @param   string    $modelName  The name of the model to enable comments for
	 */
  public function enableComments($modelName)
  {
    if ( !in_array($modelName, $this->commentEnabledModels) )
    {
      array_push($this->commentEnabledModels, $modelName);
    }
  }


  /**
	 * Get comments associated with an entity.
	 *
	 * @return   DataCollection   Collection of Comments models
	 */
  public function getComments()
  {
    if ( !in_array($modelName, $this->commentEnabledModels) )
    {
      throw new \Exception( Text::sprintf('COM_CAJOBBOARD_GET_COMMENTS_EXCEPTION_NOT_ENABLED_FOR_MODEL', $modelName) );
    }

    // @TODO: Implement getComments() in BaseModel, see Comments models.

    // @TODO: Need to add relation to this base model in constructor, something like:

    // many-to-many FK to #__cajobboard_comments
    // @TODO: check syntax
    $this->belongsToMany('Comments', 'Comments@com_cajobboard', $this->getName() . '_id', 'comment_id', '#__cajobboard_comments_foreign_models', 'comment_id', 'foreign_model_id');
  }
}
