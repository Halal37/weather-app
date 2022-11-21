<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiController extends AbstractController
{

    public function getWeatherAction(Request $request, WeatherUtil $weatherUtil): Response
    {
        $payload = $request->toArray();
        $country = $payload["country"];
        $city = $payload["city"];
        $type = $payload["type"];
        $twig = $payload["twig"];


        $weather = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        $response = new Response();

        if ($type == null || $type == "json") {
            $weatherArray = array();
            foreach ($weather as $singleWeather) {
                $weatherArray[] = $singleWeather->toArray();
            }

            if ($twig == "true") {
                $response->setContent(
                    $this->render('web_api/weather.json.twig', [
                        'country' => $country,
                        'city' => $city,
                        'weatherArray' => $weatherArray,
                    ])
                );
            }
            else {
                $response->setContent(json_encode([
                    "country" => $country,
                    "city" => $city,
                    "weather" => $weatherArray,
                ]));
            }

            $response->headers->set('Content-Type', 'application-json');
        }
        else if ($type == "csv") {
            $weatherArray = array();

            if ($twig == "true") {
                foreach ($weather as $singleWeather) {
                    $weatherArray[] = $singleWeather->toArray();
                }

                $response->setContent(
                    $this->render('web_api/weather.csv.twig', [
                        'country' => $country,
                        'city' => $city,
                        'weatherArray' => $weatherArray,
                    ])
                );
            }
            else {
                foreach ($weather as $singleWeather) {
                    $weatherArray[] = implode(',', $singleWeather->toArray());
                }

                $content = implode("\n", $weatherArray);
                $response->setContent($content);
            }

            $response->headers->set('Content-Type', 'application-csv');
        }
        else {
            $response->setContent(json_encode([
                "error" => "Invalid type"
            ]));
            $response->headers->set('Content-Type', 'application-json');
        }

        return $response;
    }

}        $country = "PL";
$city = "Szczecin";
$type = "json";
$twig = "true";