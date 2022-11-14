<?php

namespace App\Service;

use App\Repository\CityRepository;
use App\Repository\WeatherRepository;

class WeatherUtil
{
    private CityRepository $cityRepository;
    private WeatherRepository $weatherRepository;

    public function __construct(CityRepository $cityRepository, WeatherRepository $weatherRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->weatherRepository = $weatherRepository;
    }

    public function getWeatherForCountryAndCity($country, $city_name) : array
    {
        $city = $this->cityRepository->findByCity($country, $city_name);
        return $this->getWeatherForId($city[0]);

    }

    public function getWeatherForId($city) : array
    {
        return $this->weatherRepository->findByCity($city);
    }
}