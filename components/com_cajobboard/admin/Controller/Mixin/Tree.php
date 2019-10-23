<?php
/**
 * Admin Tree DataModel Helper Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   October 16, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \Calligraphic\Cajobboard\Admin\Controller\Exception\NoRootRecord;
use \FOF30\Container\Container;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

trait Tree
{
 /**
	 * Create a new node and record, using the value of the 'is_part_of' input field if present for
   * the parent node or the root node for the parent node if 'is_part_of' input field is not present.
	 * 
	 * @TODO: Missing functionality present in applySave() method:
	 *        1. Handle record locking
	 *        2. Set state to session var at end
	 *        3. Set layout to form
	 */
	public function create()
	{
		// CSRF prevention
    $this->csrfProtection();

		$model = $this->getModel();

    $db = $model->getDbo();

    $idFieldName = $model->getIdFieldName();

		$isPartOf = $model->getFieldValue('is_part_of', 1);

		$query = $db->quoteName($idFieldName) . ' = ' . $db->quote($isPartOf);

		try
		{
			$rootNode = $model->getClone()->reset()->find($isPartOf);
		}
		catch (\Exception $e)
		{
			throw new NoRootRecord( Text::_('COM_CAJOBBOARD_EXCEPTION_NO_ROOT_RECORD_DEFAULT') );
		}

    $data = $this->container->input->getData();

    $model->bind($data);

    $model->insertAsLastChildOf($rootNode);

    $textKey = Text::sprintf( strtoupper('COM_CAJOBBOARD_LBL_SAVED', $this->container->inflector->singularize($this->view) ));

		if ($customURL = $this->input->getBase64('returnurl', ''))
		{
			$customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();

		$this->setRedirect($url, $textKey);
	}


	/**
	 * Over-ridden, implements a default browse task
	 *
	 * @return  void
	 */
	public function browse()
	{
		// Initialise the savestate
		$saveState = $this->input->get('savestate', -999, 'int');

		if ($saveState == -999)
		{
			$saveState = true;
		}

		$this->getModel()->savestate($saveState);

		// Apply the Form name
		$formName = 'form.default';

		if (!empty($this->layout))
		{
			$formName = 'form.' . $this->layout;
		}

		$this->getModel()->setFormName($formName);

		// Do we have a _valid_ form?
		$form = $this->getModel()->getForm();

		if ($form !== false)
		{
			$this->hasForm = true;

			if (empty($this->layout))
			{
				$this->layout = 'default';
			}
		}

		// Display the view
		$this->display(in_array('browse', $this->cacheableTasks), $this->cacheParams);
	}
}