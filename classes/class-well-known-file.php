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
        return 'well_known_files_' . strtolower(sanitize_key($class_name));
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
        $options = get_option('well_known_files');

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
        $options = get_option('well_known_files', []);

        // Get the class name without the namespace.
        $class_name = (new \ReflectionClass($this))->getShortName();

        // Initialize the file's options if they don't exist.
        if (!isset($options[$class_name])) {
            $options[$class_name] = [];
        }

        // Update the status.
        $options[$class_name]['status'] = $status;

        // Save the options.
        return update_option('well_known_files', $options);
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
}
