<?php
/**
 * MFI Template shopping cart module for HikaShop
 *
 * @package     MFI Template
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2010-2019 HIKARI SOFTWARE. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;
?>

<?php if (!empty($html)) : ?>

  <span class="shopping-cart-in-nav" type="button" data-toggle="modal" data-target="#shopping-cart-modal">
    <span class="shopping-cart-icon glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
    <?php // @TODO: need to pull the correct shopping cart value from HikaShop module ?>
    <span class="shopping-cart-amount">$0.00</span>
  </span>

  <div class="shopping-cart-modal modal fade" id="shopping-cart-modal" tabindex="-1" role="dialog" aria-labelledby="shopping-cart-modal-label">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="shopping-cart-modal-title modal-title" id="modal-title">
            <?php echo Text::_('MOD_MFI_TEMPLATE_CART_HIKASHOP_YOUR_CART'); ?>
          </h4>
        </div>

        <div id="cart-module" class="cart-module modal-body">
          <?php echo $html; ?>
        </div>

      </div>
    </div>
  </div>

<?php endif; ?>
