<?php
namespace App\Controller;

use App\Contracts\GetInCityRequestModel;
use App\Entity\City;
use App\Entity\IP;
use App\Entity\PointOfInterestTypes;
use App\Entity\PointOfInterest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Contracts\GetInRadiusRequestModel;
use App\Exception\ApiException;
use App\Repository\PointOfInterestRepository;
use App\Repository\CityRepository;

class PointsOfInterestController extends BaseController
{
    /**
     * @Route("/point")
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $pointItem = PointOfInterest::build($request);
        if (!$this->IsValid($pointItem)) {
            return ApiException::createNotValidRequestParametersException();
        }
        $pointOfInterestTypesItem = $this->searchPointOfInterestTypesByName($request->request->get('type'));
        if (!$pointOfInterestTypesItem) {
            return ApiException::createNotFoundPointOfInterestTypeException();
        }
        $pointItem->setType($pointOfInterestTypesItem);
        $this->addNewPointOfInterest($pointItem);
        return new Response(json_encode($pointItem, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/point/{id}")
     * @Method({"PUT"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var PointOfInterest $pointItem */
        $pointItem = $this->getDoctrine()->getRepository(PointOfInterest::class)->find($id);
        if (!$pointItem) {
            return ApiException::createNotFoundPointOfInterestException();
        }
        $pointItem->update($request);
        if (!$this->IsValid($pointItem)) {
            return ApiException::createNotValidRequestParametersException();
        }
        $pointOfInterestTypesItem = $this->searchPointOfInterestTypesByName($request->request->get('type'));
        if (!$pointOfInterestTypesItem)
        {
            return ApiException::createNotFoundPointOfInterestTypeException();
        }
        $pointItem->setType($pointOfInterestTypesItem);
        $entityManager->flush();
        return new Response(json_encode($pointItem, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/points/all")
     * @Method({"GET"})
     * @param Request $request
     * @return Response
     */
    public function getInCity(Request $request)
    {
        $getInCityRequestModel = GetInCityRequestModel::build($request);
        if (!$this->IsValid($getInCityRequestModel)) {
            return ApiException::createNotValidRequestParametersException();
        }
        $cityObj = null;
        if (empty($getInCityRequestModel->getCity())) {
            $ip = $this->container->get('request_stack')->getMasterRequest()->getClientIp();
            $cityObj = $this->searchCityByIP($ip);
        }
        else {
            $cityObj = $this->searchCityByName($getInCityRequestModel->getCity());
        }
        if (!$cityObj) {
            return ApiException::createNotFoundCityException();
        }
        $pointOfInterest = $this->getDoctrine()
            ->getRepository(PointOfInterest::class)
            ->getPointOfInterestInCity($cityObj, $getInCityRequestModel->getLimit(), $getInCityRequestModel->getOffset());
        return new Response(json_encode($pointOfInterest, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/points")
     * @Method({"GET"})
     * @param Request $request
     * @return Response
     */
    public function getInRadius(Request $request)
    {
        $getInRadiusRequestModel = GetInRadiusRequestModel::build($request);
        if (!$this->IsValid($getInRadiusRequestModel)) {
            return ApiException::createNotValidRequestParametersException();
        }
        if (empty($getInRadiusRequestModel->getIp())) {
            $getInRadiusRequestModel->setIp($this->container->get('request_stack')->getCurrentRequest()->getClientIp());
        }
        $ipObj = $this->getDoctrine()->getRepository(IP::class)->findOneBy(array('address'=>$getInRadiusRequestModel->getIp()));
        if (!$ipObj) {
            return ApiException::createNotFoundIpException();
        }
        $pointOfInterest = $this->getPointsOfInterestInRadius($ipObj, $getInRadiusRequestModel->getRadius());
        return new Response(json_encode($pointOfInterest, JSON_UNESCAPED_UNICODE));
    }

    private function searchCityByIP($ip)
    {
        /** @var IP $ipObj */
        $ipObj = $this->getDoctrine()->getRepository(IP::class)->findOneBy(array('address'=>$ip));
        if (!$ipObj) {
            return null;
        }
        $city = $this->getDoctrine()->getRepository(City::class)->getCityByIp($ipObj);
        return current($city);
    }

    private function searchCityByName($name)
    {
        /** @var City $city */
        $city = $this->getDoctrine()->getRepository(City::class)->findOneBy(array('name'=>$name));
        return $city;
    }

    private function getPointsOfInterestInRadius($ipObj, $radius)
    {
        $sourcePointOfInterest = $this->getDoctrine()->getRepository(PointOfInterest::class)->findAll();
        $pointOfInterest = array();
        foreach ($sourcePointOfInterest as $item) {
            if ($this->getDistance($item->getLatitude(), $item->getLongitude(), $ipObj->getLatitude(), $ipObj->getLongitude()) < $radius) {
                array_push($pointOfInterest, $item);
            }
        }
        return $pointOfInterest;
    }

    private function searchPointOfInterestTypesByName(string $name)
    {
        /** @var PointOfInterestTypes $pointOfInterestTypes */
        $pointOfInterestTypes = $this->getDoctrine()->getRepository(PointOfInterestTypes::class)->findOneBy(array('name'=>$name));
        return $pointOfInterestTypes;
    }

    private function addNewPointOfInterest(PointOfInterest $pointOfInterestItem)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pointOfInterestItem);
        $entityManager->flush();
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earth_radius = 6371;
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
        return $d;
    }
}