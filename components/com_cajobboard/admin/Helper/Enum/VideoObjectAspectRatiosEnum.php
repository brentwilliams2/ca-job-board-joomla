<?php
/**
 * Admin Video Objects Aspect Ratios Enum Helper
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

// no direct access
defined( '_JEXEC' ) or die;

/*
 * ENUM class for system media object aspect ratios. These are a configuration option for
 * Category parameters related to images, initialized in script.cajobboard.php to inherit
 * when Job Board categories are created on component installation:
 *
 * @TODO: Should we add video object aspect ratios to categories?
 *
 *   bool                     enforce_aspect_ratio
 *   ImageObjectAspectRatios  thumbnail_aspect_ratio
 *   ImageObjectAspectRatios  image_aspect_ratio
 *
 * Usage:
 *
 *   $height = $container->VideoObjectAspectRatiosEnum->height('Square');
 */
final class VideoObjectAspectRatiosEnum
{
  private $Carousel;
  private $WideLandscape;
  private $WidePortrait;
  private $StandardLandscape;
  private $StandardPortrait;
  private $MediumPortrait;
  private $AnamorphicPortrait;

  public function __construct()
  {
    // Twitter: 60 fps or less; dimensions between 32 x 32 and 1280 x 1024; file size <= 512 MB; duration between 0.5 and 140 seconds; aspect ratio between 1:3 and 3:1

    // Facebook: minimum width 600px; .mp4 or .mov w/ h.264; max 30 fps; up to 240 mins, up to 4 gb

    // Linkedin: between 10 and 60 fps; aspect ratio 1:2.4 or 2.4:1; dimensions between 256×144 and 4096×2304; size between 75kb and 5gb; duration between 3 secs and 10 mins; video AVI, MPEG-1, MPEG-4, MKV, QuickTime, WebM, H264/AVC, MP4, VP8, VP9, WMV2, and WMV3; audio AAC, MP3, and Vorbis

    // Facebook Feed, Twitter: 720 x 720px. Instagram (?): 600 x 600 px
    $this->Carousel           = json_decode('{"widthAspect": 1,  "heightAspect": 1,  "aspectRatio":' . 1 / 1 .  ', "channel": ["Facebook", "Instagram", "Twitter"]}');

    // 1080p: 1920 x 1080px (Youtube), 720p: 1280×720px (Youtube, Twitter, Facebook Feed)
    $this->WideLandscape      = json_decode('{"widthAspect": 16, "heightAspect": 9,  "aspectRatio":' . 16 / 9 . ', "channel": ["Youtube", "Facebook", "Instagram"]}');

    // Facebook Feed, Twitter: 720 x 1280px
    $this->WidePortrait       = json_decode('{"widthAspect": 9,  "heightAspect": 16, "aspectRatio":' . 9 / 16 . ', "channel": ["Facebook"]}');

    // 480p: 640 x 480px
    $this->StandardLandscape  = json_decode('{"widthAspect": 4,  "heightAspect": 3,  "aspectRatio":' . 4 / 3 .  ', "channel": ["Youtube"]}');

    $this->StandardPortrait   = json_decode('{"widthAspect": 3,  "heightAspect": 4,  "aspectRatio":' . 3 / 4 .  ', "channel": ["Youtube"]}');

    // Facebook Feed. Instagram (?): 600 by 750 px.
    $this->MediumPortrait     = json_decode('{"widthAspect": 4,  "heightAspect": 5,  "aspectRatio":' . 4 / 5 .  ', "channel": ["Facebook", "Instagram"]}');

    $this->AnamorphicPortrait = json_decode('{"widthAspect": 9,  "heightAspect": 21, "aspectRatio":' . 9 / 21 . ', "channel": ["Facebook"]}');
  }

  public function height($aspect)
  {
    return $this->$aspect->heightAspect;
  }

  public function width($aspect)
  {
    return $this->$aspect->widthAspect;
  }

  public function ratio($aspect)
  {
    return $this->$aspect->aspectRatio;
  }

  public function getChannels($aspect)
  {
    return $this->$aspect->channel;
  }

  public function isChannelSupported($aspect, $channel)
  {
    return in_array($channel, $this->$aspect->channel);
  }
}
