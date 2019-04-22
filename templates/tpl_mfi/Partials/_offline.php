<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * This partial displays the offline message for users
 * when the board is undergoing maintenance
 *
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

  /** @var \Joomla\CMS\Document\Document $this */
?>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">

        <jdoc:include type="message" />

        <div id="frame" class="outline">

          <?php if ($app->getCfg('offline_image')) : ?>
            <img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo $app->getCfg('sitename'); ?>" />
          <?php endif; ?>

          <h1><?php echo htmlspecialchars($app->getCfg('sitename')); ?></h1>

          <?php if ($app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $app->getCfg('offline_message')) != ''): ?>

            <p><?php echo $app->getCfg('offline_message'); ?></p>

          <?php elseif ($app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != ''): ?>

            <p><?php echo JText::_('JOFFLINE_MESSAGE'); ?></p>

          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</body>
