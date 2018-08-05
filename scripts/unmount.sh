#!/bin/sh

# umount /var/www/joomla/templates/multi-familyinsiders

sudo rm /var/www/joomla/administrator/components/com_cajobboard
sudo rm /var/www/joomla/components/com_cajobboard
# rm media/com_cajobboard

sudo mv /var/www/joomla/administrator/components/com_cajobboard_bak /var/www/joomla/administrator/components/com_cajobboard
sudo mv /var/www/joomla/components/com_cajobboard_bak /var/www/joomla/components/com_cajobboard
