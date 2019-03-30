<?php
/**
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  // no direct access
  defined('_JEXEC') or die;

  JHtml::_('jquery.framework');
  JHtml::_('bootstrap.framework');

  // Set viewport recommended by Bootstrap for responsive CSS
  $document = JFactory::getDocument();
  $document->setMetaData('viewport', 'width=device-width, initial-scale=1');
?>

<head>
  <?php if (!$this->error->getCode()) : ?>
    <jdoc:include type="head" />
  <?php else : ?>
    <title><?php echo $this->error->getCode() ?> - <?php echo $this->title; ?></title>
  <?php endif; ?>
</head>
