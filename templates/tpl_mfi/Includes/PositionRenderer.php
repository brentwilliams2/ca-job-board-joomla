<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * @package     Calligraphic Job Board
 *
 * @version     April 2, 2009
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2019 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

/**
 * This class is to allow using a more readable syntax for loading modules in the template,
 * and to allow using a single template for normal, error, and offline template pages.
 * There are three entry points to a template in Joomla!, all in the root directory of the
 * template: index.php, error.php, and offline.php. Modules can be loaded in both error and
 * offline pages, but the routines to count modules at a position are not available. Also,
 * this class provides the ability to *require* certain modules to be present at given positions
 * so that when they are not included (e.g. the search or login/logout modules), the template
 * fails fast.
 */
class PositionRenderer
{
  /**
   * An array of partial files in the template's Partials directory
   *
   * @var array
   */
  private $partialFiles = array(
    'body',
    'breadcrumbs',
    'component',
    'content-component-output',
    'content-message',
    'copyright',
    'debug',
    'error',
    'error-trace',
    'head',
    'login',
    'logo-footer',
    'logo-header',
    'message',
    'nav-component',
    'nav-footer',
    'nav-primary',
    'nav-secondary',
    'offline',
    'search-footer',
    'search-header',
    'shopping-cart',
    'social-icons'
  );


  /**
   * Instance Document object of the caller ($this)
   *
   * @var \Joomla\CMS\Document\Document
   */
  private $document = null;


  /**
   * Array keyed with module position names, values are the count from the database for each position
   *
   * @var array
   */
  private $moduleCount = array();


  /**
   * Array of positions required on both Html and Error Documents that must have HTMl output generated
   *
   * @var array
   */
  private $requiredPositions = array();


  /**
   * Class constructor
   *
   * @param \Joomla\CMS\Document\Document $document
   */
  public function __construct($document)
  {
    $this->document = $document;

    $this->moduleCount = $this->document->moduleCount;

    $this->requiredPositions = $this->document->requiredPositions;
  }


  /**
   * Function to render a module position with no wrapper element
   *
   * @param  string   $modulePositionName   The name for this include, matching a module position and a partial: use 'banner-top' to include '_banner_top.php'
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withNoWrapper($modulePositionName)
  {
    return $this->includePartial($modulePositionName);
  }


  // @TODO: Factor out the "AddedClasses" methods and check for parameters, need to redo all method signatures

  /**
   * Function to render a module position with a single div wrapper and a
   * default '*-container' class, where the wildcard is the position name
   *
   * @param  string   $modulePositionName   The name for this include, matching a module position and a partial: use 'banner-top' to include '_banner_top.php'
   * @param  string   $modulePositionNameSuffix   A suffix to add to the container div class, as the module position name is used in the partial as a class. Default is 'container'.
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withDivWrapper($modulePositionName, $modulePositionNameSuffix = 'container')
  {
    $class = $modulePositionName . '-' . $modulePositionNameSuffix;

    $html = null;

    if( $this->shouldInclude($modulePositionName) )
    {
      $html .= '<div id="' . $class . '" class="' . $modulePositionName . $modulePositionNameSuffix . '">';

      $html .= $this->includePartial($modulePositionName);

      $html .= '</div>';
    }

    return $html;
  }


  /**
   * Function to render a module position wrapped in a <div> element with a default
   * '*-container' class and add'l classes, where the wildcard is the position name
   *
   * @param  string   $modulePositionName   The name for this include, matching a module position and a partial: use 'banner-top' to include '_banner_top.php'
   * @param  string   $colClasses           Bootstrap v3 column classes to apply, e.g. 'col-xs-12'. Defaults to null.
   * @param  string   $modulePositionNameSuffix   A suffix to add to the container div class, as the module position name is used in the partial
   * @param  bool     $setClassNameOnCol   Whether the classname should be set on the column div or not
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withAddedClassesDivWrapper($modulePositionName, $colClasses = null, $modulePositionNameSuffix = 'container', $setClassNameOnCol = true)
  {
    return $this->withAddedClassesElementWrapper($modulePositionName, $colClasses, $modulePositionNameSuffix, $setClassNameOnCol, 'div');
  }


  /**
   * Function to render a module position wrapped in a <div> element with a default
   * '*-container' class and add'l classes, where the wildcard is the position name
   *
   * @param  string   $modulePositionName   The name for this include, matching a module position and a partial: use 'banner-top' to include '_banner_top.php'
   * @param  string   $colClasses           Bootstrap v3 column classes to apply, e.g. 'col-xs-12'. Defaults to null.
   * @param  string   $modulePositionNameSuffix   A suffix to add to the container div class, as the module position name is used in the partial
   * @param  bool     $setClassNameOnCol   Whether the classname should be set on the column div or not
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withAddedClassesLiWrapper($modulePositionName, $colClasses = null, $modulePositionNameSuffix = 'container', $setClassNameOnCol = true)
  {
    return $this->withAddedClassesElementWrapper($modulePositionName, $colClasses, $modulePositionNameSuffix, $setClassNameOnCol, 'li');
  }


  /**
   * Wrap a partial include with a default class and id, any additional classes, and to specify the wrapping element
   *
   * @param  string   $modulePositionName   The name for this include, matching a module position and a partial: use 'banner-top' to include '_banner_top.php'
   * @param  string   $colClasses           Bootstrap v3 column classes to apply, e.g. 'col-xs-12'. Defaults to null.
   * @param  string   $modulePositionNameSuffix   A suffix to add to the container div class, as the module position name is used in the partial
   * @param  bool     $setClassNameOnCol   Whether the classname should be set on the column div or not
   * @param string $element
   *
   * @return void
   */
  private function withAddedClassesElementWrapper($modulePositionName, $colClasses = null, $modulePositionNameSuffix = 'container', $setClassNameOnCol = true, $element = 'div')
  {
    $class = $modulePositionName . '-' . $modulePositionNameSuffix;

    $html = null;

    if( $this->shouldInclude($modulePositionName) )
    {
      $html .= '<' . $element . ' ';

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
        $html = $this->withDivWrapper($modulePositionName, $modulePositionNameSuffix);
      }

      // here we need to include, and then close the tag
      $html .= $this->includePartial($modulePositionName);

      $html .= '</'. $element . '>';
    }

