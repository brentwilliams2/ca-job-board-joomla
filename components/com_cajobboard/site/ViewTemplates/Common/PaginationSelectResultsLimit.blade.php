<?php
/**
 * Select box to set maximum number of results per page, for use in site views
 *
 * The select uses the Job Board 'paginationLimitSubmit' method in frontend.js
 *
 * @package   Calligraphic Job Board
 * @version   July 13, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/*
input variables involving pagination:

  limitstart
  limit
  filter_order
  filter_order_Dir
*/

$options = array();

$currentLimit = (int) $this->container->input->get('limit', 20);

$isSelectedSet = false;


// Make the option list. $options looks like: 5, 10, 15, 20, 25, 30, 50, 100, All
for ($i = 5; $i <= 30; $i += 5)
{
  // Handle cases where the current 'limit' value falls in between the populated values to set 'selected'
  if ( ($i <= $currentLimit) && ($currentLimit < $i + 5) )
  {
    $options[] = '<option value="' . $i . '" selected="selected">' . $i . '</option>';

    $isSelectedSet = true;

    continue;
  }

  $options[] = '<option value="' . $i . '">' . $i . '</option>';
}

if ( (50 <= $currentLimit) && ($currentLimit < 100) )
{
  $options[] = '<option value="50" selected="selected">' . Text::_('J50') . '</option>';

  $isSelectedSet = true;
}
else
{
  $options[] = '<option value="50">' . Text::_('J50') . '</option>';
}

if ( (100 <= $currentLimit) && ($currentLimit !== 0) )
{
  $options[] = '<option value="100" selected="selected">' . Text::_('J100') . '</option>';

  $isSelectedSet = true;
}
else
{
  $options[] = '<option value="100">' . Text::_('J100') . '</option>';
}

if ( !$isSelectedSet )
{
  $options[] = '<option value="0" selected="selected">' . Text::_('JALL') . '</option>';
}
else
{
  $options[] = '<option value="0">' . Text::_('JALL') . '</option>';
}
?>

<form>

  <select id="pagination-limit" name="list[limit]" class="pagination-limit" pagination-limit onchange="paginationLimitSubmit();">

    @foreach ($options as $option)
      {{ $option }}
    @endforeach

  </select>

  <input type="hidden" name="@token()" value="1"/>

</form>
