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