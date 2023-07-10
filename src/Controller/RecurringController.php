<?php

namespace App\Controller;

use App\Repository\RecurringRepository;
use App\Service\RecurringService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RecurringController extends AbstractController
{
    #[Route('/recurring', name: 'listRecurring', methods:['GET'])]
    public function list(RecurringRepository $recurringRepository): JsonResponse
    {
        $list = $recurringRepository->findAll();

        return $this->json(
            $list,
        );
    }
    #[Route('/recurring', name: 'CreateRecurring', methods:['POST'])]
    public function create(Request $request, RecurringService $recurringService, RecurringRepository $recurringRepository): JsonResponse
    {
        $data = $request->ToArray();

        $recurring = $recurringService->newRecurring($data, $recurringRepository);

        return $this->json(
            $recurring,
        );
    }
}
