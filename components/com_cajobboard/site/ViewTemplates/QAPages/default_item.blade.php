<?php
 /**
  * Question and Answer Pages List View Item Template
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
  $questionTitle      = $item->Question->text;       // Title of the question this page is about
  $questionCategory   = $item->Specialty;             // A category to which item question and answer page's content applies. Join to #__cajobboard_qapage_categories
  $slug               = $item->slug;                  // Alias for SEF URL.
  $text               = $item->description;           // A long description of this question and answer page.
  $title              = $item->name;                  // A name for this question and answer page.

  // current user ID
  $userId = $this->container->platform->getUser()->id;
?>

{{--
  #1 - Question
--}}
@section('question')
  {{-- link to question --}}
  <a class="media-object question" href="@route('index.php?option=com_cajobboard&view=QAPage&task=read&id='. (int) $qapageID)">
    {{{ $questionTitle }}}
  </a>
@overwrite

{{--
  Responsive container for desktop and mobile
--}}
<div class="review-list-item">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}
  <div>
    <h4>@yield('question')</h4>
  </div>{{-- End main container --}}
  <div class="clearfix"></div>
</div>{{-- End responsive container --}}
