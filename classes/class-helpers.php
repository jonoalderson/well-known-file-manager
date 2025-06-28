<?php

namespace WellKnownFileManager;

/**
 * Various helpers
 */
class Helpers {

    /**
     * Gets the Well-Known file classes.
     *
     * @return array The array of Well-Known file class names.
     */
    public static function get_well_known_file_classes() {

        // Get all of our files.
        $files = glob(Plugin::PLUGIN_FOLDER . '/classes/well-known-files/*.php');

        // Define the namespace path.
        $path = '\WellKnownFileManager\\WellKnownFiles\\'; 

        // Prepare a container for our results
        $well_known_classes = [];

        foreach ($files as $file) {

            // Get the class name from the filename.
            $class_name = basename($file, '.php');

            // Remove the 'class-' prefix.
            $class_name = str_replace('class-', '', $class_name);

            // Add the path prefix.
            $class_name = $path . $class_name;

            // Replace hyphens with underscores.
            $class_name = str_replace('-', '_', $class_name);

            // If we find the class, add it to our list.
            if (class_exists($class_name)) {
                $well_known_classes[] = $class_name;
            }
        }

        return $well_known_classes;
    }

    /**
     * Gets the Well-Known files.
     *
     * @return array An associative array of files, their filenames, and statuses.
     */
    public static function get_well_known_files() {
        
        // Prepare a container for our results.
        $well_known_files = [];

        // Get the saved options.
        $saved_files = get_option('wkfm_files', []);

        // Iterate over all of our classes.
        foreach (self::get_well_known_file_classes() as $class_name) {

            // Get an instance of the class.
            $instance = new $class_name();

            // Remove the namespacing.
            $class_name_array = explode('\\', get_class($instance));
            $class_name_trimmed = end($class_name_array);

            // Add it to our array.
            $well_known_files[$class_name_trimmed] = [
                'filename' => $instance::FILENAME,
                'status' => isset($saved_files[$class_name_trimmed]['status']) ? $saved_files[$class_name_trimmed]['status'] : false
            ];
        }

        return $well_known_files;
    }

    /**
     * Get a specific file, and its properties
     * 
     * @param string $file The filename
     * 
     * @return Well_Known_File|bool The file instance, or FALSE if not found
     */
    public static function get_well_known_file( string $file ) {

        // Bail if the file is empty.
        if (empty($file)) {
            return false;
        }

        // Clean the filename.
        $file = basename($file);
        
        // Bail if the cleaned filename is empty or just a dot.
        if (empty($file) || $file === '.') {
            return false;
        }
      
        // Get the files.
        $files = self::get_well_known_files();

        // Convert the filename to a class name.
        $class_name = self::convert_filename_to_class_name($file);

        // Bail if the class doesn't exist.
        if (!class_exists($class_name)) {
            return false;
        }

        // Return the file.
        return new $class_name();
    }

    /**
     * Convert a filename to a class name
     * 
     * @param string $file The filename
     * 
     * @return string The class name
     */
    public static function convert_filename_to_class_name( string $file ) : string {

        // Bail if the file is empty.
        if (empty($file)) {
            return '';
        }

        // Clean the filename.
        $file = basename($file);
        
        // Bail if the cleaned filename is empty or just a dot.
        if (empty($file) || $file === '.') {
            return '';
        }

        // Convert the filename to a class name.
        $class_name = str_replace( [ '-', '.' ], '_', $file);
        $class_name = ucwords($class_name, '_');

        // Prefix the namespace.
        $full_class_name = '\\WellKnownFileManager\\WellKnownFiles\\' . $class_name;

        // Return the class name.
        return $full_class_name;
    }

    /**
     * Check if a physical file exists in the .well-known directory.
     *
     * @param string $filename The filename to check.
     * @return bool True if the file exists, false otherwise.
     */
    public static function physical_file_exists( string $filename ) : bool {
        $well_known_dir = self::get_web_root_path() . '.well-known/';
        $file_path      = $well_known_dir . $filename;
        return file_exists( $file_path );
    }

    /**
     * Gets the web root path.
     *
     * This function returns the root path of the website, which is not always
     * the same as the WordPress installation directory (ABSPATH). It uses the
     * WordPress get_home_path() function to reliably determine the correct path,
     * which handles various server configurations and subdirectory installations.
     *
     * @return string The determined web root path, with a trailing slash.
     */
    public static function get_web_root_path() : string {
        // get_home_path() is the most reliable way to get the root path of the site.
        return get_home_path();
    }

    /**
     * Checks if the WordPress site is running in a subdirectory.
     * This is determined by checking if the home URL has a path component.
     *
     * @return bool True if the site is in a subdirectory, false otherwise.
     */
    public static function is_subdirectory_install() : bool {
        $home_url = get_home_url();
        $path     = wp_parse_url( $home_url, PHP_URL_PATH );

        // If the path is null, empty, or just a slash, it's not a subdirectory install.
        return ! empty( $path ) && '/' !== $path;
    }

    /**
     * Get the cleaned URL path
     * 
     * @return string The cleaned URL path
     */
    public static function get_cleaned_request_path() : string {

        // Get the request URI.
        $url = isset($_SERVER['REQUEST_URI']) ? sanitize_url(wp_unslash($_SERVER['REQUEST_URI'])) : '';

        // Get the path.
        $path = wp_parse_url($url, PHP_URL_PATH);

        // Ensure we always return a string.
        return $path ?: '';
    }

    /**
     * Serve a 404 error.
     * 
     * @return void
     */
    public static function serve_404() : void {
        header('HTTP/1.1 404 Not Found');
        header('Content-Type: text/plain');
        header('Cache-Control: max-age=3600, public');
        header('x-robots-tag: noindex');
        exit();
    }

}