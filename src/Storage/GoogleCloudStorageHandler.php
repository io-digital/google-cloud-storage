<?php namespace IoDigital\GoogleCloudStorage\Storage;

use Carbon\Carbon;

class GoogleCloudStorageHandler
{
    protected $client;
    protected $projectBucket;
    /**
     * GoogleCloudStorageHandler constructor.
     *
     * @param GoogleClient $googleClient
     */
    public function __construct(GoogleClient $googleClient)
    {
        $this->client = $googleClient->getClient();
        $this->projectBucket = $googleClient->getBucketName();
    }

    public function uploadFile($file)
    {
        $storageService = new \Google_Service_Storage($this->client);

        $mimeType =  $file->getMimetype();

        $fileExtension =  $file->getClientOriginalExtension();
        $datePrefix = '-' . Carbon::now()->toDateString() . '_' . Carbon::now()->toTimeString();
        $file_name = explode('.',$file->getClientOriginalName())[0];

        $file_name = $file_name . $datePrefix . '.' . $fileExtension;
        /***
         * Write file to Google Storage
         */
        try {
            $postbody = array(
                'name' => $file_name,
                'data' => file_get_contents($file->getPathname()),
                'uploadType' => "media",
                'mimeType' => $mimeType
            );
            $gsso = new \Google_Service_Storage_StorageObject();
            $gsso->setName($file_name);

            $result = $storageService->objects->insert($this->projectBucket, $gsso, $postbody);

            return $result;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function readFile($file_name)
    {
        $storageService = new \Google_Service_Storage($this->client);

        /***
         * Read file from Google Storage
         */
        try
        {
            $object = $storageService->objects->get($this->projectBucket, $file_name );

            $clientHttpInterface = $this->client->getHttpClient();

            $authClientHttpInterface = $this->client->authorize($clientHttpInterface);

            $request = $authClientHttpInterface->request('GET', $object['mediaLink']);

            return $request->getBody();
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function deleteFile($file_name)
    {
        $storageService = new \Google_Service_Storage($this->client);

        /***
         * Read file from Google Storage
         */
        try
        {
            $storageService->objects->delete( $this->projectBucket, $file_name );

            return true;
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}