<?php namespace IoDigital\GoogleCloudStorage\Storage;

class GoogleClient
{
    /**
     * @var \Google_Client
     * Google Client Instance
     */
    protected $client;
    /**
     * @var string
     * Project Name
     */
    protected $projectName;
    /**
     * @var string
     * Bucket name
     */
    protected $projectBucket;

    /**
     * GoogleServiceProvider constructor.
     * @param $config
     */
    public function __construct()
    {
        $this->client = new \Google_Client();

        $this->projectName = config('google_cloud_storage.application');
        $this->projectBucket = config('google_cloud_storage.bucket');
        $this->authJsonFile = config('google_cloud_storage.auth_json_filename');

        $this->client->setApplicationName($this->projectName);

        $this->client->setAuthConfigFile(base_path($this->authJsonFile));

        $this->client->addScope(\Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);
    }

    /**
     * @return \Google_Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->projectName;
    }

    /**
     * @return string
     */
    public function getBucketName()
    {
        return $this->projectBucket;
    }
}