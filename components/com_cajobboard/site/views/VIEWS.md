This directory is required for the correct operation of the Joomla! back-end. It provides the menu items used in the menu manager when creating a new menu item. Administration menu options go in the installation XML file.

There are two files used:

  site/views/viewName/metadata.xml

and:

  site/views/viewName/tmpl/default.xml

The metadata.xml file and default.xml file differ, in that the tmpl directory xml files will add a layout parameter to the query string if the file is named anything other than "default.xml", e.g. having a "otherlayout.xml" file will end up with a query string like:

  index.php?option=com_example&view=exampleView&layout=otherlayout

There doesn't seem to be any option to choose which view, though. The downside of the metadata.xml file seems to be that you can only add a single parameter to add to the query string:

  <metadata>
    <view>
      <options var="additional_request_var">
        <default name="COM_EXAMPLE" msg="COM_EXAMPLE_DESC"/>
        <option name="COM_EXAMPLE_EXT" msg="COM_EXAMPLE_EXT_DESC" value="additional_request_var_value" />
      </options>
    </view>
  </metadata>

Results in:

  index.php?option=com_example&view=viewsDirectory&additional_request_var=additional_request_var_value

You can add additional query parameters for **all** views like this:

  <metadata>
    <view>
      <options var="task">
        <option name="Browse" msg="List view of Job Postings" value="browse" />>
        <option name="Item Edit" msg="Edit view of a Job Posting" value="edit" />
        <option name="Item" msg="Item view of a Job Posting" value="read" />
      </options>
      <fields name="request">
        <fieldset name="request">
          <field
            name="id"
            type="list"
            label="COM_HELLOWORLD_HELLOWORLD_FIELD_GREETING_LABEL"
            description="COM_HELLOWORLD_HELLOWORLD_FIELD_GREETING_DESC"
            default="1"
          >
              <option value="1">Hello World!</option>
              <option value="2">Good bye World!</option>
          </field>
          <field name="format" default="raw"/>
          <field name="task" type="hidden" default="start"/>
        </fieldset>
      </fields>
    </view>
  </metadata>
