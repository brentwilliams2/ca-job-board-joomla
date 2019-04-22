<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

class PositionRenderer
{
  /*
   * An array of partial files in the template's Partials directory
   *
   * @var array
   */
  private $partialFiles = array();

  /*
   * Instance Document object of the caller ($this)
   *
   * @var \Joomla\CMS\Document\Document
   */
  private $document = null;

  /*
   * Array keyed with module position names, values are the count from the database for each position
   *
   * @var array
   */
  private $moduleCount = array();

  /*
   *Array of positions required on both Html and Error Documents to have HTMl output generated for
   *
   * @var array
   */
  private $requiredPositions = array();


  public function __construct($document)
  {
    $this->moduleCount = $document->moduleCount;
    $this->requiredPositions = $document->requiredPositions;

    $this->document = $document;

    $this->initPartialFilesProp();
  }


  private function initPartialFilesProp()
  {
    $fileArray = scandir( realpath(  dirname(__FILE__) . '/../Partials' ) );

    foreach ($fileArray as $file)
    {
      preg_match('/\.[^\.]+$/i', $file, $fileExtOut);

      $fileExt = array_key_exists(0, $fileExtOut) ? $fileExtOut[0] : '';

      if ($file == '.' || $file == '..' || $fileExt !== '.php')
      {
        continue;
      }

      $this->partialFiles[] = str_replace('_', '-', ltrim( str_replace('.php', '', $file), '_' ));
    }
  }


  /*
   * Function to render a module position with no wrapper
   *
   * @param  string   $className        The classname for this include, matching a module position
   *                                    and a partial: 'banner-top' to include '_banner_top.php'
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withNoWrapper($className)
  {
    return $this->includePartial($className);
  }


  /*
   * Function to render a module position with a single div wrapper
   *
   * @param  string   $className        The classname for this include, matching a module position
   *                                    and a partial: 'banner-top' to include '_banner_top.php'
   *
   * @param  string   $classNameSuffix  A suffix to add to the container div class, as the classname
   *                                    is used in the partial as a class. Default is 'container'.
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withDivWrapper($className, $classNameSuffix = 'container')
  {
    $class = $className . '-' . $classNameSuffix;

    $html = null;

    if( $this->shouldInclude($className) )
    {
      $html .= '<div id="' . $class . '" class="' . $className . $classNameSuffix . '">';

      $html .= $this->includePartial($className);

      $html .= '</div>';
    }

    return $html;
  }


  /*
   * Function to render a Bootstrap v3 column container
   *
   * @param  string   $className        The classname for this include, matching a module position
   *                                    and a partial: 'banner-top' to include '_banner_top.php'
   *
   * @param  string   $colClasses       Bootstrap v3 column classes to apply, e.g. 'col-xs-12'. Defaults to null.
   *
   * @param  string   $classNameSuffix  A suffix to add to the container div class, as the classname
   *                                    is used in the partial as a class. Default is 'container'.
   *
   * @param  bool     $setClassNameOnCol   Whether the classname should be set on the column div or not
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withColumnWrapper($className, $colClasses = null, $classNameSuffix = 'container', $setClassNameOnCol = true)
  {
    $class = $className . '-' . $classNameSuffix;

    $html = null;

    if( $this->shouldInclude($className) )
    {
      $html .= '<div ';

      if ($setClassNameOnCol)
      {
        // add the className + suffix and set both colClass and colId
        $html .= 'id="' . $class . '" ';

        if ($colClasses)
        {
          // add a space after className + suffix, and append colClass
          $html .= 'class="' . $class . ' ' . $this->getColClass($colClasses). '">';
        }
      }
      elseif ($colClasses)
      {
        // only adding colClasses, no id="" or className + suffix on class="", so no space character needed
        $html .= 'class="' . $class . ' ' . $this->getColClass($colClasses). '">';
      }
      else
      {
        // here if $setClassNameOnCol = false and $colClasses = false, it's a plain div wrapper
        $html = $this->withDivWrapper($className, $classNameSuffix);
      }

      // here we need to include, and then close the tag
      $html .= $this->includePartial($className);

      $html .= '</div>';
    }

    return $html;
  }


  /*
   * Decorator function to render a Bootstrap v3 row container.
   *
   * @param  string   $className        The classname for this include, matching a module position
   *                                    and a partial: 'banner-top' to include '_banner_top.php'
   *
   * @param  string   $colClasses       Bootstrap v3 column classes to apply, e.g. 'col-xs-12'. Defaults to null.
   *
   * @param  string   $classNameSuffix  A suffix to add to the container div class, as the classname
   *                                    is used in the partial as a class. Default is 'container'.
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withRowAndColumnWrapper($className, $colClasses = null, $classNameSuffix = 'container')
  {
    $html = null;

    if( $this->shouldInclude($className) )
    {
      $classId = $className . $classNameSuffix;

      $html .= '<div id="' . $classId . '" class="' . $classId . ' row">';

      $html .= $this->withColumnWrapper($className, $colClasses, $classNameSuffix, false);

      $html .= '</div>';
    }

    return $html;
  }


  public function includePartial($className)
  {
    if ( in_array($className, $this->partialFiles) )
    {
      // We need the Html or Error Document context for the partial include, not the PostionRenderer
      // context of $this so using anonymous function and binding the Document's context in the closure
      $partial = function($className)
      {
        ob_start();

        include realpath(  dirname(__FILE__) . '/../Partials' ) . '/_' . str_replace('-', '_', $className) . '.php';

        $partial = ob_get_clean();

        return $partial;
      };

      $partial = $partial->bindTo($this->document);

      $partialOutput = $partial($className);

      return $partialOutput;
    }
    else
    {
      return '<jdoc:include type="modules" name="' . $className . '" style="none" />';
    }
  }


  private function shouldInclude($className)
  {
    if ( in_array($className, $this->requiredPositions) || $this->moduleCount[$className] > 0 )
    {
      return true;
    }

    return false;
  }


  private function getColClass($colClasses)
  {
    $colClass = null;

    if ($colClasses)
    {
      foreach ( explode(' ', $colClasses) as $class )
      {
        $colClass .= ' ' . $class;
      }
    }

    return ltrim($colClass);
  }
}
