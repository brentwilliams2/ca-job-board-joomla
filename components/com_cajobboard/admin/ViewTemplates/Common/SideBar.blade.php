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
    <fieldset
      name="parent"
      class="form-vertical-control hasTip"
      title="@lang('JGLOBAL_SHOW_PARENT_CATEGORY_LABEL')::@lang('JGLOBAL_FIELD_SHOW_PARENT_DESC')"
    >
      @jhtml('helper.editWidgets.parent')
    </fieldset>
  @endif

  @if(in_array('published', $fields))
    <fieldset
      name="published"
      class="form-vertical-control hasTip"
      title="@lang('JGLOBAL_PUBLISHED_DATE')::@lang('COM_CAJOBBOARD_FIELD_PUBLISHED_DATE_DESC')"
    >
      @jhtml('helper.editWidgets.published', $item->enabled)
    </fieldset>
  @endif

  @if(in_array('category', $fields))
    <fieldset
      name="category"
      class="form-vertical-control hasTip"
      title="@lang('JOPTION_SELECT_CATEGORY')::@lang('COM_CAJOBBOARD_FIELD_SELECT_CATEGORY_DESC')"
    >
      @jhtml('helper.editWidgets.category', $item->cat_id, $this->getName())
    </fieldset>
  @endif

  @if(in_array('featured', $fields))
    <fieldset
      name="featured"
      class="form-vertical-control hasTip"
      title="@lang('COM_CAJOBBOARD_FIELD_FEATURED_LABEL')::@lang('COM_CAJOBBOARD_FIELD_FEATURED_DESC')"
    >
      @jhtml('helper.editWidgets.featured', $item->featured)
    </fieldset>
  @endif

  @if(in_array('access', $fields))
    <fieldset
      name="access"
      class="form-vertical-control hasTip"
      title="@lang('JFIELD_ACCESS_LABEL')::@lang('JFIELD_ACCESS_DESC')"
    >
        @jhtml('helper.editWidgets.access', $item->access)
    </fieldset>
  @endif

  @if(in_array('languages', $fields))
    <fieldset
      name="languages"
      class="form-vertical-control hasTip"
      title="@lang('JFIELD_LANGUAGE_LABEL')::@lang('JFIELD_LANGUAGE_DESC')"
    >
      @jhtml('helper.editWidgets.languages', $item->language)
    </fieldset>
  @endif

  @if(in_array('tags', $fields))
    <fieldset
      name="tags"
      class="form-vertical-control hasTip"
      title="@lang('JGLOBAL_SHOW_TAGS_LABEL')::@lang('JGLOBAL_SHOW_TAGS_DESC')"
    >
      @jhtml('helper.editWidgets.tags', $item->id)
    </fieldset>
  @endif

  @if(in_array('note', $fields))
    <fieldset
      name="note"
      class="form-vertical-control hasTip"
      title="@lang('JFIELD_NOTE_LABEL')::@lang('COM_CAJOBBOARD_FIELD_NOTE_DESC')"
    >
      @jhtml('helper.editWidgets.note', $item->note)
    </fieldset>
  @endif

  @if(in_array('version_note', $fields))
    <fieldset
      name="version_note"
      class="form-vertical-control hasTip"
      title="@lang('JGLOBAL_FIELD_VERSION_NOTE_LABEL')::@lang('JGLOBAL_FIELD_VERSION_NOTE_DESC')"
    >
      @jhtml('helper.editWidgets.versionNote')
    </fieldset>
  @endif
</fieldset>
