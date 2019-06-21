<?php
 /**
  * Image Objects (photos)  List Item Detail View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  $params = JComponentHelper::getParams('com_cajobboard');

  // Padding to add to width of image, for comparing against bootstrap media query setpoints
  $imagePadding = $params->get('image-padding-for-setpoints');

  // Get configuration option for system width of images
  $displaySizes = array(
    'full-size' => $item->width                     + $imagePadding,
    'large'     => $params->get('large-width')      + $imagePadding,
    'medium'    => $params->get('medium-width')     + $imagePadding,
    'small'     => $params->get('small-width')      + $imagePadding,
    'thumbnail' => $params->get('thumbnail-width')  + $imagePadding
  );

  // Bootstrap media query setpoints
  $screen_xs_max  = $params->get('bootstrap-media-query-sm-min') - 1 . 'px';

  // Small screen / tablet
  $screen_sm_min  = $params->get('bootstrap-media-query-sm-min') . 'px';
  $screen_sm_max  = $params->get('bootstrap-media-query-md-min') - 1 . 'px';

  // Medium screen / desktop
  $screen_md_min  = $params->get('bootstrap-media-query-md-min') . 'px';
  $screen_md_max  = $params->get('bootstrap-media-query-lg-min') - 1 . 'px';

  // Large screen / wide desktop
  $screen_lg_min  = $params->get('bootstrap-media-query-lrg-min') . 'px';

  $resolvedImages = array(
    'screen_xs' => null,
    'screen_sm' => null,
    'screen_md' => null,
    'screen_lg' => null,
    'default' => null
  );

?>

{{-- Resolution Switching and Art Direction --}}
<a href="@route('index.php?option=com_cajobboard&view=ImageObject&task=read&id='. (int) $item->image_object_id)" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
  {{-- Sizes are used on <source> if width dimension descriptors are provided with srcset instead of pixel ratio values (e.g. 200w instead of 2x) --}}
  {{-- srcset can use viewport units (vw) instead of pixel width (w) to give a percent of total viewport width (e.g. 50vw for 50% of viewport) --}}
  {{-- srcset can provide alternate media formats (e.g. type="image/svg+xml" or type="image/webp") --}}
  <picture>
    {{-- Bootstrap extra-small screen --}}
    <source
      media   = "(max-width: {{ $screen_xs_max }})"
      srcset  = "images/kitten-stretching.png,
                 images/kitten-stretching@1.5x.png 1.5x,
                 images/kitten-stretching@2x.png 2x"
    >

    {{-- Bootstrap small screen --}}
    <source
      media   = "(min-width: {{ $screen_sm_min }}) and (max-width: {{ $screen_sm_max }})"
      srcset  = "images/kitten-stretching.png,
                  images/kitten-stretching@1.5x.png 1.5x,
                  images/kitten-stretching@2x.png 2x"
    >

    {{-- Bootstrap medium screen --}}
    <source
      media   = "(min-width: {{ $screen_md_min }}) and (max-width: {{ $screen_md_max }})"
      srcset  = "images/kitten-sitting.png,
                  images/kitten-sitting@1.5x.png 1.5x
                  images/kitten-sitting@2x.png 2x"
    >

    {{-- Bootstrap large screen --}}
    <source
      media   = "(min-width: {{ $screen_lg_min }})"
      srcset  = "images/kitten-sitting.png,
                  images/kitten-sitting@1.5x.png 1.5x
                  images/kitten-sitting@2x.png 2x"
    >

    {{-- Fallback for older browsers --}}
    <img
      src     = "images/kitten-curled.png" // conditional on $displaySizes[$displaySize]
      srcset  = "images/kitten-curled@1.5x.png 1.5x,
                 images/kitten-curled@2x.png 2x"
      alt     = "{{{ $item->caption }}}"
    >
  </picture>
</a>
