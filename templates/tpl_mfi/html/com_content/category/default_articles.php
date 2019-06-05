<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_content category/default_articles.php template partial override
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
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;
  use \Joomla\CMS\Uri\Uri;

  // no direct access
  defined('_JEXEC') or die;

  HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');

  // Create some shortcuts.
  $params		  = &$this->item->params;
  $n			    = count($this->items);
  $listOrder	= $this->escape($this->state->get('list.ordering'));
  $listDirection	  = $this->escape($this->state->get('list.direction'));

  // Check for at least one editable article
  $isEditable = false;

  if (!empty($this->items))
  {
    foreach ($this->items as $article)
    {
      if ($article->params->get('access-edit'))
      {
        $isEditable = true;
        break;
      }
    }
  }
?>

<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	  <p><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>

  <form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">

    <?php if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
      <fieldset class="filters btn-toolbar clearfix">

        <?php if ($this->params->get('filter_field') != 'hide') :?>
          <div class="btn-group">

            <label class="filter-search-lbl element-invisible" for="filter-search">
              <?php echo Text::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL').'&#160;'; ?>
            </label>

            <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox form-control" onchange="document.adminForm.submit();" title="<?php echo Text::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL'); ?>" />

          </div>
        <?php endif; ?>

        <?php if ($this->params->get('show_pagination_limit')) : ?>
          <div class="btn-group pull-right">

            <label for="limit" class="element-invisible">
              <?php echo Text::_('JGLOBAL_DISPLAY_NUM'); ?>
            </label>

            <?php echo $this->pagination->getLimitBox(); ?>

          </div>
        <?php endif; ?>

        <input type="hidden" name="filter_order" value="" />
        <input type="hidden" name="filter_order_Dir" value="" />
        <input type="hidden" name="limitstart" value="" />
        <input type="hidden" name="task" value="" />

      </fieldset>
    <?php endif; ?>

    <table class="category table table-striped table-bordered table-hover">

      <?php if ($this->params->get('show_headings')) : ?>
        <thead>
          <tr>

            <th id="categorylist_header_title">
              <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirection, $listOrder); ?>
            </th>

            <?php if ($date = $this->params->get('list_show_date')) : ?>
              <th id="categorylist_header_date">

                <?php if ($date == "created") : ?>

                  <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.created', $listDirection, $listOrder); ?>

                <?php elseif ($date == "modified") : ?>

                  <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.modified', $listDirection, $listOrder); ?>

                <?php elseif ($date == "published") : ?>

                  <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.publish_up', $listDirection, $listOrder); ?>

                <?php endif; ?>

              </th>
            <?php endif; ?>

            <?php if ($this->params->get('list_show_author')) : ?>

              <th id="categorylist_header_author">
                <?php echo HTMLHelper::_('grid.sort', 'JAUTHOR', 'author', $listDirection, $listOrder); ?>
              </th>

            <?php endif; ?>

            <?php if ($this->params->get('list_show_hits')) : ?>

              <th id="categorylist_header_hits">
                <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirection, $listOrder); ?>
              </th>

            <?php endif; ?>

            <?php if ($isEditable) : ?>

              <th id="categorylist_header_edit"><?php echo Text::_('COM_CONTENT_EDIT_ITEM'); ?></th>

            <?php endif; ?>

          </tr>
        </thead>
      <?php endif; ?>

      <tbody>
        <?php foreach ($this->items as $i => $article) : ?>

          <?php if ($this->items[$i]->state == 0) : ?>

            <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">

          <?php else: ?>

            <tr class="cat-list-row<?php echo $i % 2; ?>" >

          <?php endif; ?>

            <td headers="categorylist_header_title" class="list-title">

              <?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>

                <a href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>">
                  <?php echo $this->escape($article->title); ?>
                </a>

              <?php else: ?>

                <?php
                  echo $this->escape($article->title).' : ';

                  $menu		   = Factory::getApplication()->getMenu();
                  $active		 = $menu->getActive();
                  $itemId		 = $active->id;
                  $link      = Route::_('index.php?option=com_users&view=login&Itemid='.$itemId);
                  $returnURL = Route::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));

                  $fullURL   = new Uri($link);
                  $fullURL->setVar('return', base64_encode($returnURL));
                ?>

                <a href="<?php echo $fullURL; ?>" class="register">
                  <?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
                </a>

              <?php endif; ?>

              <?php if ($article->state == 0) : ?>

                <span class="list-published label label-warning">
                  <?php echo Text::_('JUNPUBLISHED'); ?>
                </span>

              <?php endif; ?>

              <?php if (strtotime($article->publish_up) > strtotime(Factory::getDate())) : ?>

                <span class="list-published label label-warning">
                  <?php echo Text::_('JNOTPUBLISHEDYET'); ?>
                </span>

              <?php endif; ?>

              <?php if ((strtotime($article->publish_down) < strtotime(Factory::getDate())) && $article->publish_down != '0000-00-00 00:00:00') : ?>

                <span class="list-published label label-warning">
                  <?php echo Text::_('JEXPIRED'); ?>
                </span>

              <?php endif; ?>

            </td>

            <?php if ($this->params->get('list_show_date')) : ?>

              <td headers="categorylist_header_date" class="list-date small">
                <?php echo HTMLHelper::_('date', $article->displayDate, $this->escape($this->params->get('date_format', Text::_('DATE_FORMAT_LC3')))); ?>
              </td>

            <?php endif; ?>

            <?php if ($this->params->get('list_show_author', 1)) : ?>

              <td headers="categorylist_header_author" class="list-author">

                <?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>

                  <?php
                    $author = $article->author
                    $author = ($article->created_by_alias ? $article->created_by_alias : $author);
                  ?>

                  <?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>

                    <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $article->contact_link, $author)); ?>

                  <?php else: ?>

                    <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>

                  <?php endif; ?>

                <?php endif; ?>

              </td>

            <?php endif; ?>

            <?php if ($this->params->get('list_show_hits', 1)) : ?>

              <td headers="categorylist_header_hits" class="list-hits">
                <span class="badge badge-info">
                  <?php echo Text::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
                </span>
              </td>

            <?php endif; ?>

            <?php if ($isEditable) : ?>

              <td headers="categorylist_header_edit" class="list-edit">

                <?php if ($article->params->get('access-edit')) : ?>

                  <?php echo HTMLHelper::_('icon.content_edit', $article, $params); ?>

                <?php endif; ?>

              </td>

            <?php endif; ?>

          </tr>

        <?php endforeach; ?>

      </tbody>
    </table>

  <?php endif; ?>

  <?php // Code to add a link to submit an article. ?>
  <?php if ($this->category->getParams()->get('access-create')) : ?>

    <?php echo HTMLHelper::_('icon.content_create', $this->category, $this->category->params); ?>

  <?php  endif; ?>

  <?php // Add pagination links ?>
  <?php if (!empty($this->items)) : ?>

    <?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>

      <div class="pagination">

        <?php if ($this->params->def('show_pagination_results', 1)) : ?>

          <p class="counter pull-right">
            <?php echo $this->pagination->getPagesCounter(); ?>
          </p>

        <?php endif; ?>

        <?php echo $this->pagination->getPagesLinks(); ?>
      </div>

    <?php endif; ?>

  </form>

<?php endif;
