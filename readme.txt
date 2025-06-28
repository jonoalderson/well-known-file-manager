=== Well-Known File Manager ===
Contributors: jonoalderson
Tags: well-known, files
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Manage files in the .well-known directory with ease. Create and manage security.txt, app associations, and other standard .well-known files directly from WordPress.

== Description ==

Well-Known File Manager provides an easy-to-use interface for creating and managing various `.well-known` files that are commonly used for security verification, app associations, and other web standards.

**Key Features:**

* **Easy Management**: Simple toggle switches to enable/disable `.well-known` files
* **Physical File Creation**: Creates actual files in the `.well-known` directory for maximum compatibility
* **Content Editing**: Built-in content editor for each file type with syntax highlighting
* **Default Templates**: Pre-configured templates for common `.well-known` files
* **Validation**: Content validation to ensure files meet required standards
* **Priority Files**: Highlighted support for important files like `security.txt`, `assetlinks.json`, and `apple-app-site-association`
* **Automatic Cleanup**: Removes files when disabled to keep your server clean

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

When deactivated, the plugin will remove all `.well-known` files it created. Your settings and file contents are preserved in the database, so reactivating the plugin will restore your configuration.

= Can I use this plugin with a caching plugin? =

Yes! The plugin is designed to work with WordPress caching plugins. Since files are served directly by the web server, they bypass WordPress caching entirely for optimal performance.

== Screenshots ==

1. Main admin interface showing enabled and disabled .well-known files
2. File editing interface with syntax highlighting
3. Priority files highlighted for important security and app association files

== Changelog ==

= 1.4.2 =
* **Major Change**: Switched to physical file creation approach
* Removed .htaccess dependency and complexity
* Added automatic file creation/deletion
* Improved compatibility across all hosting environments
* Simplified setup process
* Added automatic cleanup on plugin deactivation

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

== Upgrade Notice ==

= 1.4.3 =
This is a major update that changes how the plugin works. The plugin now creates physical files instead of using .htaccess routing. This provides better compatibility and performance across all hosting environments. No manual configuration required!