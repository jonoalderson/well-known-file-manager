<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class Openpgpkey extends WellKnownFile {

    const FILENAME = "openpgpkey";
    const CONTENT_TYPE = "application/pgp-keys";

    public function get_default_content() {
        return "-----BEGIN PGP PUBLIC KEY BLOCK-----\n...\n-----END PGP PUBLIC KEY BLOCK-----";
    }

    public function get_description() {
        return __("Stores OpenPGP public keys for email addresses on the domain.", 'well-known-manager');
    }

}
?>