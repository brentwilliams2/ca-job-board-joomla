<?php
/**
 * Warm PHP's opcache with after server reset
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// @TODO: implement cache warmer

/*
 printout files to build file list:

  find /dir -type f -follow -print

 Using PHP.ini config to use this file as a list (file_cache):
 Specifies a PHP script that is going to be compiled and executed at server start-up,
 and which may preload other files, either by including them or by using the opcache_compile_file() function.
 PHP command to compile (not exec) files and add to opcache

  opcache_compile_file ( string $file )

  opcache_is_script_cached()

 Be aware that opcache will only compile and cache files older than the script execution start.
 For instance, if you use a script to generate cache files (e.g. you don't have access to shmop
 and rely on opcache for in-memory data caching instead), opcache_compile_file will not include
 the generated file in the cache, because its modification time is after the script start. The
 workaround is to use touch() to set a date before the script execution date, then opcache will
 compile and cache the generated file.

*/
