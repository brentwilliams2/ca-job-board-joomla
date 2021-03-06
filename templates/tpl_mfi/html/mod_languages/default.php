<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * mod_languages default.php template override
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
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Uri\Uri;
  use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;

  HTMLHelper::_('stylesheet', 'mod_languages/template.css', array('version' => 'auto', 'relative' => true));

  if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0))
  {
    HTMLHelper::_('formbehavior.chosen');
  }
?>

<div class="mod-languages<?php echo $moduleclass_sfx; ?>">

  <?php if ($headerText) : ?>
    <div class="pretext"><p><?php echo $headerText; ?></p></div>
  <?php endif; ?>

  <?php if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0)) : ?>

    <form name="lang" method="post" action="<?php echo htmlspecialchars(Uri::current(), ENT_COMPAT, 'UTF-8'); ?>">

      <select class="inputbox advancedSelect" onchange="document.location.replace(this.value);" >

        <?php foreach ($list as $language) : ?>

          <option
            dir=<?php echo $language->rtl ? '"rtl"' : '"ltr"'; ?>
            value="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>"
            <?php echo $language->active ? 'selected="selected"' : ''; ?>
          >

            <?php echo $language->title_native; ?>

          </option>

        <?php endforeach; ?>

      </select>

    </form>

  <?php elseif ($params->get('dropdown', 1) && $params->get('dropdownimage', 0)) : ?>

    <div class="btn-group">

      <?php foreach ($list as $language) : ?>

        <?php if ($language->active) : ?>

          <a href="#" data-toggle="dropdown" class="btn dropdown-toggle">
            <span class="caret"></span>

            <?php if ($language->image) : ?>

              &nbsp;<?php echo HTMLHelper::_('image', 'mod_languages/' . $language->image . '.gif', '', null, true); ?>

            <?php endif; ?>

            <?php echo $language->title_native; ?>
          </a>

        <?php endif; ?>

      <?php endforeach; ?>

      <ul
        class="<?php echo $params->get('lineheight', 1) ? 'lang-block' : 'lang-inline'; ?> dropdown-menu"
        dir="<?php echo Factory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>"
      >

        <?php foreach ($list as $language) : ?>

          <?php if (!$language->active || $params->get('show_active', 0)) : ?>

            <li <?php echo $language->active ? ' class="lang-active"' : ''; ?>>

              <a href="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>">

                <?php if ($language->image) : ?>

                  <?php echo HTMLHelper::_('image', 'mod_languages/' . $language->image . '.gif', '', null, true); ?>

                <?php endif; ?>

                <?php echo $language->title_native; ?>

              </a>

            </li>

          <?php endif; ?>

        <?php endforeach; ?>

      </ul>
    </div>

  <?php else : ?>

    <ul class="<?php echo $params->get('inline', 1) ? 'lang-inline' : 'lang-block'; ?>">

      <?php foreach ($list as $language) : ?>

        <?php if (!$language->active || $params->get('show_active', 0)) : ?>

          <li <?php echo $language->active ? ' class="lang-active"' : ''; ?> dir="<?php echo $language->rtl ? 'rtl' : 'ltr'; ?>">

            <a href="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>">

            <?php if ($params->get('image', 1)) : ?>

              <?php if ($language->image) : ?>

                <?php echo HTMLHelper::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true); ?>

              <?php else : ?>

                <span class="label"><?php echo strtoupper($language->sef); ?></span>

              <?php endif; ?>

            <?php else : ?>

              <?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef); ?>

            <?php endif; ?>

            </a>

          </li>
        <?php endif; ?>

      <?php endforeach; ?>

    </ul>

  <?php endif; ?>

  <?php if ($footerText) : ?>
    <div class="posttext"><p><?php echo $footerText; ?></p></div>
  <?php endif; ?>
</div>
