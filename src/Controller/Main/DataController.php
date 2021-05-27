<?php


namespace App\Controller\Main;


use App\Service\Data\DataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends BaseController
{
    /**
     * @var DataService
     */
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }


    /**
     * @Route("/data/post", name="data_post", methods={"GET", "POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilterPostAction(Request $request): JsonResponse
    {
        $response = $this->dataService->getFilterPost($request);

//        return $this->json($response);
        return new JsonResponse($response);
    }


}