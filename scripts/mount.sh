#!/bin/sh

#mount --bind -r /var/www/html/work/ca-job-board-joomla/templates/tpl_mfi /var/www/joomla/templates/multi-familyinsiders

sudo mv /var/www/joomla/administrator/components/com_cajobboard /var/www/joomla/administrator/components/com_cajobboard_bak
sudo mv /var/www/joomla/components/com_cajobboard /var/www/joomla/components/com_cajobboard_bak

# ln -s [source file] [link name]
sudo ln -s /var/www/html/work/ca-job-board-joomla/components/com_cajobboard/admin /var/www/joomla/administrator/components/com_cajobboard
sudo ln -s /var/www/html/work/ca-job-board-joomla/components/com_cajobboard/site /var/www/joomla/components/com_cajobboard
# ln -s /var/www/html/work/ca-job-board-joomla/components/com_cajobboard/media media/com_cajobboard

sudo chown www-data:kevin -h /var/www/joomla/components/com_cajobboard
sudo chown www-data:kevin -h /var/www/joomla/administrator/components/com_cajobboard
