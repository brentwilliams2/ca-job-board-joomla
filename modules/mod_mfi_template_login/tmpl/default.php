<?php
/**
 * Multi Family Insiders Bootstrap V3 Template Login Module
 *
 * Default Login Template
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \Joomla\CMS\Component\ComponentHelper;
  use \Joomla\CMS\Plugin\PluginHelper;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;

  JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

  HTMLHelper::_('behavior.keepalive');
  HTMLHelper::_('bootstrap.tooltip');
?>

<span class="login-and-register">
  <span class="login" type="button" data-toggle="modal" data-target="#login-modal">
    <?php echo strtoupper(Text::_('MOD_MFI_TEMPLATE_LOGIN_LABEL_LOGIN')); ?>
  </span>

  &#160;&#47;&#160;

  <a class="register" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
		<?php echo strtoupper(Text::_('MOD_MFI_TEMPLATE_LOGIN_LABEL_REGISTER')); ?>
  </a>
</span>


<div class="login-modal modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">

    <form
      action="<?php echo Route::_('index.php', true, $params->get('usesecure', 0)); ?>"
      method="post"
      id="login-form"
      class="login-modal-form"
    >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="login-modal-greeting"><?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_GREETING'); ?></h4>
        </div>

        <div class="modal-body">

          <label id="form-login-username" class="form-login-username input-text-animation" for="modlgn-username">
            <input class="animation-input" type="text" id="modlgn-username" name="username" placeholder="&nbsp;">
            <span class="animation-label"><?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_VALUE_USERNAME'); ?></span>
            <span class="animation-border"></span>
          </label>

          <label id="form-login-password" class="form-login-password input-text-animation" for="modlgn-passwd">
            <input class="animation-input" type="password" id="modlgn-passwd" name="password" placeholder="&nbsp;">
            <span class="animation-label"><?php echo Text::_('JGLOBAL_PASSWORD'); ?></span>
            <span class="animation-border"></span>
          </label>


          <?php /* remember-me check box */ ?>
          <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>

            <div id="form-login-remember" class="form-login-remember">
              <input class="modlgn-remember" id="modlgn-remember" type="checkbox" name="remember"value="yes"/>
              <label for="modlgn-remember" class="control-label">
                <?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_REMEMBER_ME'); ?>
              </label>
            </div>

          <?php endif; ?>

          <div class="clearfix"></div>

          <div class="login-modal-buttons">

            <?php /* "Log in" button */ ?>
            <span id="form-login-submit" class="form-login-submit">
              <button type="submit" name="Submit" class="btn btn-sm btn-primary">
                <?php echo Text::_('JLOGIN'); ?>
              </button>
            </span>

            <?php /* "Register" link */ ?>
            <span id="form-register" class="form-register">
              <a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
                <button type="button" name="register" class="btn btn-sm btn-default">
                  <?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_LABEL_REGISTER'); ?>
                </button>
              </a>
            </span>

          </div>

          <div class="clearfix"></div>


        <div class="modal-footer">

          <?php /* "Forgot your..." links */ ?>
            <div id="form-forgot-username" class="form-forgot-username">
              <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
                <?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_FORGOT_YOUR_USERNAME'); ?>
              </a>
            </div>

            <div id="form-forgot-password" class="form-forgot-password">
              <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
                <?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_FORGOT_YOUR_PASSWORD'); ?>
              </a>
            </div>
          </div>

          <input type="hidden" name="option" value="com_users" />
          <input type="hidden" name="task" value="user.login" />
          <input type="hidden" name="return" value="<?php echo $return; ?>" />
          <?php echo HTMLHelper::_('form.token'); ?>

        </div>

      </form>

    </div>
  </div>
</div>
