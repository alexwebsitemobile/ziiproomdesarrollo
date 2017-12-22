=== HubSpot Tracking Code for WordPress ===
Contributors: HubSpotDev, gcorne
Tags: analytics, marketing analytics, hubspot, tracking code, inbound marketing, marketing
Requires at least: 3.7
Tested up to: 4.8
Stable tag: 1.2.0

HubSpot's WordPress plugin allows existing HubSpot customers and trial users to install the HubSpot tracking code on their existing WordPress blogs and websites.

== Description ==

HubSpot's WordPress plugin allows existing HubSpot customers and trial users to install the HubSpot tracking code on their existing WordPress blogs and websites.

If you don't have an account yet, <a href="http://offers.hubspot.com/free-trial?utm_campaign=Connect%20Partner%20Free%20Trial%20Conversions&utm_source=hswordpressplugin">sign up for a free 30 day trial.</a>

Note: HubSpot collects usage information about this plugin so that we can better serve our customers and know what features to add. By installing and activating the HubSpot for WordPress plugin you agree to these terms.


== Installation ==

*(using the Wordpress Admin Console)*

1. From your dashboard, click on "Plugins" in the left sidebar
2. Add a new plugin
3. Search for "HubSpot"
4. Install "HubSpot Tracking Code”
5. Once Installed, click Settings → HubSpot Settings
6. Enter your Hub ID and press “Save Settings” (your Hub ID can be found with the product version at the bottom of your HubSpot Dashboard. Once you've entered it into the plugin settings, click the Click here to authenticate button. You'll be asked to login to HubSpot and give access).

http://help.hubspot.com/articles/How_To_Doc/how-to-install-hubspot-javascript-tracking-code-on-wordpress

*(manually via FTP)*

1. Delete any existing 'hubspot' folder from the '/wp-content/plugins/' directory
2. Upload the 'hubspot' folder to the '/wp-content/plugins/' directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Once Installed, click on the HubSpot plugin in your sidebar and go to "settings"
5. Enter your Hub ID and press “Save Settings” (your Hub ID can be found with the product version at the bottom of your HubSpot Dashboard. Once you've entered it into the plugin settings, click the Click here to authenticate button. You'll be asked to login to HubSpot and give access).


== Changelog ==
= 1.2.1 =
* Fix bug with loading the analytics script against the wrong hub

= 1.2.0 =
* Upgrade to the latest version of the HubSpot analytics tracking script
* Remove multisite workaround that is no longer needed

= 1.1.2 =
* Fix PHP 7 deprecation notice

= 1.1.1 =
* Bump compatibility

= 1.1.0 =
* Fix issue with custom post type posts being labeled with "blog-post"
* Fix deprecated warnings
* Improve validation

= 1.0.0 =
* Launched the plugin

