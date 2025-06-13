<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Genid extends Well_Known_File {

    const FILENAME = "genid";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return __("This is a general identifier resolution file.", 'well-known-manager');
    }

    public function get_description() {
        return __("Supports the resolution of generated identifiers.", 'well-known-manager');
    }

}
?>