<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Dnt extends Well_Known_File {

    const FILENAME = "dnt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "DNT: 1\n";
    }

    public function get_description() {
        return __("Indicates the website's Do Not Track (DNT) policy.", 'well-known-file-manager');
    }

}
?>