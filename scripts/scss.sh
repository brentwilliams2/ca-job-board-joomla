#!/bin/sh

PATH="/var/www/html/work/ca-job-board-joomla/components/com_cajobboard/media"

# Watcher for SASS files
/usr/local/bin/sass --watch $PATH/scss:$PATH/css
