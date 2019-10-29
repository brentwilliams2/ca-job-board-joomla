<?php
 /**
  * Site Email Messages Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Language\Text;

  /** @var  FOF30\View\DataView\Html                          $this */
  /** @var \Calligraphic\Cajobboard\Site\Model\EmailMessages  $item */
  $item = $this->getItem();

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.php');

  // The name of the crud view
  $crud = 'item';

  $isEditView = ('edit' == $task);

  // Maybe need a dummy record for each of the types to show in the editor, so you get a good preview of what it will look like
  // this is to edit email templates

  /*
  Your [LEVEL] subscription at [SITENAME] is now enabled

  @TODO: Use PHP_EOL for line breaks - local MTAs will convert \r\n to \r\r\n
        Above is true for optional additional_headers and mail()'s $subject. Escaped
        characters have to be in double quotes. Set mail() to HTML type

  <div style=\"background-color: #e0e0e0; padding: 10px 20px;\">
    <div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">
      <p>Hello [FIRSTNAME],</p>
      <p>The payment for your [LEVEL] subscription on our site has just been cleared. Your subscription is now activated and will remain active until [PUBLISH_DOWN].</p>
      <p><span style=\"line-height: 1.3em;\">We\'d like to remind you that you have registered on our site using the username [USERNAME] and email address [USEREMAIL].</span></p>
      <p>You can <a href=\"[MYSUBSURL]\">review the status of all your subscriptions</a> any time on our site.</p>
    </div>
    <p style=\"font-size: x-small; color: #667;\">
      You are receiving this automatic email message because you have a subscription in <em>[SITENAME]</em>.
      <span style=\"line-height: 1.3em;\">Do not reply to this email, it\'s sent from an unmonitored email address.</span>
    </p>
  </div>'
  */
?>

{{--
Responsive component
--}}
@section('email-message-edit-container')
  <form action="{{ $postAction }}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">
    <div class="row media @jhtml('helper.commonwidgets.getAttributeClass', 'container', $prefix, $crud)">

      <header class="form-header well @jhtml('helper.commonwidgets.getAttributeClass', 'header', $prefix, $crud)">
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

      @jhtml('helper.buttonwidgets.submit', $prefix, $crud)

      @if ($isEditView)
        @jhtml('helper.buttonwidgets.delete', $humanViewNameSingular, $canUserEdit, $itemId, $prefix, $crud, false)
      @endif

      @jhtml('helper.buttonwidgets.cancel', $browseViewLink, $prefix, $crud)
    </div>

    {{-- Hidden CSRF form field --}}
    @jhtml('helper.buttonwidgets.hiddenCsrfField')
  </form>

  {{-- Form with CSRF field for delete action --}}
  @if ($isEditView)
    @jhtml('helper.buttonwidgets.deleteActionCsrfField', $deleteAction, $itemId)
  @endif
@show

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
