<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class HostMeta extends WellKnownFile {

    const FILENAME = "host-meta";
    const CONTENT_TYPE = "application/xml";

    public function get_default_content() {
        return "<XRD xmlns=\"http://docs.oasis-open.org/ns/xri/xrd-1.0\">\n  <Link rel=\"http://webfinger.net/rel/profile-page\" href=\"https://example.com/profile\" />\n</XRD>";
    }

    public function get_description() {
        return __("Provides host metadata for web-based protocols.", 'well-known-manager');
    }

}
?>