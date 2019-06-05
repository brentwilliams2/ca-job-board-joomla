<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_users profile/default.php template override
 *
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * default.xml has the values for menu items used in the menu manager when creating a new menu item
 */

  use \Joomla\CMS\Factory;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;

  HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');

  $fields = $this->form->getFieldset('params');
?>

<div class="profile<?php echo $this->pageclass_sfx; ?>">

	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>

	<?php if (Factory::getUser()->id == $this->data->id) : ?>
		<ul class="btn-toolbar pull-right">
			<li class="btn-group">
				<a class="btn" href="<?php echo Route::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
					<span class="icon-user"></span>
					<?php echo Text::_('COM_USERS_EDIT_PROFILE'); ?>
				</a>
			</li>
		</ul>
	<?php endif; ?>

	<fieldset id="users-profile-core">

    <legend>
      <?php echo Text::_('COM_USERS_PROFILE_CORE_LEGEND'); ?>
    </legend>

    <dl class="dl-horizontal">
      <dt>
        <?php echo Text::_('COM_USERS_PROFILE_NAME_LABEL'); ?>
      </dt>

      <dd>
        <?php echo $this->escape($this->data->name); ?>
      </dd>

      <dt>
        <?php echo Text::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?>
      </dt>

      <dd>
        <?php echo $this->escape($this->data->username); ?>
      </dd>

      <dt>
        <?php echo Text::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?>
      </dt>

      <dd>
        <?php echo HTMLHelper::_('date', $this->data->registerDate, Text::_('DATE_FORMAT_LC1')); ?>
      </dd>

      <dt>
        <?php echo Text::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?>
      </dt>

      <?php if ($this->data->lastvisitDate != $this->db->getNullDate()) : ?>

        <dd>
          <?php echo HTMLHelper::_('date', $this->data->lastvisitDate, Text::_('DATE_FORMAT_LC1')); ?>
        </dd>

      <?php else : ?>

        <dd>
          <?php echo Text::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>
        </dd>

      <?php endif; ?>

    </dl>

  </fieldset>

  <?php if (count($fields)) : ?>
    <fieldset id="users-profile-custom">

      <legend><?php echo Text::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?></legend>

      <dl class="dl-horizontal">

        <?php foreach ($fields as $field) : ?>

          <?php if (!$field->hidden) : ?>
            <dt>
              <?php echo $field->title; ?>
            </dt>
            <dd>
              <?php if (HTMLHelper::isRegistered('users.' . $field->id)) : ?>

                <?php echo HTMLHelper::_('users.' . $field->id, $field->value); ?>

              <?php elseif (HTMLHelper::isRegistered('users.' . $field->fieldname)) : ?>

                <?php echo HTMLHelper::_('users.' . $field->fieldname, $field->value); ?>

              <?php elseif (HTMLHelper::isRegistered('users.' . $field->type)) : ?>

                <?php echo HTMLHelper::_('users.' . $field->type, $field->value); ?>

              <?php else : ?>

                <?php echo HTMLHelper::_('users.value', $field->value); ?>

              <?php endif; ?>
            </dd>
          <?php endif; ?>

        <?php endforeach; ?>

      </dl>
    </fieldset>
  <?php endif; ?>

	<?php echo $this->loadTemplate('custom'); ?>

</div>
