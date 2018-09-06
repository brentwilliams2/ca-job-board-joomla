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

// Register modified autoload function. PHP will run through multiple autoload functions in the
// sequence they were added, so it doesn't matter that \FOF30 namespace is duplicated here
$autoloader->register(false);
