<?php

namespace WellKnownManager\WellKnownFiles;

use WellKnownManager\WellKnownFile;

class KeybaseTxt extends WellKnownFile {

    const FILENAME = "keybase.txt";
    const CONTENT_TYPE = "text/plain";

    public function get_default_content() {
        return "==================================================================\nhttps://keybase.io/example\n--------------------------------------------------------------------\n\nI hereby claim:\n\n  * I am an admin of https://example.com\n  * I am exampleuser (https://keybase.io/exampleuser) on keybase.\n  * I have a public key with fingerprint ABCD 1234 EFGH 5678 IJKL\n\nTo claim this, I am signing this object:\n\n{\n    \"body\": {\n        \"key\": {\n            \"fingerprint\": \"ABCD1234EFGH5678IJKL\",\n            \"host\": \"keybase.io\",\n            \"key_id\": \"ABCDEFGHIJKLMNOP\",\n            \"uid\": \"unique_id\",\n            \"username\": \"exampleuser\"\n        },\n        \"service\": {\n            \"hostname\": \"example.com\",\n            \"protocol\": \"https:\"\n        },\n        \"type\": \"web_service_binding\",\n        \"version\": 1\n    },\n    \"ctime\": 1234567890,\n    \"expire_in\": 157680000,\n    \"prev\": \"previous_signature_hash\",\n    \"seqno\": 1,\n    \"tag\": \"signature\"\n}\n\nwith the key ABCD 1234 EFGH 5678 IJKL, yielding the signature:\n\n-----BEGIN PGP MESSAGE-----\nVersion: Keybase OpenPGP v2.0.76\nComment: https://keybase.io/crypto\n\nyMIDAnicbZJbSBRRGMfXskxKKC0fooieloqYmXPOzJxZQosiJAkSIhFp2ZnvzB7X\ndmd3Zl0LKyF6SBDpQbKHoKIHCYqIIKILBJGEQmhYYUFgEUXRBSKiCxXdLp3Rl+Z8\n5/y/8/8u39/4xhWRWGz/2aVDLcm3t8X6Ry5GIqtXXe/qklyHVkvpLqnQPX2YeYHv\nFj3JlNISUkGxdJWppmoppmWqhqGqOtOopXFuqBbXLCYzwgijGqPMKhAJUgGGZdmm\nZXJdKjgFz/H9wAXZKbqeI2RVZjCd6BanTKOWbXPCKbUwMTgXGqWmZuqmYXBha8yy\nTWpQoqoqNwlXCRUFx3Wd/CwRHPJFoOAHjrAVkULBK3hFR0oXvCB0fNFcCIKyX3K9\nUNFcKJX9crnk5IOCa0hpQXFKnh8wPy9EhVLJ9UNFIXRLnh+6OaF0vFLZ9VzRWAg9\nNxTKrFcUXbJUUDVGCTGYpXDT0i1KKOGUqoRqFuWmplsaRjpGiGkIGYZNDMI4twkm\nFsIWBpwzAhRRrFNq6AZXEdYMZlOEKcOUYaRjrGOdUyqkRa8kpQvCUvRLjhDmPaGZ\nLwQlP+eGUvr/eMGHwA1yrlQoOoHnB1K6RbhFVdNUDGGFqcxUMcMWBpgYBkKYIoqI\nQTDXETIRpSYnGGtIVZlNDdELxYRjAzFKOKMYEUQMZFu6bhiIYoYJOFQQwYRhA+mG\nqVkIqbpuUMTFjP8Aw+H5Yl7KO2XJ8UO35DlZqehJR/8MRmKxyKrVK8LtisRWrV23\n8JGRxfGJT9Wd3e9aGqeS8cnGzODJ+pnM9VPNjVOtj9Kj7Ym2vvEbLTcfbNl2q/vK\n8/Gxw7Xp+omhPQe/f3nU8Xhsf9uJzr7Bg/ld+/Z23u2e3tF+5+zZ+p4f7z7vHD7/\n9sDxSO3Qvo/1n5r6X7/o7rg0cqXpSO3Uhwdru84NnJ8+/Hq4/cKGmR+3s1/vXXt6\nrPbUhvTM6/Gx1omV8dbG9VNbJ5+8jI7OTpyb/bT9+PrG2WuPfh2bPdkw8Hb0SXVP\nZvDXzOXG9pmV8aGfB7LVxIHc5vRQ/EUmM3v/8+ux+vDvZGLLcGb2ZvPVxu/Xkv3x\n5/FEYvDMn/TL1O+OvslDO5/t/jOy7UvVn/TE1qnNO5Pp5OzE5/sPE7Wv\n=+9yw\n-----END PGP MESSAGE-----\n\nAnd finally, I am proving ownership of this host by posting or\nappending to this document.\n\nView my publicly-auditable identity here: https://keybase.io/exampleuser\n\n==================================================================";
    }

    public function get_description() {
        return __("Verifies domain ownership for Keybase.io accounts.", 'well-known-manager');
    }

}
?>