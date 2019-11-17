<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $TopLongitude;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $BottomLongitude;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $LeftLatitude;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $RightLatitude;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getTopLongitude(): float
    {
        return $this->TopLongitude;
    }

    /**
     * @param float $TopLongitude
     */
    public function setTopLongitude(float $TopLongitude): void
    {
        $this->TopLongitude = $TopLongitude;
    }

    /**
     * @return float
     */
    public function getBottomLongitude(): float
    {
        return $this->BottomLongitude;
    }

    /**
     * @param float $BottomLongitude
     */
    public function setBottomLongitude(float $BottomLongitude): void
    {
        $this->BottomLongitude = $BottomLongitude;
    }

    /**
     * @return float
     */
    public function getLeftLatitude(): float
    {
        return $this->LeftLatitude;
    }

    /**
     * @param float $LeftLatitude
     */
    public function setLeftLatitude(float $LeftLatitude): void
    {
        $this->LeftLatitude = $LeftLatitude;
    }

    /**
     * @return float
     */
    public function getRightLatitude(): float
    {
        return $this->RightLatitude;
    }

    /**
     * @param float $RightLatitude
     */
    public function setRightLatitude(float $RightLatitude): void
    {
        $this->RightLatitude = $RightLatitude;
    }

}
