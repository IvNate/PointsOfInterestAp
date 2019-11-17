<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController extends Controller
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function IsValid($object)
    {
        $errorsPointItem = $this->validator->validate($object);
        return (count($errorsPointItem) === 0);
    }
}