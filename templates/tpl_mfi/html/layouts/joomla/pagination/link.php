<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/pagination/link.php template override
 *
 * Override of the core Joomla! footer pagination template, individual links
 *
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

  use \Joomla\CMS\Factory;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  /** @var \Joomla\CMS\Pagination\PaginationObject $item */
  $item = $displayData['data'];

  $display = $item->text; // The link text

  switch ((string) $item->text)
  {
    // Check for "Start" item
    case Text::_('JLIB_HTML_START') :
      $icon = "fa fa-backward";
      break;

    // Check for "Prev" item
    case $item->text == Text::_('JPREV') :
      $item->text = Text::_('JPREVIOUS');
      $icon = "fa fa-step-backward";
      break;

    // Check for "Next" item
    case Text::_('JNEXT') :
      $icon = "fa fa-step-forward";
      break;

    // Check for "End" item
    case Text::_('JLIB_HTML_END') :
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

  $class = null;

  if ($displayData['active'])
  {
    $title = null;

    // Start, Prev, Next, End items
    if (!is_numeric($item->text))
    {
      HTMLHelper::_('bootstrap.tooltip');
      $class = 'hasTooltip';
      $title = ' title="' . $item->text . '" ';
    }
  }
  else
  {
    $class = (property_exists($item, 'active') && $item->active) ? 'active' : 'disabled';
  }

  $routerVars = Factory::getApplication()->getRouter()->getVars();

  $uri = Route::_(
    'index.php?option=' . $routerVars['option'] .
    '&view=' . $routerVars['view']
  ) . '&limitstart=' . ($item->base > 0 ? $item->base : '0'); // append limitstart after SEF-friendly URL built
?>

<?php if ($displayData['active']) : ?>

	<li>
		<a class="<?php echo $class; ?>" <?php echo $title; ?> href="<?php echo $uri; ?>">
			<?php echo $display; ?>
		</a>
  </li>

<?php else : ?>

	<li class="<?php echo $class; ?>">
		<span><?php echo $display; ?></span>
  </li>

<?php endif;
