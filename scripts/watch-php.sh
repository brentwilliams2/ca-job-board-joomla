#!/bin/sh
# Run sync.h shell script whenever a file in project directory is changed

if [ "$(whoami)" != "www-data" ]; then
  echo "Script must be run as user www-data"
  echo "Reun with command: sudo -u www-data PATH/TO/SCRIPTS/watch-php.sh"
  exit 0
fi

while true; do
  inotifywait -r -e modify,move,create,delete $CA_DIRECTORY_TO_OBSERVE && /bin/bash ./sync.sh
done
