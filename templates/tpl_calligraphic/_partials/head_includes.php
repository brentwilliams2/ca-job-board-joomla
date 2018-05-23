<?php
/**
 * Header includes in template <head></head> tags
 *
 * @package   Multi Family Insiders Template
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
?>

<!-- Favicon -->
<link 
  rel="shortcut icon"
  href="<?php echo $this->baseurl; ?>/images/favicon.ico"
/>

<!-- Include template_css.css -->
<link
  href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_css.css"
  rel="stylesheet"
  type="text/css"
/>

<!-- Include  -->
<link
  href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/<?php echo $menu_color; ?>.css" rel="stylesheet"
  type="text/css"
/>

<!-- Include  -->
<link
  href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/rokmininews.css"
  rel="stylesheet"
  type="text/css"
/>

<!-- Include  -->
<link
  href="<?php echo $this->baseurl ?>/templates/system/css/system.css"
  rel="stylesheet"
  type="text/css"
/>

<!-- Include  -->
<link
  href="<?php echo $this->baseurl ?>/templates/system/css/general.css"
  rel="stylesheet"
  type="text/css"
/>

<!-- Include  -->
<link
  href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/typography.css"
  rel="stylesheet"
  type="text/css"
/>

<!-- Include  -->
<?php if($mtype=="moomenu" or $mtype=="suckerfish") :?>
  <link
    href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/rokmoomenu.css"
    rel="stylesheet"
    type="text/css"
  />
<?php endif; ?>

<!-- Inline Styles -->
<!--MFI - Brent BW changed the right column to max width so it wasn't large by default. -->
<style type="text/css">
	div.wrapper { <?php echo $template_width; ?>padding:0;}
	#left-column { width:<?php echo $leftcolumn_width; ?>px;padding:0;}
	#right-column { max-width:<?php echo $rightcolumn_width; ?>px;padding:0;}
	#center-column { margin-left:<?php echo $leftcolumn_width; ?>px;margin-right:<?php echo $rightcolumn_width; ?>px;padding:0;}
</style>	

<!-- Inline Script Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
  n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
  document,'script','https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1844684889110301');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1844684889110301&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->

<!-- Include template_ie7.css -->
<?php if (rok_isIe7()) :?>
  <!--[if IE 7]>
  <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_ie7.css" rel="stylesheet" type="text/css" />	
  <![endif]-->	
<?php endif; ?>

<!-- Include template_ie6.php -->
<?php if (rok_isIe6()) :?>
  <!--[if lte IE 6]>
  <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_ie6.php" rel="stylesheet" type="text/css" />
  <![endif]-->
<?php endif; ?>

<!-- Include rokutils.js -->
<script
  type="text/javascript"
  src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/js/rokutils.js"
></script>

<!-- Include rokiefix.js -->
<?php if (rok_isIe6()) : ?>
  <script
    type="text/javascript"
    src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/js/rokiefix.js"
  ></script>
<?php endif; ?> 

<!-- Include rokmoomenu.js -->
<?php if($mtype=="moomenu") :?>
  <!-- Include rokmoomenu.js -->
  <script
    type="text/javascript"
    src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/js/rokmoomenu.js"
  ></script>

  <!-- Include mootools.bgiframe.js -->
  <script
    type="text/javascript"
    src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/js/mootools.bgiframe.js"
  ></script>

  <!-- Inline Script for Rok Menu Animation -->
  <script type="text/javascript">
    window.addEvent('domready', function() {
    	new Rokmoomenu('ul.menutop ', {
    		bgiframe: <?php echo $moo_bgiframe; ?>,
    		delay: <?php echo $moo_delay; ?>,
    		animate: {
    			props: ['width', 'opacity'],
    			opts: {
    				duration:<?php echo $moo_duration; ?>,
    				fps: <?php echo $moo_fps; ?>,
    				transition: Fx.Transitions.<?php echo $moo_transition; ?>
    			}
    		}
    	});
    });
  </script>
<?php endif; ?>

<!-- Include  -->
<?php if((rok_isIe6() or rok_isIe7()) and ($mtype=="suckerfish" or $mtype=="splitmenu")) :
  echo "<script type=\"text/javascript\" src=\"" . $this->baseurl . "/templates/" . $this->template . "/js/ie_suckerfish.js\"></script>\n";
endif; ?>