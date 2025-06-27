<?php
/**
 * Plugin Name: Well-Known File Manager
 * Description: Manage files in the .well-known folder.
 * Version: 1.4
 * Author: Jono Alderson
 * Author URI: https://www.jonoalderson.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: well-known-file-manager
 */

namespace WellKnownFileManager;

/**
 * Class Plugin
 *
 * Main plugin class for the Well-Known File Manager plugin.
 */
class Plugin {

    const PLUGIN_FILENAME = __FILE__;
    const PLUGIN_FOLDER = __DIR__; 
    const CACHE_GROUP = 'well_known_file_manager';
    
    /**
     * @var Admin The admin object.
     */
    private $admin;

    /**
     * @var Handler The handler object.
     */
    private $handler;

    /**
     * WellKnownFileManager constructor.
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
        define('WELL_KNOWN_FILE_MANAGER_VERSION', '1.4');
        define('WELL_KNOWN_FILE_MANAGER_FILE', __FILE__);
        define('WELL_KNOWN_FILE_MANAGER_DIR', __DIR__);
    }

    /**
     * Register plugin hooks.
     *
     * @return void
     */
    private function register_hooks() : void {
        register_activation_hook(WELL_KNOWN_FILE_MANAGER_FILE, [$this, 'activate']);
        register_uninstall_hook(WELL_KNOWN_FILE_MANAGER_FILE, [$this, 'deactivate']);
    }

    /**
     * Deactivation routine.
     *
     * @return void
     */
    public function deactivate() : void {
        // Silence is golden.
    }

    /**
     * Activation routine.
     *
     * @return void
     */
    public function activate() : void {
        // Silence is golden.
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

}

// Include the autoloader
require_once __DIR__ . '/autoload.php';

// Initialize the plugin
$plugin = new Plugin();
$plugin->init();