<?php
 /**
  * Job Postings Item for Browse View Template
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

  $items = $this->getItems();

  // Plural translation strings:
  // @plural('COM_USERS_N_USERS_ACTIVATED', count($ids))
  // COM_USERS_N_USERS_ACTIVATED_0="No users activated"
  // COM_USERS_N_USERS_ACTIVATED_1="User successfully activated"
  // COM_USERS_N_USERS_ACTIVATED="%s Users successfully activated"

  // Translation string substitution:
  // @sprintf('STRING_WITH_NUMBERS_IN_IT', $num1, $num2, $num3)
  // STRING_WITH_NUMBERS_IN_IT="First %d, second %d, third %d"

?>

{{--  --}}

$item->slug
$item->featured



{{{ $item->relevant_occupation_name }}}
{{{ $item->disambiguating_description }}}






@section('employer_logo')
  <a href="#">
    <img class="media-object" src="..." alt="...">
  </a>
@endsection

@section('location_employer_postdate')
  $item->jobLocation
  $item->hiringOrganization
  $item->created_on
  $item->modified_on
@endsection

{{-- Row with pay, either range or fixed, and type of employment, e.g. full-time --}}
@section('pay_and_type')
  $item->base_salary__max_value
  $item->base_salary__value
  $item->base_salary__min_value
  $item->base_salary__duration    // P0H1 per hour, P1D per day, P1W per week, P2W biweekly, P1M per month, P1Y annually
  $item->employmentType
@endsection

{{-- Responsive container for desktop and mobile --}}
<div class="row">
  <div class="col-xs-12 col-md-8">
    <div class="media">
      <div class="media-left media-top">
          @yield('employer_logo')
      </div>

      <div class="media-body">
        <h4 class="media-heading">{{{ $item->title }}}</h4>
        ...
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-md-8">@yield('pay_and_type')</div>
</div>
