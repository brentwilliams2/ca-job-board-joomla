<?php
 /**
  * Persons Site Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   July 14, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentCss($this);
  $this->container->AssetFiles->addViewJavascript($this);

  /** @var \Calligraphic\Cajobboard\Site\Model\Persons $item */
  $item = $this->getItem();

  // URL to post the form to
  $task = $this->getTask();
  $componentName = $this->getContainer()->componentName;
  $view = $this->getName();

  $action  = 'index.php?option=com_cajobboard&view=Persons';

  if ('edit' == $task)
  {
    $action = '&task=save&id=' . $item->id;
  }
  elseif ('add' == $task)
  {
    $action .= '&task=save';
  }

  $removeAction = 'index.php?option=com_cajobboard&view=Persons&task=remove&id=' . $item->id;

  /*
    Limit access to personally identifiable information:

    @if ($this->getContainer()->platform->getUser()->authorise('com_cajobboard.pii', 'com_cajobboard'))
      protected content
    @endif
   */
?>


{{--
  Responsive component
--}}
@section('person-edit-container')
  <form action="@route($action)" method="post" name="siteForm" id="siteForm" class="cajobboard-form">
    <div class="person-edit-container">

      <header class="form-header">
        <h3>
          @TODO: Implement Persons add / edit form
        </h3>
      </header>

      <button class="btn btn-primary person-submit pull-right" type="submit">
        @lang('JAPPLY')
      </button>

    </div>

    {{-- Hidden form fields --}}
    <div class="cajobboard-form-hidden-fields">
      <input type="hidden" name="@token()" value="1"/>
    </div>
  </form>

   {{-- Form with CSRF field for remove action --}}
  <form action="@route($removeAction)" method="post" name="removeForm" id="removeForm-{{ $item->id }}">
    <input type="hidden" name="@token()" value="1"/>
  </form>

@show
