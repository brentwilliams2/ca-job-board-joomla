<?php
 /**
  * Answers Site Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   September 12, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

   // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html                    $this */
  /** @var \Calligraphic\Cajobboard\Site\Model\Answers  $item */
  $item = $this->getItem();

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.blade.php');

  // The name of the crud view
   $crud = 'item';
?>

@include('site:com_cajobboard/Common/Modal/report_item_modal')

{{--
  Responsive container for desktop and mobile
--}}
<div class="row media {{ $featured }} @jhtml('helper.commonwidgets.getAttributeClass', 'item', $prefix, $crud)">

  @jhtml('helper.commonwidgets.title', $title, $itemViewLink, $prefix, $crud)

  @jhtml('helper.commonwidgets.text', $text, $prefix, $crud)

  <div>
    @jhtml('helper.commonwidgets.createdOn', $createdOn, $prefix, $crud)
  </div>

  <div class="clearfix"></div>

  <div>
    @jhtml('helper.commonwidgets.authorAvatar', $author, $prefix, $crud)

    @jhtml('helper.commonwidgets.authorName', $author, $prefix, $crud)

    @jhtml('helper.commonwidgets.authorLastSeen', $author, $prefix, $crud)
  </div>

  <div class="clearfix"></div>

  <div>
    @jhtml('helper.commonwidgets.delete', $humanViewNameSingular, $canUserEdit, $itemId, $prefix, $crud)
    @jhtml('helper.commonwidgets.edit', $humanViewNameSingular, $canUserEdit, $editViewLink, $prefix, $crud)
    @jhtml('helper.commonwidgets.report', $humanViewNameSingular, $prefix, $crud)
    @jhtml('helper.commonwidgets.downvotes', $downvoteCount, $downvoteLink, $prefix, $crud)
    @jhtml('helper.commonwidgets.upvotes', $upvoteCount, $upvoteLink, $prefix, $crud)
  </div>
</div>{{-- End responsive container --}}

{{-- Form with CSRF field for remove action --}}
@jhtml('helper.commonwidgets.removeActionCsrfField', $removeAction, $itemId)

<div class="clearfix"></div>
