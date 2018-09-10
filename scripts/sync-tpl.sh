#!/bin/sh

if [ "$(whoami)" != "www-data" ]; then
  echo "Script must be run as user www-data"
  echo "Reun with command: sudo -u www-data PATH/TO/SCRIPTS/sync-tpl.sh"
  exit 0
fi

echo "Syncing template directories..."

SASS="/usr/local/bin/sass"
DIR="${CA_DIRECTORY_TO_OBSERVE}/templates/tpl_mfi"

# Compile template SASS files 
$SASS --update $DIR/scss:$DIR/css

# Create individual minified CSS files - SASS doesn't support renaming for directory compiles
$SASS $DIR/scss/bootstrap.scss     $DIR/css/bootstrap.min.css     --style compressed
$SASS $DIR/scss/chosen.scss        $DIR/css/chosen.min.css        --style compressed
$SASS $DIR/scss/font-awesome.scss  $DIR/css/font-awesome.min.css  --style compressed
$SASS $DIR/scss/glyphicons.scss    $DIR/css/glyphicons.min.css    --style compressed
$SASS $DIR/scss/icons.scss         $DIR/css/icons.min.css         --style compressed
$SASS $DIR/scss/template.scss      $DIR/css/template.min.css      --style compressed

# Sync template files
echo "Run rsync from command line to avoid file permission problems:"
echo "sudo -u www-data rsync -arvzh $CA_DIRECTORY_TO_OBSERVE/templates/tpl_mfi/ $CA_DIRECTORY_TO_JOOMLA/templates/mfi"

