<?php

namespace WellKnownManager;

/**
 * Class Admin
 *
 * Handles the admin functionalities for the Well-Known Manager plugin.
 *
 * @package WellKnownManager
 */
class Admin {
    /**
     * @var \WP_Object_Cache $cache The cache object.
     */
    private $cache;

    /**
     * Admin constructor.
     *
     * Initializes the cache object.
     */
    public function __construct() {
        $this->cache = new \WP_Object_Cache();
    }

    /**
     * Registers WordPress hooks for the admin functionalities.
     *
     * @return void
     */
    public function register_hooks() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('template_redirect', [$this, 'serve_well_known_files']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_post_save_well_known_files', [$this, 'save_well_known_files']);
    }

    /**
     * Enqueues admin-specific styles and scripts.
     *
     * @param string $hook The current admin page.
     *
     * @return void
     */
    public function enqueue_admin_assets($hook) {
        if ('settings_page_well-known-manager' !== $hook) {
            return;
        }
        wp_enqueue_style('well-known-manager-admin-styles', plugin_dir_url(__FILE__) . '../css/admin-styles.css');
        wp_enqueue_script('well-known-manager-admin-script', plugin_dir_url(__FILE__) . '../js/admin-script.js', ['jquery'], '1.0', true);
    }

    /**
     * Adds the Well-Known Manager options page to the admin menu.
     *
     * @return void
     */
    public function add_admin_menu() {
        add_options_page(
            __('Well-Known Manager', 'well-known-manager'),
            __('Well-Known Manager', 'well-known-manager'),
            'manage_options',
            'well-known-manager',
            [$this, 'create_admin_page']
        );
    }

    /**
     * Registers settings for the Well-Known Manager plugin.
     *
     * @return void
     */
    public function register_settings() {
        register_setting('well_known_files_group', 'well_known_files');
        register_setting('well_known_files_group', 'well_known_manager_options');
        register_setting('well_known_files_group', 'well_known_files_enabled');
    }

