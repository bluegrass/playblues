<?php

namespace Acme\DemoBundle\Menu;

use Bluegrass\Blues\Component\Menu\MenuItem;
use Bluegrass\Blues\Component\Menu\AbstractMenuManager;
use Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface;

class MenuManager extends AbstractMenuManager
{
    protected function buildMenu()
    {
        /*
        $menu = new MenuItem( "main", "Menu principal" );
        $menu->addChild("m1", "Item 1 de Menú principal");
        $menu->addChild("m2", "Item 2 de Menú principal");
        $menu->addChild("m3", "Item 3 de Menú principal");
         */
        $menu = $this->buildMenuFromSitemap();
        return $menu;
    }    
}

