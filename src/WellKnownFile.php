<?php

namespace WellKnownManager;

abstract class WellKnownFile {

    public $content;

    public function __construct() {
        // Silence is golden.
    }

    public abstract function get_default_content();

    /**
     * Get the content
     *
     * @return FALSE|string The content, or false if it's not set.
     */
    public function get_content() {
        $option = get_option('well_known_files', false);

        if (!is_array($option)) {
            return false;
        }

        $content = isset($option[$this->get_filename()]) ? $option[$this->get_filename()] : false;

        if (empty($content)) {
            return false;
        }

        return $content;
    }

    public function set_content($content) {
        $this->content = $content;
    }

    public function validate() {
        if (!empty($this->content) && $this->get_content_type() === 'application/json') {
            return json_decode($this->content) !== null;
        } elseif (!empty($this->content) && $this->get_content_type() === 'application/xml') {
            $dom = new \DOMDocument();
            return $dom->load_xml($this->content) !== false;
        }

        return !empty($this->content);
    }

    public function get_filename() {
        if (!defined('static::FILENAME')) {
            return 'UNKNOWN';
        }

        return static::FILENAME;
    }

    public function get_content_type() {
        if (!defined('static::CONTENT_TYPE')) {
            return 'text/plain'; // Default content type
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
?>