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
        $sitemap = new Sitemap( "H-1", "Home", new RouteBasedLocation("comprasRoute") );
        
        $m1 = $sitemap->getRoot()->addChild( new Node("GDM-1", "Gestión de Datos Maestros", new RouteBasedLocation("comprasRoute") ) );
        $m1->addChild( new Node( "GDM-1-1","Productos", new RouteBasedLocation("comprasXFRoute") ) );
        
        $m2 = $sitemap->getRoot()->addChild( new Node("COMPRAS-1","Gestión de Compras", new RouteBasedLocation("_demo_hello", array( 'name' => 'colo' ) ) ));
        $m2->addChild( new Node( "COMPRAS-1-1","Pedido de Compras", new RouteBasedLocation("comprasXFRoute") ) );
        
        $m3 = $sitemap->getRoot()->addChild( new Node("VENTAS-1","Gestión de Ventas", new RouteBasedLocation("_demo_hello", array( 'name' => 'colo' ) ), true ) );
        $m3->addChild( new Node("VENTAS-1-1","Facturar", null , true ) );
        
        return $sitemap;
    }    
}

