<?php
 /**
  * Reviews Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes

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
?>

{{--
  #1 - Question Title
--}}
@section('question_title')
  {{-- link to individual question --}}
  <a class="question-title" href="@route('index.php?option=com_cajobboard&view=question&task=read&id='. (int) $questionID)">
    {{{ $title }}}
  </a>
@overwrite

{{--
  #2 - Question Text
--}}
@section('question_text')
  <p class="question-text">
    <a class="question-text-link" href="@route('index.php?option=com_cajobboard&view=question&task=read&id='. (int) $questionID)">
      <b>{{{ $text }}}</b>
    </a>
  </p>
@overwrite


{{--
  #3 - Question Author's name
--}}
@section('authors_name')
  {{-- @TODO: add user table relationship and get user name --}}
  <span class="question-authors-name">
    Jane Q. Public
  </span>
@overwrite

{{--
  #4 - Question Author's avatar
--}}
@section('authors_avatar')
  {{-- @TODO: Implement author avatar, need to add to user profile? --}}
  <img src="{{{ $authorAvatarUri }}}" alt="Avatar" class="img-thumbnail question-author-avatar" height="24" width="24" />
@overwrite

{{--
  #5 - Question Author's last seen
--}}
@section('author_last_seen')
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="author-last-seen">
    @lang('COM_CAJOBBOARD_QUESTIONS_AUTHOR_LAST_SEEN_BUTTON_LABEL')
    1 week ago
  </span>
@overwrite

{{--
  #6 - Question Posted Date
--}}
@section('question_posted_date')
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="question-posted-date">
    @lang('COM_CAJOBBOARD_QUESTIONS_POSTED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($createdOn)); ?>
  </span>
@overwrite

{{--
  #7 - Question Upvotes
--}}
@section('question_upvotes')
  <button class="btn btn-primary btn-xs btn-question question-upvotes pull-right" type="button">
    @lang('COM_CAJOBBOARD_QUESTIONS_UPVOTES_BUTTON_LABEL')
    <span class="badge">
      {{{ $upvoteCount }}}
    </span>
  </button>
@overwrite

{{--
  #8 - Question Downvotes
--}}
@section('question_downvotes')
  <button class="btn btn-primary btn-xs btn-question question-downvotes pull-right" type="button">
    @lang('COM_CAJOBBOARD_QUESTIONS_DOWNVOTES_BUTTON_LABEL')
    <span class="badge">
      {{{ $downvoteCount }}}
    </span>
  </button>
@overwrite

{{--
  #9 - "Report Question" Button
--}}
@section('report_question')
  <button type="button" class="btn btn-primary btn-xs btn-question guest-report-question-button pull-right" data-toggle="modal" data-target="#report-question">
    @lang('COM_CAJOBBOARD_REPORT_QUESTIONS_BUTTON_LABEL')
  </button>
@overwrite


{{--
  #10 - Edit Button for logged-in users
--}}
@section('edit_question')
  {{-- @TODO: Fix access control on edit question button --}}
  @if ($userId != 0)
    <a class="edit-question-link" href="@route('index.php?option=com_cajobboard&view=question&task=edit&id='. (int) $questionID)">
      <button type="button" class="btn btn-warning btn-xs btn-question edit-question-button pull-right">
        @lang('COM_CAJOBBOARD_EDIT_QUESTIONS_BUTTON_LABEL')
      </button>
    </a>
  @endif
@overwrite

{{--
  Responsive container for desktop and mobile
--}}
{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}
<div class="row question-list-item media">
    <h4>@yield('question_title')</h4>
    <p>@yield('question_text')</p>

    <div>
      @yield('question_posted_date')
    </div>

    <div class="clearfix"></div>

    <div>
      <a href="#">
        @yield('authors_avatar')
      </a>
      <a href="#">
        @yield('authors_name')
      </a>
      @yield('author_last_seen')
    </div>

    <div class="clearfix"></div>

    <div>
      @yield('edit_question')
      @yield('report_question')
      @yield('question_downvotes')
      @yield('question_upvotes')
    </div>

</div>{{-- End responsive container --}}
<div class="clearfix"></div>

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
