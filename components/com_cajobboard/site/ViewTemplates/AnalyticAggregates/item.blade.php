<?php
 /**
  * Site Analytic Aggregates Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   September 12, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

   // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html                                $this */
  /** @var \Calligraphic\Cajobboard\Site\Model\AnalyticAggregates   $item */
  $item = $this->getItem();

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.php');

  // The name of the crud view
   $crud = 'item';
?>

@include('site:com_cajobboard/Common/Modal/report_item_modal')

{{--
  Responsive container for desktop and mobile
--}}
<div class="row media @jhtml('helper.commonwidgets.getAttributeClass', 'item', $prefix, $crud)">

  @jhtml('helper.itemwidgets.title', $title, $prefix, $crud)

  @jhtml('helper.commonwidgets.description', $description, $prefix, $crud)

  <div>
    @jhtml('helper.commonwidgets.createdOn', $createdOn, $prefix, $crud)
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

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
