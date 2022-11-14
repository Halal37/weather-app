<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Repository\WeatherRepository;
use App\Repository\CityRepository;
use App\Service\WeatherUtil;


class WeatherController extends AbstractController
{
    public function cityAction(City $city, WeatherUtil $weatherUtil): Response
    {
        $weathers = $weatherUtil->getWeatherForId($city);
        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weathers' => $weathers,
        ]);
    }

    public function cityByNameAction($country, $city, CityRepository $cityRepository, WeatherUtil $weatherUtil): Response
    {
        $city_name = $cityRepository->findByCity($country, $city);
        $weathers = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        return $this->render('weather/city.html.twig', [
            'city' => $city_name[0],
            'weathers' => $weathers,
        ]);

    }

}




/*
class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function cityAction(): Response
    {
        return $this->render('weather/city.html.twig', [
            'controller_name' => 'WeatherController',
        ]);
    }
}*/