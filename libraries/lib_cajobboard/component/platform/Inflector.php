<?php
/**
 * Overridden Platform class
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

use \FOF30\View\View;

// no direct access
defined('_JEXEC') or die;

/**
 * An Inflector to pluralize and singularize English nouns.
 */
class Inflector extends \FOF30\Inflector\Inflector
{
	/**
	 * Add an uncountable word
	 *
	 * @param   string 		$word 	The uncountable word to add to the list.
	 *
	 * @return  void
	 */
	public function addUncountableWord($word)
	{
		array_push( $this->rules['uncountable'], $word );
	}


	/**
	 * Returns a human-readable string from $word.
	 *
	 * Returns a human-readable string from $word, by replacing
	 * underscores with a space, and by upper-casing the initial
	 * character by default.
	 *
	 * @param   string $word String to "humanize"
	 *
	 * @return string Human-readable word
	 */
	public function humanize($word)
	{
		return ucwords( strtolower( str_replace( "_", " ", $this->underscore($word) ) ) );
	}


	/**
	 * Convert a CamelCased word into a hyphenated-word
	 *
	 * @param   string  $word   Word to hyphenate
	 *
	 * @return  string  Returns the hyphenated word
	 */
	public function hyphenate($word)
	{
    $word = preg_replace('/(\s)+/', '-', $word);

    $word = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '-\\1', $word));

		return $word;
	}


	/**
	 * Check to see if an Enlish word is plural. Over-ridden to consider uncountable
	 * words as plural (instead of singular as in base method). Allows URLs with no
	 * specified task to default to a 'browse' view, rather than an 'add' view.
	 *
	 * @param   string $string String to be checked.
	 *
	 * @return boolean
	 */
	public function isPlural($string)
	{
		if (in_array($string, $this->rules['uncountable']))
		{
			return true;
		}

		return parent::isPlural($string);
	}


	/**
	 * @param string $name
	 *
	 * @return string  Returns the view/model name in camel-cased plural form
	 */
	public function normalizeMediaAssetName($name)
	{
    return $this->underscore( $this->pluralize($name) );
	}


	/**
	 * Converts PascalCase or camelCase to snake_case, overridden to handle acronyms
	 *
	 * @param   string  $word  Word to camel_case
	 *
	 * @return string camel_cased word
   *
   * Examples:
   *
   *   'simpleTest'       'simple_test'
   *   'easy'             'easy'
   *   'HTML'             'html'
   *   'simpleXML'        'simple_xml'
   *   'PDFFile'          'pdf_file'
   *   'startMIDDLELast'  'start_middle_last'
   *   'AString'          'a_string'
   *   'Some4Numbers234'  'some4_numbers234'
   *   'TEST123String'     'test123_string'
	 */
	public function underscore($word)
	{
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $word, $matches);

    $ret = $matches[0];

    foreach ($ret as &$match) {
      $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }

    return implode('_', $ret);
	}
}
