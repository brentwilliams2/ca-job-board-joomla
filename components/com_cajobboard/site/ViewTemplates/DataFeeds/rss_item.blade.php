<?php
/**
 * Site Data Feeds RSS Feed item view
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html                      $this */
  /** @var \Calligraphic\Cajobboard\Site\Model\DataFeeds  $item */

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.blade.php');

  // using snake case to avoid conflict with common local variables
  $created_on = $item->getFieldValue( $item->getFieldAlias('created_on')
  $modified_on = $item->getFieldValue( $item->getFieldAlias('modified_on')

  $lastModified = $container->Format->getCreatedOnText( date('Y-m-j H:i:s', max( array_map('strtotime', $arr) )));
?>

<item>
  <id>{{ $itemId }}</id>

  @if ( isset($image) )
    <image>{{ $image }}</image>
  @endif

  @if ( isset($hits) )
    <hits>{{ $hits }}</hits>
  @endif

  <createdDate>{{ $lastModified }}</createdDate>

  <title><![CDATA[{{ $title }}]]></title>

  <description><![CDATA[{{ $description }}]]></description>

  @if ( isset($tags) )
    <tags><![CDATA[{{ $tags }}]]></tags>
  @endif

  <link>{{ $itemViewLink }}</link>

  <generator>{{ $sitename . ' - ' . $humanViewNamePlural}}</generator>
</item>
