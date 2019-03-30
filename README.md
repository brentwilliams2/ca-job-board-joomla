This is the Back-End Framework-on-Framework code for Calligraphic Job Board

Add logging debug statement:

JLog::add('Job Occupational Categories model called', JLog::DEBUG, 'cajobboard');

Example try / catch setting a flash message, from edit() in Controller:

try
{
  $model->someMethod();
}
catch (\Exception $e)
{
  $this->setRedirect($e->getMessage());
  return;
}

// Enqueue a flash message
// type is 'message' or omitted  (green dialogue box), 'notice' (blue), 'warning' (yellow), 'error' (red)
JFactory::getApplication()->enqueueMessage(JText::_('SOME_MESSAGE'),  'type');

// Use the platform's error page method, depending on where called if container available
$this->getContainer()->platform->showErrorPage($exception);

