<?php
/**
 * @package Plugin PushAlert - Web Push Notifications for Joomla! 1.6 and above
 * @version 1.0.3
 * @author Abhinav Pathak
 * @email contactus@pushalert.co
 * @website https://pushalert.co
 * @copyright (C) 2016- PushAlert.co
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Unauthorized Access' );
jimport( 'joomla.plugin.plugin');
jimport('joomla.version');

class plgSystempushalertjoomla extends JPlugin
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
		<!-- PushAlert for Joomla 1.0.3 -->
		<script type="text/javascript">
			(function(d, t) {
				var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
				g.src = "https://cdn.pushalert.co/integrate_'.$pushalert_web_id.'.js";
				s.parentNode.insertBefore(g, s);
			}(document, "script"));
		</script>
		<!-- End PushAlert for Joomla 1.0.3 -->
		';
		
		$version = new JVersion();
		$version_num = floatval($version->RELEASE);
		if ($version_num <=3.1) {
			$currDoc = JResponse::getBody();
			$currDoc = preg_replace ("/<\/head>/", "\n\n".$javascript."\n\n</head>", $currDoc);
			JResponse::setBody($currDoc);
			return true;
		}else{
			$currDoc = JFactory::getApplication()->getBody();
			$currDoc = preg_replace ("/<\/head>/", "\n\n".$javascript."\n\n</head>", $currDoc);
			JFactory::getApplication()->setBody($currDoc);
			return true;
		}
	}
}
?>