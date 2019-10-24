<?php
 /**
  * Class to generate the OpenGraph header meta tags for social
  * networks and set the page title in one consistent place
  *
  * @package     Calligraphic Job Board
  *
  * @version     0.1 May 14, 2019
  * @author      Calligraphic, LLC http://www.calligraphic.design
  * @copyright   Copyright (C) 2018 Calligraphic, LLC
  * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  * Model must have an 'image' property set to allow adding semantic headers
  */

namespace Calligraphic\Cajobboard\Site\Helper;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use FOF30\Model\DataModel;
use \FOF30\View\View;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Uri\Uri;
use \Calligraphic\Cajobboard\Admin\Model\VideoObjects;
use \Calligraphic\Cajobboard\Admin\Model\AudioObjects;

// @TODO: Run Facebook OpenGraph linter: https://developers.facebook.com/tools/debug/
// @TODO: Run Google Search Console for rich text validation: https://search.google.com/search-console/welcome

class Semantic
{
  /**
    * A reference to the application container
    *
    * @property Container
    */
  protected $container = null;


  /**
    * Views that can be shared and should have OpenGraph metadata attached. Enabling
    * social share icons for each view is determined by menu settings for the social
    * share module position.
    *
    * @property array
    */
  protected $socialShareModels = array(
    'Answers' => 'content',
    'AudioObjects' => 'media',
    'Certifications' => 'content',
    'Comments' => 'content',
    'DigitalDocuments' => 'content',
    'DiversityPolicies' => 'content',
    'FCRA' => 'content',
    'ImageObjects' => 'media',
    'JobPostings' => 'content',
    'Organizations' => 'company',
    'Profiles' => 'person',
    'Places' => 'place',
    'QAPages' => 'content',
    'Questions' => 'content',
    'Reviews' => 'content',
    'VideoObjects' => 'media'
  );


  /**
   * Map of social network-specific graph types
   *
   * @property array
   */
  protected $openGraphType = array(
    'company' => array('facebook' => 'company', 'twitter' => 'summary_large_image'),
    'content' => array('facebook' => 'article', 'twitter' => 'summary_large_image'),
    'media'   => array('facebook' => 'video',   'twitter' => 'player'),
    'person'  => array('facebook' => 'person',  'twitter' => 'summary_large_image'),
    'place'   => array('facebook' => 'place',   'twitter' => 'summary_large_image')
  );


  /**
    * Whether header meta tags have already been added, used to support HMVC. Static
    * as HMVC uses a temporary container with a new object instance of this class.
    *
    * @property boolean
    */
  protected static $isOpengraphTagSet = false;


  /**
    * Whether header meta tags have already been added, used to support HMVC. Static
    * as HMVC uses a temporary container with a new object instance of this class.
    *
    * @property boolean
    */
  protected static $isTitleSet = false;


  /**
	 * @param   Container   $container    The application container
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct ($container)
	{
    $this->container = $container;
  }


  /**
   * Allow setting page title, opengraph headers, and metadata headers with one function call
   *
	 * @param View $view  The current view object
	 *
	 * @return  void
	 */
	public function setSemanticHeaders(View $view)
	{
    $this->setPageTitle($view);
    $this->addOpenGraphMetaTags($view);
    $this->setMetadataHeaders($view);
  }


