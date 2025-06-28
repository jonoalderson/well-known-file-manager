<?php

namespace WellKnownFileManager;

/**
 * Class Admin
 *
 * Manages the admin page
 *
 * @package WellKnownFileManager
 */
class Admin {

    /**
     * @var array $options The options.
     */
    private $options = [];

    /**
     * @var Htaccess The htaccess object.
     */
    private $htaccess;

    /**
     * Admin constructor.
     *
     * Initializes the admin functionality.
     */
    public function __construct() {
        $this->register_hooks();
    }

    /**
     * Registers WordPress hooks for the admin functionalities.
     *
     * @return void
     */
    public function register_hooks() : void {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_ajax_wkfm_toggle_well_known_file', [$this, 'ajax_toggle_well_known_file']);
        add_action('wp_ajax_wkfm_save_file', [$this, 'ajax_save_well_known_file']);
        add_action('wp_ajax_wkfm_get_default_content', [$this, 'ajax_get_default_content']);
    }

    /**
     * Displays a warning if the site is installed in a subdirectory.
     * In such cases, the plugin cannot automatically handle .well-known requests
     * and requires manual web server configuration.
     *
     * @return void
     */
    public function show_subdirectory_install_warning() {
        // Only show on our plugin page to avoid cluttering the admin interface.
        if (!isset($_GET['page']) || 'well-known-file-manager' !== $_GET['page']) {
            return;
        }

        // Bail if the site is not in a subdirectory.
        if (!Helpers::is_subdirectory_install()) {
            return;
        }

        $home_path = wp_parse_url(get_home_url(), PHP_URL_PATH);
        ?>
        <div class="notice notice-error">
            <h2><?php esc_html_e('Well-Known File Manager: Action Required', 'well-known-file-manager'); ?></h2>
            <p>
                <?php
                echo wp_kses_post(
                    sprintf(
                        // translators: %s is the subdirectory path, e.g., /blog.
                        __('Your website\'s home URL is set to a subdirectory (<strong>%s</strong>). Because of this, your web server will not automatically send requests for <code>/.well-known/</code> files to WordPress, and this plugin cannot manage them.', 'well-known-file-manager'),
                        esc_html($home_path)
                    )
                );
                ?>
            </p>
        </div>
        <?php
    }

    /**
     * Enqueues admin-specific styles and scripts.
     *
     * @param string $hook The current admin page.
     *
     * @return void
     */
    public function enqueue_admin_assets($hook) {
        // Bail if we're not on the plugin admin page.
        if ('settings_page_well-known-file-manager' !== $hook) {
            return;
        }

        // Get the version based on environment.
        $version = WELL_KNOWN_FILE_MANAGER_VERSION;
        if ('production' !== wp_get_environment_type()) {
            $css_file = Plugin::PLUGIN_FOLDER . '/styles/build/admin.min.css';
            $js_file = Plugin::PLUGIN_FOLDER . '/js/build/admin.min.js';
            
            // Get the latest modification time of either file.
            $css_mtime = file_exists($css_file) ? filemtime($css_file) : 0;
            $js_mtime = file_exists($js_file) ? filemtime($js_file) : 0;
            $version = max($css_mtime, $js_mtime);
        }

        wp_enqueue_style('well-known-file-manager-admin-styles', plugin_dir_url(__FILE__) . '../styles/build/admin.min.css', [], $version);
        wp_enqueue_script('well-known-file-manager-admin-script', plugin_dir_url(__FILE__) . '../js/build/admin.min.js', [], $version, true);

        // Localize the script with the nonce and other data.
        wp_localize_script('well-known-file-manager-admin-script', 'WellKnownFileManager', [
            'nonce' => wp_create_nonce('wkfm_nonce'),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'i18n' => [
                'saving' => __('Saving...', 'well-known-file-manager'),
                'error' => __('Error saving file state.', 'well-known-file-manager')
            ]
        ]);
    }

    /**
     * Adds the Well-Known File Manager options page to the admin menu.
     *
     * @return void
     */
    public function add_admin_menu() {
        add_options_page(
            __('Well-Known File Manager', 'well-known-file-manager'),
            __('Well-Known File Manager', 'well-known-file-manager'),
            'manage_options',
            'well-known-file-manager',
            [$this, 'render_admin_page']
        );
    }

