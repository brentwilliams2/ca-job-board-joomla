<?php
/*
  An administrator triggering an email from the back-end to a user will not get SEF-friendly URLs from JRoute. Code to do so:

  $app = JFactory::getApplication();
  // Here the contentURL is the url with correct itemid
  $contentUrl = JRoute::_($contentUrl);

  if ($app->isAdmin())
  {
    $parsed_url = substr($contentUrl, strlen(JUri::base(true)) + 1);

    $appInstance = JApplication::getInstance('site');
    $router = $appInstance->getRouter();
    $uri = $router->build($parsed_url);
    $parsed_url = $uri->toString();
    $contentRoutedUrl = substr($parsed_url, strlen(JUri::base(true)) + 1);
  }
*/
