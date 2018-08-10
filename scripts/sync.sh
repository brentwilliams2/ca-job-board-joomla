#!/bin/sh

# Delete cached Blade templates on live Joomla! site
rm -r /var/www/joomla/cache/com_cajobboard

# rsync -a [source file] [destination file]

rsync -avzh /var/www/html/work/ca-job-board-joomla/components/com_cajobboard/admin/ /var/www/joomla/administrator/components/com_cajobboard

rsync -avzh /var/www/html/work/ca-job-board-joomla/components/com_cajobboard/site/ /var/www/joomla/components/com_cajobboard

#rsync -avh /var/www/html/work/ca-job-board-joomla/components/com_cajobboard/media /var/www/joomla/media/com_cajobboard
