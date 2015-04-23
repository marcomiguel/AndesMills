=== Plugin Name ===
Contributors: Jafaloo
Donate link: 
Tags: Pinterest widget, Pinterest Plugin, Pinterest, Pinterest Follow Box, Recent Pins
Requires at least: 3
Tested up to: 3.5.2
Stable tag: 1.1.1
License: GPL-3

A must have plugin that adds a Pinterest badge on your blog to your pinterest profile and showing your number of followers and recent pins.


== Description ==
= My Pinterest Badge - =
My Pinterest Badge is a fully customisable pinterest badge plugin for wordpress. This widget displays the recent pins from your Pinterest account.

It adds a widget to your blog that will display a list of your latest pinned images from your pinterest profile or page. It also displays the number of people who have followed you in pinterest, number of likes and along with the follow button.

= Additional Info - =
This plugin uses caching mechanism to store the pinterest pin data on your server inside wp-content directory which avoids pinging the pinterest website every time with page loading. 

For any issues, please mail to jafaloo@jafaloo.com

Plugin page : http://www.protechblog.com/tools/my-pinterest-badge.php

== Installation ==

1. Download my-pinterest-badge.zip.
2. Upload the file my-pinterest-badge.zip to the `/wp-content/plugins/` directory and unzip it.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the 'Widgets' menu in Wordpress and add the widget to your sidebar.
5. Input your pinterest id and save it.

Configuration Help


1. Pinterest User ID: This is your Pinterest user id. This is the one you can find from the Pinterest URL also. Suppose 
your account URL is: http://www.pinterest.com/xyz/ then xyz is the User ID and you need to enter this.

2. From Board: Here you can mention from which board you want to show the pins. So how do your find the From Board name. Just login to your
Pinterest account an click on the board from where you want to show pins. Now see the URL it looks something like
http://www.pinterest.com/yourUserName/board-name/, then here the last part is the From Board and you need to enter it, that is
board-name withour any trailing slashes.

3. Cache Time: You can select the cache refresh time(In hours). This is the time duration upto which cache will be valid and after
that it will be refreshed and will fetch latest content from your Pinterest.

== Frequently Asked Questions ==

= I get the error "Warning: file_get_contents() [function.file-get-contents]: URL file-access is disabled in the server configuration in /var/www/web/html/wordpress/wp-content/plugins/my-pinterest-badge/pinterestloader.php". AND/OR I get the error "Warning: file_get_contents(http://pinterest.com/...[function.file-get-contents]: failed to open stream: no suitable wrapper could be found in /var/www/web/html/wordpress/wp-content/plugins/my-pinterest-badge/pinterestloader.php" =

The plugin requires either CURL or file_get_contents() to be enabled on your server.If your host gives you access to your php.ini then you can change the ‘allow_url_fopen’ setting to ’1′ which will fix your problem. Otherwise speak to your host and ask them to enable CURL or allow_url_fopen for you.

== Screenshots ==

1. My Pinterest Badge widget in the sidebar.

2. My Pinterest Badge Configuration panel from admin login.

== Changelog ==

= 1.1.1 =
* Fixed a major bug noticed recently dues to which the plugin stopped displaying images.

= 1.1.0 =
* Option Added to Customize cache time
* Option Added to Show Pins from a selected board
* Added PinIt button which helps in pinning your web site images. 

= 1.0.1 =
* Fixed the directory access problem.

= 1.0.0 =
* First Release of the Plugin

== Upgrade Notice ==
Some new features has been added to the plugin like: Option to customize cache time, 
option to show pins from a selected board, added Pin It button and some minor bug fixes.
