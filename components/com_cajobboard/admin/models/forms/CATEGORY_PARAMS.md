If you have more than one type of category in your component (e.g. "com_cajobboard.answers"), you need to make the name of the XML file "category.answers.xml".

Getting access to category parameters:

  use \Joomla\CMS\Categories\Categories;

  // get a categories object
  $categories = Categories::getInstance('com_cajobboard');

  // loads a specific category and all its children in a CategoryNode object
  $category   = $categories->get('answers');

  // returns a Registry object of params
  $attr = $category->getParams();

Getting access to the admin screen for Category configuration:

  option=com_categories&view=category&layout=edit&id=45&extension=com_cajobboard.answers

Joomla! has a form field type to use in XML-form generated admin screens for selecting category:

  <field name="mycategory" type="category" extension="com_cajobboard" label="Select a category" description="" />

  show_root (optional) is whether a choice representing the root category will be shown. If the show_root attribute is 1, the first option on the list will be a string representing the root category (which is a translatable string) and is given the value 0.

  multiple (optional) (true/false) is the ability to add more than 1 category to the form field

