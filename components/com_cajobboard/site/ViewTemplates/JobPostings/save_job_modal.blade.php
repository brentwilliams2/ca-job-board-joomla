<?php
 /**
  * Save Jobs Modal Dialog Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  use JUri;

  // no direct access
  defined('_JEXEC') or die;

  $params = $this->getPageParams();
?>

Find out what it's like at a company by reading employee reviews
Research salaries to help you negotiate your offer or pay raise
Search millions of jobs from across the web with one click


{{--
  Register new user / social login modal
--}}
@section('save_job_modal')
  <div class="login-modal modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">
            @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB_MODAL_TITLE')
          </h4>
        </div>

        <div class="modal-body">



          @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB_MODAL_DESCRIPTION')
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default login-modal-close-button" data-dismiss="modal">
            @lang('COM_CAJOBBOARD_CLOSE_BUTTON_LABEL')
          </button>
          <button type="button" class="btn btn-primary login-modal-close-button">
            @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB_BUTTON_LABEL')
          </button>
        </div>
      </div>
    </div>
  </div>
@overwrite
