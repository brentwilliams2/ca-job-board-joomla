<?php

$fileArray = scandir( realpath(  dirname(__FILE__) . '/../Partials' ) );

foreach ($fileArray as $file)
{


  preg_match('/\.[^\.]+$/i', $file, $fileExtOut);

  $fileExt = array_key_exists(0, $fileExtOut) ? $fileExtOut[0] : '';

  if ($file == '.' || $file == '..' || $fileExt !== '.php')
  {
    continue;
  }

  $partialFiles = str_replace('_', '-', ltrim( str_replace('.php', '', $file), '_' ));
}

var_dump($partialFiles);
