=== Well-Known Manager ===
Contributors: jonoalderson
Tags: well-known, security, domain verification, file management
Requires at least: 5.0
Tested up to: 6.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily manage and serve .well-known files on your WordPress site for security policies, domain verification, and more.

== Description ==

Well-Known Manager is a WordPress plugin that allows you to easily manage and serve .well-known files on your WordPress site. These files are used for various purposes such as security policies, domain verification, and more.

= Features =

* Enable or disable specific .well-known files
* Edit the content of each file directly from the WordPress admin
* Automatically serve the files at the correct /.well-known/ URLs
* Supports a wide range of .well-known file types
* Caching for improved performance
* Option to clean up data on plugin deletion

= Supported .well-known Files =

The plugin supports a wide range of .well-known files, including but not limited to:

* security.txt
* acme-challenge
* assetlinks.json
* apple-app-site-association
* change-password
* dnt-policy.txt
* openid-configuration
* And many more...

== Installation ==

1. Upload the `well-known-manager` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Well-Known Manager to configure your .well-known files

== Usage ==

1. Navigate to the Well-Known Manager settings page (Settings > Well-Known Manager)
2. Enable the .well-known files you want to use by checking the corresponding boxes
3. Edit the content of each file as needed
4. Save your changes

The enabled .well-known files will now be automatically served at their respective /.well-known/ URLs.

== Frequently Asked Questions ==

= Can I add custom .well-known files? =

Currently, the plugin supports a predefined set of .well-known files. Custom file support may be added in future versions.

= How does caching work? =

The plugin caches the .well-known file responses for 1 hour to improve performance. The cache is automatically cleared when you update the file content.

= Is this plugin compatible with my hosting environment? =

The plugin should work with any standard WordPress hosting environment. However, some hosts may have restrictions on serving files from non-standard locations.

== Support ==

If you encounter any issues or have questions, please open an issue on the GitHub repository or contact the plugin support.

== Contributing ==

Contributions are welcome! Please feel free to submit a Pull Request.

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of Well-Known Manager.

== Credits ==

Well-Known Manager is developed and maintained by Jono Alderson.