    /**
     * Sanitize the well-known files options.
     *
     * @param array $input The input array to sanitize.
     * @return array The sanitized array.
     */
    public function sanitize_well_known_files($input) {
        if (!is_array($input)) {
            return [];
        }

        $sanitized = [];
        foreach ($input as $class_name => $data) {
            if (!is_array($data)) {
                continue;
            }

            $sanitized[$class_name] = [
                'status' => isset($data['status']) ? (bool) $data['status'] : false
            ];
        }

        return $sanitized;
    }

    /**
     * Sanitize the well-known file manager options.
     *
     * @param array $input The input array to sanitize.
     * @return array The sanitized array.
     */
    public function sanitize_well_known_file_manager_options($input) {
        if (!is_array($input)) {
            return [];
        }

        $sanitized = [];
        foreach ($input as $key => $value) {
            $sanitized[$key] = (bool) $value;
        }

        return $sanitized;
    }

    /**
     * Registers settings
     *
     * @return void
     */
    public function register_settings() {
        register_setting(
            'wkfm_files_group',
            'wkfm_files',
            [
                'sanitize_callback' => [$this, 'sanitize_well_known_files'],
                'default' => []
            ]
        );
        register_setting(
            'wkfm_files_group',
            'wkfm_options',
            [
                'sanitize_callback' => [$this, 'sanitize_well_known_file_manager_options'],
                'default' => []
            ]
        );
    }

    /**
     * Render the admin interface
     * 
     * @return void
     */
    private function render_plugin_options( array $options ) {
        foreach ($options as $option) {
            $this->render_option($option);
        }
    }

    /**
     * Render a plugin option
     * 
     * @return void
     */
    private function render_option(array $option) : void {
        echo sprintf(
            '<h3><label for="%s">%s<label></h3>', 
            esc_attr($option['id']), 
        );
        echo sprintf(
            '<input type="checkbox" id="%s" name="%s" value="true" %s />',
            esc_attr($option['id']),
            esc_attr($option['name']),
            checked($option['value'], 'true', false)
        );
        echo '</div>';
    }

