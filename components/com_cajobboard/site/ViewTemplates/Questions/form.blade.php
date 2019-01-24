<?php
 /**
  * Reviews Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  JLog::add('in form.blade.php', JLog::DEBUG, 'cajobboard');

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // model data fields
  $acceptedAnswer = $item->acceptedAnswer;  // Use acceptedAnswer for the best answer to a question.  FK to #__cajobboard_answers(answer_id)
  $questionID     = $item->question_id;
  $created_by     = $item->created_by;      // userid of the creator of this question.
  $createdOn      = $item->created_on;
  $description    = $item->description;     // Text of the question.
  $downvoteCount  = $item->downvote_count;  // Downvote count for this item.
  $featured       = $item->featured;        // bool whether this question is featured or not
  $hits           = $item->hits;            // Number of hits this question has received
  $isPartOf       = $item->isPartOf;        // This property points to a QAPage entity associated with this question. FK to #__cajobboard_qapage(qapage_id)
  $modifiedBy     = $item->modified_by;     // userid of person that modified this question.
  $modifiedOn     = $item->modified_on;
  $title          = $item->name;            // A title to use for the question.
  $parentItem     = $item->parentItem;      // The question this question is intended for. FK to #__cajobboard_questionss(question_id)
  $Publisher      = $item->Publisher;       // The company that wrote this question. FK to #__organizations(organization)id).
  $slug           = $item->slug;            // Alias for SEF URL
  $text           = $item->text;            // The actual text of the question itself.
  $upvoteCount    = $item->upvote_count;    // Upvote count for this item.

  // current user ID
  $userId = $this->container->platform->getUser()->id;

    // create identicon avatar 24X24
  $identicon = new \Identicon\Identicon();
  $authorAvatarUri = $identicon->getImageDataUri($questionID, 24);

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

{{--
#1 - Question Title
--}}
@section('question_title')
{{-- link to individual question --}}
<h4>
  <label>
    @lang('COM_CAJOBBOARD_QUESTIONS_TITLE_EDIT_LABEL')
  </label>
</h4>
<input
  type="text"
  class="form-control"
  name="name"
  id="question_title"
  value="{{{ $title }}}"
  placeholder="<?php echo $this->escape(isset($title) ? $title : \JText::_('COM_CAJOBBOARD_QUESTIONS_TITLE_EDIT_PLACEHOLDER')); ?>"
/>
@overwrite

{{--
#2 - Question Text
--}}
@section('question_text')
<div class="question_text">
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_QUESTIONS_EDIT_TEXT_LABEL')
    </label>
  </h4>
  <textarea name="text" id="question_text" class="form-control" rows="8">
    <?php echo $this->escape(isset($text) ? $text : \JText::_('COM_CAJOBBOARD_QUESTIONS_EDIT_TEXT_PLACEHOLDER')); ?>
  </textarea>
</div>
@overwrite

{{--
#3 - Question Posted Date
--}}
@section('question_posted_date')
{{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
<span class="question-posted-date">
  @lang('COM_CAJOBBOARD_QUESTIONS_POSTED_ON_BUTTON_LABEL')
  <?php echo date("d/m/Y", strtotime($createdOn)); ?>
</span>
@overwrite

{{--
#4 - Question Last Modified Date
--}}
@section('question_modified_date')
@if ($modifiedOn)
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="question-posted-date">
    @lang('COM_CAJOBBOARD_QUESTIONS_MODIFIED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($modifiedOn)); ?>
  </span>
@endif
@overwrite

{{--
  Responsive component
--}}
@section('question-edit-container')
  <form action="{{{ $action }}}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">

    <div class="question-edit-container">
      <div class="cajobboard-edit-form" id="cajobboard-question-edit-form">

        <header class="block-header">
          <h3>
            @if($task === 'edit')
              @lang('COM_CAJOBBOARD_QUESTIONS_EDIT_HEADER')
            @else
              @lang('COM_CAJOBBOARD_QUESTIONS_ADD_HEADER')
            @endif
          </h3>
        </header>

        <div class="form-group">
          <h4>@yield('question_title')</h4>
        </div>

        <div class="form-group">
          <p>@yield('question_text')</p>
        </div>

        <div class="form-group">
          @yield('question_posted_date')
        </div>

        <div class="form-group">
          @yield('question_modified_date')
        </div>

        <button class="btn btn-primary pull-right question-submit" type="submit">
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