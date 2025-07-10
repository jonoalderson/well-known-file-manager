=== Well-Known File Manager ===
Contributors: jonoaldersonwp
Tags: well-known, files
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.4.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Manage files in the .well-known directory with ease.

== Description ==

Manage your website's `.well-known` files with ease using this powerful yet simple plugin. The Well-Known File Manager provides a user-friendly interface to create, edit and manage standardized `.well-known` files - essential components for modern web security, app associations, and service discovery.

Whether you need to implement security.txt for vulnerability reporting, configure app associations, or set up protocol handlers, this plugin handles the technical complexities while giving you complete control. It creates actual files on your server for maximum compatibility and performance, without requiring any special server configuration or technical knowledge.

Perfect for developers, site owners, and administrators who want a reliable way to manage their site's `.well-known` directory through a clean, intuitive WordPress interface.

**Key Features:**

* **Easy Management**: Simple toggle switches to enable/disable `.well-known` files
* **Physical File Creation**: Creates actual files in the `.well-known` directory for maximum compatibility
* **Content Editing**: Built-in content editor for each file type with syntax highlighting
* **Default Templates**: Pre-configured templates for common `.well-known` files
* **Validation**: Content validation to ensure files meet required standards
* **Priority Files**: Highlighted support for important files like `security.txt`, `assetlinks.json`, and `apple-app-site-association`
* **Automatic Cleanup**: Removes files when disabled to keep your server clean
* **Data Preservation**: Files and settings are preserved when the plugin is deactivated or uninstalled

**Supported Files:**

* **Security Files**: `security.txt`, `security-txt`
* **App Associations**: `assetlinks.json`, `apple-app-site-association`
* **Protocol Handlers**: `change-password`, `gpc`, `hoba`
* **Discovery**: `host-meta`, `host-meta.json`, `nodeinfo`
* **Authentication**: `openid-configuration`, `oauth-authorization-server`
* And many more...

**How It Works:**

This plugin takes a **physical file approach** rather than routing requests through WordPress:

* **When Enabled**: Creates actual files in your `.well-known` directory
* **When Disabled**: Removes the files from your server
* **No Server Configuration**: Works on any hosting setup without requiring `.htaccess` modifications
* **Maximum Compatibility**: Files are served directly by your web server for optimal performance

**Benefits:**

* **Universal Compatibility**: Works on any hosting provider without special configuration
* **Better Performance**: Files are served directly by the web server, not through WordPress
* **Simplified Setup**: No need to configure rewrite rules or server settings
* **Automatic Management**: Files are created and removed automatically based on your settings
* **Clean Server**: Disabled files are completely removed from your server
* **Data Safety**: Your files and settings remain intact when deactivating or uninstalling the plugin

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/well-known-file-manager/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to 'Settings > Well-Known File Manager' to configure your files

== Frequently Asked Questions ==

= Can I add custom .well-known files? =

Currently, the plugin supports a predefined set of .well-known files. Custom file support may be added in future versions.

= How does the plugin handle file creation? =

The plugin creates actual physical files in your `.well-known` directory when enabled, and removes them when disabled. This ensures maximum compatibility across all hosting environments.

= Is this plugin compatible with my hosting environment? =

Yes! The plugin works with any standard WordPress hosting environment. Since it creates physical files, it doesn't require any special server configuration or .htaccess modifications.

= What happens to my .well-known files when I deactivate the plugin? =

**Your .well-known files are NOT deleted when you deactivate or uninstall the plugin.** The plugin preserves all your files and settings in the database. When you reactivate the plugin, your configuration will be restored exactly as it was. This ensures your important .well-known files remain accessible even if you temporarily deactivate the plugin.

= Can I use this plugin with a caching plugin? =

Yes! The plugin is designed to work with WordPress caching plugins. Since files are served directly by the web server, they bypass WordPress caching entirely for optimal performance.

== Screenshots ==

1. Main admin interface showing enabled and disabled .well-known files
2. File editing interface with syntax highlighting
3. Priority files highlighted for important security and app association files

== Changelog ==

= 1.4.7 (29/06/2025) =
* FEATURE: 
* FEATURE: Added a link to the settings from the plugins page (props @tacoverdo and @westonruter).
* BUGFIX: Fixed some layout shift issues (props @westonruter). 
* BUGFIX: Improve JSON rendering (props @westonruter). 
* BUGFIX: Reworked how 'disabled' files look and behave to improve accessibility (props @westonruter).
* BUGFIX: Change activation/deactivation methods to static functions (props @tacoverdo).

= 1.4.6 (29/06/2025) =
* BUGFIX: Tweaked some plugin headers.

= 1.4.5 (28/06/2025) =
* BUGFIX: Harden against some edge cases with malformed URLs.

= 1.4.2 =
* **Major Change**: Switched to physical file creation approach
* Removed .htaccess dependency and complexity
* Added automatic file creation/deletion
* Improved compatibility across all hosting environments
* Simplified setup process
* Added automatic cleanup on plugin deactivation
* **Important**: Files are preserved when plugin is deactivated/uninstalled

= 1.4.1 =
* Fixed plugin action links not showing
* Improved AJAX error handling
* Enhanced admin interface responsiveness

= 1.4.0 =
* Added support for additional .well-known file types
* Improved content validation
* Enhanced admin interface
* Better error handling and user feedback

= 1.3.0 =
* Added priority file highlighting
* Improved file organization
* Enhanced content templates
* Better mobile responsiveness

= 1.2.0 =
* Added content validation
* Improved error handling
* Enhanced admin interface
* Better file management

= 1.1.0 =
* Added support for more .well-known file types
* Improved admin interface
* Better content management
* Enhanced security features

= 1.0.0 =
* Initial release
* Basic .well-known file management
* Admin interface
* Core functionality