    return $html;
  }


  /*
   * Decorator function to render a Bootstrap v3 row container, and a module position's output
   * wrapped in a <div> with a default '*-container' class and add'l classes, where the wildcard
   * is the position name.
   *
   * @param  string   $modulePositionName   The name for this include, matching a module position and a partial: 'banner-top' to include '_banner_top.php'
   * @param  string   $colClasses       Bootstrap v3 column classes to apply, e.g. 'col-xs-12'. Defaults to null.
   * @param  string   $modulePositionNameSuffix  A suffix to add to the container div class, as the classnam is used in the partial as a class. Default is 'container'.
   *
   * @return string   Returns a string of html to echo to the output buffer
   */
  public function withRowAndColumnWrapper($modulePositionName, $colClasses = null, $modulePositionNameSuffix = 'container')
  {
    $html = null;

    if( $this->shouldInclude($modulePositionName) )
    {
      $classId = $modulePositionName . $modulePositionNameSuffix;

      $html .= '<div id="' . $classId . '" class="' . $classId . ' row">';

      $html .= $this->withAddedClassesDivWrapper($modulePositionName, $colClasses, $modulePositionNameSuffix, false);

      $html .= '</div>';
    }

    return $html;
  }


  /**
   * Buffer output of a partial include, named after template module
   * positions. The partial should render the module(s) for the position.
   *
   * @param string $modulePositionName
   *
   * @return void
   */
  public function includePartial($modulePositionName)
  {
    if ( in_array($modulePositionName, $this->partialFiles) )
    {
      // We need the Html or Error Document context for the partial include, not the PostionRenderer
      // context of $this so using anonymous function and binding the Document's context in the closure
      $partial = function($modulePositionName)
      {
        ob_start();

        include realpath(  dirname(__FILE__) . '/../Partials' ) . '/_' . str_replace('-', '_', $modulePositionName) . '.php';

        $partial = ob_get_clean();

        return $partial;
      };

      $partial = $partial->bindTo($this->document);

      $partialOutput = $partial($modulePositionName);

      return $partialOutput;
    }
    else
    {
      return '<jdoc:include type="modules" name="' . $modulePositionName . '" style="none" />';
    }
  }


  /**
   * Check whether the module position will be shown in the template, based on whether
   * any modules are enabled for the position in Joomla!'s administrative module manager
   *
   * @param string   $modulePositionName   The name for this include, matching a module position and a partial: 'banner-top' to include '_banner_top.php'
   *
   * @return void
   */
  private function shouldInclude($modulePositionName)
  {
    if ( in_array($modulePositionName, $this->requiredPositions) || ( isset($this->moduleCount[$modulePositionName]) && $this->moduleCount[$modulePositionName] > 0 ) )
    {
      return true;
    }

    return false;
  }


  /**
   * Normalize parameter input for additional CSS classes to add to the element
   *
   * @param array $colClasses  An array of CSS class names to add to the element
   *
   * @return string   A normalized string of space-separated CSS class names to add to the element
  */
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
