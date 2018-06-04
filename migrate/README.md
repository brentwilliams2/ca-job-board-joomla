postupdate.php script in migrate directory is written by mbabkar, with these instructions:

`
This script assumes that you have manually extracted the update package (2.5 to 3.x)  over your site and are ready to finish the update. You should trigger this script immediately after this process and before logging into your site's admin to do anything else, including the "database fix" routine.

To use this script, you should copy the postupdate.php file to your site's administrator directory. You can either access this script via a web request (https://www.example.com/administrator/postupdate.php) or from the command line interface (php /path/to/administrator/postupdate.php).

This script will run the "finalise" and "cleanup" steps from the update component, which performs such tasks as any database migrations and the removal of old files from your installation.
`

Tasks for migration:

1. Migrate modules database entries including mapping old Rocket template positions to new MFI template positions.
2. 