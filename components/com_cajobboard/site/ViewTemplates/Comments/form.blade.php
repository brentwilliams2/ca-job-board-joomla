<?php
/**
 * Comments Edit View Template
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

  $item = $this->getItem();

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

  // create identicon avatar 64x64
  $identicon = new \Identicon\Identicon();
  $authorAvatarUri = $identicon->getImageDataUri($commentID, 32);

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

{{--
#1 - Comment Title
--}}
@section('comment_title')
{{-- link to individual comment --}}
<h4>
  <label>
    {{{ $title or @lang('COM_CAJOBBOARD_COMMENTS_TITLE_EDIT_LABEL') }}}
  </label>
</h4>
<input
  type="text"
  class="form-control"
  name="name"
  id="comment_title"
  value="{{{ $title }}}"
  placeholder="@lang('COM_CAJOBBOARD_COMMENTS_TITLE_EDIT_PLACEHOLDER')"
/>
@overwrite

{{--
#2 - Comment Text
--}}
@section('comment_text')
<div class="comment_text">
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_COMMENTS_EDIT_TEXT_LABEL')
    </label>
  </h4>
  <textarea name="text" id="comment_text" class="form-control" rows="8">
    {{{ $text or @lang('COM_CAJOBBOARD_COMMENTS_EDIT_TEXT_PLACEHOLDER') }}}
  </textarea>
</div>
@overwrite

{{--
#3 - Comment Posted Date
--}}
@section('comment_posted_date')
{{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
<span class="comment-posted-date">
  @lang('COM_CAJOBBOARD_COMMENT_POSTED_ON_BUTTON_LABEL')
  <?php echo date("d/m/Y", strtotime($createdOn)); ?>
</span>
@overwrite

{{--
#4 - Comment Last Modified Date
--}}
@section('comment_modified_date')
@if ($modifiedOn)
  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="comment-posted-date">
    @lang('COM_CAJOBBOARD_COMMENT_MODIFIED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($modifiedOn)); ?>
  </span>
@endif
@overwrite

{{--
  Responsive component
--}}
@section('comment-edit-container')
  <form action="{{{ $action }}}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">

    <div class="comment-edit-container">
      <div class="cajobboard-edit-form" id="cajobboard-comment-edit-form">

        <header class="block-header">
          <h3>
            @if($task === 'edit')
              @lang('COM_CAJOBBOARD_COMMENT_EDIT_HEADER')
            @else
              @lang('COM_CAJOBBOARD_COMMENT_ADD_HEADER')
            @endif
          </h3>
        </header>

        <div class="form-group">
          <h4>@yield('comment_title')</h4>
        </div>

        <div class="form-group">
          <p>@yield('comment_text')</p>
        </div>

        <div class="form-group">
          @yield('comment_posted_date')
        </div>

        <div class="form-group">
          @yield('comment_modified_date')
        </div>

        <button class="btn btn-primary pull-right comment-submit" type="submit">
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
