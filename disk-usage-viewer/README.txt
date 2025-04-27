 
=== Disk Usage Viewer ===
Contributors: bxmedia
Tags: disk usage, disk space, server, dashboard, widget
Requires at least: 5.2
Tested up to: 6.8
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Displays server disk space usage (total, used, free) in a WordPress dashboard widget.

== Description ==

Disk Usage Viewer is a simple yet effective plugin that displays your server's disk space usage directly in your WordPress dashboard. The plugin shows total, used, and free space with percentages and a visual progress bar.

### Features
* Clean, easy-to-read disk usage statistics
* Visual progress bar showing used vs free space
* Proper permission checks to restrict access to authorized users
* Error handling for servers with restricted PHP functions

== Installation ==

1. Upload the `disk-usage-viewer` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. View the disk usage widget on your WordPress dashboard

== Frequently Asked Questions ==

= Who can see the disk usage widget? =

By default, only users who can view site health checks (administrators) can see the disk usage widget.

= Why does the widget show "Could not retrieve disk space information"? =

This message appears when your web host has disabled the PHP functions `disk_total_space` or `disk_free_space` for security reasons. Contact your hosting provider for more information.

= Does this plugin work with any hosting provider? =

The plugin should work with most hosting providers. However, some shared hosting environments may restrict the PHP functions needed to retrieve disk information.

== Screenshots ==

1. The disk usage dashboard widget showing space statistics and progress bar.

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of Disk Usage Viewer.

== Contact ==

For bug reports, feature requests, or any questions:
* Email: bxmedia@proton.me
* Website: [https://bxmedia.pro](https://bxmedia.pro)
