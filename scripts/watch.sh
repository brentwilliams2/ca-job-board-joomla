#!/bin/sh
# Run sync.h shell script whenever a file in project directory is changed

SCSS_SOURCE="$CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/media/scss"
CSS_DEST="$CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/media/css"

# Watcher for SASS files
if [ "$CA_ENV" = "dev" ]; then
  /usr/local/bin/sass --watch $SCSS_SOURCE:$CSS_DEST &
fi

while true; do
  inotifywait -r -e modify,move,create,delete $CA_DIRECTORY_TO_OBSERVE && /bin/bash ./sync.sh
done
