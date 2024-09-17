<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Caldav extends WellKnownFile {

    const FILENAME = "caldav";
    const CONTENT_TYPE = "text/xml";

    public function get_default_content() {
        return "<caldav>\n  <url>https://example.com/caldav</url>\n</caldav>";
    }

    public function get_description() {
        return __("Specifies the CalDAV (Calendaring Extensions to WebDAV) service URL.", 'well-known-manager');
    }

}
?>