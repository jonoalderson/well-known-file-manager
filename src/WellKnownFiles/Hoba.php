<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Hoba extends WellKnownFile {

    const FILENAME = "hoba";
    const CONTENT_TYPE = "text/xml";

    public function get_default_content() {
        return "<hoba>\n  <url>https://example.com/hoba</url>\n</hoba>";
    }

    public function get_description() {
        return __("Supports the HTTP Origin-Bound Authentication (HOBA) method.", 'well-known-manager');
    }

}
?>