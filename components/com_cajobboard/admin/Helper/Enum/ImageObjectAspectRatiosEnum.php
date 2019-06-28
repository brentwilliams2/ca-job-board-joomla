<?php
/**
 * Admin Image Objects Aspect Ratios Enum Helper
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
 *   bool                     enforce_aspect_ratio
 *   ImageObjectAspectRatios  thumbnail_aspect_ratio
 *   ImageObjectAspectRatios  image_aspect_ratio
 *
 * Usage:
 *
 *   $height = $container->ImageObjectAspectRatiosEnum->height('Square');
 */
final class ImageObjectAspectRatiosEnum
{
  private $Square;
  private $WideLandscape;
  private $StandardLandscape;
  private $StandardPortrait;
  private $MediumLandscape;
  private $MediumPortrait;

  public function __construct()
  {
    $this->Square            = json_decode('{"widthAspect": 1,  "heightAspect": 1, "aspectRatio":' . 1 / 1 .  '}');
    $this->WideLandscape     = json_decode('{"widthAspect": 16, "heightAspect": 9, "aspectRatio":' . 16 / 9 . '}');
    $this->StandardLandscape = json_decode('{"widthAspect": 4,  "heightAspect": 3, "aspectRatio":' . 4 / 3 .  '}');
    $this->StandardPortrait  = json_decode('{"widthAspect": 3,  "heightAspect": 4, "aspectRatio":' . 3 / 4 .  '}');
    $this->MediumLandscape   = json_decode('{"widthAspect": 5,  "heightAspect": 4, "aspectRatio":' . 5 / 4 .  '}');
    $this->MediumPortrait    = json_decode('{"widthAspect": 4,  "heightAspect": 5, "aspectRatio":' . 4 / 5 .  '}');
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
}
