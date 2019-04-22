Bootstrap v3 Template for Multi-Family Insiders

@TODO: need banner ad module calls included in HTML overrides for the following positions:

    banner-content-left-first
    banner-content-left-second
    banner-content-right-first
    banner-content-right-second
    banner-content-lower-right

These are shown in Jan's design drawings on the "Create New Topic" Kunena editor page and on the JomSocial pages with an editor

@TODO: The following core code files have HTML generated in them and need overridden in the template override system:

    libraries/cms/html/bootstrap.php
    libraries/cms/html/icon.php
    libraries/cms/html/jquery.php

@TODO: Might need a plugin to unset scripts/css:

```
class PlgSystemDelbootstrap extends JPlugin {

  public function onBeforeCompileHead() {
    $app = JFactory::getApplication();

    //return noting to do if its admin
    if ($app->isAdmin()) {
        return;
    }

    $doc = JFactory::getDocument();

    unset($doc->_scripts['/media/jui/js/jquery.min.js']);
    unset($doc->_scripts['/media/jui/js/jquery-noconflict.js']);
    unset($doc->_scripts['/media/jui/js/jquery-migrate.min.js']);
    unset($doc->_scripts['/media/jui/js/bootstrap.min.js']);
    unset($doc->_scripts['/media/jui/js/jquery.autocomplete.min.js']);
    unset($doc->_scripts['/media/system/js/caption.js']);
  }
}

@TODO: Need to write a module to display social share icons broken off from the component, but picking up the component's current page URI
