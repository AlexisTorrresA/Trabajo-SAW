<?php

namespace model;

class SPARQLQuery {

    private $endpointUrl;

    public function __construct($endpointUrl) {
        $this->endpointUrl = $endpointUrl;
    }

    public function query($sparqlQuery) {

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Accept: application/sparql-results+json'
                ],
            ],
        ];
        $context = stream_context_create($opts);

        $url = $this->endpointUrl . '?query=' . urlencode($sparqlQuery);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}