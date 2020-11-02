<?php
namespace App\Service;

use App\Interfaces\WeatherInterface;
use App\Traits\RequestTrait;

/**
 * Open weather service
 */
class OpenWeather implements WeatherInterface
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
    private const API_KEY = '3d187365a47abb8c797eb64fb29f2beb';

    /**
     * Constant api url
     * 
     * @var string
     */
    private const API_URL = 'http://api.openweathermap.org/data/2.5/weather';

    /**
     * Get location name method
     *
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->response->name;
    }

    /**
     * Get tempeature method
     *
     * @return float
     */
    public function getTemp(): float 
    {   
        $temp = $this->getMain()->temp - 272.15;

        return (float) number_format($temp, 1);
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
        $query .= '?q=' . $city . ',' . $country;
        $query .= '&appid=' . self::API_KEY;

        return $query;
    }

    /**
     * Get main data methods
     *
     * @return object
     */
    private function getMain(): object
    {
        return $this->response->main;
    }
}