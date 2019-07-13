Joomla! JHtml templates are a scheme to output HTML from a static method in an abstract class.
The logic to load these templates is mind-numbingly complex. Documentation is contradictory and
nearly non-existent. The only advantage to using them is that, in the back-end, where Joomla!
overrides the target on forms to use Javascript instead of providing a direct link when the form
is submitted, they pick up the Joomla! logic to enable this. They don't make any sense at all to
use on the front-end of the site.

`JHtml::_($key)` is the class loader method, and any additional arguments are passed to the called method.

`$key` is the name of helper method to load with the form: `(prefix).(class).function`

This example:

  @jhtml('helper.browseWidgets.methodName', parameter1, ...)

Is transformed by the FOF30 Blade compiler to:

  echo JHtml::_('helper.browseWidgets.methodName', parameter1, ...);

And executes the static `methodName` in the abstract class `browseWidgets` located in file:

  `JPATH_ADMINISTRATOR/Helper/Html/browsewidgets.php`

That path is added in the file `admin/View/Common/BaseHtml.php` to the HTMLHelper abstract class:

  HTMLHelper::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/Helper/Html');

The Akeeba FEF (front-end framework) helpers included with FOF30 use the JHtml scheme with revised HTML output.

JHtml helpers can't be namespaced, since the classes are used through Joomla's autoloader and JHtml system.

The source file for HTMLHelper:

  https://github.com/joomla/joomla-cms/blob/staging/libraries/src/HTML/HTMLHelper.php
