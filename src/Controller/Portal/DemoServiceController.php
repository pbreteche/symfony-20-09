<?php

namespace App\Controller\Portal;

use App\Math\CalculatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class DemoServiceController extends AbstractController
{

    /**
     * @Route("")
     */
    public function index(CalculatorInterface $adder)
    {
        return new Response($adder->calculate(3, 4), 200, [
            'Content-Type' => 'text/plain',
        ]);
    }

}