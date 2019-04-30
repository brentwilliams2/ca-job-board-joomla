<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Toggles between Login / Register and the username / avatar for logged in users
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Factory;

  // no direct access
  defined('_JEXEC') or die;

  $user = JFactory::getUser();
?>

<?php if ( in_array('login', $this->moduleCount) && $this->moduleCount['login'] ) : ?>

  <jdoc:include type="modules" name="login" style="none" />

<?php elseif ($user->guest == 1): // render static HTML for guest user error pages ?>

  <span class="login-and-register">
    <span class="login" type="button" data-toggle="modal" data-target="#login-modal">
      <?php echo strtoupper(Text::_('MOD_MFI_TEMPLATE_LOGIN_LABEL_LOGIN')); ?>
    </span>

    &#160;&#47;&#160;

    <a class="register" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
      <?php echo strtoupper(Text::_('MOD_MFI_TEMPLATE_LOGIN_LABEL_REGISTER')); ?>
    </a>
  </span>

<?php else: // render static HTML for logged-in user error pages ?>

  <li id="login-container" class="login-container pull-right">
    <span class="logged-in" type="button" data-toggle="modal" data-target="#logout-modal">
      <!-- @TODO: Fix this to show user avatar -->
      <span class="logged-in-avatar hasTooltip" title="Username">
        <img src="http://joomla.test/templates/multifamilyinsidersbootstrapv3template/images/avatar-man-24.png" alt="Avatar" width="24" height="24">
      </span>

      <span class="logged-in-greeting">steve</span>
    </span>
  </li>

<?php endif; ?>



