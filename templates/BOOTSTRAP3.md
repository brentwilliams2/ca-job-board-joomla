Using Bootstrap 3 requires template overrides for the following core extension files:

    components
        com_contact
        com_content
        com_search
        com_tags
        com_users
        com_weblinks
    Overrides the layouts
    Modules
        mod_breadcrumbs
        mod_login
        mod_menu
        mod_search
    modules.php
    pagination.php

Also, the following core code files have HTML generated in them and need overridden in the template override system:

    libraries/cms/html/bootstrap.php
    libraries/cms/html/icon.php
    libraries/cms/html/jquery.php

To migrate less than all pages to BS3, suggested to use an array ($bs3pages) in templates index.php, and check if the item_id for a page exists in that array to trigger loading BS3 and otherwise defaulting to BS2:

if ($isBS3):
 //including bootstrap version 3
 $document->addStyleSheet('templates/' . $this->template . '/css/bs3/bootstrap.min.css');
 $document->addScript('templates/' . $this->template . '/js/bs3/jquery.min.js');
 $document->addScriptDeclaration('jQuery.noConflict()');
 $document->addScript('templates/' . $this->template . '/js/bs3/jquery-migrate.min.js');
 $document->addScript('templates/' . $this->template . '/js/bs3/bootstrap.min.js');
else:
 //default bootstrap version 2
 $document->addStyleSheet('templates/' . $this->template . '/css/bootstrap.min.css');
 JHtml::_('bootstrap.framework');
endif;a

Found this code snippet to remove old jquery/bootstrap stuff:

$doc = JFactory::getDocument();
$assets = "templates/".$this->template;

// load jquery
JHtml::_('jquery.framework');

// remove default bootstrap js
foreach ($doc->_scripts as $url => $pars) {
    if ((strpos($url, "bootstrap.js") !== false) || (strpos($url, "bootstrap.min.js") !== false)) {
    unset($doc->_scripts[$url]); // remove from head
    JHtml::stylesheet($assets.'/css/bootstrapjserror.css'); // Generate error message at bottom of browserscreen
}
}

// add bootstrap 3 js
JHtml::script($assets.'/js/bootstrap.min.js');

// remove default bootstrap css
foreach ($doc->_styleSheets as $url => $pars) {
if ((strpos($url, "bootstrap.css") !== false) || (strpos($url, "bootstrap.min.css") !== false)) {
    unset($doc->_styleSheets[$url]); // remove from head
    JHtml::stylesheet($assets.'/css/bootstrapcsserror.css'); //Generate error message at bottom of browserscreen
}
}
// add bootstrap 3 css
JHtml::stylesheet($assets.'/css/bootstrap.min.css'); 

// add template css
JHtml::stylesheet($assets.'/css/template.css');




plugin to unset scripts/css:


class PlgSystemDelbootstrap extends JPlugin {

public function onBeforeCompileHead() {
    $app = JFactory::getApplication();

    //return noting to do if its admin
    if ($app->isAdmin()) {
        return;
    }

    $doc = JFactory::getDocument();
    // uncomment unwanted script
    //unset($doc->_scripts['/media/jui/js/jquery.min.js']);
    //unset($doc->_scripts['/media/jui/js/jquery-noconflict.js']);
    //unset($doc->_scripts['/media/jui/js/jquery-migrate.min.js']);
    unset($doc->_scripts['/media/jui/js/bootstrap.min.js']);
    //unset($doc->_scripts['/media/jui/js/jquery.autocomplete.min.js']);
    //unset($doc->_scripts['/media/system/js/caption.js']);
}
}
