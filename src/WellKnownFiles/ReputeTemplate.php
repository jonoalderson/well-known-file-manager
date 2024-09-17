<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class ReputeTemplate extends WellKnownFile {

    const FILENAME = "repute-template";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "Example Reputation Query Protocol";
    }
    
    public function get_description() {
        return __("Supports the Reputation Query Protocol.", 'well-known-manager');
    }
    
}
?>