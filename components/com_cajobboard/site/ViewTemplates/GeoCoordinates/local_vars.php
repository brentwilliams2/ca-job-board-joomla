<?php
/**
 * Site local variables for Geo Coordinates. This file is intended to be included into
 * Blade templates to provide convenient local variables in the template function's scope.
 *
 * @package   Calligraphic Job Board
 * @version   October 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * General local variables
 * @param  \FOF30\Container\Container   $container        An instance of the View container
 * @param  \Joomla\CMS\User\User  $user                   The Joomla! User object
 * @param  bool                   $isGuestUser            Whether the user is logged in or a guest user
 * @param  string                 $componentName          The component name (e.g. 'com_cajobboard')
 * @param  string                 $sitename               The name of the site
 * @param  string                 $siteUrl                The base URL of the site
 * @param  string                 $viewName               The name of the current view
 * @param  string                 $humanViewNamePlural    A human-readable pluralized view name, e.g. 'Job Postings'
 * @param  string                 $humanViewNameSingular  A human-readable singularized view name, e.g. 'Job Posting'
 * @param  string                 $prefix                 A prefix to prepend to a class attribute, the singular lowercase hyphenated name of the view
 * @param  string                 $transKey               A capitalized, underscored variant of the plural view name for use in translation keys
 *
 * Authorisation local variables
 * @param  boolean                $canUserEdit            Whether the user has canEdit ACL privileges
 *
 * Joomla! UCM field local variables
 * @property  string	            $latitude               latitude of a place
 * @property  string	            $longitude              longitude of a place
 */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Uri\Uri;

  /** @var \Calligraphic\Cajobboard\Site\Model\DataModel  $item */
  /** @var  FOF30\View\DataView\Html                      $this */

  // NOTE: This file is included in every Blade template, so that the provided variables
  //       are in the scope of that Blade template function. No heavy calculations here.

  /**
   * General local variables
   */

  $container = $this->getContainer();

  $user = $container->platform->getUser();
  $isGuestUser = ($user->id == 0);

  $componentName = $container->componentName;
  $sitename = $container->platform->getConfig()->get('sitename');
  $siteUrl = Uri::base();
  $viewName = $this->getName();
  $task = $this->getTask();

  $humanViewNamePlural = $container->inflector->humanize( $container->inflector->pluralize($viewName) );
  $humanViewNameSingular = $container->inflector->humanize( $container->inflector->singularize($viewName) );
  $prefix = strtolower( $container->inflector->hyphenate( $container->inflector->singularize($viewName) ));
  $transKey = strtoupper( $container->inflector->underscore( $container->inflector->pluralize($viewName) ));

  $canUserAdd = $container->User->canAdd( $this->getModel() );

  // Ignore setting these local variables if called from a browse template (e.g. 'default.blade.php') or a helper template (e.g. 'rss.blade.php')
  if ( isset($item) )
  {
    $itemId = $item->getId();

    /**
     * Authorisation local variables
     */

    if ($itemId)
    {
      $canUserEdit = $container->User->canEdit($item);
    }

    /**
     * Form and anchor URL local variables
     */

    if ('add' == $task)
    {
      $postAction = $container->template->route( $siteUrl . 'index.php?option=' . $componentName . '&view=' . $viewName . '&task=save' );
    }
    elseif ('edit' == $task)
    {
      $postAction = $container->template->route( $siteUrl . 'index.php?option=' . $componentName . '&view=' . $viewName . '&task=save&id=' . $itemId );
    }

    // Used for a 'cancel' button's link in 'add' forms
    $browseViewLink = $container->template->route(
      $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=browse'
    );

    $itemViewLink = $container->template->route(
        $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=read&id='. $itemId
    );

    $editViewLink = $container->template->route(
      $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=edit&id='. $itemId
    );

    $deleteAction = $container->template->route(
      $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=remove&id=' . $itemId
    );
  }
