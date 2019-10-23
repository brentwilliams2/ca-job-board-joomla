<?php
/**
 * FOF model behavior class to backfill the slug field with the
 * 'title' property or its fieldAlias if the slug field is empty.
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \FOF30\Model\TreeModel;
use \Joomla\CMS\Application\ApplicationHelper;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * @TODO: Submit a PR, there is code for this in DataModel's check()
 *        method but it isn't handling field aliases correctly. See
 *        how $item->$slugfield is set below for solution.
 */
class Slug extends Observer
{
	/**
	 * Add the slug field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill them in through this behaviour.
	 *
	 * @param   \FOF30\Model\DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $slugField = $item->getFieldAlias('slug');

    if ( $item->hasField($slugField) )
    {
      $item->addSkipCheckField($slugField);
    }
	}


	/**
	 * Handle 'slug' field, and 'hash' field on TreeModels
	 *
	 * Slug validation set to 'onBeforeSave' event so that it is set when
	 * the check() method is ran during the 'save' task's method. The TreeModel
	 * uses the slug field during check() to generate a hash for fast indexing.
	 *
	 * @param   \FOF30\Model\DataModel  	$item
	 * @param   array  										$data
	 */
	public function onBeforeSave(DataModel $item, &$data)
	{
		$this->setSlug($item, $data);

		$this->setHash($item, $data);
	}


	/**
	 * Transform the 'title' model field to a valid 'slug' SEF-friendly URL
	 * field and set it in $data, e.g. lower-cased text and hyphenated. Set
	 * the 'hash' model field on TreeModels to a sha1 hash taken from the slug
	 * if model is hierarchical (tree).
	 *
	 * @param   \FOF30\Model\DataModel  	$item
	 * @param   array  										$data
	 */
	protected function setSlug(DataModel $item, &$data)
	{
		// Create a slug if there is a title and an empty slug
    $slugField  = $item->getFieldAlias('slug');
		$titleField = $item->getFieldAlias('title');

		// sanity check
		if ( !$item->hasField($slugField) || !$item->hasField($titleField) )
		{
			return;
		}

		// STEP #1: If the slug is already set in the $data to bind to the model or on the model, return.
		if ( isset($slugField, $data) || $item->getFieldValue($slugField) )
		{
			return;
		}

		// STEP #2: If the title is set in the $data to bind to the model, make a slug, save it to $data[$slugField] and return.
		if ( isset($titleField, $data) )
		{
			$data[$slugField] = ApplicationHelper::stringURLSafe( $data[$titleField] );

			return;
		}

		// STEP #3: If the title is set on the model, make a slug, save it to $data[$slugField] and return.
		if ( $title = $item->getFieldValue($titleField) )
		{
			$data[$slugField] = ApplicationHelper::stringURLSafe($title);

			return;
		}
	}


	/**
	 * Set the 'hash' model field on TreeModels to a sha1 hash taken from the slug
	 * if model is hierarchical (tree). The hash enables faster searching in TreeModels.
	 * The 'hash' column should be CHAR(64) for database engine to optimise database
	 * searching of fixed size CHAR columns
	 *
	 * @param   \FOF30\Model\DataModel  	$item
	 * @param   array  										$data
	 */
	protected function setHash(DataModel $item, &$data)
	{
		// Sanity check
		if (!(
			$item->hasField('lft') && 
			$item->hasField('rgt') && 
			$item->hasField('hash') && 
			$item->hasField('slug')
		))
		{
			return;
		}

		$slugField  = $item->getFieldAlias('slug');

		// sha1 hash of 'null' is 'da39a3ee5e6b4b0d3255bfef95601890afd80709',
		// so avoid setting the hash if no slug has been set. Set from input first.
		if ( isset($slugField, $data) )
		{
			$data['hash'] = sha1( $data[$slugField] );

			return;
		}

		if ( $slug = $item->getFieldValue($slugField) )
		{
			$data['hash'] = $slug;

			return;
		}
	}
}
