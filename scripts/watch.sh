#!/bin/sh
# Run watch.sh shell script whenever a file in project directory is changed

DIRECTORY_TO_OBSERVE="/var/www/html/work/ca-job-board-joomla/components/com_cajobboard"

while true
do
  inotifywait -r -e modify,move,create,delete $DIRECTORY_TO_OBSERVE && /bin/bash ./sync.sh 
done
