<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Hoba extends Well_Known_File {

    const FILENAME = "hoba";
    const CONTENT_TYPE = "text/xml";

    public function get_default_content() {
        return "<hoba>\n  <url>https://example.com/hoba</url>\n</hoba>";
    }

    public function get_description() {
        return __("Supports the HTTP Origin-Bound Authentication (HOBA) method.", 'well-known-file-manager');
    }

}
?>