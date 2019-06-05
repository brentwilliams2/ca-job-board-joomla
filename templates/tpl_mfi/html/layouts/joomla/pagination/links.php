<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/pagination/links.php template override
 *
 * Override of the core Joomla! footer pagination template
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

  use \Joomla\CMS\Layout\LayoutHelper;
  use \Joomla\Registry\Registry;

  /*
    $displayData is an array with the following keys:

    'prefix'       // Prefix used for request variables, to namespace them
    'limit'        // Number of rows to display per page
    'limitstart'   // The record number to start displaying from
    'total'        // total number of items
    'limitfield'   // HTML for a dropdown box for selecting how many records to show per page
    'pagescounter' // Returns the pagination pages counter string, ie. Page 2 of 4
    'pages'        // Returns the pagination pages list, ie. Previous, Next, 1 2 3 ... x
    'pagesTotal'   // Total number of pages
  */

  $list = $displayData['list'];

  $pages = $list['pages'];

  $options = new Registry($displayData['options']);

  $showPagesLinks = $options->get('showPagesLinks', true);
  $showLimitStart = $options->get('showLimitStart', true);

  // Calculate to display range of pages
  $currentPage = 1;
  $range = 1;
  $step = 5;

  if (!empty($pages['pages']))
  {
    foreach ($pages['pages'] as $k => $page)
    {
      if (!$page['active'])
      {
        $currentPage = $k;
      }
    }
  }

  if ($currentPage >= $step)
  {
    if ($currentPage % $step === 0)
    {
      $range = ceil($currentPage / $step) + 1;
    }
    else
    {
      $range = ceil($currentPage / $step);
    }
  }
  ?>

<?php if ($showPagesLinks && (!empty($pages))) : ?>

  <ul class="pagination-links pagination pagination-sm center-block">

    <?php
      echo LayoutHelper::render('joomla.pagination.link', $pages['start']);
      echo LayoutHelper::render('joomla.pagination.link', $pages['previous']);
    ?>

    <?php foreach ($pages['pages'] as $k => $page) : ?>

      <?php $output = LayoutHelper::render('joomla.pagination.link', $page); ?>

      <?php if (in_array($k, range($range * $step - ($step + 1), $range * $step), true)) : ?>

        <?php if (($k % $step === 0 || $k === $range * $step - ($step + 1)) && $k !== $currentPage && $k !== $range * $step - $step) : ?>
          <?php $output = preg_replace('#(<a.*?>).*?(</a>)#', '$1...$2', $output); ?>
        <?php endif; ?>

      <?php endif; ?>

      <?php echo $output; ?>

    <?php endforeach; ?>

    <?php
      echo LayoutHelper::render('joomla.pagination.link', $pages['next']);
      echo LayoutHelper::render('joomla.pagination.link', $pages['end']);
    ?>

  </ul>

<?php endif; ?>

<?php if ($showLimitStart) : ?>
  <input type="hidden" name="<?php echo $list['prefix']; ?>limitstart" value="<?php echo $list['limitstart']; ?>" />
<?php endif; ?>
