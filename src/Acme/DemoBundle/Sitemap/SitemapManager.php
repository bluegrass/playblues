<?php

namespace Acme\DemoBundle\Sitemap;

use Bluegrass\Blues\Component\Sitemap\Sitemap;
use Bluegrass\Blues\Component\Sitemap\AbstractSitemapManager;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

use Bluegrass\Blues\Component\Sitemap\Node;

class SitemapManager extends AbstractSitemapManager
{
    protected function buildSitemap()
    {
        $sitemap = new Sitemap( "Home" );
        
        $m1 = $sitemap->getRoot()->addChild( new Node("Gestión de Datos Maestros", new RouteBasedLocation("comprasRoute") ) );
        $m1->addChild( new Node( "Productos", new RouteBasedLocation("comprasXFRoute") ) );
        
        $m2 = $sitemap->getRoot()->addChild( new Node("Gestión de Compras", new RouteBasedLocation("_demo_hello", array( 'name' => 'colo' ) ) ));
        $m2->addChild( new Node( "Pedido de Compras", new RouteBasedLocation("comprasXFRoute") ) );
        
        $m3 = $sitemap->getRoot()->addChild( new Node("Gestión de Ventas", null, false) );
        $m3->addChild( new Node("Facturar", new RouteBasedLocation("comprasXFRoute") ) );
        return $sitemap;
    }    
}

