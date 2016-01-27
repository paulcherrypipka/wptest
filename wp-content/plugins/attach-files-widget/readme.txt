=== Attach Files Widget ===
Contributors: Vyacheslav Volkov (vexell@gmail.com)
Tags: widget, attachments, upload, sidebar, admin, files, enqueue media
Requires at least: 3.5.1
Tested up to: 4.0
Stable tag: 2.4

== Description ==

Simple attachment widget that uses native Wordpress upload manager to add files link widgets to your site.

* Title and Description
* Attach Existing Files
* Upload New files
* Sort files

== Installation ==

= Install =

1. In your WordPress administration, go to the Plugins page
1. Activate the Image Widget plugin and a subpage for the plugin will appear
   in your Manage menu.
1. Go to the Appearance > Widget page and place the widget in your sidebar in the Design

If you find any bugs or have any ideas, please mail me.

= Requirements =

* PHP 5.1 or above
* WordPress 3.5.1 or above

== Documentation ==

Press "Add attachment" button. Upload or choose exists file. Add title or description for file. Press "Insert Into Widget".
To remove attachment press "x" link.

At any post or page you can use shortcode [widget_attachments] to display widget content.
Available params:
 id - Widget ID (You can see at widget)
 limit - How many items can be showed

Example: [widget_attachments id="3" limit=5] It will show 5 attached files from Widget ID equal 3;

== Changelog ==

= 2.4 =
Thx Henrique Vianna

* Added an extra widget configuration option, that allows the user to choose large, small or no icons (defaults to "no icons", keeping the original plugin behavior)
* Added a frontend.css file to the ./assets/css/ folder for styling the icons display (each file name was wrapped in an additional "div" tag, to help with the positioning of the icons)
* Added filetype icon images to ./assets/images/
* Some tweaks in the i18n functions
* Added Brazilian Portuguese (pt_BR) translation files

= 2.3 =

* Fix error with "Featured image"

= 2.2 =

* Add shortcode to display widget content
* Fix error with plugins like "WP-PAGE-WIDGET". Widget styles and javascript initialization has been added to "admin_init"

= 2.1 =

* Add files sorting option
* Fix some bugs

= 2.0 =

* Use new Wordpress uploader
* Add description for files

= 1.1 =

* Fix javascript window.send_to_editor function.

= 1.0 =

* First version

== Screenshots ==

1. Image Widget admin screen.
2. Wordpress uploader for Widget
