<?php
/**
 * Admin Answers RSS Feed view
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('content-type: text/xml');
?>

<?xml version='1.0″ encoding='utf-8″?>
<rss xmlns:content='http://purl.org/rss/1.0/modules/content/' version='2.0″>

<title>{{$YOUR_SITE_TITLE_MENTIONED_IN_GLOBAL_CONFIGURATION}}</title>
<link>{{{$YOUR_DOMAIN_BASE_URL}}}</link>

  <?php foreach ($db_value as $value): ?>

    <item>
      <id>{{$value->id}}</id>
      <image>{{{$value->image}}}</image>
      <hits>{{$value->hits}}</hits>
      <createdDate>{{$value->date}}</createdDate>
      <title><![CDATA[{{{$value->title}}}]]></title>
      <description><![CDATA[{{{$value->description}}}]]></description>
      <tags><![CDATA[{{{$value->tags}}}]]></tags>
      <link>{{{$EVERY_PAGE_URL_OF_YOUR_ITEM}}}</link>
      <generator>Feed_Name</generator>
      <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    </item>

  <?php endforeach; ?>

</rss>
