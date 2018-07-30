<?php
  /**
   * @package		todo
   * @copyright	2015 Nicholas K. Dionysopoulos / Akeeba Ltd
   * @license		GNU GPL version 3 or later
   */
  $date = new \JDate($this->item->due);
  $class = ($date->toUnix() < time()) ? 'label label-important' : '';
/*
<h2><?php echo $this->escape($this->item->title) ?></h2>

<div>
	<span class="<?php echo $class ?>">
		<?php echo $date->format(\JText::_('DATE_FORMAT_LC1')); ?>
	</span>
</div>

<p></p>

<div class="well">
	<?php echo $this->item->description ?>
</div>

<hr/>

<a href="<?php echo \JRoute::_('index.php?option=com_cajobboard'); ?>">
	<?php echo JText::_('JTOOLBAR_BACK'); ?>
</a>
*/

echo $this->getRenderedForm();
