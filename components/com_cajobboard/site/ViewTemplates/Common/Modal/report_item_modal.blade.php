<?php
 /**
  * Site Report Issue on Item Modal Views Template
  *
  * @package   Calligraphic Job Board
  * @version   October 4, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  // get component configuration
  $params = $this->getContainer()->params;

  // admin parameters for links
  $terms_of_service = $this->getContainer()->template->route('index.php?Itemid=' . $params->getComponentConfigOption('terms_of_use'));

  $singularizedViewName = $this->getContainer()->inflector->singularize( $this->getName() );
  $humanizedViewName = strtolower( $this->getContainer()->inflector->humanize($singularizedViewName) );
?>

{{--
  Singleton issue report modal for abusive content reports - Javascript links a singleton modal into all buttons
--}}
@section('report-item-modal')
<div class="modal fade report-item-modal" id="report-item-modal" tabindex="-1" role="dialog" aria-labelledby="reportItemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        {{-- button with an "X" to close the modal, top right-hand corner --}}
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="reportItemModalLabel">
            @sprintf('COM_CAJOBBOARD_REPORT_ITEM_HEADER_DESC', $humanizedViewName, $terms_of_service)
        </h4>
      </div>

      <div class="modal-body">
        <form id="report-item-form">
          {{-- "Describe the problem" and text input form element --}}
          <div id="report-item" class="form-group">
            <label for="report-item-text-box" class="control-label">
              @lang('COM_CAJOBBOARD_REPORT_ITEM_USER_EMAIL_INPUT_BOX_LABEL')
            </label>
            <textarea class="form-control" id="report-item-text-box">
                @sprintf('COM_CAJOBBOARD_REPORT_ITEM_USER_EMAIL_INPUT_BOX_PLACEHOLDER', $humanizedViewName)
            </textarea>
          </div>

          {{-- Javascript is responsible for setting the item's id number for this hidden field --}}
        <input id="report-item-id" type="hidden" value="0">
        </form>
      </div>

      <div class="modal-footer">
        <div>
          {{-- "Submit your report of this item" --}}
          <div class="report-submit">
            @sprintf('COM_CAJOBBOARD_REPORT_ITEM_SUBMIT_DESC', $humanizedViewName)
          </div>

          <div class="report-footer-button-row"> {{-- button row --}}
            {{-- "Send" button to report item --}}
            <span class="float-right">
              <button id="submit-item-report-btn" class="btn btn-primary btn-xs" type="submit" form="report-item-form">
                @lang('COM_CAJOBBOARD_REPORT_ITEM_SUBMIT_BUTTON_LABEL')
              </button>
            </span>

            {{-- Close button to cancel modal --}}
            <span class="float-right">
              <button type="button" class="btn btn-default btn-xs report-close" data-dismiss="modal">
                @lang('COM_CAJOBBOARD_CLOSE_BUTTON_LABEL')
              </button>
            </span>
          </div> {{-- END button row --}}
        </div>
      </div> {{-- End Footer --}}

    </div>
  </div>
</div>
@stop
