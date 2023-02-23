<?php

declare(strict_types=1);

$connection = env('APP_ENV') == 'production' ? [
    'elasticCloudId' => env('ELASTIC_CLOUD_ID', null),
    'auth' => [
        'username' => env('ELASTIC_USERNAME', 'elastic'),
        'password' => env('ELASTIC_PASSWORD')
    ]
]: [
    'host' => 'localhost',
    'port' => '9200',
    'scheme' => 'http',
    'auth' => [
        'username' => env('ELASTIC_USERNAME', 'elastic'),
        'password' => env('ELASTIC_PASSWORD')
    ]
];

return [
    /*
     * There are different options for the connection. Since Explorer uses the Elasticsearch PHP SDK
     * under the hood, all the host configuration options of the SDK are applicable here. See
     * https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/configuration.html
     */
    'connection' => $connection,

    /**
     * An index may be defined on an Eloquent model or inline below. A more in depth explanation
     * of the mapping possibilities can be found in the documentation of Explorer's repository.
     */
    'indexes' => [
        \App\Models\Book::class
    ],

    /**
     * You may opt to keep the old indices after the alias is pointed to a new index.
     * A model is only using index aliases if it implements the Aliased interface.
     */
    'prune_old_aliases' => false,
];
