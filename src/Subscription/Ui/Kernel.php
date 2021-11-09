<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $root = $this->getRootPath();
        $container->import($root . '/config/{packages}/*.yaml');
        $container->import($root . '/config/{packages}/' . $this->environment . '/*.yaml');

        if (\is_file($root . '/config/services.yaml')) {
            $container->import($root . '/config/services.yaml');
            $container->import($root . '/config/{services}_' . $this->environment . '.yaml');
        } elseif (\is_file($path = $root . '/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $root = $this->getRootPath();
        $routes->import($root . '/config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import($root . '/config/{routes}/*.yaml');

        if (\is_file($root . '/config/routes.yaml')) {
            $routes->import($root . '/config/routes.yaml');
        } elseif (\is_file($path = $root . '/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }

    private function getRootPath(): string
    {
        return \realpath(\dirname(__DIR__) . '/../../');
    }

    public function getLogDir(): string
    {
        $logDir = \getenv('LOG_DIR');

        return false === $logDir ? parent::getLogDir() : $logDir;
    }

    public function getCacheDir(): string
    {
        $cacheDir = \getenv('CACHE_DIR');

        return false === $cacheDir ? parent::getLogDir() : $cacheDir;
    }
}
