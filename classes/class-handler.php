<?php

namespace WellKnownFileManager;

use WellKnownFileManager\Helpers;

/**
 * Class Admin
 *
 * Handles file serving
 */
class Handler {

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
        $this->register_hooks();
    }

    /**
     * Register hooks
     * 
     * @return void
     */
    private function register_hooks() : void {
        add_action('init', [$this, 'serve_files'], 1);
    }

    /**
     * Try to serve a response from our cache.
     * 
     * @param string $path The request path.
     * 
     * @return bool TRUE if the response was served from the cache, otherwise FALSE 
     */
    private function serve_from_cache( string $path ) : bool {
            
        // Bail if the path is empty.
        if (empty($path)) {
            return false;
        }

        // Define the cache key for the request.
        $cache_key = 'wkfm_' . md5(basename($path));

        // Check if we have a cached response.
        $cached_response = wp_cache_get($cache_key, Plugin::CACHE_GROUP);

        // IF we got a cached response, just serve it.
        if ($cached_response !== false) {
            header('Content-Type: ' . sanitize_text_field($cached_response['content_type']));
            header('Cache-Control: max-age=3600, public');
            header('x-robots-tag: noindex');

            // Echo the cached content.
            echo wp_kses_post($cached_response['content']);

            return true;
        }

        return false;
    }

    /**
     * Check if we should serve files.
     * 
     * @return bool TRUE if we should serve files, otherwise FALSE.
     */
    private function should_serve_files() : bool {

        $path = Helpers::get_cleaned_request_path();

        // Debug: Log all requests to see what's being processed.
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Well-Known File Manager: Checking path: ' . $path);
        }

        // Check if the request is for a well-known file.
        if (strpos($path, '.well-known') !== false) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('Well-Known File Manager: Detected .well-known request for: ' . $path);
            }
            return true;
        }

        return false;
    }

    /**
     * Serve a file
     * 
     * @param Well_Known_File iAn instance of the file 
     * 
     * @return void
     */
    private function serve_file(Well_Known_File $instance) : void {

        // Set the appropriate Content-Type header.
        header('Content-Type: ' . sanitize_text_field($instance->get_content_type()));
        header('Cache-Control: max-age=3600, public');
        header('x-robots-tag: noindex');

        // Echo the content.
        echo wp_kses_post($instance->get_content());
    }

    /**
     * Serves the well-known files based on the request URI.
     *
     * @return void
     */
    public function serve_files() {

        // Bail if we shouldn't be serving files.
        if (!$this->should_serve_files()) {
            return;
        }

        // Get the requested filename.
        $path = Helpers::get_cleaned_request_path();
        
        // Bail if the path is empty.
        if (empty($path)) {
            return;
        }
        
        // Get an instance of the file.
        $instance = Helpers::get_well_known_file($path);

        // Serve a 404 if no matching file was found.
        if (!$instance) {
            Helpers::serve_404();
        }

        // Serve a 404 if the file is not enabled.
        if ($instance->get_status() === false) {
            Helpers::serve_404();
        }

        // Try to serve from cache first.
        if ($this->serve_from_cache($path)) {
            exit();
        }

        // Serve the file.
        $this->serve_file($instance);

        // Cache the response.
        wp_cache_set(
            'wkfm_' . md5(basename($path)),
            [
                'content_type' => $instance->get_content_type(),
                'content' => $instance->get_content(),
                'status' => $instance->get_status()
            ],
            Plugin::CACHE_GROUP,
            3600 // Cache for 1 hour.
        );

        exit();
    }



}