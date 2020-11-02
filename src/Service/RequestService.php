<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Request service
 */
class RequestService 
{   
    /**
     * Request client
     *
     * @var HttpClientInterface
     */
    private $client;

    /**
     * Request response
     *
     * @var Object
     */
    private $response;

    /**
     * Constructor method
     *
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Make request method
     *
     * @param string $query
     * @return void
     */
    public function makeRequest(string $query): void 
    {   
        $response = $this->client->request(
            'GET',
            $query
        );

        $this->response = $response;
    }
    
    /**
     * Get request message error method
     *
     * @return string|null
     */
    public function getRequestMessage(): ?string
    {   
        if (200 !== $this->getResponseStatusCode()) {
            $content = $this->getResponseContent();
            $jsonEncodeContent = json_decode($content);

            return ($jsonEncodeContent) ? $jsonEncodeContent->message : 'Something goes wrong';
        }
        
        return NULL;
    }

    /**
     * Get request response status code
     *
     * @return int
     */
    public function getResponseStatusCode(): int 
    {
        return $this->response
                    ->getStatusCode();
    }
    
    /**
     * Get request response content method
     *
     * @return object
     */
    public function getResponseContent(): string 
    {
        return $this->response
                    ->getContent(false);
    }

    /**
     * Get request response content array method
     *
     * @return array
     */
    public function getResponseContentArray(): array
    {
        return $this->response
                    ->toArray();
    }
}