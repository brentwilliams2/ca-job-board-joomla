<?php
/**
 * Site common local variables template. This file is intended to be included into
 * Blade templates to provide convenient local variables in the template function's scope.
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * General local variables
 * @param  \FOF30\Container\Container   $container        An instance of the View container
 * @param  \Joomla\CMS\User\User  $user                   The Joomla! User object
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
 * @param  int                    $itemId                 The primary key value (id) for the item
 * @param  string                 $createdOn              A formatted string built from the 'created_on' model field
 * @param  string                 $modifiedOn             A formatted string built from the 'modified_on' model field
 * @param  string                 $featured               A string ('featured' or an empty string) to append to HTML element class attributes
 * @param  string                 $title                  Sanitized string from 'title' model property alias
 * @param  string                 $text                   Sanitized string from 'text' model property alias
 *
 * Job Board fields, only set when field present on model
 * @param  int                    $downvoteCount          The downvote count for the item
 * @param  int                    $upvoteCount            The downvote count for the item
 *
 * Form and anchor URL local variables
 * @param  string                 $itemViewLink           A URL to the individual (item) view of this item
 * @param  string                 $editViewLink           A URL to the edit view of this item
 * @param  string                 $removeAction           A URL to delete and redirect from this item
 * @param  string                 $rawPostAction          A URL to post the form to
 *
 * 'Author' "magic" variable for relation to Persons, used in many models
 * @param  \StdClass              $author                 An object to hold author property values
 * @param  int                    $author->id             The primary key value (id) for the author's Joomla! Users (Persons) model field
 * @param  string                 $author->name           The name of the author
 * @param  string                 $author->avatarUri      A URL to the avatar image for the author
 * @param  string                 $author->profileLink    A URL to the author's Profiles page item view
 * @param  string                 $author->lastSeen       A formatted string built from the author's Joomla! Users (Persons) model 'last_seen' field
 */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Filter\InputFilter;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
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
  $componentName = $container->componentName;
  $sitename = $container->platform->getConfig()->get('sitename');
  $siteUrl = Uri::base();
  $viewName = $this->getName();
  $task = $this->getTask();

  $humanViewNamePlural = $container->inflector->humanize( $container->inflector->pluralize($viewName) );
  $humanViewNameSingular = $container->inflector->humanize( $container->inflector->singularize($viewName) );
  $prefix = strtolower( $container->inflector->hyphenate( $container->inflector->singularize($viewName) ));
  $transKey = strtoupper( $container->inflector->underscore( $container->inflector->pluralize($viewName) ));

  // Ignore if called from a browse template (e.g. 'default.blade.php') or a helper template (e.g. 'rss.blade.php')
  if ( isset($item) )
  {
    /**
     * Authorisation local variables
     */

    $canUserEdit = $container->User->canEdit($user, $item);

    /**
     * Joomla! UCM field local variables
     */

    $itemId = $item->getId();

    if ( $item->hasField( $item->getFieldAlias('created_on') ))
    {
      $createdOn = $container->Format->getCreatedOnText( $item->getFieldValue( $item->getFieldAlias('created_on') ));
    }

    if ( $item->hasField( $item->getFieldAlias('modified_on') ))
    {
      $modifiedOn = $container->Format->getCreatedOnText( $item->getFieldValue( $item->getFieldAlias('modified_on') ));
    }

    if ( $item->hasField( $item->getFieldAlias('featured') ))
    {
      $featured = $item->getFieldValue( $item->getFieldAlias('featured') ) ? 'featured' : '';
    }

    if ( $item->hasField( $item->getFieldAlias('title') ))
    {
      $titlePlaceholder = Text::sprintf('COM_CAJOBBOARD_TITLE_EDIT_PLACEHOLDER', $humanViewNameSingular);
      $title = InputFilter::getInstance()->clean( $item->getFieldValue( $item->getFieldAlias('title')), 'html');
    }

    if ( $item->hasField( $item->getFieldAlias('description') ))
    {
      $descriptionPlaceholder = Text::sprintf('COM_CAJOBBOARD_DESCRIPTION_EDIT_PLACEHOLDER', $humanViewNameSingular);
      $description = InputFilter::getInstance()->clean( $item->getFieldValue( $item->getFieldAlias('description')), 'html');
    }

    if ( $item->hasField( $item->getFieldAlias('description_intro') ))
    {
      $descriptionIntroPlaceholder = Text::sprintf('COM_CAJOBBOARD_DESCRIPTION_INTRO_EDIT_PLACEHOLDER', $humanViewNameSingular);
      $descriptionIntro = InputFilter::getInstance()->clean( $item->getFieldValue( $item->getFieldAlias('description_intro')), 'html');
    }

    if ( $item->hasField( $item->getFieldAlias('text') ))
    {
      $textPlaceholder = Text::sprintf('COM_CAJOBBOARD_TEXT_EDIT_PLACEHOLDER', $humanViewNameSingular);
      $text = InputFilter::getInstance()->clean( $item->getFieldValue( $item->getFieldAlias('text')), 'html');
    }

    if ( $item->hasField( $item->getFieldAlias('hits') ))
    {
      $hits = $container->Format->getCreatedOnText( $item->getFieldValue( $item->getFieldAlias('hits') ));
    }

    // @TODO: Implement $image field local variable

    // @TODO: Implement $tags field local variable

    /**
     * Job Board fields, only set when field present on model
     */

    if ( $item->hasField( $item->getFieldAlias('downvote_count') ))
    {
      $downvoteCount = $item->getFieldValue( $item->getFieldAlias('downvote_count') );

      $downvoteLink = $container->template->route(
        $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=downvote_count&id='. $itemId
      );
    }

    if ( $item->hasField( $item->getFieldAlias('upvote_count') ))
    {
      $upvoteCount = $item->getFieldValue( $item->getFieldAlias('upvote_count') );

      $upvoteLink = $container->template->route(
        $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=upvote_count&id='. $itemId
      );
    }


    /**
     * Form and anchor URL local variables
     */

    if ('add' == $task)
    {
      // Used for a 'cancel' button's link in 'add' forms
      $itemViewLink = $container->template->route(
        $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=browse'
      );
    }
    else
    {
      $itemViewLink = $container->template->route(
        $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=read&id='. $itemId
      );
    }

    $editViewLink = $container->template->route(
      $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=edit&id='. $itemId
    );

    // $postAction handles both 'edit' and 'add' tasks
    $rawPostAction = $siteUrl . 'index.php?option=' . $componentName . '&view=' . $viewName . '&task=save';

    if ('edit' == $task)
    {
      $rawPostAction .= '&id=' . $itemId;
    }

    $postAction = $container->template->route($rawPostAction);
    unset($rawPostAction);

    $removeAction = $container->template->route(
      $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=remove&id=' . $itemId
    );

    /**
     * 'Author' "magic" variable for relation to Persons, used in many models
     */

    if ( isset($item->Author) )
    {
      $author = new \StdClass;
      $author->id = $item->Author->getId();
      $author->name = $item->Author->getFieldValue('name');
      // Container has User helper utility class
      $author->avatarUri = $container->User->getAvatar($author->id);
      $author->profileLink = $container->User->getLinkToUserProfile($author->id);
      $author->lastSeen = $container->User->lastSeen( $item->Author->getFieldValue('lastvisitDate') );
    }
  }

  /*
    Limit access to personally identifiable information:

    @if ($container->platform->getUser()->authorise('com_cajobboard.pii', 'com_cajobboard'))
      protected content
    @endif
   */
