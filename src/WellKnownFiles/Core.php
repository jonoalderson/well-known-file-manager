<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Core extends WellKnownFile {

    const FILENAME = "core";
    const CONTENT_TYPE = "text/xml";
   
    public function get_default_content() {
        return "<core>\n  <url>https://example.com/core</url>\n  <version>1.0</version>\n  <description>Core information for this service</description>\n</core>";
    }

    public function get_description() {
        return __("Provides core information about the service or application.", 'well-known-manager');
    }
}


?>