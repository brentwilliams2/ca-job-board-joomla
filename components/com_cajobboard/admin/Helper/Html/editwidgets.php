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
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and HTMLHelper system

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Helper\TagsHelper;
use \Joomla\CMS\HTML\HTMLHelper;
use \FOF30\Utils\SelectOptions;
use Calligraphic\Cajobboard\Admin\Helper\Category;

abstract class HelperEditWidgets
{

	/**
	 * "Access" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function access($access)
	{
    $label = Text::_('JFIELD_ACCESS_LABEL');

    $html = '<label for="access">' . $label . '</label>';

    $html .= HTMLHelper::_(
      'FEFHelper.select.genericlist',
      SelectOptions::getOptions('access'),
      'access',
      ['list.select' => $access]
    );

		return $html;
  }


	/**
	 * "Category" widget for edit sidebar
   *
   * @param   null|string    $cat_id   The category id of this item, or null for new records.
   * @param   string         $view     The name of the view, for setting a category on new records. Should be plural e.g. 'Answers'
	 *
	 * @return  string    HTML string of the <select> control for categories
	 *
	 * @since   0.1
	 */
	public static function category($cat_id, $view)
	{
    $html  = '<div class="control-group">';
    $html .= '<div class="control-label">';
    $html .= '<label id="jform_catid-lbl" for="jform_catid" class="hasPopover required" title="">';
    $html .= Text::_('JCATEGORY');
    $html .= '</label>';
    $html .= '</div>';

    $html .= '<div class="controls">';
    $html .= '<select id="jform_catid" name="cat_id" class="required chzn-custom-value" required="required" aria-required="true" onchange="categoryHasChanged(this);" style="display: none;">';

    $categories = Category::getCategories();

    $selected = Category::selectedHelper($categories, $cat_id, $view);

    foreach($categories as $category)
    {
      $select = $selected == $category->id ? 'selected' : NULL;
      $html .= '<option value="' . $category->id . '" ' . $select . '>';
      $html .= Category::getIndentedCategoryTitle($category);
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
    $label = Text::_('JFEATURED');
    $yes   = Text::_('JYES');
    $no    = Text::_('JNO');

    $html  = '<label for="featured">'. $label . '</label>';
    $html .= '<fieldset id="featured" class="btn-group btn-group-yesno radio">';

    if( $isFeatured )
    {
      $html .= '<input type="radio" id="featured0" name="featured" value="1" checked="checked">';
      $html .= '<label for="featured0" class="btn active btn-success">' . $yes . '</label>';

      $html .= '<input type="radio" id="featured1" name="featured" value="0">';
      $html .= '<label for="featured1" class="btn">' . $no . '</label>';
    }
    else
    {
      $html .= '<input type="radio" id="featured0" name="featured" value="1">';
      $html .= '<label for="featured0" class="btn">' . $yes . '</label>';

      $html .= '<input type="radio" id="featured1" name="featured" value="0" checked="checked">';
      $html .= '<label for="featured1" class="btn active btn-danger">' . $no . '</label>';
    }

    $html .= '</fieldset>';

    return $html;
  }


  /**
	 * Generic number input widget
   *
   * @param   string                  $fieldName  The name of the model field this textbox should be generated for
   * @param   \FOF30\Model\DataModel  $item       The instance item model
	 *
	 * @return  string
	 */
	public static function inputNumber($fieldName, $item)
	{
    $uppercaseFieldName = strtoupper($fieldName);
    $fieldValue = $item->$fieldName;

    $tooltipTitle = Text::_('COM_CAJOBBOARD_' . $uppercaseFieldName . '_FIELD_TOOLTIP_TITLE');
    $tooltipText = Text::_('COM_CAJOBBOARD_' . $uppercaseFieldName . '_FIELD_TOOLTIP_TEXT');
    $labelText = Text::_('COM_CAJOBBOARD_' . $uppercaseFieldName . '_FIELD_LABEL');

    $html = <<<EOT
<fieldset
  name="$fieldName"
  class="control-group hasTip"
  title="$tooltipTitle::$tooltipText"
>
  <div class="control-label">
    <label for="$fieldName">
      $labelText
    </label>
  </div>
  <div class="controls">
    <input type="number" step="1" name="$fieldName" id="$fieldName" value="$fieldValue"/>
  </div>
</fieldset>
EOT;

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
    $html = '<label for="languages">' . Text::_('JFIELD_LANGUAGE_LABEL') . '</label>';

    $languageOptions = SelectOptions::getOptions('languages');

    // Change '*' to translation of 'All' in the options drop-down
    for ($i = 0; $i < count( $languageOptions ); $i++)
    {
      // FOF getOptions() method returns both objects and arrays
      if (is_array($languageOptions[$i]))
      {
        $languageOptions[$i] = (object) $languageOptions[$i];
      }

      // 'value' property is the short form of language name, e.g. en-GB
      if ($languageOptions[$i]->value === '*')
      {
        $languageOptions[$i]->text = Text::_('COM_CAJOBBOARD_ALL');
      }
    }

    // Change '*' to translation of 'All' if that is the current setting
    if ($language === '*')
    {
      $language = Text::_('COM_CAJOBBOARD_ALL');
    }

    $html .= HTMLHelper::_(
      'FEFHelper.select.genericlist',
      $languageOptions,
      'language',
      ['list.select' => $language]
    );

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
    $label = Text::_('JNOTE');

    $html = <<<EOT
<label for="note">$label</label>
<input type="text" name="note" id="note" value="$text"/>
EOT;

    return $html;
  }


  /**
	 * "Parent" widget for models that have an ownership hierarchy
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function parent()
	{
    $label = Text::_('JPARENT');

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
      '1'  => Text::_('JPUBLISHED'),
      '0'  => Text::_('JUNPUBLISHED'),
      '2'  => Text::_('JARCHIVED'),
      '-2' =>	Text::_('JTRASHED'),
    );

    $label = Text::_('JSTATUS');

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
	 * "Tags" widget for edit sidebar
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function tags($answer_id)
	{
    // @TODO: Tags are **NOT** saving from admin edit screens
    $label = Text::_('JTAG');

    $html = <<<EOT
<div class="controls">
  <label for="admin_tags">$label</label>
  <select
    id="tags"
    name="tags"
    class="admin_tags"
    style="display: none;"
    data-placeholder="Choose a tag..."
    multiple
  >
EOT;

    // get list of all enabled tags on site for user to select from:
    $siteTags = HTMLHelper::_('tag.tags', ['filter.published' => 1]);

    if ($siteTags)
    {
      foreach ($siteTags as $siteTag)
      {
        $html .= "<option value=\"$siteTag->value\">" . Text::_($siteTag->text) . "</option>";
      }
    }

    $html .= '</select></div>';

    // get tags for this item:
    $setTags = new TagsHelper;
    $setTags->getItemTags('com_cajobboard.answers', $answer_id);

    // add script tag for JQuery Chosen library to set the selected
    // property for tags that are associated with this item:
    if ($setTags->itemTags)
    {
      // @TODO: this could include a link to the tag edit page for each tag:
      // \JLoader::register('TagsHelperRoute', \JPATH_SITE . '/components/com_tags/helpers/route.php');
			// $html .= '<a href="' . \JRoute::_(\TagsHelperRoute::getTagRoute($tag->id)) . '">';

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
	 * Generic textbox widget
   *
   * @param   string                  $fieldName  The name of the model field this textbox should be generated for
   * @param   \FOF30\Model\DataModel  $item       The instance item model
	 *
	 * @return  string
	 */
	public static function textbox($fieldName, $item)
	{
    $uppercaseFieldName = strtoupper($fieldName);
    $fieldValue = Text::_($item->$fieldName);

    $tooltipTitle = Text::_('COM_CAJOBBOARD_' . $uppercaseFieldName . '_FIELD_TOOLTIP_TITLE');
    $tooltipText = Text::_('COM_CAJOBBOARD_' . $uppercaseFieldName . '_FIELD_TOOLTIP_TEXT');
    $labelText = Text::_('COM_CAJOBBOARD_' . $uppercaseFieldName . '_FIELD_LABEL');

    $html = <<<EOT
<fieldset
  name="$fieldName"
  class="control-group hasTip"
  title="$tooltipTitle::$tooltipText"
>
  <div class="control-label">
    <label for="$fieldName">
      $labelText
    </label>
  </div>
  <div class="controls">
    <textarea name="$fieldName" id="$fieldName" rows="5">$fieldValue</textarea>
  </div>
</fieldset>
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
    // @TODO: Version notes are **NOT** saving from admin edit screens
    $label = Text::_('JGLOBAL_FIELD_VERSION_NOTE_LABEL');

    $html = <<<EOT
<label for="version_note">$label</label>
<input type="text" name="version_note" id="version_note" value="$text"/>
EOT;

    return $html;
  }

}
