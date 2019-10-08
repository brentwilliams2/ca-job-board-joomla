<?php
 /**
  * Job Postings Site Modal Views Template
  *
  * @package   Calligraphic Job Board
  * @version   October 5, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  // get component configuration
  $params = $this->container->params;

  // parameters for email input box placeholder from component
  $emailPlaceholder = $params->get('registration_email_placeholder');

  // admin parameters for links
  $terms_of_service = JRoute::_('index.php?Itemid=' . $params->get('terms_of_use'));
  $privacy_policy = JRoute::_('index.php?Itemid=' . $params->get('privacy_policy'));
?>

{{--
  Singleton "email a job" modal - Javascript links a singleton modal into all buttons
--}}
@section('email-a-job-modal')
  <div class="modal fade" id="email-a-job-modal" tabindex="-1" role="dialog" aria-labelledby="emailJobModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          {{-- button with an "X" to close the modal, top right-hand corner --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="emailJobModalLabel">
              @lang('COM_CAJOBBOARD_EMAIL_A_JOB_HEADER_DESC')
          </h4>
        </div>

        <div class="modal-body">
          <form id="email-a-job-form">
            {{-- "Enter email to send job to" input box --}}
            <div id="send-to-email" class="form-group">
              <label for="send-email-input-box" class="control-label">
                @lang('COM_CAJOBBOARD_EMAIL_A_JOB_USER_EMAIL_INPUT_BOX_LABEL')
              </label>
              <input type="email" class="form-control" id="send-email-input-box" placeholder="{{{ $emailPlaceholder }}}">
            </div>

            {{-- Javascript responsible for setting a hidden input with id="email-job-id" with value of that job's id number --}}
            <input id="email-job-id" type="hidden" value="0">
          </form>
        </div>

        <div class="modal-footer">
          <div>
            {{-- "Email this job to yourself or a friend" text description --}}
            <div>@lang('COM_CAJOBBOARD_JOB_POSTINGS_EMAIL_JOB_SUBMIT_DESC')</div>

            <div> {{-- button row --}}
              {{-- "Send" button to email job --}}
              <span class="float-right">
                <button id="submit-job-to-email-button" class="btn btn-primary btn-xs" type="submit" form="email-a-job-form">
                  @lang('COM_CAJOBBOARD_JOB_POSTINGS_EMAIL_JOB_SUBMIT_BUTTON_LABEL')
                </button>
              </span>

              {{-- Close button to cancel modal --}}
              <span class="float-right">
                <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">
                  @lang('COM_CAJOBBOARD_CLOSE_BUTTON_LABEL');
                </button>
              </span>
            </div> {{-- END button row --}}
          </div>

          {{-- Terms of Service and Privacy Policy statement --}}
          <div>
            @lang('COM_CAJOBBOARD_REGISTRATION_TOS_AND_PRIVACY_POLICY_STATEMENT', $terms_of_service, $privacy_policy)
          </div>
        </div> {{-- End Footer --}}

      </div>
    </div>
  </div>
@stop
