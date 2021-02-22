<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{


    /**
     * @Route("/home", name="home")
     * @param CallApiService $callApiService
     * @return Response
     */
    public function index(CallApiService $callApiService): Response
    {
        //dd($callApiService->getFranceData());
        return $this->render('home/index.html.twig', [
            'data' => $callApiService->getFranceData(),
            //on rajoute à notre vue les departements
            'departments' => $callApiService->getAllData(),
        ]);
    }
}
