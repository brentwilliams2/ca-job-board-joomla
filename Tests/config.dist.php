<?php
/**
 * Configuration for PHPUnit Tests
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018-2019 Calligraphic LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 *
 * YOU ARE SUPPOSED TO USE A DEDICATED SITE FOR THESE TESTS, SINCE WE'LL COMPLETELY OVERWRITE EXISTING
 * DATABASE DATA WITH WHAT IS NEEDED FOR THE TEST!
 */
$testConfig = [
	'site_root' => '/var/www/guineapig',
	'site_name' => 'Calligraphic Job Board Unit Tests',
	'site_url'  => 'http://localhost/guineapig/',
];