  /**
	 * Set the Open Graph meta tags for social sharing
   *
   * @param View $view  The current view object
	 *
	 * @return  void
	 */
  public function addOpenGraphMetaTags (View $view)
  {
    // Test if this is an item or edit view, browse views aren't shared.
    if ( !$view->isItem() )
    {
      return;
    }

    // Sanity check
    if ( !$view->hasField('image') )
    {
      throw new \Exception('Calling Semantic model helper to add social metadata headers, but the calling model lacks an image property');
    }

    /** @var \FOF30\Model\DataModel */
    $item = $view->getItem();

    $itemName = $item->getName();

    /** @var \FOF30\Container\Container $container */
    $container = $item->getContainer();

    /** @var \FOF30\Platform\PlatformInterface $platform */
    $platform = $container->platform;

    // Return if the open graph tag has already been set for a page, the view calling this isn't
    // top-level (e.g. it's HMVC), or the model attached to this view isn't intended for social sharing
    if (self::$isOpengraphTagSet || !$this->isRequestedView($view) || !array_key_exists($itemName, $this->socialShareModels) )
    {
      return;
    }

    self::$isOpengraphTagSet = true;

    $language = $platform->getLanguage()->getTag();

    // Item-level field values

    $title = $container->Text->filterText( $item->getFieldValue( $item->getFieldAlias('title') ) );

    $description     = $container->Text->filterText( $item->getFieldValue( $item->getFieldAlias('description__intro') ) );

    /** @var \Calligraphic\Library\Platform\Registry */
    $imageRegistry   = $item->getFieldValue( $item->getFieldAlias('image') );
    $cardImage       = $imageRegistry->get('image_intro');
    $imageAltText    = $imageRegistry>get('image_intro_alt');
    unset($imageRegistry);

    $facebookAppId   = $this->container->params->getConfigOption('facebook_app_id', null, $item);
    $twitterHandle   = $this->container->params->getConfigOption('twitter_handle', null, $item);

    $itemType = $this->socialShareModels[$itemName];

    $contentType     = $this->openGraphType[$itemType]['facebook'];
    $twitterCardType = $this->openGraphType[$itemType]['twitter'];

    if ( $item instanceof VideoObjects || $item instanceof AudioObjects )
    {
      $audioVideoUrl = $item->content_url;
    }

    // The site name from global configuration (configuration.php)
    $tag  = '<meta property="og:site_name" content="' . $this->container->params->getConfigOption('sitename') . '"/>';
    // Language the content for this page is encoded in, e.g. en-GB
    $tag .= '<meta property="og:locale" content="' . $language . '"/>';
    // The title of the article without any branding such as the site name.
    $tag .= '<meta property="og:title" content="' . $title . '"/>';
    // A brief description of the content. Displayed below the title of the post on Facebook. 280 characters maximum for Google and Twitter, 300 for FaceBook.
    $tag .= '<meta property="og:description" content="' . $description . '"/>';
    // The canonical URL for this page. Likes and Shares for this URL will aggregate at this URL.
    $tag .= '<meta property="og:url" content="' . $platform->getCurrentSefUri() . '">';

    // Type of media of the content, affects how content shows in FB News Feed. Default type is 'website'. Types include 'video', 'article', 'profile'.
    $tag .= '<meta property="og:type" content="' . $contentType . '"/>';
    // Options are 'summary' cards with title, description, and thumbnail; 'summary_large_image' for a large image, and 'player' cards for audio / video. Twitter uses og:type if missing.
    $tag .= '<meta name="twitter:card" content="'. $twitterCardType . '">';

    // App ID from the FB App Dashboard to enable using Facebook Insights analytics
    $tag .= $facebookAppId ? '<meta property="fb:app_id" content=' . $facebookAppId . '/>' : '';
    // Username to associate with activity for this graph, similar to FB App ID
    $tag .= $twitterHandle ? '<meta name="twitter:site" content="' . $twitterHandle . '">' : '';

    // The URL of the image that appears when someone shares the content to Facebook.
    $tag .= $cardImage ? '<meta property="og:image" content="' . $cardImage . '"/>' : '';

    // Alt text for the main image, for visually impaired users
    $tag .= $imageAltText ? '<meta name="twitter:image:alt" content="' . $imageAltText . '">' : '';

    // URL to raw video or audio stream, for use with Player cards
    $tag .= $audioVideoUrl ? '<meta name="twitter:player:stream" content="' . $audioVideoUrl . '">' : '';

    // Adds a custom HTML tag to the document's <head>
    $this->container->platform->getDocument()->addCustomTag($tag);
  }


