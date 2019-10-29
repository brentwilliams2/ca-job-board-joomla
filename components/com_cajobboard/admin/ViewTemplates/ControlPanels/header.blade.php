<?php
 /**
  * Admin Control Panel Header View Template
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

  $headerItems = array(
    'sales',
    'jobs-posted',
    'applications-sent',
    'job-alerts',
    'profiles',
    'social-media'
  );
?>

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Sales -----------------------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('sales')
  @include('admin:com_cajobboard/ControlPanel/header_item', array(
    'title' => Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_SALES'),
    'icon'  => 'cart',
    'count' => 3700,
    'increaseOrDecrease' => 'increase',
    'percent' => 4.7,
    'isCurrency' => true
  ))
@overwrite

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Jobs Posted -----------------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('jobs-posted')
  @include('admin:com_cajobboard/ControlPanel/header_item', array(
    'title' => Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_JOBS_POSTED'),
    'icon'  => 'briefcase',
    'count' => 198,
    'increaseOrDecrease' => 'increase',
    'percent' => 2.3,
    'isCurrency' => false
  ))
@overwrite

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Applications Sent -----------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('applications-sent')
  @include('admin:com_cajobboard/ControlPanel/header_item', array(
    'title' => Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_APPLICATIONS_SENT'),
    'icon'  => 'envelope',
    'count' => 472,
    'increaseOrDecrease' => 'increase',
    'percent' => 1.7,
    'isCurrency' => false
  ))
@overwrite

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Job Alerts Created ----------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('job-alerts')
  @include('admin:com_cajobboard/ControlPanel/header_item', array(
    'title' => Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_JOB_ALERTS_CREATED'),
    'icon'  => 'comments-2',
    'count' => 622,
    'increaseOrDecrease' => 'decrease',
    'percent' => 1.1,
    'isCurrency' => false
  ))
@overwrite

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Profiles Created ------------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('profiles')
  @include('admin:com_cajobboard/ControlPanel/header_item', array(
    'title' => Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_PROFILES_CREATED'),
    'icon'  => 'users',
    'count' => 27,
    'increaseOrDecrease' => 'increase',
    'percent' => 0.2,
    'isCurrency' => false
  ))
@overwrite

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Social Media Index ----------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('social-media')
  @include('admin:com_cajobboard/ControlPanel/header_item', array(
    'title' => Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_SOCIAL_MEDIA_INDEX'),
    'icon'  => 'users',
    'count' => 132,
    'increaseOrDecrease' => 'increase',
    'percent' => 14,
    'isCurrency' => false
  ))
@overwrite


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Job Alerts Created ----------------------------------------------}}
{{-----------------------------------------------------------------------------}}

<div class="row tile-count">
  @foreach ($headerItems as $item)
    @yield($item)
  @endforeach
</div>
