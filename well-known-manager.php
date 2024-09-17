<?php
/**
 * Plugin Name: Well-Known Manager
 * Description: Manage files in the .well-known folder.
 * Version: 1.1
 * Author: Jono Alderson
 * Author URI: https://www.jonoalderson.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: well-known-manager
 */

namespace WellKnownManager;

define('WELL_KNOWN_MANAGER_VERSION', '1.1');
define('WELL_KNOWN_MANAGER_FILE', __FILE__);
define('WELL_KNOWN_MANAGER_DIR', __DIR__);

// Include the autoloader
require_once WELL_KNOWN_MANAGER_DIR . '/autoload.php';

use WellKnownManager\WellKnownManager;

function run() {
    $plugin = new WellKnownManager();
    $plugin->init();
}

// Activation routine
function activate() {
    // Set default options
    $default_options = [
        'well_known_cleanup_on_deletion' => '0', // Default to not clean up
    ];

    if (get_option('well_known_cleanup_on_deletion') === false) {
        add_option('well_known_cleanup_on_deletion', $default_options['well_known_cleanup_on_deletion']);
    }
}

// Deletion routine
function delete_options() {
    // Check if cleanup is enabled
    if (get_option('well_known_cleanup_on_deletion') === '1') {
        delete_option('well_known_files');
        delete_option('well_known_cleanup_on_deletion');
    }
}

// Register activation and deletion hooks
register_activation_hook(WELL_KNOWN_MANAGER_FILE, 'WellKnownManager\activate');
register_uninstall_hook(WELL_KNOWN_MANAGER_FILE, 'WellKnownManager\delete_options');

run();


// TODO: Implement the following improvements:
// 1. Store validation errors with their respective files:
//    - Modify the save_well_known_files() method in the Admin class to store validation errors
//      alongside each file's content in the database.
//    - Update the render_well_known_file_section() method to display these errors when rendering each file section.

// 2. Expose content format as a property on each file's section:
//    - Add a get_content_format() method to each well-known file class (e.g., RobotsFile, SecurityFile, etc.).
//    - Update the render_well_known_file_section() method to include a data attribute with the content format.
//    - Implement client-side validation in admin-script.js using the exposed content format.

// These changes will improve error handling and enable client-side validation for a better user experience.