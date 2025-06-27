<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Carddav extends Well_Known_File {   

    const FILENAME = "carddav";
    const CONTENT_TYPE = "text/xml";

    public function get_default_content() {
        return "<carddav>\n  <url>https://example.com/carddav</url>\n</carddav>";
    }

    public function get_description() {
        return __("Specifies the CardDAV (vCard Extensions to WebDAV) service URL.", 'well-known-file-manager');
    }
    
}
?>