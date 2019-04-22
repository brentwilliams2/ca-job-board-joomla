<?php
/**
 * Social Shares Module for Multi Family Insiders Bootstrap V3 Template
 *
 * Get count of all module positions to avoid calling methods on null objects
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (c) 2019 Steven Palmer All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\HTML\HTMLHelper;

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

//Lets get help and params from our helper
$help = new ModMfiTemplateSocialShareHelper();

HTMLHelper::_('jquery.framework');

// Load the language files
$jlang = Factory::getLanguage();

// Module
$jlang->load('mod_mfi_template_social_shares', JPATH_SITE, 'en-GB', true);
$jlang->load('mod_mfi_template_social_shares', JPATH_SITE, $jlang->getDefault(), true);
$jlang->load('mod_mfi_template_social_shares', JPATH_SITE, null, true);

$uniqueId = $module->id;
$doc = Factory::getDocument();

$list = $help::getList($params);
$checkLinks = $help::checkForLinks($list, $params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$uikitPrefix = $params->get('uikit_prefix', 'cw');

$itemCount = $params->get('count', 5);
$showReadmore = $params->get('show_readmore', 1);
$alwaysReadmore = $params->get('always_readmore', 0);
$readmoreText = $params->get('readmore_text', Text::_('MOD_MFI_TEMPLATE_SOCIAL_SHARES_BTN_RM'));
$readmoreType = $params->get('readmore_type', 'l');
$readmoreCustom = $params->get('readmore_custom');
$html = $params->get('strip_html', 1) > 0 ? true : false;
$exclusions = $params->get('html_exclusions', '');
$limit = $params->get('max_char', 200);

//Remore button type
switch ($readmoreType){
    case 'p' :
        $rmTypeCw = $uikitPrefix . '-button ' .$uikitPrefix . '-button-primary';
        break;
    case 's' :
        $rmTypeCw = $uikitPrefix . '-button ' .$uikitPrefix . '-button-success';
        break;
    case 'd' :
        $rmTypeCw = $uikitPrefix . '-button ' .$uikitPrefix . '-button-danger';
        break;
    case 'l' :
        $rmTypeCw = $uikitPrefix . '-button ' .$uikitPrefix . '-button-link';
        break;
    case 'c' :
        $rmTypeCw = $readmoreCustom;
        break;
}

$displayLinks = $params->get('display_links', 0);
$displayDetails = $params->get('show_article_info');
$moreFrom = $params->get('more_from', 0);
$morefromText = $params->get('morefrom_text', Text::_('MOD_MFI_TEMPLATE_SOCIAL_SHARES_MORE'));
$itemHeading = $params->get('item_heading', 'h4');
$linkHeading = $params->get('link_heading', 'h4');
$linkText = $params->get('link_text', Text::_('MOD_MFI_TEMPLATE_SOCIAL_SHARES_LINKS'));

$showImg = $params->get('show_image', 1);
//Update old image type options
$imgType = $params->get('image_type', 'image_intro');
$typeUpdate = $help::checkType($imgType);
if ($typeUpdate['changed'] === true){
    $imgType = $typeUpdate['type'];
}

$imgWidthLarge = $params->get('image_width_large', 2);
$imgWidthMedium = $params->get('image_width_medium', 4);
$imgWidthSmall = $params->get('image_width_small', 10);
$columnsLarge = ($params->get('columns_large', 4) > $itemCount ? $itemCount : $params->get('columns_large', 4));
$columnsMedium = ($params->get('columns_medium', 2) > $itemCount ? $itemCount : $params->get('columns_medium', 2));
$columnsSmall = ($params->get('columns_small', 1) > $itemCount ? $itemCount : $params->get('columns_small', 1));
$artWidthLarge = ($showImg ? 10 - $imgWidthLarge : 10);
$artWidthMedium = ($showImg ? 10 - $imgWidthMedium : 10);
$artWidthSmall = ($showImg ? 10 - $imgWidthSmall : 10);

//A bit of redundancy for old settings
$marginsInner = $params->get('grid_margins_inner') === 'preserve' ? 'small' : $params->get('grid_margins_inner', 'small');
$marginsOuter = $params->get('grid_margins_outer') === 'preserve' || 'small' ? '20' : $params->get('grid_margins_outer', '20');
$textAlign = $params->get('text_align', 'justify');
$readmoreAlign = $params->get('readmore_align', 'right');
$titleAlign = $params->get('title_align', 'left');
$detailsAlign = $params->get('details_align', 'left');
$imageAlign = $params->get('image_align', 'left');
$panelType = $params->get('panel_style', 'd');
$dynFilter = $params->get('dynamic_filter', '');
$matchHeight = $params->get('match_height', 0) ? 'data-' . $uikitPrefix . '-grid-match="{row: false}"' : '';

//Panel type
switch ($panelType){
    case 'd' :
        $panelStyle = $uikitPrefix . '-panel-box' ;
        break;
    case 'p' :
        $panelStyle = $uikitPrefix . '-panel-box ' .$uikitPrefix . '-panel-box-primary';
        break;
    case 's' :
        $panelStyle = $uikitPrefix . '-panel-box ' .$uikitPrefix . '-panel-box-secondary';
        break;
    case 'h' :
        $panelStyle = $uikitPrefix . '-panel-hover';
        break;
}

// Do we need to load UIkit?
if ($uikitPrefix === 'cw') {
    $helpFunc = new CwGearsHelperLoadcount();
    $url = JURI::getInstance()->toString();
    $helpFunc::setUikitCount($url);
    $helpFunc::setUikitPlusCount($url);
}

require JModuleHelper::getLayoutPath('mod_mfi_template_social_shares', $params->get('layout', 'default'));
