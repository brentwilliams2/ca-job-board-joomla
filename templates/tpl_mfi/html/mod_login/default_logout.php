<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * mod_login default_logout.php template partial override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;
  use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;

HTMLHelper::_('behavior.keepalive');
?>

<form action="<?php echo Route::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="form-vertical">

  <?php if ($params->get('greeting')) : ?>

    <div class="login-greeting">
      <small>

        <?php if ($params->get('name') == 0) : {
          echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
        } else : {
          echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
        } endif; ?>

      </small>
    </div>

  <?php endif; ?>

	<div class="logout-button">

		<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo Text::_('JLOGOUT'); ?>" />

		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />

		<?php echo HTMLHelper::_('form.token'); ?>

	</div>

</form>
