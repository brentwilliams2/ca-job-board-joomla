<?php
/**
 * Register namespaces with FOF autoloader
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die;

$autoloader = FOF30\Autoloader\Autoloader::getInstance();

// Add Admin Helper namespace
$adminHelperNamespace = 'Calligraphic\\Cajobboard\\Admin\\Helper\\';

if (!$autoloader->hasMap($adminHelperNamespace))
{
  $autoloader->addMap($adminHelperNamespace, JPATH_COMPONENT_ADMINISTRATOR . '/Helper');
}

// Add Admin Repository namespace
$adminRepositoryNamespace = 'Calligraphic\\Cajobboard\\Admin\\Repository\\';

if (!$autoloader->hasMap($adminRepositoryNamespace))
{
  $autoloader->addMap($adminRepositoryNamespace, JPATH_COMPONENT_ADMINISTRATOR . '/Repository');
}

// Add Site Repository namespace
$siteRepositoryNamespace = 'Calligraphic\\Cajobboard\\Site\\Repository\\';

if (!$autoloader->hasMap($siteRepositoryNamespace))
{
  $autoloader->addMap($siteRepositoryNamespace, JPATH_COMPONENT_SITE . '/Repository');
}

// Register modified autoload function
$autoloader->register(false);

// Add Composer autoloader for applications in vendor directory
require_once JPATH_ROOT . '/vendor/autoload.php';
