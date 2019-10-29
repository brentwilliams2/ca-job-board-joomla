<?php
 /**
  * Site Answers List View Item Template
  *
  * @package   Calligraphic Job Board
  * @version   September 12, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  // no direct access
  defined('_JEXEC') or die;

  /** @var \Calligraphic\Cajobboard\Site\Model\Answers  $item */
  /** @var  FOF30\View\DataView\Html                    $this */

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.php');

  // The name of the crud view
  $crud = 'browse';
?>

{{--
  Responsive container for desktop and mobile
--}}
<div class="row media {{ $featured }} @jhtml('helper.commonwidgets.getAttributeClass', 'list-item', $prefix, $crud)">
  @jhtml('helper.browsewidgets.title', $title, $itemViewLink, $prefix, $crud)

  @jhtml('helper.browsewidgets.text', $text, $prefix, $crud)

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
    @jhtml('helper.buttonwidgets.delete', $humanViewNameSingular, $canUserEdit, $itemId, $prefix, $crud)
    @jhtml('helper.buttonwidgets.edit', $humanViewNameSingular, $canUserEdit, $editViewLink, $prefix, $crud)
    @jhtml('helper.buttonwidgets.report', $humanViewNameSingular, $prefix, $crud)
    @jhtml('helper.buttonwidgets.downvote_count', $downvoteCount, $isGuestUser, $itemId, $prefix, $crud)
    @jhtml('helper.buttonwidgets.upvote_count', $upvoteCount, $isGuestUser, $itemId, $prefix, $crud)
  </div>
</div>{{-- End responsive container --}}

{{-- Forms with CSRF field for actions --}}
@jhtml('helper.buttonwidgets.deleteActionCsrfField', $deleteAction, $itemId)
@jhtml('helper.buttonwidgets.downvoteActionCsrfField', $downvoteAction, $itemId)
@jhtml('helper.buttonwidgets.upvoteActionCsrfField', $upvoteAction, $itemId)

<div class="clearfix"></div>
