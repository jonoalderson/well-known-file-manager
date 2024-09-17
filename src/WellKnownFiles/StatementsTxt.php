<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class StatementsTxt extends WellKnownFile {

    const FILENAME = "statements.txt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "Example of a collective contract signing standard";
    }

    public function get_description() {
        return __("Supports a collective contract signing standard.", 'well-known-manager');
    }
 
}
?>