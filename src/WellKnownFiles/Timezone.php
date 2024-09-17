<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Timezone extends WellKnownFile {

    const FILENAME = "timezone";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "Time Zone Data Distribution Service";
    }

    public function get_description() {
        return __("Provides information about the Time Zone Data Distribution Service.", 'well-known-manager');
    }   
   
}
?>