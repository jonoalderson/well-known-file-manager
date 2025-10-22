# Well-Known File Manager

A WordPress plugin for managing files in the `.well-known` directory. This plugin provides an easy-to-use interface for creating and managing various `.well-known` files that are commonly used for security verification, app associations, and other web standards.

**WARNING:** This plugin won't work on hosting environments and setups which disallow writing to / editing files in the `.well-known` directory (including sites hosted on wordpress.com). 

## Features

- **Easy Management**: Simple toggle switches to enable/disable `.well-known` files
- **Physical File Creation**: Creates actual files in the `.well-known` directory for maximum compatibility
- **Content Editing**: Built-in content editor for each file type with syntax highlighting
- **Default Templates**: Pre-configured templates for common `.well-known` files
- **Validation**: Content validation to ensure files meet required standards
- **Priority Files**: Highlighted support for important files like `security.txt`, `assetlinks.json`, and `apple-app-site-association`
- **Automatic Cleanup**: Removes files when disabled to keep your server clean

## Supported Files

The plugin supports a wide range of `.well-known` files, including:

- **Security Files**: `security.txt`, `security-txt`
- **App Associations**: `assetlinks.json`, `apple-app-site-association`
- **Protocol Handlers**: `change-password`, `gpc`, `hoba`
- **Discovery**: `host-meta`, `host-meta.json`, `nodeinfo`
- **Authentication**: `openid-configuration`, `oauth-authorization-server`
- **And many more...**

## Installation

1. Upload the plugin files to `/wp-content/plugins/well-known-file-manager/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to 'Settings > Well-Known File Manager' to configure your files

## Usage

1. **Enable Files**: Use the toggle switches to enable the `.well-known` files you need
2. **Edit Content**: Click the "Save" button to edit the content of each file
3. **Restore Defaults**: Use the "Restore Default" button to reset content to recommended defaults
4. **Automatic Creation**: When enabled, files are automatically created in your `.well-known` directory
5. **Automatic Cleanup**: When disabled, files are automatically removed from your server

## How It Works

This plugin takes a **physical file approach** rather than routing requests through WordPress:

- **When Enabled**: Creates actual files in your `.well-known` directory
- **When Disabled**: Removes the files from your server
- **No Server Configuration**: Works on any hosting setup without requiring `.htaccess` modifications
- **Maximum Compatibility**: Files are served directly by your web server for optimal performance

## Benefits

- **Universal Compatibility**: Works on any hosting provider without special configuration
- **Better Performance**: Files are served directly by the web server, not through WordPress
- **Simplified Setup**: No need to configure rewrite rules or server settings
- **Automatic Management**: Files are created and removed automatically based on your settings
- **Clean Server**: Disabled files are completely removed from your server

## File Permissions

The plugin automatically sets appropriate file permissions (644) for the created `.well-known` files. Make sure your web server has write permissions to your site's root directory for the plugin to function properly.

## Support

For support, feature requests, or bug reports, please visit the plugin's GitHub repository or contact the author.

## License

This plugin is licensed under the GPL v2 or later.

## Changelog

### 1.4.2
- **Major Change**: Switched to physical file creation approach
- Removed .htaccess dependency and complexity
- Added automatic file creation/deletion
- Improved compatibility across all hosting environments
- Simplified setup process
- Added automatic cleanup on plugin deactivation
