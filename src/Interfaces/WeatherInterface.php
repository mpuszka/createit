<?php
declare(strict_types=1);

namespace App\Interfaces;

/**
 * Weather interface
 */
interface WeatherInterface 
{   
    /**
     * Prepare query for request
     *
     * @param string $city
     * @param string $country
     * @return string
     */
    public function prepareQuery(string $city, string $country);

    /**
     * Get Location name
     *
     * @return string
     */
    public function getLocationName();

    /**
     * Get Temperature
     *
     * @return float
     */
    public function getTemp();
}