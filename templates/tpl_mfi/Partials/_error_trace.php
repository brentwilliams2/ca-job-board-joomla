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

  use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;
?>

<?php
  if ($this->error instanceof \Throwable)
  {
    $html = '';

    if (ini_get('display_errors'))
    {
      $html .= '<div class="well">';
      $html .= '<div>Type of error object: ' . get_class ($this->error) . '</div>';
      $html .= '<div>'. ucfirst ( $this->error->getMessage() ) . ' in file:</div>';
      $html .= '<div>'. $this->error->getFile() . ': line number ' . $this->error->getLine() . '</div>';
      $html .= '</div>';

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

      foreach ($this->error->getTrace() as $k => $line)
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
          $html .= '<td class="TD">' . HTMLHelper::_('debug.xdebuglink', $line['file'], $line['line']) . '</td>';
        }
        else
        {
        $html .= '<td class="TD">&#160;</td>';
        }

        $html .= '</tr>';
      }

      $html .= '</table>';
    }

    echo $html;
  }
?>
