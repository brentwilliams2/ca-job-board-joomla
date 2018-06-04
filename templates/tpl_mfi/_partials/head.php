<?php
/*
* Header includes in template <head></head> tags
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

/*
*  Asset files imported by original template:
*  /images/favicon.ico
*  /css/template_css.css
*  /css/$menu_color(blue?).css
*  /css/rokmininews.css
*  /templates/system/css/system.css
*  /templates/system/css/general.css
*  /css/typography.css
*  
*/

// no direct access
defined( '_JEXEC' ) or die;
?>
<head>
  <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

  <jdoc:include type="head" />

  <!-- Inline Styles -->
  <!--MFI - Brent BW changed the right column to max width so it wasn't large by default. -->
  <style type="text/css">
    div.wrapper { <?php echo $template_width; ?>padding:0;}
    #left-column { width:<?php echo $leftcolumn_width; ?>px;padding:0;}
    #right-column { max-width:<?php echo $rightcolumn_width; ?>px;padding:0;}
    #center-column { margin-left:<?php echo $leftcolumn_width; ?>px;margin-right:<?php echo $rightcolumn_width; ?>px;padding:0;}
  </style>

  <!-- Boxed styling for Bootstrap template -->
  <style type="text/css">
    body {
      background: url("<?php  echo $path ; ?>") repeat fixed center top rgba(0, 0, 0, 0);
    }
  </style>

  <!-- Inline Script Facebook Pixel Code -->
  <script>
    (function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    })(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1844684889110301');
    fbq('track', 'PageView');
  </script>

  <noscript>
    <img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1844684889110301&ev=PageView&noscript=1"
    />
  </noscript>
  <!-- End Facebook Pixel Code -->

  <!--Analytics on FB likes -->
  <meta property="fb:page_id" content="138281615578" />
</head>