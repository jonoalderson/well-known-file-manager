<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Timezone extends Well_Known_File {

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