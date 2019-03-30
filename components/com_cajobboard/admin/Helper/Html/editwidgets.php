<?php
/**
 * Custom Joomla! HTMLHelper class for admin edit view controls
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.editWidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helperrs included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system

// no direct access
defined('_JEXEC') or die;

use FOF30\Utils\ArrayHelper;
use \FOF30\Utils\SelectOptions;

use Calligraphic\Cajobboard\Admin\Helper\CategoryHelper;

abstract class HelperEditWidgets
{
	/**
	 * "Parent" widget for models that have an ownership hierarchy
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function parent()
	{
    $label = JText::_('JPARENT');

    $html = <<<EOT
<label for="parent">$label</label>
<span name="parent" class="" aria-hidden="true"><i>Implement ViewTemplates/Common/HelperEditWidgets::parent</i></span>
EOT;

		return $html;
  }


	/**
	 * "Published" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function published($selected = False)
	{
    $options = array(
      '1'  => JText::_('JPUBLISHED'),
      '0'  => JText::_('JUNPUBLISHED'),
      '2'  => JText::_('JARCHIVED'),
      '-2' =>	JText::_('JTRASHED'),
    );

    $label = JText::_('JSTATUS');

    $html = '<label for="enabled">' . $label . '</label>';
    $html .= '<select id="enabled" name="enabled" class="chzn-color-state" size="1" style="display: none;">';

    foreach ($options as $option => $label)
    {
      if($option === $selected)
      {
        $html .= "<option value=\"$option\" selected=\"selected\">$label</option>";
      }
      else
      {
        $html .= "<option value=\"$option\">$label</option>";
      }
    }

    $html .= '</select>';

		return $html;
  }


	/**
	 * "Category" widget for edit sidebar
   *
   * @param   string    $cat_id   The category id of this item
	 *
	 * @return  string    HTML string of the <select> control for categories
	 *
	 * @since   0.1
	 */
	public static function category($cat_id)
	{
    $html  = '<div class="control-group">';
    $html .= '<div class="control-label">';
    $html .= '<label id="jform_catid-lbl" for="jform_catid" class="hasPopover required" title="">';
    $html .= JText::_('JCATEGORY');
    $html .= '</label>';
    $html .= '</div>';

    $html .= '<div class="controls">';
    $html .= '<select id="jform_catid" name="cat_id" class="required chzn-custom-value" required="required" aria-required="true" onchange="categoryHasChanged(this);" style="display: none;">';

    $categories = CategoryHelper::getCategories();

    $selected = CategoryHelper::selectedHelper($categories, $cat_id);

    foreach($categories as $category)
    {
      $select = $selected == $category->id ? 'selected' : NULL;
      $html .= '<option value="' . $category->id . '" ' . $select . '>';
      $html .= CategoryHelper::getIndentedCategoryTitle($category);
      $html .= '</option>';
    }

    $html .= '</select>';
    $html .= '</div>';
    $html .= '</div>';

		return $html;
  }


	/**
	 * "Featured" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function featured($isFeatured = False)
	{
    $label = JText::_('JFEATURED');
    $yes   = JText::_('JYES');
    $no    = JText::_('JNO');

    $html  = '<label for="featured">'. $label . '</label>';
    $html .= '<fieldset id="featured" class="btn-group btn-group-yesno radio">';

    if( $isFeatured )
    {
      $html .= '<input type="radio" id="featured0" name="[featured]" value="1" checked="checked">';
      $html .= '<label for="featured0" class="btn active btn-success">' . $yes . '</label>';

      $html .= '<input type="radio" id="featured1" name="[featured]" value="0">';
      $html .= '<label for="featured1" class="btn">' . $no . '</label>';
    }
    else
    {
      $html .= '<input type="radio" id="featured0" name="[featured]" value="1">';
      $html .= '<label for="featured0" class="btn">' . $yes . '</label>';

      $html .= '<input type="radio" id="featured1" name="[featured]" value="0" checked="checked">';
      $html .= '<label for="featured1" class="btn active btn-danger">' . $no . '</label>';
    }

    $html .= '</fieldset>';

    return $html;
  }

	/**
	 * "Access" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function access($access)
	{
    $label = JText::_('JFIELD_ACCESS_LABEL');

    $html = '<label for="access">' . $label . '</label>';

    $html .= \JHtml::_(
      'FEFHelper.select.genericlist',
      SelectOptions::getOptions('access'),
      'access',
      ['list.select' => $access]
    );

		return $html;
  }


  /**
	 * "Language" control for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function languages($language)
	{
    $label = JText::_('JFIELD_LANGUAGE_LABEL');

    $html = '<label for="languages">' . $label . '</label>';

    $html .= \JHtml::_(
      'FEFHelper.select.genericlist',
      SelectOptions::getOptions('languages'),
      'languages',
      ['list.select' => $language]
    );

		return $html;
  }


	/**
	 * "Tags" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function tags($answer_id)
	{
    $label = JText::_('JTAG');

    $html = <<<EOT
<div class="controls">
  <label for="admin_tags">$label</label>
  <select
    id="admin_tags"
    name="admin_tags[tags]"
    class="admin_tags"
    style="display: none;"
    data-placeholder="Choose a tag..."
    multiple
  >
EOT;

    // get list of all enabled tags on site for user to select from:
    $siteTags = JHtml::_('tag.tags', ['filter.published' => 1]);

    if ($siteTags)
    {
      foreach ($siteTags as $siteTag)
      {
        $html .= "<option value=\"$siteTag->value\">$siteTag->text</option>";
      }
    }

    $html .= '</select></div>';

    // get tags for this item:
    $setTags = new \JHelperTags;
    $setTags->getItemTags('com_cajobboard.answers', $answer_id);

    // add script tag for JQuery Chosen library to set the selected
    // property for tags that are associated with this item:
    if ($setTags->itemTags)
    {
      $selected = array_keys($setTags->itemTags);

      $html .= <<<EOT
<script>
  $("#admin_tags").val($selected).trigger("chosen:updated");
</script>
EOT;
    }
		return $html;
  }


	/**
	 * "Note" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function note($text = null)
	{
    $label = JText::_('JNOTE');

    $html = <<<EOT
<label for="note">$label</label>
<input type="text" name="note" id="note" value="$text"/>
EOT;

    return $html;
  }



	/**
	 * "Version Note" widget (content history) for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function versionNote($text = null)
	{
    $label = JText::_('JGLOBAL_FIELD_VERSION_NOTE_LABEL');

    $html = <<<EOT
<label for="version_note">$label</label>
<input type="text" name="version_note" id="version_note" value="$text"/>
EOT;

    return $html;
  }

}
