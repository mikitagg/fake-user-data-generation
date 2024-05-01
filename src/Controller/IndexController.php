<?php

namespace App\Controller;

use App\Service\DataGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(Request $request, DataGenerator $dataGenerator): Response
    {

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
           // 'generatedData' => $generatedData,
        ]);
    }

    #[Route('/index/getdata', name: 'app_index_getdata')]
    public function getGeneratedData(Request $request, DataGenerator $dataGenerator): JsonResponse
    {
        $region = $request->get('option');
        $generatedData = $dataGenerator->generateData($region);
        return new JsonResponse($generatedData);
    }
}
