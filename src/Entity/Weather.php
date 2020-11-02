<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherRepository::class)
 */
class Weather
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="float")
     */
    private $avg;

    /**
     * @ORM\Column(type="float")
     */
    private $temp1;

    /**
     * @ORM\Column(type="float")
     */
    private $temp2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getAvg(): ?float
    {
        return $this->avg;
    }

    public function setAvg(float $avg): self
    {
        $this->avg = $avg;

        return $this;
    }

    public function getTemp1(): ?float
    {
        return $this->temp1;
    }

    public function setTemp1(float $temp1): self
    {
        $this->temp1 = $temp1;

        return $this;
    }

    public function getTemp2(): ?float
    {
        return $this->temp2;
    }

    public function setTemp2(float $temp2): self
    {
        $this->temp2 = $temp2;

        return $this;
    }
}
