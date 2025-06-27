<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Est extends Well_Known_File {

    const FILENAME = "est";
    const CONTENT_TYPE = "text/xml";
    
    public function get_default_content() {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<est>\n  <server>https://example.com:8443/.well-known/est</server>\n  <ca-certs>https://example.com:8443/.well-known/est/cacerts</ca-certs>\n  <csrs>https://example.com:8443/.well-known/est/simpleenroll</csrs>\n  <renew>https://example.com:8443/.well-known/est/simplereenroll</renew>\n</est>";
    }

    public function get_description() {
        return __("Supports Enrollment over Secure Transport (EST) for certificate enrollment.", 'well-known-file-manager');
    }

}
?>