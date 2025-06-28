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
    private function get_option_name() : string {
        // Get the class name without the namespace.
        $class_name = (new \ReflectionClass($this))->getShortName();
        
        // Convert to lowercase and sanitize.
        return 'wkfm_files_' . strtolower(sanitize_key($class_name));
    }

    /**
     * Get the content of the file.
     *
     * @return string The content of the file.
     */
    public function get_content() {
        // Get content from dedicated option.
        $content = get_option($this->get_option_name());
        if ($content !== false) {
            return $content;
        }
        
        return $this->get_default_content();
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
        return \get_home_path() . '.well-known/' . $this->get_filename();
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
