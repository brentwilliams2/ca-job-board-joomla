<?php
 /**
  * Organizations (Employer Profiles) Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

Organizations (Employer Profiles) Edit View Template
