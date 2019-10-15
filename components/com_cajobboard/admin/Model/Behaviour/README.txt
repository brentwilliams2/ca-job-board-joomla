To override validation behaviour for a particular model, create a directory
named named after the model in the 'Behaviour' directory and create a file with
the same file name as this behaviour ('Check.php'). The model file cannot go in
this directory, it must stay in the root Model folder.

Behaviour classes are observers of standard and bespoke model events. Events can
be added with the $model->triggerEvent($eventName) method. Because the same standard
events are listened to in multiple Behaviour classes, leading to naming inconsistency
and deciding where logic should live, it is convenient to segregate behaviours that
implement onCheck() methods to the Model/Behaviour/Check directory, named in CamelCase
after the model property that they are checking.

Top-level behaviours (e.g. Model/Behaviour/Category) can also implement onCheck()
methods, but should usually be performing some action in response to the
$model->onBeforeCreate() method. They should add the property to the list of fields
that are skipped on check, so that it doesn't catch on any default Check tasks (like
checking for null required fields that don't have a default):

  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $theField = $model->getFieldAlias('the_field');

    if ( $model->hasField($theField) )
    {
      $model->addSkipCheckField($theField);
    }
  }

The project is using Check classes in the Model/Behaviour/Check folder with the onCheck()
method to set default values for complex fields (e.g. Registry objects that are transformed
to JSON in the database). This functionality could be put into other classes (e.g. Publish
and Slug both set values for their respective fields and live in Model/Behaviour), but is 
in Check classes for the following reasons:

1. The behaviour in Publish, Slug, etc. is calculated and not default;

2. Default values are set in the Model/Behaviour/Check.php class when they are given in the
   database metadata, so it makes sense to locate default value setting methods to Check classes

