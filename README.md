# Well-Known File Manager

Manage all your website's .well-known files in one place - from security policies to domain verification and more.

# Description

Your website needs to communicate with various services, bots, and systems. These interactions often require specific files in your `.well-known` directory - files that help others understand your site better, verify ownership, or implement security policies.

Well-Known File Manager makes it easy to manage all these important files from your WordPress admin panel. No more manual file creation or FTP uploads needed!

## Why Do You Need This?

* **Security**: Provide security contact information via `security.txt`
* **App Verification**: Verify your domain for Google Play and Apple App Store
* **Domain Verification**: Prove ownership for various services
* **OpenID Connect**: Enable authentication services
* **Password Management**: Help users change their passwords
* **Privacy Policies**: Share your Do Not Track policy
* **And More**: Support for many other standard .well-known files

## Key Features

* 🛠️ **Easy Management**: Enable, disable, and edit files directly from WordPress
* 🔄 **Automatic Serving**: Files are served at the correct URLs automatically
* 📱 **Mobile-Friendly**: Clean, responsive admin interface
* ⚡ **Performance**: Intelligent caching with automatic purging
* 🔍 **Priority Files**: Special highlighting for important files like security.txt

## Supported Files

The plugin supports a wide range of .well-known files, including:

* `security.txt` - Security contact information
* `assetlinks.json` - Android App Links verification
* `apple-app-site-association` - iOS Universal Links
* `acme-challenge` - SSL certificate verification
* `change-password` - Password change location
* `dnt-policy.txt` - Do Not Track policy
* `openid-configuration` - OpenID Connect configuration
* And many more...

# Installation

1. Upload the `well-known-manager` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Well-Known Manager to configure your files

# Usage

1. Navigate to Settings > Well-Known Manager
2. Enable the files you need by toggling their switches
3. Edit the content of each file as needed
4. Save your changes

Your .well-known files will be automatically served at their respective URLs (e.g., `https://yoursite.com/.well-known/security.txt`).

# Frequently Asked Questions

## Can I add custom .well-known files?

Currently, the plugin supports a predefined set of .well-known files. Custom file support may be added in future versions.

## How does caching work?

The plugin implements intelligent caching for optimal performance. The cache is automatically cleared when you update file content or plugin options, ensuring your files are always served with the latest content.

## Is this plugin compatible with my hosting environment?

The plugin works with any standard WordPress hosting environment. However, some hosts may have restrictions on serving files from non-standard locations. If you encounter issues, please check your hosting provider's documentation.

## What happens to my .well-known files when I deactivate the plugin?

When deactivated, the .well-known files will no longer be served, but your settings and file contents are preserved. Reactivating the plugin will restore your configuration.

## Can I use this plugin with a caching plugin?

Yes! The plugin is designed to work with WordPress caching plugins. It automatically purges its own cache when files are updated and is compatible with most popular caching solutions.