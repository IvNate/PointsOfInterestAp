<?php


namespace App\Exception;
use Symfony\Component\HttpFoundation\Response;

class ApiException
{
    public static function createNotValidRequestParametersException()
    {
        $response = new Response();
        return $response
            ->setStatusCode(400)
            ->setContent('{"message": "Not valid request parameters."}');
    }

    public static function createNotFoundPointOfInterestTypeException()
    {
        $response = new Response();
        return $response
            ->setStatusCode(404)
            ->setContent('{"message": "Point of interest type not found."}');
    }

    public static function createNotFoundPointOfInterestException()
    {
        $response = new Response();
        return $response
            ->setStatusCode(404)
            ->setContent('{"message": "Point of interest not found."}');
    }

    public static function createNotFoundCityException()
    {
        $response = new Response();
        return $response
            ->setStatusCode(404)
            ->setContent('{"message": "City not found."}');
    }

    public static function createNotFoundIpException()
    {
        $response = new Response();
        return $response
            ->setStatusCode(404)
            ->setContent('{"message": "Ip not found."}');
    }
}