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
?>

@extends('admin:com_cajobboard/Common/edit')

@section('edit-form-body')

	<div class="akeeba-form-group">

		<label for="key">
			@fieldtitle('key')
    </label>

		{{ BrowseView::genericSelect('key', \Akeeba\Subscriptions\Admin\Helper\Email::getEmailKeys(1), $this->getItem()->key, ['fof.autosubmit' => false, 'translate' => false]) }}

  </div>

	<div class="akeeba-form-group">

		<label for="language">
			@fieldtitle('language')
    </label>

		{{ BrowseView::genericSelect('language', \FOF30\Utils\SelectOptions::getOptions('languages', ['none' => 'COM_AKEEBASUBS_EMAILTEMPLATES_FIELD_LANGUAGE_ALL']), $this->getItem()->language, ['fof.autosubmit' => false, 'translate' => false]) }}

  </div>

	<div class="akeeba-form-group">

		<label for="subscription_level_id">
			@fieldtitle('subscription_level_id')
    </label>

		<?php echo BrowseView::modelSelect('subscription_level_id', 'Levels', $this->getItem()->subscription_level_id, ['fof.autosubmit' => false, 'none' => 'COM_AKEEBASUBS_EMAILTEMPLATES_FIELD_SUBSCRIPTION_LEVEL_ID_NONE', 'translate' => false]) ?>

  </div>

	<div class="akeeba-form-group">

		<label for="enabled">
			@lang('JPUBLISHED')
    </label>

		@jhtml('FEFHelper.select.booleanswitch', 'enabled', $this->getItem()->enabled)

  </div>

	<div class="akeeba-form-group">

		<label for="subject">
			@fieldtitle('subject')
    </label>

		<input type="text" name="subject" id="subject" value="{{{ $this->getItem()->subject }}}" />

  </div>

	<div class="akeeba-form-group">

		<label for="body">
			@fieldtitle('body')
    </label>

		<div class="akeeba-nofef">
			@jhtml('FEFHelper.edit.editor', 'body', $this->getItem()->body)
    </div>

  </div>

@stop
