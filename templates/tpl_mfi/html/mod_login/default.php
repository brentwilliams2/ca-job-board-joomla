<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * mod_login default.php template override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Component\ComponentHelper;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;

	HTMLHelper::_('jquery.framework');
	HTMLHelper::_('behavior.keepalive');
?>

<form action="<?php  echo Route::_('index.php', true, $params->get('usesecure')); ?>" method="post">

	<?php  if ($params->get('pretext')) : ?>
    <div class="pretext">
      <p><?php  echo $params->get('pretext'); ?></p>
    </div>
	<?php endif; ?>

  <?php  if (!$params->get('usetext')) : ?>

    <div id="form-login-username" class="form-group">

      <label for="modlgn-username" class="element-invisible">
        <?php  echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>
      </label>

      <div class="input-group">

        <div class="input-group-addon">
          <span class="glyphicon glyphicon-user tip" title="<?php  echo Text::_('MOD_LOGIN_VALUE_USERNAME')  ?>"></span>
        </div>

        <input
          id="modlgn-username"
          type="text"
          name="username"
          class="form-control input-small"
          tabindex="0"
          placeholder="<?php  echo Text::_('MOD_LOGIN_VALUE_USERNAME')  ?>"
        >

      </div>

    </div>

  <?php  else : ?>

    <label for="modlgn-username">
      <?php  echo Text::_('MOD_LOGIN_VALUE_USERNAME')  ?>
    </label>

    <input
      id="modlgn-username"
      type="text"
      name="username"
      class="form-control input-small"
      tabindex="0"
      placeholder="<?php  echo Text::_('MOD_LOGIN_VALUE_USERNAME')  ?>"
    >

  <?php  endif; ?>

	<div id="form-login-password" class="form-group">
		<div class="controls">

			<?php  if (!$params->get('usetext')) : ?>

			  <label for="modlgn-passwd" class="element-invisible">
          <?php  echo Text::_('JGLOBAL_PASSWORD'); ?>
        </label>

			  <div class="input-group">

          <span class="input-group-addon">
            <span class="glyphicon glyphicon-lock tip" title="<?php  echo Text::_('JGLOBAL_PASSWORD')  ?>"></span>
          </span>

				  <input
            id="modlgn-passwd"
            type="password"
            name="password"
            class="form-control input-small"
            tabindex="0"
            placeholder="<?php  echo Text::_('JGLOBAL_PASSWORD')  ?>"
          >

			  </div>

			<?php  else : ?>

			  <label for="modlgn-passwd">
          <?php  echo Text::_('JGLOBAL_PASSWORD')  ?>
        </label>

			  <input
          id="modlgn-passwd"
          type="password"
          name="password"
          class="form-control input-small"
          tabindex="0"
          placeholder="<?php  echo Text::_('JGLOBAL_PASSWORD')  ?>"
        >

			<?php  endif; ?>

		</div>
	</div>

	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>

		<div id="form-login-remember" class="checkbox control-group">

			<label for="modlgn-remember">

        <input
          id="modlgn-remember"
          type="checkbox"
          name="remember"
          class="inputbox"
          value="yes"
        >

        <?php echo Text::_('MOD_LOGIN_REMEMBER_ME') ?>

      </label>
		</div>
	<?php endif; ?>

	<button type="submit" tabindex="0" name="Submit" class="btn btn-primary">
    <?php  echo Text::_('JLOGIN')  ?>
  </button>

	<?php $usersConfig = ComponentHelper::getParams('com_users'); if ($usersConfig->get('allowUserRegistration')) : ?>

    <ul class="unstyled">
      <li> a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>"><?php  echo Text::_('MOD_LOGIN_REGISTER'); ?><span class="icon-arrow-right"></span></a></li>
      <li><a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>"> <?php  echo Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a></li>
      <li><a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>"><?php  echo Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a></li>
    </ul>

	<?php  endif; ?>

	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php  echo $return; ?>" />

	<?php  echo HTMLHelper::_('form.token'); ?>

	<?php  if ($params->get('posttext')) : ?>

    <div class="posttext">
      <p><?php  echo $params->get('posttext'); ?></p>
    </div>

	<?php  endif; ?>
</form>