  /**
	 * Set the page title and metadata.
   *
   * @param View $view  The current view object
	 *
	 * @return  void
	 */
	public function setPageTitle(View $view)
	{
    if ( self::$isTitleSet || !$this->isRequestedView($view) )
    {
      return;
    }

    self::$isTitleSet = true;

    $document = $this->container->platform->getDocument();

    // Test if this is an item or edit view. Use the model 'title' field if so.
    if ( $view->isItem() )
    {
      $item = $view->item;

      $titleField = $item->getFieldAlias('title');

      if ( property_exists($item, $titleField) && $title = $item->getFieldValue($titleField) )
      {
        $document->setTitle($title);

        return;
      }
    }

    // Not item or edit view - either a browse or add view
    $option = $this->container->componentName;

    $viewName = $view->getName();

    // Get the default page title translation key. No getters / setters for $defaultPageTitle in base
    // view class. If no default page title set, build a translation key for the title in the form:
    //   COM_CAJOBBOARD_PAGE_TITLE_VIEWNAME, set in admin/language/**/*.com_cajobboard_common.*
    $defaultTitleKey = empty($view->defaultPageTitle) ? strtoupper($option) . '_PAGE_TITLE_' . strtoupper($viewName) : $view->defaultPageTitle;

    $document->setTitle( Text::_($defaultTitleKey) );
  }


  /**
	 * Set the metadata headers in site views (robots, author and keywords) on the
   * document so that they are generated automatically in the template jdoc:head call
   *
   * <meta name="robots" content="index|noindex, follow|nofollow" />
   *
   *   index      Allow search engines to add the page to their index, so that it can be discovered by people searching. Default if tag missing.
   *   noindex    Disallow search engines from adding this page to their index, and therefore disallow them from showing it in their results.
   *   follow     Tells the search engines that it may follow links on the page, to discover other pages. Default if tag missing.
   *   nofollow   Tells the search engines robots to not follow any links on the page.
   *
   * @param   View  $view   The View object
	 */
	public function setMetadataHeaders(View $view)
	{
    /** @var \FOF30\Platform\PlatformInterface  */
    $platform = $this->container->platform;

    /** @var Document $document */
    $document = $this->container->platform->getDocument();

    if ( $view->isItem() )
    {
      /** @var DataModel $item */
      $item = $view->getItem();



      // @TODO: This isn't fetching robots value from 'metadata' model field

      // Automatically cascades fetching config option if missing from item -> component -> menu item -> global
      $document->setMetaData( 'robots', $this->container->params->getConfigOption('robots', 'index, follow', $item) );

      /** @var \Calligraphic\Library\Platform\Registry $itemParams  */
      $itemParams = $item->getFieldValue( $item->getFieldAlias('params') );




      // @TODO: This isn't fetching author value from 'metadata' model field

      // Set the 'author' metadata tags on the document so they are generated automatically if it is set in parameters
      if ( $author = $itemParams->get('author') )
      {
        $document->setMetaData('author', $author);
      }




      // Set the 'keywords' metadata tags on the document so they are generated automatically if it is set in parameters
      if ( $keywords = $itemParams->metakey )
      {
        $document->setMetaData('keywords', $keywords);
      }
    }
    // Use component, menu, or global parameters in cascading order to set
    else
    {
      // 'params' field not set on model, so set a default using cascade if missing from item -> component -> menu item -> global
      $document->setMetaData( 'robots', $this->container->params->getConfigOption('robots', 'index, follow') );
    }
  }


  /**
   * Test if the view calling this is top-level (e.g. the requested view) or HMVC
   *
   * @param View $view
   *
   * @return boolean
   */
  public function isRequestedView(View $view)
  {
    $requestedView = $this->container->input->get('view');

    $viewName = $this->container->dispatcher->getViewAlias( $view->getName() );

    return $viewName == $requestedView;
  }
}
