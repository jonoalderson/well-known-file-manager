<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Ni extends WellKnownFile {

    const FILENAME = "ni";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "ni:///sha-256;examplehash";
    }

    public function get_description() {
        return __("Supports the Named Information (ni) URI scheme.", 'well-known-manager');
    }
}

?>