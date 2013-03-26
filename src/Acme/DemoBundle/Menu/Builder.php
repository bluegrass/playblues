<?php

namespace Acme\DemoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array(
            'route' => '_demo_hello', 
            'routeParameters' => array('name' => 'colo')
        ));
        $menu->addChild('About Me', array(
            'route' => '_demo_goodbye',
            'routeParameters' => array('id' => 42)
        ));
        // ... add more children

        return $menu;
    }
}