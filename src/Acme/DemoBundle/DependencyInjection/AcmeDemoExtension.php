<?php

namespace Acme\DemoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class AcmeDemoExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        /*
        $reflClass = new \ReflectionClass('Blues\Bridge\Twig\Extension\FormExtension');
        $container->getDefinition('twig.loader.filesystem')->addMethodCall('addPath', array(dirname(dirname($reflClass->getFileName())).'/Resources/views/Form'));
        */
    }

    public function getAlias()
    {
        return 'acme_demo';
    }
}
