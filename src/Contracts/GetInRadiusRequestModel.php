<?php


namespace App\Contracts;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetInRadiusRequestModel
{
    /**
     * @var string
     */
    private $ip;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @var float
     */
    private $radius;

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    public function getRadius()
    {
        return $this->radius;
    }

    public function setRadius($radius): void
    {
        if (is_numeric($radius))
        {
            $this->radius = floatval($radius);
        }
        else
            {
            $this->radius = $radius;
            }
    }

    function __construct($ip, $radius) {
        $this->setIp($ip);
        $this->setRadius($radius);
    }

    public static function build(Request $request): GetInRadiusRequestModel
    {
        return new GetInRadiusRequestModel(
            $request->query->get('ip'),
            $request->query->get('radius', 1));
    }
}