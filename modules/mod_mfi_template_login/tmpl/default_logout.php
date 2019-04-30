<?php
/**
 * Multi Family Insiders Bootstrap V3 Template Login Module
 *
 * Default logout template
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \Joomla\CMS\Factory;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;

  HTMLHelper::_('behavior.keepalive');

  /* @var   string   */
  $templatePath = Factory::getURI()->base() . 'templates/' . Factory::getApplication()->getTemplate();
?>

<span class="logged-in" type="button" data-toggle="modal" data-target="#logout-modal">
  <!-- @TODO: Fix this to show user avatar -->
  <span class="logged-in-avatar hasTooltip" title="<?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_VALUE_USERNAME'); ?>">
    <img src="<?php echo $templatePath; ?>/images/avatar-man-24.png"  alt="Avatar" height="24" width="24">
  </span>

  <span class="logged-in-greeting">
    <?php echo htmlspecialchars($user->get('name'), ENT_COMPAT, 'UTF-8'); ?>
  </span>
</span>

<!-- Modal -->
<div class="logout-modal modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">

      <form
        action="<?php echo Route::_('index.php', true, $params->get('usesecure', 0)); ?>"
        method="post"
        id="logout-form"
        class="logout-form form-vertical"
      >

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">

          <div class="logout-profile-link">
            <a href="<?php echo Route::_('index.php?option=com_users&view=profile'); ?>">
              <?php echo Text::_('MOD_MFI_TEMPLATE_LOGIN_PROFILE'); ?>
            </a>
          </div>

          <div class="logout-button">
            <input type="submit" name="Submit" class="btn btn-primary" value="<?php echo Text::_('JLOGOUT'); ?>" />
          </div>

        </div>

        <div class="modal-footer">
          <input type="hidden" name="option" value="com_users" />
          <input type="hidden" name="task" value="user.logout" />
          <input type="hidden" name="return" value="<?php echo $return; ?>" />
          <?php echo HTMLHelper::_('form.token'); ?>
        </div>

      </form>

    </div>
  </div>
</div>
