<?php
 /**
  * Answers Site Item View Template
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

  // create identicon avatar 32X32
  $identicon = new \Identicon\Identicon();
  $authorAvatarUri = $identicon->getImageDataUri($answerID, 32);
?>

{{--
  #1 - Answer Title
--}}
@section('answer_title')
  {{-- link to individual answer --}}
  <span class="answer-title">
    {{{ $title }}}
  </span>
@overwrite

{{--
  #2 - Answer Text
--}}
@section('answer_text')
  <p class="answer-text">
    <b>{{{ $text }}}</b>
  </p>
@overwrite


{{--
  #3 - Answer Author's name
--}}
@section('authors_name')
  {{-- @TODO: add user table relationship and get user name --}}
  <span class="answer-authors-name">
    Jane Q. Public
  </span>
@overwrite

{{--
  #4 - Answer Author's avatar
--}}
@section('authors_avatar')
  {{-- @TODO: Implement author avatar, need to add to user profile? --}}
  <img src="{{{ $authorAvatarUri }}}" alt="Avatar" class="img-thumbnail answer-author-avatar" height="32" width="32" />
@overwrite

{{--
  #5 - Answer Author's last seen
--}}
@section('author_last_seen')
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="author-last-seen">
    @lang('COM_CAJOBBOARD_ANSWERS_AUTHOR_LAST_SEEN_BUTTON_LABEL')
    1 week ago
  </span>
@overwrite

{{--
  #6 - Answer Posted Date
--}}
@section('answer_posted_date')
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="answer-posted-date">
    @lang('COM_CAJOBBOARD_ANSWERS_POSTED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($createdOn)); ?>
  </span>
@overwrite

{{--
  #7 - Answer Upvotes
--}}
@section('answer_upvotes')
  <button class="btn btn-primary btn-xs btn-answer answer-upvotes pull-right" type="button">
    @lang('COM_CAJOBBOARD_ANSWERS_UPVOTES_BUTTON_LABEL')
    <span class="badge">
      {{{ $upvoteCount }}}
    </span>
  </button>
@overwrite

{{--
  #8 - Answer Downvotes
--}}
@section('answer_downvotes')
  <button class="btn btn-primary btn-xs btn-answer answer-downvotes pull-right" type="button">
    @lang('COM_CAJOBBOARD_ANSWERS_DOWNVOTES_BUTTON_LABEL')
    <span class="badge">
      {{{ $downvoteCount }}}
    </span>
  </button>
@overwrite

{{--
  #9 - "Report answer" Button
--}}
@section('report_answer')
  <button type="button" class="btn btn-primary btn-xs btn-answer guest-report-answer-button pull-right" data-toggle="modal" data-target="#report-answer">
    @lang('COM_CAJOBBOARD_REPORT_ANSWERS_BUTTON_LABEL')
  </button>
@overwrite


{{--
  #10 - Edit Button for logged-in users
--}}
@section('edit_answer')
  {{-- @TODO: Fix access control on edit answer button --}}
  @if ($userId != 0)
    <a class="edit-answer-link" href="@route('index.php?option=com_cajobboard&view=answer&task=edit&id='. (int) $answerID)">
      <button type="button" class="btn btn-warning btn-xs btn-answer edit-answer-button pull-right">
        @lang('COM_CAJOBBOARD_EDIT_ANSWERS_BUTTON_LABEL')
      </button>
    </a>
  @endif
@overwrite


{{--
  Responsive container for desktop and mobile
--}}
{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}
<div class="row answer-item media">
    <h4>@yield('answer_title')</h4>
    <p>@yield('answer_text')</p>

    <div>
      @yield('answer_posted_date')
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
      @yield('edit_answer')
      @yield('report_answer')
      @yield('answer_downvotes')
      @yield('answer_upvotes')
    </div>


</div>{{-- End responsive container --}}
<div class="clearfix"></div>
