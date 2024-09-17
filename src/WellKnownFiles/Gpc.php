<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Gpc extends WellKnownFile {

    const FILENAME = "gpc";
    const CONTENT_TYPE = "text/plain";
    
    public function get_default_content() {
        return "GPC: 1\n";
    }
    
    public function get_description() {
        return __("Indicates the website's Global Privacy Control (GPC) policy.", 'well-known-manager');
    }
}
?>