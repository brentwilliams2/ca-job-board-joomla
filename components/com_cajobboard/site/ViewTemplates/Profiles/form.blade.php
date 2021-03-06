<?php
 /**
  * Profiles Site Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   July 14, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  use \Calligraphic\Cajobboard\Site\Helper\Format;
  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentCss($this);
  $this->container->AssetFiles->addViewJavascript($this);

  /** @var \Calligraphic\Cajobboard\Site\Model\Profiles $item */
  $item = $this->getItem();

  // model data fields
  $answerId       = $item->answer_id;
  $createdOn      = Format::getCreatedOnText($item->created_on);
  $modifiedOn     = Format::getCreatedOnText($item->modified_on);

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $componentName = $this->getContainer()->componentName;
  $view = $this->getName();

  $action  = 'index.php?option=' . $componentName . '&view=' . $view;

  if ('edit' == $task)
  {
    $action = '&task=save&id=' . $answerId;
  }
  elseif ('add' == $task)
  {
    $action .= '&task=save';
  }

  $removeAction = 'index.php?option=' . $componentName . '&view=' . $view . '&task=remove&id=' . $answerId;

  /*
    Limit access to personally identifiable information:

    @if ($this->getContainer()->platform->getUser()->authorise('com_cajobboard.pii', 'com_cajobboard'))
      protected content
    @endif
   */
?>

{{--
#1 - Answer Title
--}}
@section('answer_title')
  <div class="answer_title">
    {{-- link to individual answer --}}
    <h4>
      <label for="name">
        @lang('COM_CAJOBBOARD_ANSWERS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    <input
      type="text"
      class="form-control"
      name="name"
      id="answer-title-input"
      value="{{{ $title }}}"
      placeholder="<?php echo $this->escape(isset($title) ? $title : null); ?>"
    />
  </div>
@overwrite

{{--
#2 - Answer Text
--}}
@section('answer_text')
  <div class="answer_text">
    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_ANSWERS_EDIT_TEXT_LABEL')
      </label>
    </h4>

    <textarea name="text" id="answer-text" class="form-control" rows="8"><?php echo $text ?></textarea>{{-- no whitespace in textarea --}}
  </div>
@overwrite

{{--
#3 - Answer Posted Date
--}}
@section('answer_posted_date')
  <span class="answer-posted-date">
    @lang('COM_CAJOBBOARD_ANSWERS_POSTED_ON_BUTTON_LABEL')
    {{ $createdOn }}
  </span>
@overwrite

{{--
#4 - Answer Last Modified Date
--}}
@section('answer_modified_date')
  @if ($modifiedOn)
    <span class="answer-modified-date">
      @lang('COM_CAJOBBOARD_ANSWERS_MODIFIED_ON_BUTTON_LABEL')
      {{ $modifiedOn }}
    </span>
  @endif
@overwrite

{{--
  Responsive component
--}}
@section('answer-edit-container')
  <form action="@route($action)" method="post" name="siteForm" id="siteForm" class="cajobboard-form">
    <div class="answer-edit-container">

      <header class="form-header">
        <h3>
          @if($task === 'edit')
            @lang('COM_CAJOBBOARD_ANSWERS_EDIT_HEADER')
          @else
            @lang('COM_CAJOBBOARD_ANSWERS_ADD_HEADER')
          @endif
        </h3>
      </header>

      <div class="form-group">
        <h4>@yield('answer_title')</h4>
      </div>

      <div class="form-group">
        <p>@yield('answer_text')</p>
      </div>

      @if ('edit' == $task)

        <div class="form-group">
          @yield('answer_posted_date')
        </div>

        <div class="form-group">
          @yield('answer_modified_date')
        </div>

      <a class="delete-answer-link" onClick="removeSubmit( {{ $answerId }} )">
          <button type="button" class="btn btn-danger btn-primary btn-answer delete-answer-button pull-right">
            @lang('COM_CAJOBBOARD_DELETE_ANSWERS_BUTTON_LABEL')
          </button>
        </a>

      @endif

      <button class="btn btn-primary answer-submit pull-right" type="submit">
        @lang('JAPPLY')
      </button>

    </div>

    {{-- Hidden form fields --}}
    <div class="cajobboard-form-hidden-fields">
      <input type="hidden" name="@token()" value="1"/>
    </div>
  </form>

   {{-- Form with CSRF field for remove action --}}
  <form action="@route($removeAction)" method="post" name="removeForm" id="removeForm-{{ $answerId }}">
    <input type="hidden" name="@token()" value="1"/>
  </form>

@show

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
