<?php

namespace OxErpTest;

use OxErpTest\Container\CompilerPass\CommandCollectorCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class Container
{
    /**
     * @var ContainerInterface;
     */
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return ContainerInterface
     */
    public static function Instance()
    {
        if (static::$instance === null) {
            static::$instance = self::initializeContainer();
        }

        return static::$instance;
    }

    /**
     * @return ContainerBuilder
     */
    public static function initializeContainer()
    {
        $container = new ContainerBuilder();

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.xml');

        $container->addCompilerPass(new CommandCollectorCompilerPass());
        $container->compile();

        return $container;
    }

    private function __clone()
    {
    }
}
