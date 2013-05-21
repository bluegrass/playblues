<?php

namespace Acme\DemoBundle\Menu;

use Bluegrass\Blues\Component\Menu\AbstractMenuManager;

class MenuManager extends AbstractMenuManager
{
    
    /**
     * @return \Bluegrass\Blues\Component\Menu\Menu
     */
    
    protected function buildMenu()
    {
        $menu = $this->buildMenuFromSitemap( true );
        return $menu;
    }    
}

