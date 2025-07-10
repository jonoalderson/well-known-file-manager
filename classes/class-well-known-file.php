<?php

namespace WellKnownFileManager;

/**
 * Abstract class Well_Known_File
 * 
 * Provides a framework for defining how individual files should behave
 * 
 * TODO: When the content type is JSON or XML, minify it (and then prettify it when displaying it).
 *
 */
abstract class Well_Known_File {

    /**
     * The filename for the file.
     *
     * @var string
     */
    const FILENAME = 'UNKNOWN';

	    /**
     * The content type for the file.
     *
     * @var string
     */
    const CONTENT_TYPE = 'text/plain';

    /**
     * The type of file (content or redirect).
     *
     * @var string
     */
    const FILE_TYPE = 'content';

    /**
     * The content of the file.
     *
     * @var string
     */
    public $content;

    /**
     * Constructor
     */
    public function __construct() {
        // Silence is golden.
    }

    /**
     * Get the default content.
     *
     * @return string The default content.
     */
    public abstract function get_default_content();

    /**
     * Get the sanitized option name for this file.
     *
     * @return string The sanitized option name.
     */
    public function get_option_name() : string {
        // Get the class name without the namespace.
        $class_name = (new \ReflectionClass($this))->getShortName();
        
        // Convert to lowercase and sanitize.
        return 'wkfm_files_' . strtolower(sanitize_key($class_name));
    }

    /**
     * Get the content of the file.
     *
     * Priority order:
     * 1. Physical file content (if file exists and is readable)
     * 2. Database content (if saved in WordPress options)
     * 3. Default content (fallback)
     *
     * @return string The content of the file.
     */
    public function get_content() {
        // First, check if physical file exists and is readable.
        $file_path = $this->get_physical_file_path();
        if ($this->physical_file_exists() && is_readable($file_path)) {
            $physical_content = file_get_contents($file_path);
            if ($physical_content !== false) {
                // Sync physical file content back to database for consistency.
                $this->sync_physical_content_to_database($physical_content);
                return $physical_content;
            }
        }
        
        // If no physical file or unreadable, get content from dedicated option.
        $content = get_option($this->get_option_name());
        if ($content !== false) {
            return $content;
        }
        
        // Fallback to default content.
        return $this->get_default_content();
    }

    /**
     * Syncs physical file content back to the database for consistency.
     *
     * @param string $content The content from the physical file.
     * @return void
     */
    private function sync_physical_content_to_database($content) : void {
        // Only sync if the content is different from what's in the database.
        $db_content = get_option($this->get_option_name());
        if ($db_content !== $content) {
            update_option($this->get_option_name(), $content);
        }
    }

    /**
     * Gets content directly from the physical file without syncing to database.
     *
     * @return string|false The content from the physical file, or false if file doesn't exist or is unreadable.
     */
    public function get_physical_file_content() {
        $file_path = $this->get_physical_file_path();
        
        if (!$this->physical_file_exists() || !is_readable($file_path)) {
            return false;
        }
        
        $content = file_get_contents($file_path);
        return $content !== false ? $content : false;
    }

    /**
     * Gets formatted content for display purposes.
     *
     * @return string The formatted content.
     */
    public function get_formatted_content() {
        $content = $this->get_content();
        return $this->format_content_for_display($content);
    }

    /**
     * Formats content for display based on content type.
     *
     * @param string $content The content to format.
     * @return string The formatted content.
     */
    private function format_content_for_display($content) {
        // If content type is JSON, format it with JSON_UNESCAPED_SLASHES.
        if (strpos($this->get_content_type(), 'application/json') !== false || strpos($this->get_content_type(), 'json') !== false) {
            // Try to decode and re-encode with proper formatting.
            $decoded = json_decode($content, true);
            if ($decoded !== null) {
                return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }
        }
        
        // Return content as-is for non-JSON content types.
        return $content;
    }

    /**
     * Set the content.
     *
     * @param string $content The content to set.
     * 
     * @return void
     */
    public function set_content( $content ) : void {
        $this->content = $content;
    }

    /**
     * Update the content of the file.
     *
     * @param string $content The new content.
     * @return bool Whether the update was successful.
     */
    public function update_content( $content ) : bool {
        // Set the content on the instance.
        $this->set_content($content);

        // Store the content in a dedicated option.
        return update_option($this->get_option_name(), $content);
    }

    /**
     * Get the filename.
     *
     * @return string The filename.
     */
    public function get_filename() {
        if ( ! defined( 'static::FILENAME' ) ) {
            return 'UNKNOWN';
        }

        return static::FILENAME;
    }

