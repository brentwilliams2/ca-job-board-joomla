<?php
/**
 * Push Alerts plugin
 *
 * @package   Calligraphic Job Board
 * @version   July 7, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   GNU General Public License version 3, or later
 *
 */
// no direct access
defined( '_JEXEC' ) or die( 'Unauthorized Access' );
jimport( 'joomla.plugin.plugin');
jimport('joomla.version');

class plgSystemPush_alert extends JPlugin
{
	function onAfterRender()
	{
		$currApp = JFactory::getApplication();

		if($currApp->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false){
			return;
		}

		$pushalert_web_id = $this->params->get('pushalert_web_id', '');

		if($pushalert_web_id == '')
		{
			return;
		}

		$javascript ='
		<!-- Push Alert -->
		<script type="text/javascript">
			(function(d, t) {
				var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
				g.src = "https://cdn.pushalert.co/integrate_'. $pushalert_web_id .'.js";
				s.parentNode.insertBefore(g, s);
			}(document, "script"));
		</script>
		<!-- End Push Alert -->
		';

    $version = new JVersion();

    $version_num = floatval($version->RELEASE);

    if ($version_num <=3.1)
    {
      $currDoc = JResponse::getBody();

      $currDoc = preg_replace ("/<\/head>/", "\n\n".$javascript."\n\n</head>", $currDoc);

			JResponse::setBody($currDoc);
			return true;
    }
    else
    {
      $currDoc = JFactory::getApplication()->getBody();

      $currDoc = preg_replace ("/<\/head>/", "\n\n".$javascript."\n\n</head>", $currDoc);

      JFactory::getApplication()->setBody($currDoc);

			return true;
		}
	}
}
?>
