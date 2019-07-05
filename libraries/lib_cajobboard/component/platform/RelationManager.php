<?php
/**
 * Base Admin Hierarchical Nested List Model for all Job Board Models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c) 2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

class RelationManager extends \FOF30\Model\DataModel\RelationManager
{
	/**
	 * Populates the static map of relation type methods and relation handling classes
	 *
	 * @return array Key = method name, Value = relation handling class
	 */
	public static function getRelationTypes()
	{
		if (empty(static::$relationTypes))
		{
      $relationTypeDirectory = __DIR__ . '/Relation';

      $fs = new \DirectoryIterator($relationTypeDirectory);

      /** @var $file \DirectoryIterator */

			foreach ($fs as $file)
			{
				if ($file->isDir())
				{
					continue;
				}
				if ($file->getExtension() != 'php')
				{
					continue;
				}
        $baseName = ucfirst($file->getBasename('.php'));

        $methodName = strtolower($baseName[0]) . substr($baseName, 1);

        $className = '\\FOF30\\Model\\DataModel\\Relation\\' . $baseName;

				if (!class_exists($className, true))
				{
					continue;
        }

				static::$relationTypes[$methodName] = $className;
			}
    }

		return static::$relationTypes;
	}
}
