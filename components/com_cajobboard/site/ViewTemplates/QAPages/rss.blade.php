<?php
/**
 * QA Pages Site RSS Feed view
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html  $this */

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.blade.php');

  //header('Cache-Control: no-cache, must-revalidate');
  //header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('content-type: text/xml');
?>

<?xml version='1.0″ encoding='utf-8″?>
<rss xmlns:content='http://purl.org/rss/1.0/modules/content/' version='2.0″>
  <title>{{ $sitename }}</title>

  <link>{{ $siteUrl }}</link>

  @each('site:com_cajobboard/' . $viewName . '/rss_item', $this->items, 'item', 'text|COM_CAJOBBOARD__NO_' . $transKey . '_FOUND')
</rss>
