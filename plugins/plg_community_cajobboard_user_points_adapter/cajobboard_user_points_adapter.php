<?php
/*
Brent mentioned allowing employers to set a bounty on a job posting, to control
which connectors can see it, and to push a notification to those connectors about it

@TODO: Need to load rules into Jomsocial for our stuff

http://documentation.jomsocial.com/wiki/User_Points_System

User Points System
Contents

    1 Calling the UserPoints API in Your Code
    2 Register Action Rules into Database
    3 See Also

JomSocial user points system allows any Third-Party developer or application
to easily reward "points" to any user action. The points system does not require
an activity stream item to be created and can be awarded at any desired event.

The site Admin will have the ability to modify the exact number of points to be
awarded for each action and can also completely disable it, if necessary.
Calling the UserPoints API in Your Code

If you want to give points to a user, you will need to call the API by inserting
the codes where you want them.

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
include_once JPATH_ROOT.'/components/com_community/libraries/userpoints.php';
CuserPoints::assignPoint('your.action.string');


The your.action.string is the rule registered in database with how many points
awarded to the current logged-in user. You will need to give a unique action
string to your components such as 'com_name.profile.upload.avatar'. In some
situations, where you want to give points to another user instead of the current
logged-in user, you can call the API's in the following manner:

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
include_once JPATH_ROOT.'/components/com_community/libraries/userpoints.php';
CuserPoints::assignPoint('your.action.string', 62);


By giving the userId (62) as the second parameter, the API will give points to
the specified user.
Register Action Rules into Database

To register all the action rules that used in your component / module / plugins,
you will need to create an XML file for this. Create one XML file and name it
'jomsocial_rule.xml'. You MUST name your file exactly as shown or else the rule
registration will fail.

You MUST include this file in your installer and put this file at the root level
in your Frontend component folder. Your XML file should look like the below one :

<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE jomsocial>
<jomsocial>
     <component>com_[Component Name]</component>
     <rules>
          <rule>
				<name>[Rule Name]</name>
				<description>[Rule Description]</description>
				<action_string>[Action String]</action_string>
				<publish>[default: true/false]</publish>
				<points>[default point, set 1 if needed]</points>
				<access_level>[acces level]</access_level>
          </rule>
     </rules>
</jomsocial>


For example,

<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE jomsocial>
<jomsocial>
     <component>com_hikashop</component>
     <rules>
          <rule>
				<name>Blogger Review</name>
				<description>Give point when vote added.</description>
				<action_string>hikashop.add.vote</action_string>
				<publish>true</publish>
				<points>1</points>
				<access_level>0</access_level>
          </rule>
     </rules>
</jomsocial>


For the access_level, use these are the values:

    0 => Public
    1 => Registered
    2 => Special

Assuming you have included this 'jomsocial_rule.xml' into your installer.

Install your component through Joomla Backend and your component folder 'com_xxx'
should be created in 'Joomla\components\com_xxx' and this XML should stay in
'Joomla\components\com_xxx\ jomsocial_rule.xml'.

Now, go to your Jomsocial Backend and you should see the icon 'UserPoints'. Go into
UserPoints and you should see screen below with some default / existing action rule displayed.

            Rules1.jpg

Click Rule Scan to bring up the popup screen. Rule Scan will actually scan through all
of the components folders to search for the file, 'jomsocial_rule.xml'. If there are new
rules, the scanning will register them into db and you should see the screen below for what
rules are registered. Click Refresh to continue.

            Rules2.jpg

That's it. Now all your actions have been registered into db and your components should give
points where you have placed your UserPoints API. You can always configure the action rule from
the JomSocial Backend in the UserPoints page. The screen below shows where you can modify your
rule's attributes.
*/
