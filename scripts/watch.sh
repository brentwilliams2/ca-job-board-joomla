#!/bin/sh

# Job Board development tool for compiling SASS to CSS and
# syncing development repository to a live Joomla! site
#
# @package   Calligraphic Job Board
# @version   0.1 May 1, 2018
# @author    Calligraphic, LLC http://www.calligraphic.design
# @copyright Copyright (C) 2018 Calligraphic, LLC
# @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only

if [ "$(whoami)" != "root" ]; then
  printf "\nScript must be run as root user. The rsync and sass commands are\n"
  printf "executed as the 'www-data' user for Ubuntu systems. Adjust script\n"
  printf "for distributions with different web server users. The -E flag to sudo\n"
  printf "will preserve local environment variables for the root user if needed.\n\n"
  printf "Rerun with command: sudo ./watch.sh\n\n"
  exit 0
fi

# Make sure environment vars are set
if [ -z "$CA_DIRECTORY_TO_REPO" ] || [ -z "$CA_DIRECTORY_TO_JOOMLA" ]; then
  printf "\nYou need to set the following environmental variables in your shell\n"
  printf "environment, for example in /etc/bash.bashrc on Debian systems:\n\n"
  printf "  CA_DIRECTORY_TO_JOOMLA  - the root of the live Joomla! site to sync to\n"
  printf "  CA_DIRECTORY_TO_REPO - the root of the project repository\n"
  printf "\nExample entries for Debian in bash.bashrc:\n\n"
  printf "export CA_DIRECTORY_TO_REPO=\"/var/www/work/ca-job-board-joomla\"\n"
  printf "export CA_DIRECTORY_TO_JOOMLA=\"/var/www/joomla\"\n\n"
  exit 0
fi

# Sass will run as a daemon in `--watch` mode, so kill it on abort
cleanup () {
  printf "\n## Caught SIGINT; Clean up and Exit \n"
  pkill -P $(cat /var/run/cajobboard_sass_watcher.pid) 2> /dev/null
  rm /var/run/cajobboard_sass_watcher.pid 2> /dev/null
  exit $?
}

# @TODO: There is a race condition between the SASS watcher, and the inotifywait watcher. Should all of this move to a Gulp script?

# Watcher for SASS files
sudo -u www-data /usr/local/bin/sass --watch "$CA_DIRECTORY_TO_REPO/components/com_cajobboard/media/scss":"$CA_DIRECTORY_TO_REPO/components/com_cajobboard/media/css" &
sudo -u www-data /usr/local/bin/sass --watch "$CA_DIRECTORY_TO_REPO/templates/tpl_mfi/scss":"$CA_DIRECTORY_TO_REPO/templates/tpl_mfi/css" &

# Write out the pid for the SASS daemon
printf $! > /var/run/cajobboard_sass_watcher.pid

# Set error handlers so we can kill the SASS watcher daemon on script interrupt
trap cleanup INT TERM

# Attach file system listeners to trigger the `sync` scripts.
while true; do
  sudo -u www-data inotifywait -r -e modify,move,create,delete $CA_DIRECTORY_TO_REPO && /bin/bash ./sync.sh
done