    /**
     * Creates the admin page for the Well-Known Manager plugin.
     *
     * @return void
     */
    public function create_admin_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'well-known-manager'));
        }

        $options = get_option('well_known_manager_options', []);
        $cleanup_on_deletion = isset($options['cleanup_on_deletion']) ? $options['cleanup_on_deletion'] : '0';

        $well_known_classes = WellKnownManager::get_well_known_file_classes();
        $enabled_states = get_option('well_known_files_enabled', []);

        // Define common files.
        $common_files = ['security.txt', 'acme-challenge', 'assetlinks.json'];

        echo '<div class="wrap well-known-manager-admin">';
        echo '<h1>' . esc_html__('Well-Known Manager', 'well-known-manager') . '</h1>';

        echo '<div class="well-known-intro">';
        echo '<h2>' . esc_html__('Welcome to Well-Known Manager', 'well-known-manager') . '</h2>';
        echo '<p>' . esc_html__('This plugin allows you to easily manage and serve .well-known files on your WordPress site. These files are used for various purposes such as security policies, domain verification, and more.', 'well-known-manager') . '</p>';
        echo '<p>' . esc_html__('With Well-Known Manager, you can:', 'well-known-manager') . '</p>';
        echo '<ul>';
        echo '<li>' . esc_html__('Enable or disable specific .well-known files', 'well-known-manager') . '</li>';
        echo '<li>' . esc_html__('Edit the content of each file directly from the WordPress admin', 'well-known-manager') . '</li>';
        echo '<li>' . esc_html__('Automatically serve the files at the correct /.well-known/ URLs', 'well-known-manager') . '</li>';
        echo '</ul>';
        echo '<p>' . esc_html__('Simply toggle the files you want to use and edit their content below. Don\'t forget to save your changes!', 'well-known-manager') . '</p>';
        echo '</div>';

        echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
        wp_nonce_field('save_well_known_files', 'well_known_files_nonce');
        echo '<input type="hidden" name="action" value="save_well_known_files">';

        echo '<section>';
        echo '<h2>' . esc_html__('Common Files', 'well-known-manager') . '</h2>';
        echo '<p class="section-description">' . esc_html__('These are frequently used .well-known files that are relevant for most websites. They include security policies, domain verification, and other standard configurations.', 'well-known-manager') . '</p>';
        echo '<div id="common-well-known-files">';
        foreach ($well_known_classes as $class_name) {
            $instance = new $class_name();
            $filename = $instance->get_filename();
            if (in_array($filename, $common_files)) {
                $this->render_well_known_file_section($class_name, $enabled_states);
            }
        }
        echo '</div>';
        echo '</section>';

        echo '<section>';
        echo '<h2>' . esc_html__('Other Files', 'well-known-manager') . '</h2>';
        echo '<p class="section-description">' . esc_html__('These are additional .well-known files that may be useful for specific purposes or advanced configurations. Enable and configure these as needed for your particular use case.', 'well-known-manager') . '</p>';
        echo '<div id="other-well-known-files">';
        foreach ($well_known_classes as $class_name) {
            $instance = new $class_name();
            $filename = $instance->get_filename();
            if (!in_array($filename, $common_files)) {
                $this->render_well_known_file_section($class_name, $enabled_states);
            }
        }
        echo '</div>';
        echo '</section>';

        echo '<br>';
        echo '<section id="cleanup-options">';
        echo '<h2>' . esc_html__('Plugin Cleanup Options', 'well-known-manager') . '</h2>';
        echo '<p class="section-description">' . esc_html__('Control how the plugin handles its data when deactivated or uninstalled.', 'well-known-manager') . '</p>';
        echo '<div class="cleanup-option">';
        echo '<label for="cleanup_on_deletion">';
        echo '<input type="checkbox" id="cleanup_on_deletion" name="well_known_manager_options[cleanup_on_deletion]" value="1" ' . checked($cleanup_on_deletion, '1', false) . ' />';
        echo esc_html__('Enable option cleanup on deletion', 'well-known-manager');
        echo '</label>';
        echo '<p class="option-description">';
        echo esc_html__('When enabled, this option will remove all plugin data from the database when the plugin is deleted.
            This includes all saved .well-known file contents and settings. Use with caution as this action is irreversible.', 'well-known-manager');
        echo '</p>';
        echo '</div>';
        echo '</section>';

        echo '<div class="submit-section">';
        echo '<input type="submit" name="save_well_known_files" class="button button-primary" value="' . esc_attr__('Save All Settings', 'well-known-manager') . '">';
        echo '</div>';
        echo '</form>';
        echo '</div>';

        // Check for validation errors.
        $validation_errors = get_transient('well_known_validation_errors');
        if ($validation_errors) {
            echo '<div class="error"><p>' . esc_html__('Some files had validation errors:', 'well-known-manager') . '</p><ul>';
            foreach ($validation_errors as $filename => $error) {
                echo "<li>" . esc_html($error) . "</li>";
            }
            echo '</ul></div>';
            delete_transient('well_known_validation_errors');
        }

        // Check for validation warnings.
        $validation_warnings = get_transient('well_known_validation_warnings');
        if ($validation_warnings) {
            echo '<div class="notice notice-warning"><p>' . esc_html__('Some files may have invalid content:', 'well-known-manager') . '</p><ul>';
            foreach ($validation_warnings as $filename => $warning) {
                echo "<li>" . esc_html($warning) . "</li>";
            }
            echo '</ul></div>';
            delete_transient('well_known_validation_warnings');
        }
    }

    /**
     * Renders the section for a specific well-known file.
     *
     * @param string $class_name The class name of the well-known file.
     * @param array $enabled_states The enabled states of the well-known files.
     *
     * @return void
     */
    private function render_well_known_file_section($class_name, $enabled_states) {
        $instance = new $class_name();
        $filename = $instance->get_filename();
        $default_content = $instance->get_default_content();
        $content = $instance->get_content();
        $is_enabled = isset($enabled_states[$filename]) ? $enabled_states[$filename] : false;
        $description = $instance->get_description();

        // Check for errors or warnings.
        $validation_warnings = get_transient('well_known_validation_warnings');
        $has_warning = isset($validation_warnings[$filename]);

        $error_class = ($has_warning ? 'has-warning' : '');
        ?>
        <div class="well-known-file <?php echo esc_attr($error_class); ?>">
            <h3>
                <label for="toggle-<?php echo esc_attr($filename); ?>">
                    <input type="checkbox" class="toggle-file" id="toggle-<?php echo esc_attr($filename); ?>" name="well_known_files_enabled[<?php echo esc_attr($filename); ?>]" value="1" <?php checked($is_enabled, true); ?>>
                    <span><?php echo esc_html($filename); ?></span>
                </label>
                <a href="<?php echo esc_url(home_url('/.well-known/' . $filename)); ?>" target="_blank" class="view-file" title="View file">
                    <span class="dashicons dashicons-visibility"></span>
                </a>
            </h3>
            <p class="file-description"><?php echo esc_html($description); ?></p>
            <textarea name="well_known_files[<?php echo esc_attr($filename); ?>]" rows="10" cols="50" style="display: <?php echo $is_enabled ? 'inherit' : 'none'; ?>;" placeholder="<?php echo esc_attr($default_content); ?>"><?php echo esc_textarea($content); ?></textarea>
        </div>
        <?php
    }

    /**
     * Serves the well-known files based on the request URI.
     *
     * @return void
     */
    public function serve_well_known_files() {
        $request_uri = $_SERVER['REQUEST_URI'];

        // Check if the request is for a well-known file.
        if (strpos($request_uri, '/.well-known/') === false) {
            return;
        }

        // Check if we have a cached response.
        $cached_response = $this->cache->get('well_known_' . md5($request_uri), 'well_known_manager');
        if ($cached_response !== false) {
            header('Content-Type: ' . $cached_response['content_type']);
            echo $cached_response['content'];
            exit;
        }

        // Get our well-known files.
        $well_known_files = WellKnownManager::get_well_known_files();
        $enabled_states = get_option('well_known_files_enabled', []);

        foreach ($well_known_files as $class_name => $filename) {
            // Check if the requested URI matches the current well-known file.
            if (preg_match('/^\/\.well-known\/' . preg_quote($filename, '/') . '$/', $request_uri)) {
                // Check if the file is enabled.
                if (!isset($enabled_states[$filename]) || !$enabled_states[$filename]) {
                    return;
                }

                // Special handling for 'Void' as it doesn't match the class name.
                $class_name = ($filename === 'void') ? 'VoidFile' : $class_name;

                // Skip if the class doesn't exist.
                if (!class_exists($class_name)) {
                    continue;
                }

                $instance = new $class_name();
                $content = $instance->get_content();

                // Return if content is empty.
                if (empty($content)) {
                    return;
                }

                // Set the appropriate Content-Type header.
                $content_type = $instance::CONTENT_TYPE;
                header('Content-Type: ' . $content_type);

                // Cache the response.
                $this->cache->set('well_known_' . md5($request_uri), [
                    'content_type' => $content_type,
                    'content' => $content
                ], 'well_known_manager', 3600); // Cache for 1 hour.

                // Echo the content.
                echo wp_kses_post($content); // Or implement a more specific sanitization based on file type.

                // Exit after serving the file.
                exit;
            }
        }
    }

    /**
     * Saves the well-known files and their settings.
     *
     * @return void
     */
    public function save_well_known_files() {
        if (!isset($_POST['well_known_files_nonce']) || !wp_verify_nonce($_POST['well_known_files_nonce'], 'save_well_known_files')) {
            wp_die('Invalid nonce');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized user');
        }

        $updated_files = [];
        $enabled_states = [];
        $validation_errors = [];

        $well_known_classes = WellKnownManager::get_well_known_file_classes();

        foreach ($well_known_classes as $class_name) {
            $instance = new $class_name();
            $filename = $instance->get_filename();

            // Save enabled state.
            $enabled_states[$filename] = isset($_POST['well_known_files_enabled'][$filename]) ? true : false;

            // Get the content.
            $content = wp_unslash($_POST['well_known_files'][$filename]);

            // Sanitize the content.
            $content = wp_kses_post($content);

            // Always save the content, even if it's empty.
            $instance->set_content($content);
            $updated_files[$filename] = $content;

            // Perform validation only if the file is enabled and not empty.
            if ($enabled_states[$filename] && !empty($content)) {
                if (!$instance->validate()) {
                    $validation_errors[$filename] = "Warning: Content for $filename may be invalid. Please check the format.";
                }
            }

        }

        // Update options.
        update_option('well_known_files', $updated_files);
        update_option('well_known_files_enabled', $enabled_states);

        // Save general options.
        $options = [
            'cleanup_on_deletion' => isset($_POST['well_known_manager_options']['cleanup_on_deletion']) ? '1' : '0'
        ];
        update_option('well_known_manager_options', $options);

        // Store validation warnings in a transient.
        if (!empty($validation_errors)) {
            set_transient('well_known_validation_warnings', $validation_errors, 60);
        }

        // Purge all cached well-known files.
        $this->cache->flush_group('well_known_manager');

        // Redirect back to the settings page.
        $redirect_url = add_query_arg([
            'page' => 'well-known-manager',
            'updated' => 'true',
            'warning' => !empty($validation_errors) ? 'true' : 'false'
        ], admin_url('options-general.php'));

        wp_safe_redirect($redirect_url);
        exit;
    }
}
