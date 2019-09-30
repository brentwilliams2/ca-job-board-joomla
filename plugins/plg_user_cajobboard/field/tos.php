<?php
/**
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('radio');

/**
 * Provides input for Terms of Service
 */
class JFormFieldTos extends JFormFieldRadio
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  2.5.5
	 */
  protected $type = 'Tos';

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 *
	 * @since   2.5.5
	 */
	protected function getLabel()
	{
    $label = '';

    if ($this->hidden) return $label;

		// Get the label text from the XML element, defaulting to the element name.
		$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
    $text = $this->translateLabel ? JText::_($text) : $text;

		// Set required to true as this field is not displayed at all if not required.
    $this->required = true;

		// Add CSS and JS for the TOS field
    $doc = JFactory::getDocument();

		$css = '#jform_profile_tos {width: 18em; margin: 0 !important; padding: 0 2px !important;}
				#jform_profile_tos input {margin: 0 5px 0 0 !important; width: 10px !important;}
				#jform_profile_tos label {margin: 0 15px 0 0 !important; width: auto;}
        ';

    $doc->addStyleDeclaration($css);

    JHtml::_('behavior.modal');

    // Build the class for the label.
		$class = !empty($this->description) ? 'hasPopover' : '';
		$class = $class . ' required';
    $class = !empty($this->labelClass) ? $class . ' ' . $this->labelClass : $class;

		// Add the opening label tag and main attributes attributes.
    $label .= '<label id="' . $this->id . '-lbl" for="' . $this->id . '" class="' . $class . '"';

		// If a description is specified, use it to build a tooltip.
		if (!empty($this->description))
		{
			$label .= ' title="' . htmlspecialchars(trim($text, ':'), ENT_COMPAT, 'UTF-8') . '"';
			$label .= ' data-content="' . htmlspecialchars(
				$this->translateDescription ? JText::_($this->description) : $this->description,
				ENT_COMPAT,
				'UTF-8'
			) . '"';
    }

    // @TODO: Uses 'article' attribute of XML form to set article id number, need to make this settable as a parameter
    $tosArticle = $this->element['article'] > 0 ? (int) $this->element['article'] : 0;

		if ($tosArticle)
		{
      JLoader::register('ContentHelperRoute', JPATH_BASE . '/components/com_content/helpers/route.php');

      $db = JFactory::getDbo();

      $query = $db->getQuery(true)
        ->select('id, alias, catid, language')
				->from('#__content')
        ->where('id = ' . $tosArticle);

      $article = $db->setQuery($query)->loadObject();

			if (JLanguageAssociations::isEnabled())
			{
				$tosAssociated = JLanguageAssociations::getAssociations('com_content', '#__content', 'com_content.item', $tosArticle);
      }

      $currentLang = JFactory::getLanguage()->getTag();

			$attribs          = array();
			$attribs['class'] = 'modal';
      $attribs['rel']   = '{handler: \'iframe\', size: {x:800, y:500}}';

			if (isset($tosAssociated) && $currentLang !== $article->language && array_key_exists($currentLang, $tosAssociated))
			{
				$url = ContentHelperRoute::getArticleRoute(
					$tosAssociated[$currentLang]->id,
					$tosAssociated[$currentLang]->catid,
					$tosAssociated[$currentLang]->language
        );

				$link = JHtml::_('link', JRoute::_($url . '&tmpl=component'), $text, $attribs);
			}
			else
			{
				$slug = $article->alias ? ($article->id . ':' . $article->alias) : $article->id;
				$url  = ContentHelperRoute::getArticleRoute($slug, $article->catid, $article->language);
				$link = JHtml::_('link', JRoute::_($url . '&tmpl=component'), $text, $attribs);
			}
		}
		else
		{
			$link = $text;
    }

		// Add the label text and closing tag.
		$label .= '>' . $link . '<span class="star">&#160;*</span></label>';
		return $label;
	}
}