#!/bin/sh

echo "Syncing directories..."

# Delete cached Blade templates on live Joomla! site
rm -r $CA_DIRECTORY_TO_JOOMLA/cache/com_cajobboard 2> /dev/null

# Sync administrator component files
rsync -arvzh $CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/admin/ $CA_DIRECTORY_TO_JOOMLA/administrator/components/com_cajobboard --delete

# Sync site component files
rsync -arvzh $CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/site/ $CA_DIRECTORY_TO_JOOMLA/components/com_cajobboard --delete

# Sync media component files
rsync -arvh $CA_DIRECTORY_TO_OBSERVE/components/com_cajobboard/media/ $CA_DIRECTORY_TO_JOOMLA/media/com_cajobboard --delete
