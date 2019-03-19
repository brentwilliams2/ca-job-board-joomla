#!/bin/sh
# Run sync.sh shell script whenever a file in project directory is changed
# and set up a SASS watcher to compile .scss files to css when they are edited
if [ "$(whoami)" != "root" ]; then
  echo "Script must be run as root user. The rsync and sass commands are"
  echo "executed as the 'www-data' user for Ubuntu systems. Adjust script"
  echo "to for distributions with different web server users.\n"
  echo "Rerun with command: sudo ./watch.sh"
  exit 0
fi

# Sass will run as a daemon in `--watch` mode, so kill it on abort
cleanup () {
  echo "\n## Caught SIGINT; Clean up and Exit \n"
  pkill -P $(cat /var/run/cajobboard_sass_watcher.pid) 2> /dev/null
  rm /var/run/cajobboard_sass_watcher.pid 2> /dev/null
  exit $?
}

SCSS_SOURCE="$CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/media/scss"
CSS_DEST="$CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/media/css"

# Watcher for SASS files
if [ "$CA_ENV" = "dev" ]; then
  sudo -u www-data /usr/local/bin/sass --watch $SCSS_SOURCE:$CSS_DEST &
fi

# Write out the pid for the SASS daemon
echo $! > /var/run/cajobboard_sass_watcher.pid

# Set error handlers so we can kill SASS on script interrupt
trap cleanup INT TERM

# Attach file system listeners to trigger the `sync` scripts. Add other sync scripts here (template, etc.).
while true; do
  sudo -u www-data inotifywait -r -e modify,move,create,delete $CA_DIRECTORY_TO_OBSERVE && /bin/bash ./sync-component.sh
done
