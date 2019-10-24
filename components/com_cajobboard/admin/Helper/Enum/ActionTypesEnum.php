<?php
/**
 * Admin Schema.org Action Type Enumerations
 *
 * @package   Calligraphic Job Board
 * @version   12 September, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\BasicEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Exception\EnumException;
use \Joomla\CMS\Language\Text;

/*
 * ENUM class for custom classes extended from Schema.org Actions
 */
abstract class ActionTypesEnum extends BasicEnum
{
  const APPLICATION_ACTION = 'APPLICATION_ACTION';
  const APPLICATION_LETTER_ACTION = 'APPLICATION_LETTER_ACTION';
  const BACKGROUND_CHECK_ACTION = 'BACKGROUND_CHECK_ACTION';
  const CERTIFICATION_ACTION = 'CERTIFICATION_ACTION';
  const CREDIT_REPORT_ACTION = 'CREDIT_REPORT_ACTION';
  const DIVERSITY_POLICY_ACTION = 'DIVERSITY_POLICY_ACTION';
  const FAIR_CREDIT_REPORTING_ACT_NOTICE_ACTION = 'FAIR_CREDIT_REPORTING_ACT_NOTICE_ACTION';
  const HIRE_ACTION = 'HIRE_ACTION';
  const INTERVIEW_ACTION = 'INTERVIEW_ACTION';
  const OFFER_ACTION = 'OFFER_ACTION';
  const POST_JOB_ACTION = 'POST_JOB_ACTION';
  const REFERENCE_ACTION = 'REFERENCE_ACTION';
  const RESUME_ACTION = 'RESUME_ACTION';
  const SCHEDULE_ACTION = 'SCHEDULE_ACTION';
  const SCORE_CARD_ACTION = 'SCORE_CARD_ACTION';



  /**
   * Get available action statuses as an associative array, with key as action status name and numeric value
   *
   * @return array
   */
  public static function getActionTypesConstants()
  {
    return self::getConstants();
  }
}
