<?php
/**
 * Site Image Objects Controller
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

class ImageObject extends BaseController
{
	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

		$this->setModelName('ImageObjects');

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(

		));
  }


  /*
    Category parameters related to images, initialized in script.cajobboard.php to inherit when
    Job Board categories are created on component installation:

        enforce_aspect_ratio, thumbnail_aspect_ratio, image_aspect_ratio

    Component parameters related to images:

        thumbnail-width, small-width, medium-width, large-width


		SEE https://docs.joomla.org/Retrieving_request_data_using_JInput for input object files method
				to provide a nicer array output from uploaded files in an HTML form:

		<form action="<?php echo JRoute::_('index.php?option=com_example&task=file.submit'); ?>" enctype="multipart/form-data" method="post">
			<input type="file" name="jform1[test][]" />
			<input type="file" name="jform1[test][]" />
			<input type="submit" value="submit" />
		</form>

		$files = $input->files->get('jform1');

		Array
		(
			[test] => Array
			(
				[0] => Array
					(
						[name] => youtube_icon.png
						[type] => image/png
						[tmp_name] => /tmp/phpXoIpSD
						[error] => 0
						[size] => 34409
					)

				[1] => Array
					(
						[name] => Younger_Son_2.jpg
						[type] => image/jpeg
						[tmp_name] => /tmp/phpWDE7ye
						[error] => 0
						[size] => 99529
					)
			)
		)
	*/
}
