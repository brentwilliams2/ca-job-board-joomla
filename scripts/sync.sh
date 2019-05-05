#!/bin/sh

#  Job Board development script to sync repository directories to a live Joomla! site installation
#
# @package   Calligraphic Job Board
# @version   0.1 May 1, 2018
# @author    Calligraphic, LLC http://www.calligraphic.design
# @copyright Copyright (C) 2018 Calligraphic, LLC
# @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only

echo "Syncing directories..."

# Delete cached Blade templates on live Joomla! site
rm -r $CA_DIRECTORY_TO_JOOMLA/cache/com_cajobboard 2> /dev/null

# RSYNC NOTE: Use multiple `--exclude` parameters if multiple files or directories are to be excluded

#-----------------------------------
#  @TODO: Call gulpfile task to add BrowserSync code into CSS files, maybe should be 2 gulp
#         tasks that feed a stream from first to second? Instead of a file destination?
#         SCSS transpile -> BrowserSync code injection -> file CSS -> minify to disk -> compress to disk
#-----------------------------------

# Implement

#-----------------------------------
#  Component file syncing
#-----------------------------------

# @TODO: the --delete flag here is why the compiled blade templates are getting wiped out, should exclude that directory
# Sync administrator component files. Excluded file 'user.json' is for the sample data generator in Cli directory.
rsync -arvzh --exclude 'user.json' $CA_DIRECTORY_TO_REPO/components/com_cajobboard/admin/ $CA_DIRECTORY_TO_JOOMLA/administrator/components/com_cajobboard --delete

# Sync site component files
rsync -arvzh $CA_DIRECTORY_TO_REPO/components/com_cajobboard/site/ $CA_DIRECTORY_TO_JOOMLA/components/com_cajobboard --delete

# Sync media component files
rsync -arvh $CA_DIRECTORY_TO_REPO/components/com_cajobboard/media/ $CA_DIRECTORY_TO_JOOMLA/media/com_cajobboard --delete

#-----------------------------------
#  Template file syncing
#-----------------------------------

# Sync template root PHP files
rsync -avzh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/*.php $CA_DIRECTORY_TO_JOOMLA/templates/mfi

# Sync template XML configuration file
rsync -avzh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/templateDetails.xml $CA_DIRECTORY_TO_JOOMLA/templates/mfi

# Sync template favicon file
rsync -avh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/favicon.ico $CA_DIRECTORY_TO_JOOMLA/templates/mfi/favicon.ico

# Sync template icon files
rsync -avh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/*.png $CA_DIRECTORY_TO_JOOMLA/templates/mfi

# Sync template Javascript files
rsync -arvzh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/js/ $CA_DIRECTORY_TO_JOOMLA/templates/mfi/js --delete

# Sync template CSS files
rsync -arvzh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/css/ $CA_DIRECTORY_TO_JOOMLA/templates/mfi/css --delete

# Sync template image files
rsync -arvh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/images/ $CA_DIRECTORY_TO_JOOMLA/templates/mfi/images --delete

# Sync template language files
rsync -arvzh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/language/ $CA_DIRECTORY_TO_JOOMLA/templates/mfi/language --delete

# Sync template font files
rsync -arvzh $CA_DIRECTORY_TO_REPO/templates/tpl_mfi/fonts/ $CA_DIRECTORY_TO_JOOMLA/templates/mfi/fonts --delete

#-----------------------------------
#  Plugin file syncing
#-----------------------------------

# Sync "user" group job board plugin files
rsync -arvzh --exclude 'README.md' $CA_DIRECTORY_TO_REPO/plugins/plg_user_cajobboard/ $CA_DIRECTORY_TO_JOOMLA/plugins/user/cajobboard --delete

