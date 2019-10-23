<?php
/**
 * Site Job Posting local variables template. This file is intended to be included into Job Posting
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
 * Joomla! UCM field local variables
 * @param  int                    $itemId                 The primary key value (id) for the item
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

  use \Calligraphic\Cajobboard\Site\Helper\Format;
  use \Joomla\CMS\Filter\InputFilter;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Helper\TagsHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Uri\Uri;

  /** @var \Calligraphic\Cajobboard\Site\Model\DataModel  $item */
  /** @var  FOF30\View\DataView\Html                      $this */

  // NOTE: This file is included in every Blade template, so that the provided variables
  //       are in the scope of that Blade template function. No heavy calculations here.

die(var_dump($item->JobLocation));
/*


  $logoSource           = $this->container->template->parsePath($item->jobLocation->Logo->thumbnail);
  $logoCaption          = $item->jobLocation->Logo->caption;
  $employerID           = $item->hiringOrganization->organization_id;



  // Setup Tags
  $tags = new TagsHelper;
  $tags->getItemTags('com_cajobboard.jobpostings', $item->job_posting_id);



  // @TODO: "Share this" social media button on job



  $aggregateReview = new stdClass();

  foreach ( $this->aggregateReviews as $aggregateReviewIteratee )
  {
    if ($aggregateReviewIteratee->job_posting_id == $item->job_posting_id)
    {
      $aggregateReview = $aggregateReviewIteratee;
      break;
    }
  }




  $formattedPay = $this->container->JobPosting->formatPayToValueOrRange(
    $item->base_salary__value,
    $item->base_salary__min_value,
    $item->base_salary__max_value,
    $item->base_salary__duration
  );
  */

// @TODO: $canUserEdit or something?

  /**
   * General local variables
   */

   $userId = $user->id;

  // Ignore if called from a browse template (e.g. 'default.blade.php') or a helper template (e.g. 'rss.blade.php')
  if ( isset($item) )
  {
    /**
     * Scalar Job Postings local variables
     */

    if ( $item->hasField( $item->getFieldAlias('created_on') ))
    {
      $createdOn = $container->Format->getCreatedOnText( $item->getFieldValue( $item->getFieldAlias('created_on') ));
    }


    /**
     * Routed URLs
     */

    $removeAction = $container->template->route(
      $siteUrl . 'index.php?option=com_cajobboard&view=' . $this->getName() . '&task=remove&id=' . $itemId
    );


    /**
     * 'Author' "magic" variable for relation to Persons
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