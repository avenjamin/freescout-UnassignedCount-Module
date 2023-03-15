# FreeScout Unassigned Count Module
[FreeScout](https://github.com/freescout-helpdesk/freescout "FreeScout") Module to display the number of unassigned conversations in the Mailbox menu.

![Mailbox Menu](Public/img/UnassignedCount-Screenshot.png)

## Changes
* [Number of unassigned conversations in the Mailbox menu](Providers/UnassignedCountServiceProvider.php#L37-L54)

## Install
1. Navigate to your Modules folder e.g. `cd /var/www/html/Modules`
2. Run `git clone https://github.com/avenjamin/freescout-UnassignedCount-Module.git UnassignedCount`
3. Run `chown -R www-data:www-data UnassignedCount` (or whichever user:group your webserver uses)
4. Activate the Module in the FreeScout Manage > Modules menu.

## Update
1. Navigate to the Unassigned Count Module folder e.g. `cd /var/www/html/Modules/UnassignedCount`
2. Run `git pull`
3. Enjoy the update!