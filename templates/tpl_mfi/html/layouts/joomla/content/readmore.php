<?php
/**
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  // no direct access
  defined('_JEXEC') or die;

  $params = $displayData['params'];
  $item = $displayData['item'];
?>

<p class="readmore">
	<a class="btn btn-default" href="<?php echo $displayData['link']; ?>" itemprop="url">
		<i class="fa fa-chevron-right"></i>
		<?php if (!$params->get('access-view')) :
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
		elseif ($readmore = $item->alternative_readmore) :
			echo $readmore;
			if ($params->get('show_readmore_title', 0) != 0) :
				echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
			endif;
		elseif ($params->get('show_readmore_title', 0) == 0) :
			echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
		else :
			echo JText::_('COM_CONTENT_READ_MORE');
			echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
		endif; ?>
	</a>
</p>