<?php
 /**
  * Admin Common Permissions Tab View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  use \Calligraphic\Cajobboard\Admin\Helper\PermissionsHelper;

  // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html  $this */

  /JHtml::_('behavior.formvalidator');

  /JHtml::_('bootstrap.tooltip');

  // Add Javascript for permission change
  /JHtml::_('script', 'system/permissions.js', array('version' => 'auto', 'relative' => true));

  /*
   *  \JText::script allows using translation strings in javascript by first adding the translation key in PHP:
   *
   *    \JText::script('VALIDATION_ERROR');
   *
   *  Then using the translation key in Javascript:
   *
   *    Joomla.JText._('VALIDATION_ERROR')
   */

  // Add strings for JavaScript message translations.
  \JText::script('ERROR');
  \JText::script('WARNING');
  \JText::script('NOTICE');
  \JText::script('MESSAGE');

  // Add strings for JavaScript error translations.
  \JText::script('JLIB_JS_AJAX_ERROR_CONNECTION_ABORT');
  \JText::script('JLIB_JS_AJAX_ERROR_NO_CONTENT');
  \JText::script('JLIB_JS_AJAX_ERROR_OTHER');
  \JText::script('JLIB_JS_AJAX_ERROR_PARSE');
  \JText::script('JLIB_JS_AJAX_ERROR_TIMEOUT');

  // This is to enable setting the permission's Calculated Setting when you change the permission's Setting.
  // The core javascript code for initiating the Ajax request looks for a field
  // with id="jform_title" and sets its value as the 'title' parameter to send in the Ajax request
  \JFactory::getDocument()->addScriptDeclaration('
    jQuery(document).ready(function() {
      greeting = jQuery("#jform_greeting").val();
      jQuery("#jform_title").val(greeting);
    });
  ');

  // Ajax request data.
  $ajaxUri = \JRoute::_('index.php?option=com_cajobboard&task=config.store&format=json&' . \JSession::getFormToken() . '=1');

  /*
    Values needed from PermissionsHelper:
      $groups
      $actions
      $assetId
      $assetRules

    Values in "calculated asset" section:
      $parentAssetId

  */

  @TODO: Finish this
?>

<input id="jform_title" type="hidden" name="helloworld-message-title"/>

<fieldset class="adminform">
  <legend>
    <?php echo \JText::_('JCONFIG_PERMISSIONS_LABEL') ?>
  </legend>

  <div class="row-fluid">
    <div class="span12">

      {{--  Description --}}
      <p class="rule-desc">@lang('JLIB_RULES_SETTINGS_DESC')</p>

      {{--  Begin tabs --}}
      <div class="tabbable tabs-left" data-ajaxuri="{{ $ajaxUri }}" id="permissions-sliders">
        {{--  Building tab nav --}}
        <ul class="nav nav-tabs">
          {{--  User groups --}}
          @foreach ($groups as $group)
            {{--  Initial Active tab for user groups --}}
            <?php $active = (int) $group->value === 1 ? ' class="active"' : ''; ?>

            <li {{ $active }}>
              <a href="#permission-{{ $group->value }}" data-toggle="tab">
                <?php \JLayoutHelper::render('joomla.html.treeprefix', array('level' => $group->level + 1)) . $group->text; ?>
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="tab-content">
        {{-- Start a row for each user group. --}}
        @foreach($groups as $group)
        {
          {{--  Initial Active Pane --}}
          <?php $active = (int) $group->value === 1 ? ' active' : ''; ?>

          <div class="tab-pane{{ $active }}" id="permission-{{ $group->value }}">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="actions" id="actions-th{{ $group->value }}">
                    <span class="acl-action">@lang('JLIB_RULES_ACTION')</span>
                  </th>
                  <th class="settings" id="settings-th{{ $group->value }}">
                    <span class="acl-action">@lang('JLIB_RULES_SELECT_SETTING')</span>
                  </th>
                  <th id="aclactionth{{ $group->value }}">
                    <span class="acl-action">@lang('JLIB_RULES_CALCULATED_SETTING')</span>
                  </th>
                </tr>
              </thead>

              <tbody>
                {{--  Check if this group has super user permissions --}}
                <?php $isSuperUserGroup = \JAccess::checkGroup($group->value, 'core.admin'); ?>

                @foreach($actions as $action)
                  <tr>
                    <td headers="actions-th' . $group->value . '">
                      <label
                        for="{{ $this->id }}_{{ $action->name }}_{{ $group->value }}"
                        class="hasTooltip"
                        title="@jhtml('tooltipText', $action->title, $action->description)"
                      >
                        @lang($action->title)
                      </label>
                    </td>

                    <td headers="settings-th' . $group->value . '">
                      <select
                        onchange="sendPermissions.call(this, event)"
                        data-chosen="true"
                        class="input-small novalidate"'
                        name="{{ $this->name }}[{{ $action->name }}][{{ $group->value }}]"
                        id="{{ $this->id }}_{{ $action->name }}_{{ $group->value }}"
                        title="<?php strip_tags(\JText::sprintf('JLIB_RULES_SELECT_ALLOW_DENY_GROUP', \JText::_($action->title), trim($group->text))) ?>"
                      >
                        {{--  Get the actual setting for the action for this group: true = allowed, false = denied, null = inherited--}}
                        <?php $assetRule = empty($assetId) ? $assetRules->allow($action->name, $group->value) : null; ?>

                        {{--  Build the dropdowns for the permissions sliders --}}
                        {{--  The parent group has "Not Set", all children can rightly "Inherit" from that. --}}
                        <option value="" <?php ($assetRule === null ? ' selected="selected"' : '') ?> >
                          @lang('JLIB_RULES_INHERITED')
                        </option>

                        <option value="1"' . ($assetRule === true ? ' selected="selected"' : '') . '>
                          @lang('JLIB_RULES_ALLOWED')
                        </option>

                        <option value="0"' . ($assetRule === false ? ' selected="selected"' : '') . '>
                          @lang('JLIB_RULES_DENIED')
                        </option>
                      </select>

                      &#160; {{-- HTML entity for NBSP --}}
                      <span id="icon_{{ $this->id }}_{{ $action->name }}_{{ $group->value }}"></span>
                    </td>

                    {{--  Build the Calculated Settings column. --}}
                    <td headers="aclactionth{{ $group->value }}">

                      $result = array();

                      {{--  Get the group, group parent id, and group global config recursive calculated permission for the chosen action. --}}
                      $inheritedGroupRule            = JAccess::checkGroup((int) $group->value, $action->name, $assetId);
                      $inheritedGroupParentAssetRule = !empty($parentAssetId) ? JAccess::checkGroup($group->value, $action->name, $parentAssetId) : null;
                      $inheritedParentGroupRule      = !empty($group->parent_id) ? JAccess::checkGroup($group->parent_id, $action->name, $assetId) : null;

                      {{--  Current group is a Super User group, so calculated setting is "Allowed (Super User)". --}}
                      if ($isSuperUserGroup)
                      {
                        $result['class'] = 'label label-success';
                        $result['text'] = '<span class="icon-lock icon-white"></span>@lang('JLIB_RULES_ALLOWED_ADMIN');
                      }

                      {{--  Not super user. --}}
                      else
                      {
                        {{--  First get the real recursive calculated setting and add (Inherited) to it. --}}
                        {{--  If recursive calculated setting is "Denied" or null. Calculated permission is "Not Allowed (Inherited)". --}}
                        if ($inheritedGroupRule === null || $inheritedGroupRule === false)
                        {
                          $result['class'] = 'label label-important';
                          $result['text']  = \JText::_('JLIB_RULES_NOT_ALLOWED_INHERITED');
                        }

                        {{--  If recursive calculated setting is "Allowed". Calculated permission is "Allowed (Inherited)". --}}
                        else
                        {
                          $result['class'] = 'label label-success';
                          $result['text']  = \JText::_('JLIB_RULES_ALLOWED_INHERITED');
                        }

                        {{--  Second part: Overwrite the calculated permissions labels if there is an explicit permission in the current group. --}}
                        /**
                        * @to do: incorrect info
                        * If a component has a permission that doesn't exists in global config (ex: frontend editing in com_modules) by default
                        * we get "Not Allowed (Inherited)" when we should get "Not Allowed (Default)".
                        */
                        {{--  If there is an explicit permission "Not Allowed". Calculated permission is "Not Allowed". --}}
                        if ($assetRule === false)
                        {
                          $result['class'] = 'label label-important';
                          $result['text']  = \JText::_('JLIB_RULES_NOT_ALLOWED');
                        }

                        {{--  If there is an explicit permission is "Allowed". Calculated permission is "Allowed". --}}
                        elseif ($assetRule === true)
                        {
                          $result['class'] = 'label label-success';
                          $result['text']  = \JText::_('JLIB_RULES_ALLOWED');
                        }

                        {{--  Third part: Overwrite the calculated permissions labels for special cases. --}}
                        {{--  Global configuration with "Not Set" permission. Calculated permission is "Not Allowed (Default)". --}}
                        /**
                        * Component/Item with explicit "Denied" permission at parent Asset (Category, Component or Global config) configuration.
                        * Or some parent group has an explicit "Denied".
                        * Calculated permission is "Not Allowed (Locked)".
                        */
                        elseif ($inheritedGroupParentAssetRule === false || $inheritedParentGroupRule === false)
                        {
                          $result['class'] = 'label label-important';
                          $result['text']  = '<span class="icon-lock icon-white"></span>@lang('JLIB_RULES_NOT_ALLOWED_LOCKED');
                        }
                      }

                      <span class="' . $result['class'] . '">{{ $result['text'] }}</span>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        @endforeach

      </div>
    </div>

    <div class="clr"></div>
    <div class="alert">
      @if($section === 'component' || !$section)
        @lang('JLIB_RULES_SETTING_NOTES')
      @else
        @lang('JLIB_RULES_SETTING_NOTES_ITEM')
      @endif
    </div>
  </div>
</fieldset>
