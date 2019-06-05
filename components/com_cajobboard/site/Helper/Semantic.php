<?php
  /**
   * Class to generate the OpenGraph header meta tags for social networks
   *
   * @package     Calligraphic Job Board
   *
   * @version     0.1 May 14, 2019
   * @author      Calligraphic, LLC http://www.calligraphic.design
   * @copyright   Copyright (C) 2018 Calligraphic, LLC
   * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
   *
   */

  namespace Calligraphic\Cajobboard\Site\Helper;

  // no direct access
  defined('_JEXEC') or die;

  use \FOF30\Model\Model;
  use \FOF30\View\View;
  use \Joomla\CMS\Component\ComponentHelper;
  use \Joomla\CMS\Factory;
  use \Joomla\CMS\Uri\Uri;

  // @TODO: Run Facebook OpenGraph linter: https://developers.facebook.com/tools/debug/
  // @TODO: Run Google Search Console for rich text validation: https://search.google.com/search-console/welcome

  class Semantic
  {
    /*
     * @var   View   A reference to the application container
     */
    protected $container = null;


    /*
     * @var   View   A reference to the current view
     */
    protected $view = null;


    /*
     * @var   Bool    Whether header meta tags have already been added, used to support HMVC
     */
    protected static $isTagsSet = false;


    /*
     * @var   Bool    Whether header meta tags should be shown for this instance, used to support HMVC
     */
    protected static $isTitleSet = false;


  // Twitter will use FB OpenGraph tags if they correspond to Twitter tags

  // og:title         The title of the article without any branding such as the site name.
  // og:url           The canonical URL for this page. Likes and Shares for this URL will aggregate at this URL.
  // og:image         The URL of the image that appears when someone shares the content to Facebook.
  // og:description   A brief description of the content, usually between 2 and 4 sentences. Displayed below the title of the post on Facebook.
  // og:type          Type of media of the content, affects how content shows in FB News Feed. Default type is website. Types include video, article, profile.
  // twitter:image:alt  Alt text for the main image, for visually impaired users
  // twitter:card     Options are summary cards with title, description, and thumbnail; summary_large_image cards with a large image, and player cards for audio / video.
  // fb:app_id        App ID from the FB App Dashboard to enable using Facebook Insights analytics
  // twitter:site     Username to associate with activity for this graph, similar to FB App ID

  	/**
	 * @param   Model   $model    The model for the component's
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct (View $view)
	{
    $this->container = $view->getContainer();

    $this->view = $view;

    // Useful vars:
    //
    //$this->model = $view->getModel();
    //$requestedView = $this->container->input->get('view'); // e.g. answers
    //$thisView = $this->view->getName(); // e.g. Answers
  }


  /**
	 * Set the Open Graph meta tags for social sharing
	 *
	 * @return  void
	 */
  public function addOpenGraphMetaTags ()
  {
    // @TODO: Maybe matching against the request URL to see if this is the top-level HMVC triad?
    if ($this->isTagsSet)
    {
      return;
    }

    $app = Factory::getApplication();
    $document = Factory::getDocument();

    // @TODO: get item card image
    $cardImage = 'http://example.com';

    // Adds a custom HTML tag to the document's <head>
    $document->addCustomTag('
      <meta property="og:title" content="'  .$this->view->escape($this->view->item->title) . '"/>
      <meta property="og:url" content="' . str_replace('" ','&quot;',Uri::current()) . '">
      <meta property="og:site_name" content="'. $app->get('sitename') . '"/>
      <meta property="og:image" content="'. $cardImage .'"/>
      <meta property="og:type" content="article"/>
      <meta property="og:description" content="' . strip_tags($this->view->item->introtext) . '"/>
      <meta property="og:locale" content="en_GB" />
      <meta name="twitter:image:alt" content="Alt text for image">
      <!-- Fixed boilerplate for Twitter -->
      <meta name="twitter:card" content="summary_large_image">
      <!-- Analytics -->
      <meta property="fb:app_id" content="" />
      <meta name="twitter:site" content="@website-username">
    ');

    $this->isTagsSet = true;
  }


  /**
	 * Set the page title and metadata.
	 *
	 * @return  void
	 */
	public function setPageTitle()
	{
    // @TODO: Maybe matching against the request URL to see if this is the top-level HMVC triad?
    if ($this->isTitleSet)
    {
      return;
    }

		/** @var \Joomla\CMS\Application\SiteApplication $app */
    $app = Factory::getApplication();
    $document = Factory::getDocument();

    // Get the option and view name
    $option = $this->container->componentName;
    $view = $this->view->getName();

    // Get the default page title translation key. No getters / setters for $defaultPageTitle
    // COM_CAJOBBOARD_PAGE_TITLE_ANSWERS
    $defaultTitleKey = empty($this->view->defaultPageTitle) ? strtoupper($option) . '_PAGE_TITLE_' . strtoupper($view) : $this->view->defaultPageTitle;

    // Set the document title. page_title can be set from the component,
    // the menu item, or the model item (in order of inheritance)
    $title = $this->view->getPageParams()->get('page_title', '');

//die(var_dump( $this->view->getPageParams() ));
    $sitename = $app->get('sitename');

// Title tags should be between 50-60 characters in length. Google will truncate longer titles.
// @TODO: Use Title Case for the page title.

// @TODO: Need logic here to figure out what the title should be.
//         1. An Answer title?
//         2. A default title for some pages?

		if (empty($title))
		{
			$title = Text::_($defaultTitleKey);
    }

    $document->setTitle($title);

    $this->isTitleSet = true;
  }
}
