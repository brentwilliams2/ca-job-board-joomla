<?php
 /**
  * Job Postings Site Modal Views Template
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

  // get global site configuration
  $config = $this->container->platform->getConfig();

  // get sitename from global configuration
  $siteName = $config->get('sitename', 'Job Board');

  // get component configuration
  $params = $this->container->params;
  // $this->view->getPageParams()->get('page_title', '');

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


{{--
  Singleton "report a job" for abusive content modal - Javascript links a singleton modal into all buttons
--}}
@section('report-job-modal')
<div class="modal fade" id="report-job-modal" tabindex="-1" role="dialog" aria-labelledby="reportAJobModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
      {{-- button with an "X" to close the modal, top right-hand corner --}}
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="reportJobModalLabel">
          @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_HEADER_DESC', $terms_of_service)
        </h4>
      </div>

      <div class="modal-body">
        <form id="report-job-form">
          {{-- "Describe the problem" and text input form element --}}
          <div id="report-job" class="form-group">
            <label for="report-job-text-box" class="control-label">
              @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_USER_EMAIL_INPUT_BOX_LABEL')
            </label>
            <textarea class="form-control" id="report-job-text-box">
              @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_USER_EMAIL_INPUT_BOX_PLACEHOLDER')
            </textarea>
          </div>

          {{-- Javascript responsible for setting a hidden input with id="report-job-id" with value of that job's id number --}}
          <input id="report-job-id" type="hidden" value="0">
        </form>
      </div>

      <div class="modal-footer">
        <div>
          {{-- "Submit your report of this job" --}}
          <div>@lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_SUBMIT_DESC')</div>

          <div> {{-- button row --}}
            {{-- "Send" button to report job --}}
            <span class="float-right">
              <button id="submit-job-report-button" class="btn btn-primary btn-xs" type="submit" form="report-job-form">
                @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_SUBMIT_BUTTON_LABEL')
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
      </div> {{-- End Footer --}}

    </div>
  </div>
</div>
@stop


{{--
  Singleton login and register modal (only include once)
--}}
@section('login-or-register-modal')
  <div class="modal fade" id="login-or-register-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {{-- button with an "X" to close the modal, top right-hand corner --}}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          {{-- Left-hand column with text giving reasons to login or register to site --}}
          <div class="col-xs-hidden col-md-6 save-job-left-column">
            @lang('COM_CAJOBBOARD_SAVE_JOB_INVITE_TO_LOGIN_OR_REGISTER')
          </div>

          {{-- Right-hand column --}}
          <div class="col-xs-12 col-md-6 save-job-right-column">
            {{-- Registration form (default) --}}
            <div class="save-job-registration-form">
              @include('site:com_cajobboard/Registrations/register')
            </div>

            {{-- Login form (initially hidden) --}}
            <div class="save-job-login-form hidden">
              {{-- @include('site:com_cajobboard/Persons/login') --}}
            </div>
          </div>
        </div>

        {{-- Footer with option to toggle between registration and login views --}}
        <div class="modal-footer">
          {{-- "Already have a job board account? sign in" link on registration screen --}}
          <span id="toggle-to-login">
            @lang('COM_CAJOBBOARD_LOGIN_OR_REGISTER_TOGGLE_TO_LOGIN_LABEL', $siteName)
          </span>

          {{-- "Don't have a job board account? sign up" link on login screen --}}
          <span id="toggle-to-register hidden">
            @lang('COM_CAJOBBOARD_LOGIN_OR_REGISTER_TOGGLE_TO_REGISTER_LABEL', $siteName)
          </span>

          {{-- Close button --}}
          <button type="button" class="btn btn-default btn-xs " data-dismiss="modal">
            @lang('COM_CAJOBBOARD_CLOSE_BUTTON_LABEL');
          </button>
        </div>
      </div>
    </div>
  </div>
@stop