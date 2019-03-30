<?php
/**
 * Admin Common Joomla! sidebar for edit views
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage:
 *
 *   @include('admin:com_cajobboard/Common/SideBar', [ 'item' => $item, 'fieldsToHide' = array() ])
 */

  // no direct access
  defined('_JEXEC') or die;

  $fields = array(
    'parent',
    'published',
    'category',
    'featured',
    'access',
    'languages',
    'tags',
    'note',
    'version_note',
  );

  // Handle fields that should not display in form
  foreach ($fieldsToHide as $field)
  {
    if(in_array($field, $fields))
    {
      $fieldIndex = array_search($field, $fields);
      unset($fields[$fieldIndex]);
    }
  }

  // reindex array
  $fields = array_values($fields);
?>

<fieldset class="form-vertical">
  @if(in_array('parent', $fields))
    <fieldset name="parent" class="form-vertical-control">
      @jhtml('helper.editWidgets.parent')
    </fieldset>
  @endif

  @if(in_array('published', $fields))
    <fieldset name="published" class="form-vertical-control">
      @jhtml('helper.editWidgets.published', $item->enabled)
    </fieldset>
  @endif

  @if(in_array('category', $fields))
    <fieldset name="category" class="form-vertical-control">
      @jhtml('helper.editWidgets.category', $item->cat_id)
    </fieldset>
  @endif

  @if(in_array('featured', $fields))
    <fieldset name="featured" class="form-vertical-control">
      @jhtml('helper.editWidgets.featured', $item->featured)
    </fieldset>
  @endif

  @if(in_array('access', $fields))
    <fieldset name="access" class="form-vertical-control">
        @jhtml('helper.editWidgets.access', $item->access)
    </fieldset>
  @endif

  @if(in_array('languages', $fields))
    <fieldset name="languages" class="form-vertical-control">
      @jhtml('helper.editWidgets.languages', $item->language)
    </fieldset>
  @endif

  @if(in_array('tags', $fields))
    <fieldset name="tags" class="form-vertical-control">
      @jhtml('helper.editWidgets.tags', $item->id)
    </fieldset>
  @endif

  @if(in_array('note', $fields))
    <fieldset name="note" class="form-vertical-control">
      @jhtml('helper.editWidgets.note', $item->note)
    </fieldset>
  @endif

  @if(in_array('version_note', $fields))
    <fieldset name="version_note" class="form-vertical-control">
      @jhtml('helper.editWidgets.versionNote')
    </fieldset>
  @endif
</fieldset>
