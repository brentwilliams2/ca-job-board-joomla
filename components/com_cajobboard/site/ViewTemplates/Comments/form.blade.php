<?php
 /**
  * Comments Site Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   September 12, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html                      $this */
  /** @var \Calligraphic\Cajobboard\Site\Model\Comments   $item */
  $item = $this->getItem();

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.blade.php');

  // The name of the crud view
  $crud = 'edit';

  $isEditView = ('edit' == $task);
?>

{{--
  Responsive component
--}}
@section('answer-edit-container')
  <form action="{{ $postAction }}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">
    <div class="@jhtml('helper.editwidgets.getAttributeClass', 'edit-container', $prefix, $crud)">

      <header class="form-header well">
        @jhtml('helper.editwidgets.header', $isEditView, $humanViewNameSingular, $prefix, $crud)
      </header>

      <div class="form-group">
        @jhtml('helper.editwidgets.title', $title, $titlePlaceholder, $humanViewNameSingular, $prefix, $crud)
      </div>

      <div class="form-group">
        @jhtml('helper.editwidgets.description', $description, $descriptionPlaceholder, $humanViewNameSingular, $prefix, $crud)
      </div>

      @if ($isEditView)
        <div class="form-group">
          @jhtml('helper.editwidgets.createdOn', $createdOn, $prefix, $crud)
        </div>

        @if ( isset($modifiedOn) )
          <div class="form-group">
            @jhtml('helper.editwidgets.modifiedOn', $modifiedOn, $prefix, $crud)
          </div>
        @endif
      @endif

      @jhtml('helper.editwidgets.submit', $prefix, $crud)

      @if ($isEditView)
        @jhtml('helper.editwidgets.delete', $canUserEdit, $itemId, $humanViewNameSingular, $prefix, $crud)
      @endif

      @jhtml('helper.editwidgets.cancel', $itemViewLink, $prefix, $crud)
    </div>

    {{-- Hidden CSRF form field --}}
    @jhtml('helper.editwidgets.hiddenCsrfField')
  </form>

  {{-- Form with CSRF field for remove action --}}
  @if ($isEditView)
    @jhtml('helper.commonwidgets.removeActionCsrfField', $removeAction, $itemId)
  @endif
@show
