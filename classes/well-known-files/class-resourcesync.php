<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Resourcesync extends Well_Known_File {

    const FILENAME = "resourcesync";
    const CONTENT_TYPE = "application/xml";

    public function get_default_content() {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n        xmlns:rs=\"http://www.openarchives.org/rs/terms/\">\n  <rs:ln rel=\"up\"\n         href=\"http://example.com/dataset1/capabilitylist.xml\"/>\n  <url>\n    <loc>http://example.com/res1</loc>\n    <lastmod>2013-01-03T09:00:00Z</lastmod>\n  </url>\n</urlset>";
    }

    public function get_description() {
        return __("Supports the ResourceSync Framework for Web resource synchronization.", 'well-known-file-manager');
    }

}
?>