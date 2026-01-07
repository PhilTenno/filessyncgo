<?php
//FilesSyncGo -> src/ContaoManager/Plugin.php

declare(strict_types=1);

namespace PhilTenno\FilesSyncGo\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use PhilTenno\FilesSyncGo\FilesSyncGoBundle;

class Plugin implements BundlePluginInterface, RoutingPluginInterface, ConfigPluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(FilesSyncGoBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        $file = __DIR__ . '/../../config/routes.yaml';

        return $resolver
            ->resolve($file)
            ->load($file);
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $config): void
    {
        // Services des Bundles laden
        $loader->load(__DIR__ . '/../../config/services.yaml');

        // RateLimiter-Konfiguration des Bundles laden
        $loader->load(__DIR__ . '/../../config/rate_limiter.yaml');
    }
}