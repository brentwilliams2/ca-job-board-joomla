<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/content/info_block/author.php template override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

 use \Joomla\CMS\HTML\HTMLHelper;
 use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;
?>

<dd class="createdby" itemprop="author" itemscope itemtype="http://schema.org/Person">

	<i class="fa fa-user"></i>

	<?php $author = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $displayData['item']->author); ?>

	<?php $author = '<span itemprop="name">' . $author . '</span>'; ?>

	<?php if (!empty($displayData['item']->contact_link ) && $displayData['params']->get('link_author') == true) : ?>

		<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url'))); ?>

	<?php else :?>

		<?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>

	<?php endif; ?>

</dd>
