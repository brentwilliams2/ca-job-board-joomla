<?php
/**
 * Site Audio Objects Item View Template
 *
 * @package   Calligraphic Job Board
 * @version   October 21, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

   // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html                          $this */
  /** @var \Calligraphic\Cajobboard\Site\Model\AudioObjects   $item */
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

  @jhtml('helper.itemwidgets.title', $title, $prefix, $crud)

  @jhtml('helper.commonwidgets.description', $description, $prefix, $crud)

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
  </div>
</div>{{-- End responsive container --}}

{{-- Forms with CSRF field for actions --}}
@jhtml('helper.buttonwidgets.deleteActionCsrfField', $deleteAction, $itemId)

<div class="clearfix"></div>
