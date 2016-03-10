<?php namespace IoDigital\GoogleCloudStorage\Storage;

class GoogleClient
{
    protected $client;
    protected $projectName;
    protected $projectBucket;

    /**
     * GoogleServiceProvider constructor.
     *
     */
    public function __construct()
    {
        $this->client = new \Google_Client();

        $this->client->setApplicationName(config('google_cloud_storage.application'));

        $this->client->setAuthConfigFile(base_path(config('google_cloud_storage.auth_json_filename')));

        $this->client->addScope(\Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);

        $this->projectName = config('google_cloud_storage.application');
        $this->projectBucket = config('google_cloud_storage.bucket');
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getApplicationName()
    {
        return $this->projectName;
    }

    public function getBucketName()
    {
        return $this->projectBucket;
    }
}