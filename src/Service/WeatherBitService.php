<?php
namespace App\Service;

use App\Interfaces\WeatherInterface;
use App\Traits\RequestTrait;

class WeatherBitService implements WeatherInterface
{
    use RequestTrait;

    /**
     * Response variable
     *
     * @var object
     */
    private $response;

    /**
     * Constant api key
     * 
     * @var string
     */
    private const API_KEY = '3ac6950ba8334a309aa57193200dec30';

    /**
     * Constant api url
     * 
     * @var string
     */
    private const API_URL = 'https://api.weatherbit.io/v2.0/current';

    /**
     * Get location name method
     *
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->response->data[0]->city_name;
    }
    
    /**
     * Get tempeature method
     *
     * @return float
     */
    public function getTemp(): float
    {
        return (float) $this->response->data[0]->temp;
    }

    /**
     * Prepare query for request
     *
     * @param string $city
     * @param string $country
     * @return string
     */
    public function prepareQuery(string $city, string $country): string
    {
        $query = self::API_URL;
        $query .= '?city=' . $city . '&country=' . $country;
        $query .= '&key=' . self::API_KEY;

        return $query;
    }
}