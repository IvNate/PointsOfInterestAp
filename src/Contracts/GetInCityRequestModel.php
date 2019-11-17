<?php


namespace App\Contracts;
use App\Entity\City;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetInCityRequestModel
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @var integer
     */
    private $limit;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @var integer
     */
    private $offset;

    /**
     * @var string
     */
    private $city;

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit($limit): void
    {
        if (is_numeric($limit))
        {
            $this->limit = intval($limit);
        }
        else
        {
            $this->limit = $limit;
        }
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset): void
    {
        if (is_numeric($offset))
        {
            $this->offset = intval($offset);
        }
        else
        {
            $this->offset = $offset;
        }
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): void
    {
        $this->city = $city;
    }

    function __construct($limit, $offset, $city) {
        $this->setLimit($limit);
        $this->setOffset($offset);
        $this->setCity($city);
    }

    public static function build(Request $request): GetInCityRequestModel
    {
        return new GetInCityRequestModel(
            $request->query->get('limit', 50),
            $request->query->get('offset', 0),
            $request->query->get('city'));
    }
}