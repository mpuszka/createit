<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait for request methods
 */
Trait RequestTrait 
{   
    /**
     * Make request 
     *
     * @param object $requestService
     * @param string $city
     * @param string $country
     * @return object
     */
    public function makeRequest(object $requestService, string $city, string $country): object 
    {
        $requestService->makeRequest($this->prepareQuery($city, $country));
        $content = json_decode($requestService->getResponseContent());
        $this->setResponse($content);

        return $this->response;
    }

    /**
     * Get request response
     *
     * @return object
     */
    public function getResponse(): object 
    {
        return $this->response;
    }

    /**
     * Set request response
     *
     * @param object $response
     * @return void
     */
    public function setResponse(object $response): void
    {
        $this->response = $response;
    }
}