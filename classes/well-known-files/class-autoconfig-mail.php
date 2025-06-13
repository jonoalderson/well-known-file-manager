<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\Well_Known_File;

class Autoconfig_Mail extends Well_Known_File {

    const FILENAME = "autoconfig/mail";
    const CONTENT_TYPE = "application/xml";

    public function get_default_content() {
        return '<?xml version="1.0" encoding="UTF-8"?>
<clientConfig version="1.1">
  <emailProvider id="example.com">
    <domain>example.com</domain>
    <displayName>Example Mail</displayName>
    <displayShortName>Example</displayShortName>
    <incomingServer type="imap">
      <hostname>imap.example.com</hostname>
      <port>993</port>
      <socketType>SSL</socketType>
      <authentication>password-cleartext</authentication>
      <username>%EMAILADDRESS%</username>
    </incomingServer>
    <outgoingServer type="smtp">
      <hostname>smtp.example.com</hostname>
      <port>587</port>
      <socketType>STARTTLS</socketType>
      <authentication>password-cleartext</authentication>
      <username>%EMAILADDRESS%</username>
    </outgoingServer>
  </emailProvider>
</clientConfig>';
    }

    public function get_description() {
        return __("Provides email client autoconfiguration settings for your domain.", 'well-known-manager');
    }

}
?>