<?php
 /**
  * View Template Helper for Login or Register Modal
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

  // current user ID
  $userId = $this->container->platform->getUser()->id;
?>

{{--
  Login and register modal
--}}
@section('login-or-register-modal')
  {{-- only take bandwidth hit of including modal HTML if user is a guest --}}
  @if ($userId == 0)
    <div class="modal fade" id="login-or-register-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          {{-- button with an "X" to close the modal, top right-hand corner --}}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>

          <div class="modal-body">
            <div class="col-xs-12 col-md-6">
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
  @endif
@show
