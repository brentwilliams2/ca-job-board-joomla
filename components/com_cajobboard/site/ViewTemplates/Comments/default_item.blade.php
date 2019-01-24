<?php
 /**
  * Comments List View Item Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Identicon avatar generator
  use Identicon\Identicon;

  // no direct access
  defined('_JEXEC') or die;

  // model data fields
  $aboutForeignId         = $item->about__id;       //  The entity id in the foreign model this comment refers to.
  $aboutForeignModelName  = $item->about__model;    // The model name this comment refers to.
  $commentID              = $item->comment_id;
  $createdBy              = $item->created_by;      // userid of the creator of this comment.
  $createdOn              = $item->created_on;
  $description            = $item->description;     // A short description of this comment.
  $downvoteCount          = $item->downvote_count;  // The number of downvotes this comment has received from the community.
  $featured               = $item->featured;        // bool whether this comment is featured or not
  $hits                   = $item->hits;            // Number of hits this comment has received
  $modifiedBy             = $item->modified_by;     // userid of person that modified this comment.
  $modifiedOn             = $item->modified_on;
  $title                  = $item->name;            //  A title for this comment.
  $parentItem             = $item->parent_item;     // The comment this comment is a child of, or zero if a top-level comment. FK to #__cajobboard_comments
  $slug                   = $item->slug;            // Alias for SEF URL
  $text                   = $item->text;            // The full text of this comment.
  $upvoteCount            = $item->upvote_count;    // The number of upvotes this comment has received from the community.

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // create identicon avatar 64x64
  $identicon = new \Identicon\Identicon();
  $authorAvatarUri = $identicon->getImageDataUri($commentID, 32);
?>

{{--
  #1 - Comment Title
--}}
@section('comment_title')
  {{-- link to individual comment --}}
  <a class="comment-title" href="@route('index.php?option=com_cajobboard&view=Comment&task=read&id='. (int) $commentID)">
    {{{ $title }}}
  </a>
@overwrite

{{--
  #2 - Comment Text
--}}
@section('comment_text')
  <p class="comment-text">
    <a class="comment-text-link" href="@route('index.php?option=com_cajobboard&view=Comment&task=read&id='. (int) $commentID)">
      <b>{{{ $text }}}</b>
    </a>
  </p>
@overwrite

{{--
  #3 - Comment Author's name
--}}
@section('authors_name')
  {{-- @TODO: add user table relationship and get user name --}}
  <span class="comment-authors-name">
    Jane Q. Public
  </span>
@overwrite

{{--
  #4 - Comment Author's avatar
--}}
@section('authors_avatar')
  {{-- @TODO: Implement author avatar, need to add to user profile? --}}
  <img src="{{{ $authorAvatarUri }}}" alt="Avatar" class="img-thumbnail comment-author-avatar" height="32" width="32" />
@overwrite

{{--
  #5 - Comment Author's last seen
--}}
@section('author_last_seen')
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="author-last-seen">
    <div>@lang('COM_CAJOBBOARD_COMMENTS_AUTHOR_LAST_SEEN_BUTTON_LABEL')</div>
    <div>1 week ago</div>
  </span>
@overwrite

{{--
  #6 - Comment Posted Date
--}}
@section('comment_posted_date')
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="comment-posted-date">
    @lang('COM_CAJOBBOARD_COMMENTS_POSTED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($createdOn)); ?>
  </span>
@overwrite

{{--
  #7 - Comment Upvotes
--}}
@section('comment_upvotes')
  <button class="btn btn-primary btn-xs btn-comment comment-upvotes pull-right" type="button">
    @lang('COM_CAJOBBOARD_COMMENTS_UPVOTES_BUTTON_LABEL')
    <span class="badge">
      {{{ $upvoteCount }}}
    </span>
  </button>
@overwrite

{{--
  #8 - Comment Downvotes
--}}
@section('comment_downvotes')
  <button class="btn btn-primary btn-xs btn-comment comment-downvotes pull-right" type="button">
    @lang('COM_CAJOBBOARD_COMMENTS_DOWNVOTES_BUTTON_LABEL')
    <span class="badge">
      {{{ $downvoteCount }}}
    </span>
  </button>
@overwrite

{{--
  #9 - "Report Comment" Button
--}}
@section('report_comment')
  <button type="button" class="btn btn-primary btn-xs btn-comment guest-report-comment-button pull-right" data-toggle="modal" data-target="#report-comment">
    @lang('COM_CAJOBBOARD_REPORT_COMMENTS_BUTTON_LABEL')
  </button>
@overwrite


{{--
  #10 - Edit Button for logged-in users
--}}
@section('edit_comment')
  {{-- @TODO: Fix access control on edit comment button --}}
  @if ($userId != 0)
    <a class="edit-comment-link" href="@route('index.php?option=com_cajobboard&view=Comment&task=edit&id='. (int) $commentID)">
      <button type="button" class="btn btn-warning btn-xs btn-comment edit-comment-button pull-right">
        @lang('COM_CAJOBBOARD_EDIT_COMMENTS_BUTTON_LABEL')
      </button>
    </a>
  @endif
@overwrite


{{--
  Responsive container for desktop and mobile
--}}
{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}
<div class="row comment-list-item media">
    <div class="col-xs-4 col-md-3">
      <a href="#">
        @yield('authors_avatar')
      </a>
      <a href="#">
        @yield('authors_name')
      </a>
      @yield('author_last_seen')
    </div>

    <div class="col-xs-8 col-md-9">
      <h4>@yield('comment_title')</h4>
      <p>@yield('comment_text')</p>

      <div>
        @yield('comment_posted_date')
      </div>

      <div class="clearfix"></div>

      <div>
        @yield('edit_comment')
        @yield('report_comment')
        @yield('comment_downvotes')
        @yield('comment_upvotes')
      </div>
    </div>
</div>{{-- End responsive container --}}
<div class="clearfix"></div>
