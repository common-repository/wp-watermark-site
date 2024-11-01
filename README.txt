=== WP Watermark Site ===
Plugin URI: https://chrisjoseph.org/wp-watermark-site/
Contributors: Chris Joseph
Donate link: https://chrisjoseph.org/wp-watermark-site/
Tags: watermark,water mark,web designer,client protection,copyright,drm,image protect
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add any image or text as a watermark visible on all pages and posts of your WordPress site.

== Description ==

WP Watermark Site allows you to add an image or text as a watermark visible on all pages and posts of your WordPress site. 

This can be a permanent feature, or used (for example) to encourage prompt payment from clients by removing the watermark only after payment has been received.

If you find this plugin useful, please consider leaving something in my tip jar towards future development at https://chrisjoseph.org/wp-watermark-site/


== Installation ==

Either 

- Install this plugin direct from your WordPress site: go to Plugins > Add New > Search plugins > 'WP Watermark Site' > Install Now 

or 

- Download 'wp-watermark-site.zip' and upload to your WordPress site: go to Plugins > Add New > Upload Plugin > Choose the zip you have downloaded


After installation,

1. Activate the plugin ('WP Watermark Site') through the 'Plugins' menu in WordPress

2. Change the watermark settings via the 'Watermark' menu on the left of the WordPress admin panel


== Frequently Asked Questions ==

= The watermark is appearing over my page links and stopping them from working! =

By default, the watermark will appear on top of all other page elements. This works on themes that don't place links in the area where you place the watermark.

If you definitely need the watermark in a particular location, and can't move the links instead, you can try changing the "z-index" value in the plugin. For example, a value of -1 should place it beneath all other page elements, but it might be obscured by background colours or other images. Each WordPress theme is different, so you'll have to experiment if you don't know much CSS.
 
= Can I use an image on the web as the watermark? =

Yes, just add the URL of the image in the box under 'Watermark image'. However it is not good practice to use an image hosted by someone else as it uses up their bandwidth, so it is better to download the image to your computer and upload it again to your own WordPress media library. This will also ensure that your watermark doesn't disappear if the image is moved or removed. 

Also check that there are no copyright restrictions on the image.

= Can you add [this feature] to this plugin? =

I will consider adding frequently requested features if the plugin is used by enough people.


== Screenshots ==

1. Administration panel - watermarking turned off
2. Administration panel - text watermark
3. Administration panel - image watermark
4. Example of text watermark in bottom left position at 0.2 opacity
5. Example of image watermark in top right position at 0.2 opacity


== Changelog ==

= 1.4.1 =
* Fixed z-index setting to allow value of zero
* Fixed color picker on text watermark

= 1.4.0 =
* Added previews of watermark when image or text is chosen
* Added 'strong' to permitted HTML tags

= 1.3.0 =
* Added option to change z-index of watermark (thanks to Ina Bliss for this suggestion)
* Added option to change font size and family
* Added option to change image size

= 1.2.0 =
* Added option to position watermark (thanks to Hans Mueller for this suggestion)
* Added option to allow limited html tags in text watermark - < a href="" > < /a >, < br >, and < em >< /em >.
* Added option to choose text watermark color

= 1.1.0 =
* Option to turn watermarking off without deactivating plugin
* Switcher to clarify options (watermark off, text or image)
* Show message when settings not saved
* Fade out settings saved message after 4s
* Sanitizing of input fields

= 1.0.1 =
* Fixes file location calls, wp_enqueue for admin css and unique function names

= 1.0.0 =
* Initial version, 25th January 2016


== Upgrade Notice ==

= 1.4.1 =
Bug fixes to color picker and to allow zero z-index value

= 1.4.0 =
Now shows previews of watermark, and 'strong' HTML tags are permitted.

= 1.3.0 =
New options are available including font size and family, image size.

= 1.2.0 =
New options are available to position and style the watermark.

= 1.1.0 =
This version adds the option to switch watermarking off without deactivating the plugin.
