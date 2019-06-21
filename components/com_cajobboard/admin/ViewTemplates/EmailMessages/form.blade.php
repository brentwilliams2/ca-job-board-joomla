<?php
 /**
  * Email Messages Edit View Template
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

  use Akeeba\Subscriptions\Admin\Helper\Select;
  use FOF30\Utils\FEFHelper\BrowseView;

  /** @var  FOF30\View\DataView\Html  $this */

  // Maybe need a dummy record for each of the types to show in the editor, so you get a good preview of what it will look like
  // this is to edit email templates
?>

@extends('admin:com_cajobboard/Common/edit')

@section('edit-form-body')

	<div class="akeeba-form-group">
		<label for="key">@fieldtitle('key')</label>
		{{ BrowseView::genericSelect('key', \Akeeba\Subscriptions\Admin\Helper\Email::getEmailKeys(1), $this->getItem()->key, ['fof.autosubmit' => false, 'translate' => false]) }}
  </div>

	<div class="akeeba-form-group">
		<label for="language">@fieldtitle('language')</label>
		{{ BrowseView::genericSelect('language', \FOF30\Utils\SelectOptions::getOptions('languages', ['none' => 'COM_AKEEBASUBS_EMAILTEMPLATES_FIELD_LANGUAGE_ALL']), $this->getItem()->language, ['fof.autosubmit' => false, 'translate' => false]) }}
  </div>

	<div class="akeeba-form-group">
		<label for="subscription_level_id">@fieldtitle('subscription_level_id')</label>
		<?php echo BrowseView::modelSelect('subscription_level_id', 'Levels', $this->getItem()->subscription_level_id, ['fof.autosubmit' => false, 'none' => 'COM_AKEEBASUBS_EMAILTEMPLATES_FIELD_SUBSCRIPTION_LEVEL_ID_NONE', 'translate' => false]) ?>
  </div>

	<div class="akeeba-form-group">
		<label for="enabled">@lang('JPUBLISHED')</label>
		@jhtml('FEFHelper.select.booleanswitch', 'enabled', $this->getItem()->enabled)
  </div>

	<div class="akeeba-form-group">
		<label for="subject">@fieldtitle('subject')</label>
		<input type="text" name="subject" id="subject" value="{{{ $this->getItem()->subject }}}" />
  </div>

	<div class="akeeba-form-group">
		<label for="body">@fieldtitle('body')</label>
		<div class="akeeba-nofef">
			@jhtml('FEFHelper.edit.editor', 'body', $this->getItem()->body)
    </div>
  </div>

@stop

<?php
/*
Your [LEVEL] subscription at [SITENAME] is now enabled

@TODO: Use PHP_EOL for line breaks - local MTAs will convert \r\n to \r\r\n
       Above is true for optional additional_headers and mail()'s $subject. Escaped
       characters have to be in double quotes. Set mail() to HTML type

<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">
  <div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">
    <p>Hello [FIRSTNAME],</p>
    <p>The payment for your [LEVEL] subscription on our site has just been cleared. Your subscription is now activated and will remain active until [PUBLISH_DOWN].</p>
    <p><span style=\"line-height: 1.3em;\">We\'d like to remind you that you have registered on our site using the username [USERNAME] and email address [USEREMAIL].</span></p>
    <p>You can <a href=\"[MYSUBSURL]\">review the status of all your subscriptions</a> any time on our site.</p>
  </div>
  <p style=\"font-size: x-small; color: #667;\">
    You are receiving this automatic email message because you have a subscription in <em>[SITENAME]</em>.
    <span style=\"line-height: 1.3em;\">Do not reply to this email, it\'s sent from an unmonitored email address.</span>
  </p>
</div>'
*/
