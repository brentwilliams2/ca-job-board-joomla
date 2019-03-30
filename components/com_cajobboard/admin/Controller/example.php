<?php

die();

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Table\Table;
use \Joomla\CMS\Table\Asset;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Access\Rules;


// Akeeba Subs FOF Controller Method examples

// Invoice controller has nice PDF-generating function
// EmailTemplate controller is nice e-mail generator

public function __construct(Container $container, array $config = array())
{
  $config['csrfProtection'] = 0;

  // before parent constructor call
  $config['cacheableTasks'] = [];

  // or after parent constructor call
  $this->cacheableTasks = [];

  // When a singular controller is extending a plural controller to
  // get view templates read from the Answer (singular) directory.
  $this->viewName = 'Answer';

  // task aliases
  $this->registerTask('thankyou', 'read');
	$this->registerTask('cancel', 'read');
}

public function create()
{
  // We have to use a real method for every task, so we can hook at them inside the view
  $this->display();
}

public function getlimits()
{
  // We have to use a real method for every task, so we can hook at them inside the view
  $this->display();
}

/**
* Make sure we only call the create event through the json format.
*/
protected function onBeforeCreate()
{
  $format = $this->input->getCmd('format', 'html');

  if ($format != 'json')
  {
    throw new AccessForbidden;
  }

  // get some request vars
  $slug = $this->input->getString('slug', null);

  // get some session vars
  $subscriber_user_id = $this->container->platform->getSessionVar('subscribes.user_id', null, 'com_akeebasubs');

  // set some session vars
  $this->container->platform->setSessionVar('subscribes.user_id', null, 'com_akeebasubs');

  // maybe reset some request vars
  $this->input->set('layout', 'thankyou');

  // or "work around progressive caching"
  \JFactory::getApplication()->input->set('subid', $subid);

  // set some controller properties
  $this->layout = 'thankyou';

  // maybe play with a model, our instance model:
  $levelsModel = $this->getModel()->find(['slug' => $slug]);

  // set state on the model
  $levelsModel->setState('id', $id);

  // or a different model:
  $subscription = $this->getModel('Subscriptions')->savestate(0)->setIgnoreRequest(0)->clearState()->find($subid);

  // Set the subscription model to a view class property
  $this->getView()->subscription = $subscription;

  // interesting
  $this->getIDsFromRequest($levelsModel, true);

	// Get the current user's ID
  $userId = $this->container->platform->getUser()->id;

  // Does the user have core.manage access or belongs to SA group?
  $isAdmin = $user->authorise('core.manage', 'com_akeebasubs');

  use FOF30\Dispatcher\Exception\AccessForbidden;

  // Use FOF access control
  if (!$this->checkACL('core.manage') && ($sub->user_id != $user->id))
  {
    throw new AccessForbidden;
  }
}

// Coupons controller has a simple task added to predefinedTaskList ('generate'):
public function generate($cachable = false, $urlparams = false, $tpl = null)
{
  /** @var  $model Akeeba\Subscriptions\Admin\Model\MakeCoupons */
  $model = $this->getModel();
  $model->makeCoupons();
  $this->setRedirect('index.php?option=com_akeebasubs&view=MakeCoupons');
}

// Invoices controller does a bunch of work and then shows the view from a custom task:
public function invoices()
{
  // lots of work

  // Show the view
  $this->display(false);
}

// Subscription no-ops default predefinedTaskList items
public function publish()
{
  $this->noop();
}

// maybe not well named, should be setRedirect()?
public function noop()
{
  // CSRF prevention
  $this->csrfProtection();

  // Redirect
  if ($customURL = $this->input->getBase64('returnurl', ''))
  {
    $customURL = base64_decode($customURL);
  }

  $url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();

  $this->setRedirect($url);
}

// user controller has this:
use PersonalInformation;

protected function onBeforeEdit()
{
  $user_id = $this->input->getInt('user_id', 0);

  // Try to load a record based on the Joomla! user ID
  if ($user_id)
  {
    /** @var Users $model */
    $model = $this->getModel()->savestate(false);

    $item = $model->user_id($user_id)->firstOrNew();

    $model->bind($item->getData());

    // If the record was not found, try to create a new one
    if (!$model->getId())
    {
      $url = 'index.php?option=com_akeebasubs&view=User';

      $this->setRedirect($url);
      $this->redirect();
    }
  }
}
?>

<form action="/administrator/index.php?option=com_content&amp;layout=edit&amp;id=1" method="post" name="adminForm" id="item-form" class="form-validate">

<div class="form-inline form-inline-header">
<div class="form-horizontal">

<div class="control-group">

<div class="control-label">

<fieldset class="adminform">
<fieldset class="form-vertical">

<label id="jform_title-lbl" for="jform_title" class="hasTooltip required" title="" data-original-title="<strong>Title</strong>">


<input type="text" name="jform[title]" id="jform_title">
<input type="text" name="jform[alias]" id="jform_alias">
<input type="text" name="jform[note]" id="jform_note">
<input type="text" name="jform[version_note]" id="jform_version_note">
<input type="text" name="jform[images][image_intro_caption]" id="jform_images_image_intro_caption">
<input type="text" name="jform[images][image_intro]" id="jform_images_image_intro">
<input type="text" name="jform[urls][urlatext]" id="jform_urls_urlatext">
<input type="text" id="jform_publish_up" name="jform[publish_up]">
<input type="text" id="jform_created" name="jform[created]">
<input type="number" name="jform[hits]" id="jform_hits">

<textarea name="jform[metadesc]" id="jform_metadesc" cols="30" rows="3">
<textarea name="jform[metakey]" id="jform_metakey" cols="30" rows="3">


<input type="radio" name="jform[featured]" id="jform_featured0" value="1">
<input type="radio" id="jform_featured1" name="jform[featured]" value="0" checked="checked">

<select id="jform_state" name="jform[state]" >
<select id="jform_access" name="jform[access]" size="1" style="display: none;">
<select id="jform_language" name="jform[language]" style="display: none;">

should be:
  <select name="var[]" multiple="yes">
otherwise all options will be set as 'var' in the POST response and overwrite each otherwise

<select id="jform_tags" name="jform[tags][]" class="span12" multiple="" style="display: none;">


<select id="jform_images_float_intro" name="jform[images][float_intro]" style="display: none;"></select>
<select id="jform_attribs_article_layout" name="jform[attribs][article_layout]" style="display: none;">

<select id="jform_metadata_robots" name="jform[metadata][robots]" style="display: none;">
<input type="text" name="jform[metadata][author]" id="jform_metadata_author" value="" size="20">


