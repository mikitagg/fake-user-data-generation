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
            'controller_name' => 'IndexController'
        ]);
    }

    #[Route('/index/getdata', name: 'app_index_getdata')]
    public function getGeneratedData(Request $request, DataGenerator $dataGenerator): JsonResponse
    {
        $region = $request->get('region');
        $seed = $request->get('seed');
        $errors = $request->get('errors');
        $count = $request->get('count');
        $generatedData = $dataGenerator->generateData($region, $errors, $seed, $count);
        return new JsonResponse($generatedData);
    }
}
