<?php


namespace App\Service;


use http\Client\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /*public function getFranceData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://coronavirusapi-france.now.sh/FranceLiveGlobalData'
        );
        return $response->toArray();
    }*/

    private function getApi(string $var)
    {
        $response = $this->client->request (
            'GET',
            'https://coronavirusapi-france.now.sh/' . $var
        );
        return $response->toArray();
    }

    public function getFranceData(): array
    {
        return $this->getApi('FranceLiveGlobalData');
    }

    public function getAllData(): array
    {
        return $this->getApi('AllLiveData');
    }

    // infos par department

    public function getDepartmentData($department): array
    {
        return $this->getApi('LiveDataByDepartement?Departement=' . $department);
    }

    // infos par DATE

    public function getAllDataByDate($date): array
    {
        return $this->getApi('AllDataByDate?date=' . $date);
    }


}