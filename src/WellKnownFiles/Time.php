<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Time extends WellKnownFile {

    const FILENAME = "time";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "Time over HTTPS specification";
    }

    public function get_description() {
        return __("Provides information about the Time over HTTPS specification.", 'well-known-manager');
    }
  
}
?>