<?php
/**
 * Plugin Name: Well-Known Manager
 * Description: Manage files in the .well-known folder.
 * Version: 1.3
 * Author: Jono Alderson
 * Author URI: https://www.jonoalderson.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: well-known-manager
 */

namespace WellKnownManager;

/**
 * Class Plugin
 *
 * Main plugin class for the Well-Known Manager plugin.
 */
class Plugin {

    const PLUGIN_FILENAME = __FILE__;
    const PLUGIN_FOLDER = __DIR__; 
    const CACHE_GROUP = 'well_known_manager';
    
    /**
     * @var Admin The admin object.
     */
    private $admin;

    /**
     * @var Handler The handler object.
     */
    private $handler;

    /**
     * WellKnownManager constructor.
     */
    public function __construct() {
        $this->admin = new Admin();
        $this->handler = new Handler();
    }

    /**
     * Initialize the plugin.
     *
     * @return void
     */
    public function init() : void {
        $this->define_constants();
        $this->register_hooks();
    }

    /**
     * Define plugin constants.
     *
     * @return void
     */
    private function define_constants() : void {
        define('WELL_KNOWN_MANAGER_VERSION', '1.3');
        define('WELL_KNOWN_MANAGER_FILE', __FILE__);
        define('WELL_KNOWN_MANAGER_DIR', __DIR__);
    }

    /**
     * Register plugin hooks.
     *
     * @return void
     */
    private function register_hooks() : void {
        register_activation_hook(WELL_KNOWN_MANAGER_FILE, [$this, 'activate']);
        register_uninstall_hook(WELL_KNOWN_MANAGER_FILE, [$this, 'maybe_delete_options']);
    }


    /**
     * Get all well-known files with their class names.
     *
     * @return array Array of well-known files with their class names as keys.
     */
    public static function get_well_known_files() : array {
        $files = [];
        $classes = self::get_well_known_file_classes();
        
        foreach ($classes as $class_name) {
            $instance = new $class_name();
            $filename = $instance->get_filename();
            $files[$class_name] = $filename;
        }
        
        return $files;
    }

    /**
     * Activation routine.
     *
     * @return void
     */
    public function activate() {
        // No default options needed anymore.
    }

    /**
     * Deletion routine.
     *
     * @return void
     */
    public function maybe_delete_options() : void {
        // Delete the files option.
        delete_option('well_known_files');
    }
}

// Include the autoloader
require_once __DIR__ . '/autoload.php';

// Initialize the plugin
$plugin = new Plugin();
$plugin->init();