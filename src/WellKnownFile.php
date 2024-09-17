<?php

namespace WellKnownManager;

/**
 * Abstract class WellKnownFile.
 *
 * @package WellKnownManager
 */
abstract class WellKnownFile {

    /**
     * The filename for the well-known file.
     *
     * @var string
     */
    const FILENAME = 'UNKNOWN';

	/**
	 * The content type for the well-known file.
	 *
	 * @var string
	 */
	const CONTENT_TYPE = 'text/plain';

    /**
     * The content of the well-known file.
     *
     * @var string
     */
    public $content;

    /**
     * Constructor.
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
     * Get the content.
     *
     * @return false|string The content, or false if it's not set.
     */
    public function get_content() {
        $option = get_option( 'well_known_files', false );

        if ( ! is_array( $option ) ) {
            return false;
        }

        $content = isset( $option[ $this->get_filename() ] ) ? $option[ $this->get_filename() ] : false;

        if ( empty( $content ) ) {
            return false;
        }

        return $content;
    }

    /**
     * Set the content.
     *
     * @param string $content The content to set.
     */
    public function set_content( $content ) {
        $this->content = $content;
    }

    /**
     * Validate the content.
     *
     * @return bool True if the content is valid, false otherwise.
     */
    public function validate() {
        if ( ! empty( $this->content ) && $this->get_content_type() === 'application/json' ) {
            return json_decode( $this->content ) !== null;
        } elseif ( ! empty( $this->content ) && $this->get_content_type() === 'application/xml' ) {
            $dom = new \DOMDocument();
            return $dom->loadXML( $this->content ) !== false;
        }

        return ! empty( $this->content );
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
            // Default content type.
        }

        return static::CONTENT_TYPE;
    }

    /**
     * Get the description of the well-known file.
     *
     * @return string The description of the well-known file.
     */
    abstract public function get_description();
}
