<?php
 /**
  * Image Objects (photos)  List Item Detail View Template
  *
  * @package   Calligraphic Job Board
  * @version   October 31, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  // no direct access
  defined('_JEXEC') or die;

  /** @var \Calligraphic\Cajobboard\Site\Model\ImageObjects   $item */
  /** @var  FOF30\View\DataView\Html                          $this */

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.php');
  include(JPATH_COMPONENT . '/ViewTemplates/ImageObjects/local_vars.php');

  // The name of the crud view
  $crud = 'browse';
?>

{{--
  Responsive container for desktop and mobile
--}}
<div class="row media {{ $featured }} @jhtml('helper.commonwidgets.getAttributeClass', 'list-item', $prefix, $crud)">
  @jhtml('helper.browsewidgets.title', $title, $itemViewLink, $prefix, $crud)

  @jhtml('helper.commonwidgets.description', $description, $prefix, $crud)

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

  <div>
    @jhtml('helper.commonwidgets.createdOn', $createdOn, $prefix, $crud)
  </div>

  <div class="clearfix"></div>

  <div>
    @jhtml('helper.commonwidgets.authorAvatar', $author, $prefix, $crud)

    @jhtml('helper.commonwidgets.authorName', $author, $prefix, $crud)

    @jhtml('helper.commonwidgets.authorLastSeen', $author, $prefix, $crud)
  </div>

  <div class="clearfix"></div>

  <div>
    @jhtml('helper.buttonwidgets.delete', $humanViewNameSingular, $canUserEdit, $itemId, $prefix, $crud)
    @jhtml('helper.buttonwidgets.edit', $humanViewNameSingular, $canUserEdit, $editViewLink, $prefix, $crud)
    @jhtml('helper.buttonwidgets.report', $humanViewNameSingular, $prefix, $crud)
  </div>
</div>{{-- End responsive container --}}

{{-- Forms with CSRF field for actions --}}
@jhtml('helper.buttonwidgets.deleteActionCsrfField', $deleteAction, $itemId)

<div class="clearfix"></div>