<?php

declare(strict_types=1);

namespace PhilTenno\FileSyncGo\Controller;

use Contao\System;                     // System‑Klasse für Einstellungen
use PhilTenno\FileSyncGo\Service\FileSyncService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;          // ←  richtige Route‑Annotation
use Symfony\Component\RateLimiter\RateLimiterFactory;

#[Route('/filessyncgo', name: 'philtenno_filessyncgo')]
final class FileSyncController
{
    public function __invoke(
        Request $request,
        FileSyncService $syncService,
        RateLimiterFactory $filessyncgoLimiter
    ): Response {
        // 1️⃣ Token aus Query‑Parameter holen
        $token = (string) $request->query->get('token');

        // 2️⃣ Token aus System‑Einstellungen holen
        $storedToken = (string) System::getContainer()
            ->getParameter('contao.settings')['filessyncgo_token'];

        if ($token !== $storedToken) {
            throw new AccessDeniedHttpException('Invalid token.');
        }

        // 3️⃣ Rate‑Limit prüfen (global, 3 Aufrufe pro Stunde)
        $limiter = $filessyncgoLimiter->create('global');
        if (!$limiter->consume()->isAccepted()) {
            throw new AccessDeniedHttpException('Rate limit exceeded. Try again later.');
        }

        // 4️⃣ Synchronisation auslösen
        $syncService->synchronize();

        return new Response('File sync triggered.');
    }
}
