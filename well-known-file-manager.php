<?php
/**
 * Well-Known File Manager - Manage files in the .well-known directory.
 *
 * @package   Well_Known_File_Manager
 * @author    Jono Alderson <https://www.jonoalderson.com/>
 * @license   GPL-2.0-or-later
 * @link      https://github.com/jonoalderson/well-known-file-manager/
 * @since     1.0.0
 * @version   1.4.9
 *
 * @wordpress-plugin
 * Plugin Name:       Well-Known File Manager
 * Plugin URI:        https://github.com/jonoalderson/well-known-file-manager/
 * Description:       Manage files in the .well-known directory with ease.
 * Version:           1.4.9
 * Requires PHP:      7.4
 * Requires at least: 5.6
 * Tested up to:      6.8.2
 * Author:            Jono Alderson
 * Author URI:        https://www.jonoalderson.com/
 * Text Domain:       well-known-file-manager
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
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
    const CACHE_GROUP = 'wkfm_cache';
    
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
        define('WELL_KNOWN_FILE_MANAGER_VERSION', '1.4.9');
        define('WELL_KNOWN_FILE_MANAGER_FILE', __FILE__);
        define('WELL_KNOWN_FILE_MANAGER_DIR', __DIR__);
    }

    /**
     * Register plugin hooks.
     *
     * @return void
     */
    private function register_hooks() : void {
        register_activation_hook(WELL_KNOWN_FILE_MANAGER_FILE, [self::class, 'activate']);
        register_uninstall_hook(WELL_KNOWN_FILE_MANAGER_FILE, [self::class, 'deactivate']);
        
        // Register plugin action links.
        add_filter('plugin_action_links_' . plugin_basename(WELL_KNOWN_FILE_MANAGER_FILE), [$this->admin, 'add_plugin_action_links']);
    }

    /**
     * Deactivation routine.
     *
     * @return void
     */
    public static function deactivate() : void {
        // Clean up any physical files created by the plugin
        self::cleanup_physical_files();
    }

    /**
     * Activation routine.
     *
     * @return void
     */
    public static function activate() : void {
        // Create .well-known directory if it doesn't exist
        $well_known_dir = \WellKnownFileManager\Helpers::get_web_root_path() . '.well-known';
        if (!\is_dir($well_known_dir)) {
            \wp_mkdir_p($well_known_dir);
        }
    }

    /**
     * Clean up physical files on deactivation.
     *
     * @return void
     */
    private static function cleanup_physical_files() : void {
        $well_known_dir = \WellKnownFileManager\Helpers::get_web_root_path() . '.well-known';
        
        if (\is_dir($well_known_dir)) {
            $files = \glob($well_known_dir . '/*');
            foreach ($files as $file) {
                if (\is_file($file)) {
                    \unlink($file);
                }
            }
            
            // Remove the .well-known directory if it's empty
            if (\count(\glob($well_known_dir . '/*')) === 0) {
                \rmdir($well_known_dir);
            }
        }
    }

    /**
     * Get all well-known files with their class names.
     *
     * @return array Array of well-known files with their class names as keys.
     */
    public static function get_well_known_files() : array {
        $files = [];
        $classes = \WellKnownFileManager\Helpers::get_well_known_file_classes();
        
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