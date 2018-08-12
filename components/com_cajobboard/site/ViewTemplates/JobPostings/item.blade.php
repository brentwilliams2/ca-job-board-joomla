<?php
 /**
  * Job Postings Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  use FOF30\Utils\FEFHelper\BrowseView;
  use FOF30\Utils\SelectOptions;
  use JUri;

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // @TODO: Need Database field for employer's requisition / job number and EEO statement
?>

@section('header')
    <h1>This is the item view header</h1>
@show

@section('sidebar')
  <p>This is the item view sidebar</p>
@show

@section('item')
  <h1></h1><?php echo $item->title ?></h1>
@show

@section('footer')
  <p>This is the item view footer</p>
@show


{{{ $item->slug }}}
{{{ $item->metadesc }}}
{{{ $item->hits }}}
{{{ $item->featured }}}

{{{ $item->title }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_TITLE_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_TITLE_DESC')

{{{ $item->relevant_occupation_name }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_RELEVANT_OCCUPATION_NAME_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_RELEVANT_OCCUPATION_NAME_DESC')

{{{ $item->disambiguating_description }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_DISAMBIGUATING_LABELRIPTION_DESC')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_DISAMBIGUATING_LABELRIPTION_DESC')

{{{ $item->description }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_DESCRIPTION_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_DESCRIPTION_DESC')

{{{ $item->education_requirements }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_EDUCATION_REQUIREMENTS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_EDUCATION_REQUIREMENTS_DESC')

{{{ $item->experience_requirements }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_EXPERIENCE_REQUIREMENTS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_EXPERIENCE_REQUIREMENTS_DESC')

{{{ $item->incentive_compensation }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_INCENTIVE_COMPENSATION_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_INCENTIVE_COMPENSATION_DESC')

{{{ $item->job_benefits }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_JOB_BENEFITS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_JOB_BENEFITS_DESC')

{{{ $item->qualifications }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_QUALIFICATIONS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_QUALIFICATIONS_DESC')

{{{ $item->responsibilities }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_RESPONSIBILITIES_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_RESPONSIBILITIES_DESC')

{{{ $item->skills }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_SKILLS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_SKILLS_DESC')

{{{ $item->special_commitments }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_SPECIAL_COMMITMENTS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_SPECIAL_COMMITMENTS_DESC')

{{{ $item->work_hours }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_WORK_HOURS_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_WORK_HOURS_DESC')

{{{ $item->base_salary__max_value }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__MAX_VALUE_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__MAX_VALUE_DESC')

{{{ $item->base_salary__value }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__VALUE_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__VALUE_DESC')

{{{ $item->base_salary__min_value }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__MIN_VALUE_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__MIN_VALUE_DESC')

{{{ $item->base_salary__currency }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__CURRENCY_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__CURRENCY_DESC')

{{{ $item->base_salary__duration }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__DURATION_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_BASE_SALARY__DURATION_DESC')

{{{ $item->jobLocation }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_JOBLOCATION_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_JOBLOCATION_DESC')

{{{ $item->hiringOrganization }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_HIRINGORGANIZATION_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_HIRINGORGANIZATION_DESC')

{{{ $item->employmentType }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_EMPLOYMENTTYPE_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_EMPLOYMENTTYPE_DESC')

{{{ $item->occupationalCategory }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_OCCUPATIONALCATEGORY_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_OCCUPATIONALCATEGORY_DESC')

{{{ $item->identifier }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_JOBID_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_JOBID_DESC')

{{{ $item->sameAs }}}
@lang('COM_CAJOBBOARD_JOBPOSTINGS_CANONICAL_WEBPAGE_LABEL')
@lang('COM_CAJOBBOARD_JOBPOSTINGS_CANONICAL_WEBPAGE_DESC')
