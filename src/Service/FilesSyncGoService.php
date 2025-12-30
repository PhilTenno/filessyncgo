<?php
//src/Service/FilesSyncGoService.php

declare(strict_types=1);

namespace PhilTenno\FilesSyncGo\Service;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Dbafs;
use Psr\Log\LoggerInterface;

final class FilesSyncGoService
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ContaoFramework $framework,
    ) {
    }

    public function synchronize(): void
    {
        $this->framework->initialize();

        /** @var Dbafs $dbafsAdapter */
        $dbafsAdapter = $this->framework->getAdapter(Dbafs::class);
        
        // Synchronisiert alle Dateien (wie im Backend "Dateien → Synchronisieren")
        $dbafsAdapter->syncFiles();

        $this->logger->info('File synchronization triggered via filessyncgo.');
    }
}