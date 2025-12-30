<?php
// src/Controller/FilesSyncGoController.php
declare(strict_types=1);

namespace PhilTenno\FilesSyncGo\Controller;

use PhilTenno\FilesSyncGo\Service\FilesSyncGoService;
use PhilTenno\FilesSyncGo\Service\FilesSyncSettings;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FilesSyncGoController
{
    public function __construct(
        private readonly FilesSyncGoService $syncService,
        private readonly FilesSyncSettings $settings,
    ) {
    }

    #[Route('/filessyncgo', name: 'philtenno_filessyncgo', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $token = (string) $request->query->get('token');
        $storedToken = $this->settings->getToken();

        if ($token === '' || $storedToken === '' || $token !== $storedToken) {
            return new JsonResponse(['error' => 'Invalid token.'], 
            Response::HTTP_UNAUTHORIZED);
        }

        $this->syncService->synchronize();

        return new Response('File sync triggered.', Response::HTTP_OK);
    }
}