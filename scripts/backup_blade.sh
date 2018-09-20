#!/bin/sh

SOURCE="/var/www/joomla/cache"
DEST="/var/www/tmp"

while true; do
  inotifywait -r -e modify,move,create,delete $SOURCE && rsync -arvzh $SOURCE $DEST
done
