<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use App\Repository\CityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
class Weather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $temperature_c = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $probability_of_precipitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clouds = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityId(): ?City
    {
        return $this->city_id;
    }
    public function getStringCityId()
    {
        return (string) $this->getCityId();
    }

    public function setCityId(?City $city_id): self
    {
        $this->city_id = $city_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperatureC(): ?string
    {
        return $this->temperature_c;
    }

    public function setTemperatureC(string $temperature_c): self
    {
        $this->temperature_c = $temperature_c;

        return $this;
    }

    public function getProbabilityOfPrecipitation(): ?string
    {
        return $this->probability_of_precipitation;
    }

    public function setProbabilityOfPrecipitation(?string $probability_of_precipitation): self
    {
        $this->probability_of_precipitation = $probability_of_precipitation;

        return $this;
    }

    public function getClouds(): ?string
    {
        return $this->clouds;
    }

    public function setClouds(?string $clouds): self
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function toArray(): array
    {
        return [
            $this->id,
            $this->date->format('d-m-Y'),
            $this->temperature_c,
            $this->probability_of_precipitation,
            $this->clouds
        ];
    }

}
