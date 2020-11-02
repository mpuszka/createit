<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\RequestService;
use App\Service\OpenWeather;
use App\Service\WeatherBitService;
use App\Service\CountriesService;

use App\Entity\Weather;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     * 
     * Get weather api
     *
     * @param RequestService $requestService
     * @param OpenWeather $openWeather
     * @param WeatherBitService $weatherBitService
     * @param CountriesService $countriesService
     * @param string $country
     * @param string $city
     * @return Response
     */
    public function getWeather(
            RequestService $requestService, 
            OpenWeather $openWeather, 
            WeatherBitService $weatherBitService,
            CountriesService $countriesService,
            string $country,
            string $city
        ): Response
    {   
        $countryCode = $countriesService->getCountryCodeByName($country);

        if (NULL === $countryCode) 
        {
            return $this->json([
                'status'    => 'error',
                'message'   => 'Country not found'
            ]);
        }

        $weatherBitService->makeRequest($requestService, $city, $countryCode);
        if (NULL !== $requestService->getRequestMessage()) 
        {   
            return $this->json([
                'status'    => 'error',
                'message'   => $requestService->getRequestMessage()
            ]);
        } 

        $openWeather->makeRequest($requestService, $city, $countryCode);
        if (NULL !== $requestService->getRequestMessage()) 
        {  
            return $this->json([
                'status'    => 'error',
                'message'   => $requestService->getRequestMessage()
            ]);
        } 

        $locationName       = $weatherBitService->getLocationName();
        $weatherBitTemp     = $weatherBitService->getTemp();
        $openWeatherTemp    = $openWeather->getTemp();
        $avgTemp            = ($weatherBitTemp + $openWeatherTemp)/2;
        $roundAvgTemp       = (float) number_format($avgTemp, 1);

        $data = [
            'temp1'     => $weatherBitTemp,
            'temp2'     => $openWeatherTemp,
            'avg'       => $roundAvgTemp,
            'location'  => $locationName
        ];

        $entityManager = $this->getDoctrine()->getManager();

        $weather = new Weather;
        $weather->setLocation($locationName);
        $weather->setAvg($roundAvgTemp);
        $weather->setTemp1($weatherBitTemp);
        $weather->setTemp2($openWeatherTemp);

        $entityManager->persist($weather);
        $entityManager->flush();

        return $this->json($data);
    }
}
