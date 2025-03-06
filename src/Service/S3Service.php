<?php

namespace App\Service;

use Aws\S3\S3Client;

class S3Service
{
    protected ?S3Client $client = null;

    public function __construct() {}

    public function getClient()
    {
        if ($this->client) {
            return $this->client;
        }

        return $this->client = new S3Client([
            'version' => 'latest',
            'region' =>  $_ENV['AWS_DEFAULT_REGION'],
            'endpoint' => $_ENV['AWS_ENDPOINT'],
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $_ENV['AWS_ACCESS_KEY'],
                'secret' => $_ENV['AWS_SECRET_KEY']
            ]
        ]);
    }
}
