<?php

declare(strict_types=1);

namespace PhilTenno\FileSyncGo\Service;

use Psr\Log\LoggerInterface;

final class FileSyncService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function synchronize(): void
    {
        // Hier die eigentliche Synchronisation einbauen.
        // Für den Prototypen reicht ein Log‑Eintrag.
        $this->logger->info('File synchronization triggered via filessyncgo.');
    }
}
