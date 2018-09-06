
<?php xdebug_var_dump($item->title); ?>

@section('job_title')
  <div>{{{ $item->title }}}</div>
@overwrite

@yield('job_title')