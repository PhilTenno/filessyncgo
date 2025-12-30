<?php

namespace PhilTenno\FilesSyncGo\Controller;

use PhilTenno\FilesSyncGo\Service\FilesSyncGoService;
use PhilTenno\FilesSyncGo\Service\FilesSyncSettings;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;

final class FilesSyncGoController
{
    public function __construct(
        private readonly FilesSyncGoService $syncService,
        private readonly FilesSyncSettings $settings,
        private readonly RateLimiterFactory $filessyncgoLimiter,
    ) {
    }

    #[Route('/filessyncgo', name: 'syncFiles', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // 1. Token-Prüfung
        $token = (string) $request->query->get('token');
        $storedToken = $this->settings->getToken();

        if ($token === '' || $storedToken === '' || $token !== $storedToken) {
            return new JsonResponse(['error' => 'Invalid token.'], Response::HTTP_UNAUTHORIZED);
        }

        // 2. Rate-Limiter (Missbrauchsschutz, pro IP) – analog Contao-Login
        $limiter = $this->filessyncgoLimiter->create($request->getClientIp() ?? 'unknown');
        $limit   = $limiter->consume(1);

        if (!$limit->isAccepted()) {
            return new JsonResponse(
                ['error' => 'Too many requests. Please try again later.'],
                Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        // 3. Dateisynchronisierung auslösen (wie „Dateien → Synchronisieren“ im Backend)
        $this->syncService->synchronize();

        return new JsonResponse(
            ['success' => true, 'message' => 'File sync triggered.'],
            Response::HTTP_OK
        );
    }
}