    /**
     * Get the content type.
     *
     * @return string The content type.
     */
    public function get_content_type() {
        if ( ! defined( 'static::CONTENT_TYPE' ) ) {
            return 'text/plain';
        }

        return static::CONTENT_TYPE;
    }

    /**
     * Get the file type.
     *
     * @return string The file type (content or redirect).
     */
    public function get_file_type() {
        if ( ! defined( 'static::FILE_TYPE' ) ) {
            return 'content';
        }

        return static::FILE_TYPE;
    }

    /**
     * Get the status of a file
     */
    public function get_status() : bool {
        // Get the options.
        $options = get_option('wkfm_files');

        // If we didn't get any options, return false.
        if (!$options) {
            return false;
        }

        // Get the class name without the namespace.
        $class_name = (new \ReflectionClass($this))->getShortName();

        // If we didn't find an entry for this specific file, return false.
        if (!isset($options[$class_name])) {
            return false;
        }

        // If the file doesn't have a status property, return false.
        if (!isset($options[$class_name]['status'])) {
            return false;
        }

        // Return the status.
        return $options[$class_name]['status'];
    }

    /**
     * Update the status of the file.
     *
     * @param bool $status Whether the file is enabled.
     * @return bool Whether the update was successful.
     */
    public function update_status( bool $status ) : bool {
        // Get the current options.
        $options = get_option('wkfm_files', []);

        // Get the class name without the namespace.
        $class_name = (new \ReflectionClass($this))->getShortName();

        // Initialize the file's options if they don't exist.
        if (!isset($options[$class_name])) {
            $options[$class_name] = [];
        }

        // Update the status.
        $options[$class_name]['status'] = $status;

        // Save the options.
        return update_option('wkfm_files', $options);
    }

    /**
     * Set the status.
     *
     * @param bool $status The status to set.
     * 
     * @return void
     */
    public function set_status( bool $status ) : void {
        $this->status = $status;
    }

    /**
     * Get the description of the well-known file.
     *
     * @return string The description of the well-known file.
     */
    abstract public function get_description();

    /**
     * Gets the physical file path for this well-known file.
     *
     * @return string The physical file path.
     */
    public function get_physical_file_path() : string {
        return \WellKnownFileManager\Helpers::get_web_root_path() . '.well-known/' . $this->get_filename();
    }

    /**
     * Creates or updates the physical file.
     *
     * @param string $content The content to write to the file.
     * @return bool True on success, false on failure.
     */
    public function create_or_update_physical_file(string $content) : bool {
        $file_path = $this->get_physical_file_path();
        $directory = \dirname($file_path);

        // Create .well-known directory if it doesn't exist
        if (!\is_dir($directory)) {
            // Try multiple directory creation methods
            $mkdir_success = $this->create_directory_with_fallbacks($directory);
            
            if (!$mkdir_success) {
                return false;
            }
            
            // Double-check the directory was actually created
            if (!\is_dir($directory)) {
                return false;
            }
        }

        // Check if directory is writable
        if (!\is_writable($directory)) {
            return false;
        }

        // Write the file content
        $result = \file_put_contents($file_path, $content);
        
        if ($result === false) {
            return false;
        }

        // Set proper permissions (readable by web server)
        \chmod($file_path, 0644);
        
        return true;
    }

    /**
     * Creates a directory using multiple fallback methods.
     *
     * @param string $directory The directory path to create.
     * @return bool True on success, false on failure.
     */
    private function create_directory_with_fallbacks(string $directory) : bool {
        // Method 1: WordPress wp_mkdir_p
        $result = \wp_mkdir_p($directory);
        if ($result && \is_dir($directory)) {
            return true;
        }

        // Method 2: PHP mkdir with recursive flag
        $result = \mkdir($directory, 0755, true);
        if ($result && \is_dir($directory)) {
            return true;
        }

        // Method 3: Try creating parent directories first
        $parent_dir = \dirname($directory);
        if (!\is_dir($parent_dir)) {
            \wp_mkdir_p($parent_dir);
        }

        // Method 4: Try mkdir again after parent creation
        if (\is_dir($parent_dir)) {
            $result = \mkdir($directory, 0755);
            if ($result && \is_dir($directory)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Deletes the physical file.
     *
     * @return bool True on success, false on failure.
     */
    public function delete_physical_file() : bool {
        $file_path = $this->get_physical_file_path();
        
        if (\file_exists($file_path)) {
            return \unlink($file_path);
        }
        
        return true; // File doesn't exist, consider it "deleted"
    }

    /**
     * Checks if the physical file exists.
     *
     * @return bool True if the file exists, false otherwise.
     */
    public function physical_file_exists() : bool {
        return \file_exists($this->get_physical_file_path());
    }
}
