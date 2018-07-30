 This directory is required for the correct operation of the Joomla! back-end.

Joomla! menu manager will look for XML files describing front-end views in the "views" directory, even though we actually use the "View" directory (singular, first letter uppercase) to hold our files. This is a limitation of Joomla!, unfortunately. The not-so-elegant solution is to have this directory just for these XML files. Without this directory the menu manager will not allow you to create menu items for the component.

site/views/viewName/metadata.xml:

    <?xml version="1.0" encoding="utf-8"?>
    <metadata>
      <!-- View definition -->
      <view>
        <!-- Layout options -->
        <options>
          <!-- Default layout's name -->
          <default name="COM_CAJOBBOARD_VIEW_ITEM_TITLE" />
        </options>
      </view>
    </metadata>
