<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Repute_Template extends Well_Known_File {

    const FILENAME = "repute-template";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "Example Reputation Query Protocol";
    }
    
    public function get_description() {
        return __("Supports the Reputation Query Protocol.", 'well-known-file-manager');
    }
    
}
?>