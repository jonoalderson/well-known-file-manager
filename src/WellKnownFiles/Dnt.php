<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Dnt extends WellKnownFile {

    const FILENAME = "dnt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "DNT: 1\n";
    }

    public function get_description() {
        return __("Indicates the website's Do Not Track (DNT) policy.", 'well-known-manager');
    }

}
?>