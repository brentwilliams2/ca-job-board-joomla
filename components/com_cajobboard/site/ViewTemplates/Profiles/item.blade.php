<?php
 /**
  * Profiles Site Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  use \Calligraphic\Cajobboard\Site\Helper\User;
  use \Calligraphic\Cajobboard\Site\Helper\Format;

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentCss($this);
  $this->container->AssetFiles->addViewJavascript($this);

  /** @var \Calligraphic\Cajobboard\Site\Model\Profiles $item */
  $item = $this->getItem();

  // model data fields
  $answerId       = $item->getFieldValue('answer_id');

  $userId = $this->container->platform->getUser()->id;
  $authorId = $item->Author->getId();

  $authorAvatarUri = $this->container->User::getAvatar($authorId);
  $authorProfileLink = $this->container->User->getLinkToUserProfile($authorId);
  $canUserEdit = $this->container->User->canEdit($item);
  $lastSeen = $this->container->User->lastSeen($item->Author->lastvisitDate);
  $name = $item->Author->getFieldValue('name');
  $postedOn = Format::getCreatedOnText($createdOn);

  $componentName = $this->getContainer()->componentName;
  $view = $this->getName();
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
  {{-- link to individual answer --}}
  <span class="answer-title">
    {{{ $title }}}
  </span>
@overwrite

{{--
  #2 - Answer Text
--}}
@section('answer_text')
  <span class="answer-text">
    {{{ $text }}}
  </span>
@overwrite

{{--
  #3 - Answer Author's avatar
--}}
@section('authors_avatar')
  <a href="{{ $authorProfileLink }}" class="author-avatar">
    <img src="{{{ $authorAvatarUri }}}" alt="Avatar" class="img-thumbnail" height="24" width="24">
  </a>
@overwrite

{{--
  #4 - Answer Author's name
--}}
@section('authors_name')
  <a href="{{ $authorProfileLink }}" class="author-name">
    {{{ $name }}}
  </a>
@overwrite

{{--
  #5 - Answer Author's last seen
--}}
@section('author_last_seen')
  <span class="author-last-seen">
      {{ $lastSeen }}
  </span>
@overwrite

{{--
  #6 - Answer Posted Date
--}}
@section('answer_posted_date')
  <span class="answer-posted-date">
    @lang('COM_CAJOBBOARD_ANSWERS_POSTED_ON_BUTTON_LABEL')
    {{ $postedOn }}
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
  <button type="button" class="btn btn-primary btn-xs btn-answer report-answer pull-right" data-toggle="modal" data-target="#report-answer">
    @lang('COM_CAJOBBOARD_REPORT_ANSWERS_BUTTON_LABEL')
  </button>
@overwrite


{{--
  #10 - Edit Button for logged-in users
--}}
@section('edit_answer')
  @if ($canUserEdit)

    <a class="delete-answer-link" onClick="removeSubmit( {{ $answerId }} )">
      <button type="button" class="btn btn-danger btn-xs btn-answer delete-answer-button pull-right">
        @lang('COM_CAJOBBOARD_DELETE_ANSWERS_BUTTON_LABEL')
      </button>
    </a>

    <a class="edit-answer-link" href="@route('index.php?option=com_cajobboard&view=answer&task=edit&id='. (int) $answerId)">
      <button type="button" class="btn btn-warning btn-xs btn-answer edit-answer-button pull-right">
        @lang('COM_CAJOBBOARD_EDIT_ANSWERS_BUTTON_LABEL')
      </button>
    </a>

  @endif
@overwrite


{{--
  Responsive container for desktop and mobile
--}}
<div class="row answer-item media <?php echo ($featured) ? 'featured' : ''; ?>">
    <h4>@yield('answer_title')</h4>
    <p>@yield('answer_text')</p>

    <div>
      @yield('answer_posted_date')
    </div>

    <div class="clearfix"></div>

    <div>
      @yield('authors_avatar')
      @yield('authors_name')
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

{{-- Form with CSRF field for remove action --}}
<form action="@route($removeAction)" method="post" name="removeForm" id="removeForm-{{ $answerId }}">
  <input type="hidden" name="@token()" value="1"/>
</form>

<div class="clearfix"></div>

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
