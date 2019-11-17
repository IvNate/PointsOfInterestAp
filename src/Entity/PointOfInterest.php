<?php

namespace App\Entity;

use App\Entity\PointOfInterestTypes;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointOfInterestRepository")
 */
class PointOfInterest implements JsonSerializable
{
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'type' => $this->type->getName()
        ];
    }

    function __construct($name, $description, $latitude, $longitude) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->dateOfCreation = new DateTime('now');
        $this->dateOfUpdate = new DateTime('now');
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text", length = 500)
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text", length = 500)
     * @var string
     */
    private $description;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @ORM\Column(type="float")
     * @var float
     */
    private $longitude;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @ORM\Column(type="float")
     * @var float
     */
    private $latitude;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $dateOfCreation;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $dateOfUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PointOfInterestTypes", inversedBy="$pointOfInterests")
     * @ORM\JoinColumn(nullable=true)
     * @var PointOfInterestTypes
     */
    private $type;

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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude): void
    {
        if (is_numeric($longitude))
        {
            $this->longitude = floatval($longitude);
        }
        else
        {
            $this->longitude = $longitude;
        }
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude): void
    {
        if (is_numeric($latitude))
        {
            $this->latitude = floatval($latitude);
        }
        else{
            $this->latitude = $latitude;
        }
    }

    /**
     * @return \App\Entity\PointOfInterestTypes
     */
    public function getType(): \App\Entity\PointOfInterestTypes
    {
        return $this->type;
    }

    /**
     * @param \App\Entity\PointOfInterestTypes $type
     */
    public function setType(PointOfInterestTypes $type): void
    {
        $this->type = $type;
    }

    /**
     * @return DateTime
     */
    public function getDateOfCreation(): DateTime
    {
        return $this->dateOfCreation;
    }

    /**
     * @return DateTime
     */
    public function getDateOfUpdate(): DateTime
    {
        return $this->dateOfUpdate;
    }

    public static function build(Request $request): PointOfInterest
    {
        return new PointOfInterest($request->request->get('name'),
            $request->request->get('description'),
            $request->request->get('latitude'),
            $request->request->get('longitude'));
    }

    public function update(Request $request)
    {
        $this->setName($request->request->get('name'));
        $this->setDescription($request->request->get('description'));
        $this->setLatitude($request->request->get('latitude'));
        $this->setLongitude($request->request->get('longitude'));
        $this->dateOfUpdate = new DateTime('now');
    }
}
