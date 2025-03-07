<?php

namespace App\Service;

use Aws\S3\S3Client;

class S3Service
{
    protected ?S3Client $client = null;

    public function __construct() {}

    /**
     * Get the S3 client
     * 
     * @return S3Client
     */ 
    public function getClient(): S3Client
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

    /**
     * Get all buckets
     * 
     * @return array
     */
    public function getBuckets(): array
    {
        $buckets = $this->getClient()->listBuckets();

        return $buckets['Buckets'] ?? $buckets['Buckets'];
    }

    /**
     * Get all objects in a bucket
     * 
     * @param string $bucket
     * @return array
     */ 
    public function getBucketObjects(string $bucket): array
    {
        $objects = $this->getClient()->listObjects([
            'Bucket' => $bucket
        ]);

        return $objects['Contents'] ?? $objects['Contents'];
    }

    /**
     * Get an object from a bucket
     * 
     * @param string $bucket
     * @param string $key
     * @return array
     */
    public function getObject(string $bucket, string $key): string
    {
        $object = $this->getClient()->getObject([
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        return $object['Body'] ?? $object['Body'];
    }
}