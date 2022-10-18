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
        var_dump($city);
        $weathers = $weatherRepository->findByCity($city);
        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weathers' => $weathers,
        ]);
    }

    public function cityAction2(City $city_country,City $city_name, WeatherRepository $weatherRepository,CityRepository $cityRepository): Response
    {z
        $weathers = $weatherRepository->findByCity($city_name);
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