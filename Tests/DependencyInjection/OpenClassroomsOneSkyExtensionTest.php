<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\DependencyInjection;

use OpenClassrooms\Bundle\OneSkyBundle\OpenClassroomsOneSkyBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsOneSkyExtensionTest extends \PHPUnit\Framework\TestCase
{
    public function testContainerCompile()
    {
        $container = new ContainerBuilder();
        $bundle = new OpenClassroomsOneSkyBundle();
        $container->registerExtension($bundle->getContainerExtension());
        $container->loadFromExtension('openclassrooms_onesky');

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Fixtures/Resources/config'));
        $loader->load('config.yml');

        $bundle->build($container);

        $container->setParameter('kernel.root_dir', __DIR__.'/../../');
        $container->compile();
        $this->assertTrue($container->isFrozen());
    }
}