    /**
     * Render the admin page
     *
     * @return void
     */
    public function render_admin_page() {
        // Bail if the user doesn't have the necessary permissions.
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'well-known-file-manager'));
        }

        // Check for file synchronization issues
        $sync_data = $this->check_file_synchronization();

        // Render the admin page.
        echo '<div class="wrap well-known-file-manager-admin">';
        echo '<h1>' . esc_html__('Well-Known File Manager', 'well-known-file-manager') . '</h1>';

        // Add the nonce field
        wp_nonce_field('wkfm_nonce', 'wkfm_nonce');

        // Show auto-fix notice if any files were auto-enabled
        if (!empty($sync_data['auto_fixes'])) {
            echo '<div class="notice notice-info is-dismissible">';
            echo '<p><strong>' . esc_html__('Auto-Fixed File Synchronization:', 'well-known-file-manager') . '</strong></p>';
            echo '<p>' . esc_html(sprintf(
                __('Found %d physical files that were not enabled in the database. These have been automatically enabled.', 'well-known-file-manager'),
                count($sync_data['auto_fixes'])
            )) . '</p>';
            echo '</div>';
        }

        // Show created files notice if any files were auto-created
        if (!empty($sync_data['created_files'])) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p><strong>' . esc_html__('Auto-Created Missing Files:', 'well-known-file-manager') . '</strong></p>';
            echo '<p>' . esc_html(sprintf(
                __('Recreated %d missing physical files: %s', 'well-known-file-manager'),
                count($sync_data['created_files']),
                implode(', ', $sync_data['created_files'])
            )) . '</p>';
            echo '</div>';
        }

        // Render the files sections.
        $this->render_files_options();

        echo '</div>';
    }

    /**
     * Check for synchronization issues between database and physical files.
     *
     * @return array Array of auto-fixes applied.
     */
    private function check_file_synchronization() : array {
        $options = get_option('wkfm_files', []);
        $file_classes = Helpers::get_well_known_file_classes();
        $auto_fixes = [];
        $created_files = [];

        foreach ($file_classes as $class_name) {
            $instance = new $class_name();
            $short_class_name = (new \ReflectionClass($instance))->getShortName();
            $filename = $instance->get_filename();
            
            // Check if file is enabled in database
            $is_enabled_in_db = isset($options[$short_class_name]['status']) && $options[$short_class_name]['status'];
            
            // Check if physical file exists
            $physical_file_exists = $instance->physical_file_exists();
            
            // Check for sync issues
            if ($is_enabled_in_db && !$physical_file_exists) {
                // File should exist but doesn't - auto-create it
                $content = isset($options[$short_class_name]['content']) ? $options[$short_class_name]['content'] : $instance->get_content();
                
                $success = $instance->create_or_update_physical_file($content);
                
                if ($success) {
                    $created_files[] = $filename;
                }
            } elseif (!$is_enabled_in_db && $physical_file_exists) {
                // File shouldn't exist but does - auto-fix by enabling
                $auto_fixes[] = $short_class_name;
                
                // Update database to match physical state
                if (!isset($options[$short_class_name])) {
                    $options[$short_class_name] = [];
                }
                $options[$short_class_name]['status'] = true;
                $options[$short_class_name]['content'] = $instance->get_content();
                $options[$short_class_name]['response_code'] = 200;
            }
        }
        
        // Save any auto-fixes
        if (!empty($auto_fixes)) {
            update_option('wkfm_files', $options);
        }
        
        return [
            'auto_fixes' => $auto_fixes,
            'created_files' => $created_files
        ];
    }

    /**
     * Render the files options section.
     *
     * @return void
     */
    private function render_files_options() : void {
        echo '<section id="well-known-files">';
        echo '<p class="section-description">' . esc_html__('Enable and configure the .well-known files you want to use on your site. Each file serves a specific purpose and may be required by different services or applications.', 'well-known-file-manager') . '</p>';
        echo '<div class="well-known-files-grid">';

        // Get all file classes
        $file_classes = Helpers::get_well_known_file_classes();
        
        // Define priority files
        $priority_files = [
            'Security_Txt',
            'Assetlinks_Json',
            'Apple_App_Site_Association'
        ];

        // Sort files into priority and regular
        $priority_classes = [];
        $regular_classes = [];

        foreach ($file_classes as $class_name) {
            $short_name = (new \ReflectionClass($class_name))->getShortName();
            if (in_array($short_name, $priority_files)) {
                $priority_classes[] = $class_name;
            } else {
                $regular_classes[] = $class_name;
            }
        }

        // Sort regular classes alphabetically
        usort($regular_classes, function($a, $b) {
            $a_name = (new \ReflectionClass($a))->getShortName();
            $b_name = (new \ReflectionClass($b))->getShortName();
            return strcasecmp($a_name, $b_name);
        });

        // Render priority files first
        foreach ($priority_classes as $class_name) {
            $short_name = (new \ReflectionClass($class_name))->getShortName();
            $this->render_file_card($class_name, true);
        }

        // Then render regular files
        foreach ($regular_classes as $class_name) {
            $short_name = (new \ReflectionClass($class_name))->getShortName();
            $this->render_file_card($class_name, false);
        }

        echo '</div>';
        echo '</section>';
    }

    /**
     * Render a file card.
     *
     * @param string $class_name The class name of the well-known file.
     * @param bool $is_priority Whether this is a priority file.
     * @return void
     */
    private function render_file_card($class_name, $is_priority = false) {
        $instance = new $class_name();
        $filename = $instance->get_filename();
        $description = $instance->get_description();
        $content = $instance->get_content();
        $status = $instance->get_status();
        $content_type = $instance->get_content_type();

        // Get the short class name for the form field.
        $short_class_name = (new \ReflectionClass($instance))->getShortName();

        // Get validation error if any.
        $options = get_option('wkfm_files', []);

        $card_class = 'well-known-file-card';
        if (!$status) {
            $card_class .= ' disabled';
        }
        if ($is_priority) {
            $card_class .= ' priority';
        }

        echo '<div class="' . esc_attr($card_class) . '" data-file-id="' . esc_attr($short_class_name) . '" data-content-type="' . esc_attr($instance::CONTENT_TYPE) . '">';
        echo '<div class="well-known-file-header">';
        echo '<h3>';
        echo '<a href="' . esc_url(home_url('/.well-known/' . $filename)) . '" class="well-known-file-link" target="_blank">' . esc_html($filename) . '</a>';
        if ($is_priority) {
            echo ' <span class="dashicons dashicons-star-filled priority-icon"></span>';
        }
        echo '</h3>';
        echo '<div class="well-known-file-actions">';
        echo '<label class="switch">';
        echo '<input type="checkbox" class="well-known-file-toggle" ' . checked($status, true, false) . ' data-file-id="' . esc_attr($short_class_name) . '">';
        echo '<span class="slider round"></span>';
        echo '</label>';
        echo '<button type="button" class="button restore-default-content" data-file-id="' . esc_attr($short_class_name) . '" ' . disabled(!$status, true, false) . '>';
        echo esc_html__('Restore Default', 'well-known-file-manager');
        echo '</button>';
        echo '<button type="button" class="button save-file-content" data-file-id="' . esc_attr($short_class_name) . '" ' . disabled(!$status, true, false) . '>';
        echo esc_html__('Save', 'well-known-file-manager');
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '<p class="description">' . esc_html($description) . '</p>';

        echo '<div class="well-known-file-content">';
        echo '<textarea ' . disabled(!$status, true, false) . '>' . esc_textarea($content) . '</textarea>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Saves the well-known files and their settings.
     *
     * @return void
     */
    public function save_well_known_files() {
        
        // Verify nonce.
        if (!isset($_POST['wkfm_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wkfm_nonce'])), 'save_wkfm_files')) {
            wp_die(esc_html__('Security check failed.', 'well-known-file-manager'));
        }

        // Check permissions.
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to perform this action.', 'well-known-file-manager'));
        }

        // Get the files data.
        $files = isset($_POST['wkfm_files']) ? array_map('sanitize_text_field', wp_unslash($_POST['wkfm_files'])) : [];
        if (empty($files)) {
            wp_die(esc_html__('No files data received.', 'well-known-file-manager'));
        }

        // Prepare a container for the files to save.
        $files_to_save = [];

        foreach ($files as $filename => $file_data) {
            $status = isset($file_data['status']) ? (bool) $file_data['status'] : false;
            $content = isset($file_data['content']) ? wp_unslash($file_data['content']) : '';

            // Get the class name and create an instance.
            $class_name = Helpers::convert_filename_to_class_name($filename);
            if (!class_exists($class_name)) {
                continue;
            }

            $file = new $class_name();
            $file->update_content($content);

            $files_to_save[$filename] = [
                'status' => $status,
                'content' => $content,
            ];
        }

        // Save the validated data.
        update_option('wkfm_files', $files_to_save);

        // Redirect back with success message.
        wp_safe_redirect(add_query_arg('settings-updated', 'true', wp_get_referer()));
        exit;
    }

    /**
     * Purges the cache when plugin options are updated.
     *
     * @param mixed $old_value The old option value.
     * @param mixed $value The new option value.
     * @param string $option The option name.
     *
     * @return void
     */
    public function purge_cache_on_update($old_value, $value, $option) {
        // Flush only our cache group to avoid affecting other plugins.
        wp_cache_flush_group(Plugin::CACHE_GROUP);
    }

    /**
     * Handles the AJAX request to toggle a well-known file.
     *
     * @return void
     */
    public function ajax_toggle_well_known_file() {
        try {
            // Verify nonce
            if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wkfm_nonce')) {
                wp_send_json_error(['message' => __('Security check failed.', 'well-known-file-manager')]);
                return;
            }
            // Check permissions
            if (!current_user_can('manage_options')) {
                wp_send_json_error(['message' => __('You do not have permission to perform this action.', 'well-known-file-manager')]);
                return;
            }
            
            // Get and validate file ID
            $file_id = isset($_POST['file_id']) ? sanitize_text_field(wp_unslash($_POST['file_id'])) : '';
            if (empty($file_id)) {
                wp_send_json_error(['message' => __('No file specified.', 'well-known-file-manager')]);
                return;
            }
            
            // Get content
            $content = isset($_POST['content']) ? sanitize_textarea_field(wp_unslash($_POST['content'])) : '';
            
            // Get enabled state
            $enabled = isset($_POST['enabled']) ? filter_var(wp_unslash($_POST['enabled']), FILTER_VALIDATE_BOOLEAN) : false;
            
            // Get the class name
            $class_name = Helpers::convert_filename_to_class_name($file_id);
            
            if (!class_exists($class_name)) {
                wp_send_json_error(['message' => __('Invalid file type.', 'well-known-file-manager')]);
                return;
            }
            
            // Create instance and update content
            $file = new $class_name();
            $file->update_content($content);
            $file->update_status($enabled);
            
            wp_send_json_success([
                'message' => __('File saved successfully.', 'well-known-file-manager')
            ]);
            
        } catch (\Exception $e) {
            wp_send_json_error([
                'message' => __('Error saving file.', 'well-known-file-manager')
            ]);
        }
    }

    /**
     * AJAX handler for saving well-known file content.
     *
     * @return void
     */
    public function ajax_save_well_known_file() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wkfm_nonce')) {
            wp_send_json_error(['message' => __('Security check failed.', 'well-known-file-manager')]);
        }

        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('You do not have permission to perform this action.', 'well-known-file-manager')]);
        }

        // Get file ID
        $file_id = isset($_POST['file']) ? sanitize_text_field(wp_unslash($_POST['file'])) : '';
        if (empty($file_id)) {
            wp_send_json_error(['message' => __('No file ID provided.', 'well-known-file-manager')]);
        }

        // Get the file handler
        $file_handler = Helpers::get_well_known_file($file_id);
        if (!$file_handler) {
            wp_send_json_error(['message' => __('Invalid file ID.', 'well-known-file-manager')]);
        }

        // Get content and status
        $content = isset($_POST['content']) ? wp_unslash($_POST['content']) : '';
        $enabled = isset($_POST['status']) && $_POST['status'] === 'true';
        $response_code = isset($_POST['response_code']) ? intval($_POST['response_code']) : 200;

        // Save to database
        $options = get_option('wkfm_files', []);
        $options[$file_id] = [
            'content' => $content,
            'status' => $enabled,
            'response_code' => $response_code
        ];
        update_option('wkfm_files', $options);

        // Handle physical file creation/deletion
        if ($enabled) {
            // Create or update the physical file
            $success = $file_handler->create_or_update_physical_file($content);
            if (!$success) {
                wp_send_json_error(['message' => __('Failed to create physical file. Please check file permissions.', 'well-known-file-manager')]);
            }
        } else {
            // Delete the physical file
            $file_handler->delete_physical_file();
        }

        // Clear any caches
        if (function_exists('wp_cache_flush')) {
            wp_cache_flush();
        }

        wp_send_json_success([
            'message' => $enabled ? __('File enabled and saved successfully.', 'well-known-file-manager') : __('File disabled and removed successfully.', 'well-known-file-manager')
        ]);
    }

    /**
     * AJAX handler for getting default content.
     *
     * @return void
     */
    public function ajax_get_default_content() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wkfm_nonce')) {
            wp_send_json_error(['message' => __('Invalid nonce.', 'well-known-file-manager')]);
        }

        // Get file ID
        $file_id = isset($_POST['file_id']) ? sanitize_text_field(wp_unslash($_POST['file_id'])) : '';
        if (empty($file_id)) {
            wp_send_json_error('No file ID provided.');
        }

        // Get the file handler
        $file_handler = Helpers::get_well_known_file($file_id);
        if (!$file_handler) {
            wp_send_json_error('Invalid file ID.');
        }

        // Get default content
        $default_content = $file_handler->get_default_content();
        wp_send_json_success(['content' => $default_content]);
    }

    /**
     * Renders the well-known files section.
     *
     * @return void
     */
    private function render_well_known_files() {
        // Get all file classes
        $file_classes = Helpers::get_well_known_file_classes();
        
        // Define priority files
        $priority_files = [
            'Security_Txt',
            'Assetlinks_Json',
            'Apple_App_Site_Association'
        ];

        // Sort files into priority and regular
        $priority_classes = [];
        $regular_classes = [];

        foreach ($file_classes as $class_name) {
            $short_name = (new \ReflectionClass($class_name))->getShortName();
            if (in_array($short_name, $priority_files)) {
                $priority_classes[] = $class_name;
            } else {
                $regular_classes[] = $class_name;
            }
        }

        // Sort regular classes alphabetically
        usort($regular_classes, function($a, $b) {
            $a_name = (new \ReflectionClass($a))->getShortName();
            $b_name = (new \ReflectionClass($b))->getShortName();
            return strcasecmp($a_name, $b_name);
        });
        
        echo '<div class="well-known-files-grid">';
        
        // Render priority files first
        foreach ($priority_classes as $class_name) {
            $this->render_file_card($class_name, true);
            }

        // Then render regular files
        foreach ($regular_classes as $class_name) {
            $this->render_file_card($class_name, false);
        }
        
        echo '</div>';
    }

    /**
     * Adds plugin action links.
     *
     * @param array $links The existing plugin action links.
     * @return array The modified plugin action links.
     */
    public function add_plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=well-known-file-manager') . '">' . __('Settings', 'well-known-file-manager') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}
