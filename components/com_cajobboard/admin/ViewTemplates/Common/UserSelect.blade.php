<?php
/**
 * User entry field, allowing selection of a user from a modal dialog
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, Copyright (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 *
 *  Usage:
 *
 *   @include('admin:com_cajobboard/Common/UserSelect', $params)
 *
 * $params is an array defining the following keys (they are expanded into local scope vars automatically):
 *
 * @var int                                    $userID      The user ID number to set as default
 * @var string                                 $name        The user input field's name, e.g. "user_id"
 * @var string                                 $id          The id of the user input field, default is $name
 * @var \FOF30\Model\DataModel                 $item        The model object for the item we're editing
 * @var bool                                   $readonly    Is this a read only field? Default: false
 * @var string                                 $placeholder Placeholder text, also used as the button's tooltip. Default is JLIB_FORM_SELECT_USER
 * @var bool                                   $required    Is a value required for this field? Default: false
 * @var string                                 $width       Width of the modal box. Default: 800
 * @var string                                 $height      Height of the modal box. Default: 500
 *
 * Variables made automatically available to us by FOF:
 *
 * @var \FOF30\View\DataView\DataViewInterface $this
 */

$id          = isset($id) ? $id : $name;
$readonly    = isset($readonly) ? ($readonly ? true : false) : false;
$placeholder = isset($placeholder) ? JText::_($placeholder) : JText::_('JLIB_FORM_SELECT_USER');

$user        = $item->getContainer()->platform->getUser($userID);

$width       = isset($width)  ? $width : 800;
$height      = isset($height) ? $height : 500;

$uri = new JUri('index.php?option=com_users&view=users&layout=modal&tmpl=component');
$uri->setVar('required', (isset($required) ? ($required ? 1 : 0) : 0));
$uri->setVar('field', $name);

$url = 'index.php' . $uri->toString(['query']);
?>

@unless($readonly)
  @jhtml('behavior.modal', 'a.userSelectModal_' . $this->escape($name))
  @jhtml('script', 'jui/fielduser.min.js', ['version' => 'auto', 'relative' => true])
@endunless

<div class="input-append">
  <input
    @if($readonly)
      readonly
    @endif
    type="text"
    id="{{{ $name }}}"
    class="field-user-input-name"
    value="{{{ $user->username }}}"
    placeholder="{{{ $placeholder }}}"
    aria-invalid="false"
  />

  <a
    href="@route($url)"
    class="userSelectModal_{{{ $name }}}"
    rel="{handler: 'iframe', size: {x: {{$width}}, y: {{$height}} }}"
  >
    <button
      type="button"
      class="btn btn-primary button-select"
      title="{{{ $placeholder }}}"
      aria-label="{{{ $placeholder }}}"
    >
      <span class="icon-user" aria-hidden="true"></span>
    </button>
  </a>
</div>

@unless($readonly)
  <input type="hidden" id="{{{ $name }}}_id" name="{{{ $name }}}" value="{{ (int) $userID }}"/>
@endunless
