<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Error message to show in component area on error pages
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

 use use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;
?>

<p><strong><?php echo $this->error->getCode() ?> - <?php echo $this->error->message ?></strong></p>

<p><strong><?php echo Text::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>

<ol>
  <li><?php echo Text::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
  <li><?php echo Text::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
  <li><?php echo Text::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
  <li><?php echo Text::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
  <li><?php echo Text::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
  <li><?php echo Text::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
</ol>

<p><strong><?php echo Text::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>

<ul>
  <li>
    <a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">
      <?php echo Text::_('JERROR_LAYOUT_HOME_PAGE'); ?>
    </a>
  </li>
</ul>

<p><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?>.</p>

<div>
  <?php echo $this->error->getTraceAsString(); ?>
</div>


if ($error instanceof \Throwable)
		{
      // This is reached if unable to create and render an error document

      // Only display sensitive data in non-production environments, but config file
      // (to check $config->debug) may not have loaded when this point is reached
      // so use display_errors setting as a proxy for determining environment
			if (ini_get('display_errors'))
			{
        $html  = '<div class="well">';
        $html .= '<div>Type of error object: ' . get_class ($error) . '</div>';
        $html .= '<div>'. ucfirst ( $error->getMessage() ) . ' in file:</div>';
        $html .= '<div>'. $error->getFile() . ': line number ' . $error->getLine() . '</div>';
        $html .= '</div>';

        $html .= '<link rel="stylesheet" property="stylesheet" href="'. JUri::base() . '/media/jui/css/bootstrap.css">';

        $html .= <<<EOT
<table cellpadding="0" cellspacing="0" class="Table table table-striped table-bordered">
  <tr>
    <td colspan="3" class="TD">
      <strong>Call stack</strong>
    </td>
  </tr>

  <tr>
    <td class="TD">
      <strong>#</strong>
    </td>
    <td class="TD">
      <strong>Function</strong>
    </td>
    <td class="TD">
      <strong>Location</strong>
    </td>
  </tr>
EOT;

        foreach ($error->getTrace() as $k => $line)
        {
          $itemNumber = $k + 1;

          $html .= '<tr>';
          $html .= '<td class="TD">'. $itemNumber . '</td>';

          if ( isset($line['class']) )
          {
            $html .= '<td class="TD">'. $line['class'] . $line['type'] . $line['function'] . '()</td>';
          }
          else
          {
          $html .= '<td class="TD">' . $line['function'] . '()</td>';
          }

          if ( isset($line['file']) )
          {
            $html .= '<td class="TD">' . JHtml::_('debug.xdebuglink', $line['file'], $line['line']) . '</td>';
          }
          else
          {
          $html .= '<td class="TD">&#160;</td>';
          }

          $html .= '</tr>';
        }

        echo $html;
      }
    }
