<?php
 /**
  * Answers Site Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // model data fields
  $answerID       = $item->answer_id;
  $created_by     = $item->created_by;      // userid of the creator of this answer.
  $createdOn      = $item->created_on;
  $description    = $item->description;     // Text of the answer.
  $downvoteCount  = $item->downvote_count;  // Downvote count for this item.
  $featured       = $item->featured;        // bool whether this answer is featured or not
  $hits           = $item->hits;            // Number of hits this answer has received
  $isPartOf       = $item->isPartOf;        // This property points to a QAPage entity associated with this answer. FK to #__cajobboard_qapage(qapage_id)
  $modifiedBy     = $item->modified_by;     // userid of person that modified this answer.
  $modifiedOn     = $item->modified_on;
  $title          = $item->name;            // A title to use for the answer.
  $parentItem     = $item->parentItem;      // The question this answer is intended for. FK to #__cajobboard_questionss(question_id)
  $Publisher      = $item->Publisher;       // The company that wrote this answer. FK to #__organizations(organization)id).
  $slug           = $item->slug;            // Alias for SEF URL
  $text           = $item->text;            // The actual text of the answer itself.
  $upvoteCount    = $item->upvote_count;    // Upvote count for this item.

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

{{--
#1 - Answer Title
--}}
@section('answer_title')
{{-- link to individual answer --}}
<h4>
  <label>
    @lang('COM_CAJOBBOARD_ANSWERS_TITLE_EDIT_LABEL')
  </label>
</h4>
<input
  type="text"
  class="form-control"
  name="name"
  id="answer_title"
  value="{{{ $title }}}"
  placeholder="<?php echo $this->escape(isset($title) ? $title : \JText::_('COM_CAJOBBOARD_ANSWERS_TITLE_EDIT_PLACEHOLDER')); ?>"
/>
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
  <textarea name="text" id="answer_text" class="form-control" rows="8">
    <?php echo $this->escape(isset($text) ? $text : \JText::_('COM_CAJOBBOARD_ANSWERS_EDIT_TEXT_PLACEHOLDER')); ?>
  </textarea>
</div>
@overwrite

{{--
#3 - Answer Posted Date
--}}
@section('answer_posted_date')
{{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
<span class="answer-posted-date">
  @lang('COM_CAJOBBOARD_ANSWERS_POSTED_ON_BUTTON_LABEL')
  <?php echo date("d/m/Y", strtotime($createdOn)); ?>
</span>
@overwrite

{{--
#4 - Answer Last Modified Date
--}}
@section('answer_modified_date')
@if ($modifiedOn)
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="answer-posted-date">
    @lang('COM_CAJOBBOARD_ANSWERS_MODIFIED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($modifiedOn)); ?>
  </span>
@endif
@overwrite

{{--
  Responsive component
--}}
@section('answer-edit-container')
  <form action="{{{ $action }}}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">

    <div class="answer-edit-container">
      <div class="cajobboard-edit-form" id="cajobboard-answer-edit-form">

        <header class="block-header">
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

        <div class="form-group">
          @yield('answer_posted_date')
        </div>

        <div class="form-group">
          @yield('answer_modified_date')
        </div>

        <button class="btn btn-primary pull-right answer-submit" type="submit">
          @lang('COM_CAJOBBOARD_SUBMIT_BUTTON_LABEL')
        </button>

      </div>
    </div>

    {{-- Hidden form fields --}}
    <div class="cajobboard-form-hidden-fields">
      <input type="hidden" name="@token()" value="1"/>
    </div>
  </form>
@show
