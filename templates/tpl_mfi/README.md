Bootstrap v3 Template for Multi-Family Insiders

<h3>Supported libraries:</h3>
<ul>
  <li>Bootstrap 3.5</li>
  <li>Modernizr</li>
  <li>Font Awesome</li>
  <li>PIE for IE</li>
  <li>Holder, client-side image placeholders</li>
</ul>

<h3>Positions:</h3>
<ul>
  <li>Left and Right Modules with independent proportions</li>
  <li>Fullwidth position for sliders</li>
</ul>

<h3>Admin features:</h3>
<ul>
  <li>Upload Logo from Administrator</li>
  <li>Hide front content option in admin</li>
</ul>

<h3>Gulp Tasks</h3>

* `gulp clean`: Cleans all the template files from the working website.
* `gulp copy`: Copies template files to the working website.
* `gulp watch`: Starts watching for changes in the repository folder to compile them and update the working website and local files.
* `gulp sass`: Compile Sass files in the repository folder and copy them to the local `css` folder + working website `css` folder
* `gulp scripts`: Compile `template.js` from the repository folder and copy results to the local `js` folder + working website `js` folder
* `gulp`. When running gulp with no tasks it will run the default task. That automatically launches: `copy`, `watch`, `browser-sync`. So it will copy all the files to the working website, start watching for changes there and launch an instance of BrowserSync in your browser that will be automatically refreshed when any change is done to the template files.


<h3>TODO:</h3>
The following core code files have HTML generated in them and need overridden in the template override system:

    libraries/cms/html/bootstrap.php
    libraries/cms/html/icon.php
    libraries/cms/html/jquery.php

Might need a plugin to unset scripts/css:

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
