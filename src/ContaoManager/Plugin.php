<?php
// src/ContaoManager/Plugin.php

declare(strict_types=1);

namespace PhilTenno\FileSyncGo\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;   // ←  korrekter Namespace
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use PhilTenno\FileSyncGo\FileSyncGoBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(FileSyncGoBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
