<?php
// src/Service/FilesSyncSettings.php
declare(strict_types=1);

namespace PhilTenno\FilesSyncGo\Service;

use Contao\CoreBundle\Framework\ContaoFramework;

final class FilesSyncSettings
{
    public function __construct(
        private readonly ContaoFramework $framework,
    ) {
    }

    public function getToken(): string
    {
        $this->framework->initialize();
        
        $config = $this->framework->getAdapter(\Contao\Config::class);
        
        return (string) ($config->get('filessyncgo_token') ?? '');
    }
}