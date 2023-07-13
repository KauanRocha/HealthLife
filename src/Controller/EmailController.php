<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/email/send', name: 'app_email')]
    public function index(EmailService $emailService, Request $request): JsonResponse
    {
        $data = $request->toArray();

        $email = $emailService->SendEmail($data['destiny'], $data['subject'], $data['text']);

        return $this->json(
            $email, 200, ['message' => 'Email send successfully!']
        );
    }
}
