<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Repository\WeatherRepository;
use App\Repository\CityRepository;


class WeatherController extends AbstractController
{
    public function cityAction(City $city, WeatherRepository $weatherRepository): Response
    {
        $weathers = $weatherRepository->findByCity($city);
        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weathers' => $weathers,
        ]);
    }

    public function cityByNameAction(string $country, string $city, CityRepository $cityRepository, WeatherRepository $weatherRepository): Response
    {
        $city_weathers = $cityRepository->findByCity($country, $city);
        $city_name = $city_weathers[0];
        $weathers = $weatherRepository->findByCity($city_weathers[0]);
        return $this->render('weather/city.html.twig', [
            'city' => $city_name,
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