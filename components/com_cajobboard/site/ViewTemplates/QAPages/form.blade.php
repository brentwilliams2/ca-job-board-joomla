<?php
 /**
  * Question and Answer Pages Edit View Template
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
  $aboutOrganization  = $item->About->legal_name;     // The organization item question-and-answer page is about. FK to #__cajobboard_organizations
  $createdBy          = $item->created_by;            // Userid of the creator of this answer.
  $createdOn          = $item->created_on;            // Date this answer was created.
  $featured           = $item->featured;              // Whether this answer is featured or not.
  $hits               = $item->hits;                  // Number of hits this answer has received.
  $modifiedBy         = $item->modified_by;           // Userid of person that last modified this answer.
  $modifiedOn         = $item->modified_on;           // Date this answer was last modified.
  $qapageID           = $item->qapage_id;             // Surrogate primary key
  $questionID         = $item->Question->question_id; // ID of the Question this page is about
  $questionCategory   = $item->Specialty;             // A category to which item question and answer page's content applies. Join to #__cajobboard_qapage_categories
  $slug               = $item->slug;                  // Alias for SEF URL.
  $text               = $item->description;           // A long description of this question and answer page.
  $title              = $item->name;                  // A name for this question and answer page.

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

{{--
  Responsive component
--}}
@section('qapage-edit-container')
  <form action="{{{ $action }}}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">

    <div class="qapage-edit-container">
      <div class="cajobboard-edit-form" id="cajobboard-qapage-edit-form">

        <header class="block-header">
          <h3>
            @if($task === 'edit')
              @lang('COM_CAJOBBOARD_QAPAGE_EDIT_HEADER')
            @else
              @lang('COM_CAJOBBOARD_QAPAGE_ADD_HEADER')
            @endif
          </h3>
        </header>

      </div>
    </div>

    {{-- Hidden form fields --}}
    <div class="cajobboard-form-hidden-fields">
      <input type="hidden" name="@token()" value="1"/>
    </div>
  </form>
@show





{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
