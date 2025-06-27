<?php

namespace WellKnownFileManager\WellKnownFiles;

use WellKnownFileManager\Well_Known_File;

class Void_File extends Well_Known_File {

    const FILENAME = "void";
    const CONTENT_TYPE = "application/json";
   
    public function get_default_content() {
        return json_encode([
            "@context" => "http://rdfs.org/ns/void#",
            "@type" => "Dataset",
            "title" => "Example Dataset",
            "description" => "This is an example VoID description for a dataset.",
            "homepage" => "http://example.com/dataset",
            "sparqlEndpoint" => "http://example.com/sparql",
            "dataDump" => "http://example.com/dump.nt",
            "triples" => 1000000,
            "entities" => 100000,
            "classes" => 50,
            "properties" => 200,
            "distinctSubjects" => 100000,
            "distinctObjects" => 900000,
            "vocabulary" => [
                "http://www.w3.org/2000/01/rdf-schema#",
                "http://xmlns.com/foaf/0.1/"
            ],
            "exampleResource" => "http://example.com/resource/1"
        ], JSON_PRETTY_PRINT);
    }

    public function get_description() {
        return __("Provides information about the VoID specification.", 'well-known-file-manager');
    }

}
?>