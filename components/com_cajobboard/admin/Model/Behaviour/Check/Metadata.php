<?php
/**
 * FOF model behavior class to validate the 'metadata' attribute value from state on record save.
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\Check;

use \Calligraphic\Cajobboard\Admin\Model\Exception\LengthExceeded;
use \Calligraphic\Library\Platform\Registry;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;

// no direct access
defined( '_JEXEC' ) or die;


class Metadata extends Observer
{
  use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check\Mixin\Utility;

  /**
   * Validate the 'metadata' field on save. This is a Registry object, with validation callbacks
   * for the Registry paths specified in an array of callbacks keyed by path name. The 'metadata',
   * 'metakey', and 'metadesc' Joomla! UCM table fields are transformed to HTML <meta> tags in
   * site's Semantic helper.
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
   *
   * @return void
	 */
	public function onCheck(DataModel $model)
	{
    $this->executeCheck($model, 'metadata');
  }


  /**
	 * Provides an array of keys of the same name as the Registry object (e.g. Image, Metadata, or Params) this
   * array will be used with. Each array value should have a corresponding validation method in this class,
   * named in the pattern 'checkForValidArrayValueField', where 'ArrayValue' is the camelcased Registry path name.
   *
	 * @return  void
	 */
  public function getFieldArray()
  {
    return array (
      'author',
      'robots'
    );
  }


  /**
   * Validate the 'author' path of the 'metadata' Registry object on save
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
	 */
	protected function checkForValidAuthorField(DataModel $model)
	{
    /** @var \FOF30\Container\Container $container */
    $container = $model->getContainer();

    $metadataField = $model->getFieldAlias('metadata');

    $metadataRegistry = $model->getFieldValue($metadataField);

    $authorValue = $metadataRegistry->get('author');

    // Do nothing if author name not set
    if (!$authorValue)
    {
      return;
    }

    // Remove HTML

    $authorValue = $container->Text->filterText($authorValue);

    // Get configuration options for the metadata author field, over-rideable item -> menu -> component

    $requiredFlag = $container->params->getConfigOption('metadata_author__length_required', true, $model);

    $maxLength = $container->params->getConfigOption('metadata_author__length', 70, $model);

    // Calculation

    $exceedsMaxLength = strlen($authorValue) > $maxLength;

    // Constants defined in Dispatcher for 'title_length_required' config.xml parameter value. Truncate text if set to do so.

    if ( $exceedsMaxLength && $requiredFlag == LENGTH_TRUNCATE_ON_EXCEEDED )
    {
      $authorValue = $container->Text->truncateText($authorValue, $maxLength);
    }
    elseif ( $exceedsMaxLength && $requiredFlag == LENGTH_REJECT_ON_EXCEEDED )
    {
      throw new LengthExceeded( Text::_('COM_CAJOBBOARD_EXCEPTION_FIELD_LENGTH_EXCEEDED', strtolower( Text::_('COM_CAJOBBOARD_UCM_FIELD_NAME_METADATA_AUTHOR') )));
    }

    $metadataRegistry->set('author', $authorValue);
  }


  /**
   * Validate the 'robots' path of the 'metadata' Registry object on save, formatting it to Google standards
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
	 */
	protected function checkForValidRobotsField(DataModel $model)
	{
    $metadataField = $model->getFieldAlias('metadata');

    $metadataRegistry = $model->getFieldValue($metadataField);

    $value = strtoupper( str_replace(' ', '', $metadataRegistry->get('robots', 'follow,index') ));

    // Default to INDEX
    $shouldIndex = strpos($value, 'noindex') === false;

    // Default to FOLLOW
    $shouldFollow = strpos($value, 'nofollow') === false;

    $robots = $shouldIndex ? 'index,' : 'noindex,';
    $robots .= $shouldFollow ? 'follow' : 'nofollow';

    $metadataRegistry->set('robots', $robots);
  }
}
