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

  $item = $displayData['data'];

  $display = $item->text;

  switch ((string) $item->text)
  {
    // Check for "Start" item
    case JText::_('JLIB_HTML_START') :
      $icon = "fa fa-backward";
      break;

    // Check for "Prev" item
    case $item->text == JText::_('JPREV') :
      $item->text = JText::_('JPREVIOUS');
      $icon = "fa fa-step-backward";
      break;

    // Check for "Next" item
    case JText::_('JNEXT') :
      $icon = "fa fa-step-forward";
      break;

    // Check for "End" item
    case JText::_('JLIB_HTML_END') :
      $icon = "fa fa-forward";
      break;

    default:
      $icon = null;
      break;
  }

  if ($icon !== null)
  {
    $display = '<i class="' . $icon . '"></i>';
  }

  if ($displayData['active'])
  {
    if ($item->base > 0)
    {
      $limit = 'limitstart.value=' . $item->base;
    }
    else
    {
      $limit = 'limitstart.value=0';
    }

    $cssClasses = array();

    $title = '';

    if (!is_numeric($item->text))
    {
      JHtml::_('bootstrap.tooltip');
      $cssClasses[] = 'hasTooltip';
      $title = ' title="' . $item->text . '" ';
    }

    $onClick = 'document.adminForm.' . $item->prefix . 'limitstart.value=' . ($item->base > 0 ? $item->base : '0') . '; Joomla.submitform();return false;';
  }
  else
  {
    $class = (property_exists($item, 'active') && $item->active) ? 'active' : 'disabled';
  }
?>

<?php if ($displayData['active']) : ?>
	<li>
		<a class="<?php echo implode(' ', $cssClasses); ?>" <?php echo $title; ?> href="#" onclick="<?php echo $onClick; ?>">
			<?php echo $display; ?>
		</a>
	</li>
<?php else : ?>
	<li class="<?php echo $class; ?>">
		<span><?php echo $display; ?></span>
	</li>
<?php endif;
