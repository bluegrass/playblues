<?php

namespace Acme\DemoBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bluegrass\Blues\Bundle\BluesBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as AnnotationRoute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;

use Bluegrass\Blues\Component\Widget\FilterableMenu\Model\FilterableMenuWidgetModel;

use Bluegrass\Blues\Component\DataSource\ArrayDataSource;

class DemoController extends Controller
{
    /**
     * @AnnotationRoute("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    protected function getDummyData()
    {
        return [
                            [ 'currency' => 'Dolar', 'quote' => 5.36, 'updatedAt' =>new \DateTime("2013-06-25") ],
                            [ 'currency' => 'Dolar', 'quote' => 5.37, 'updatedAt' =>new \DateTime("2013-06-25") ],
                            [ 'currency' => 'Euro', 'quote' => 7.15, 'updatedAt' =>new \DateTime("2013-06-24") ],
                            [ 'currency' => 'Real', 'quote' => 260, 'updatedAt' =>new \DateTime("2013-06-20") ],                           
                            [ 'currency' => 'Euro', 'quote' => 7.15, 'updatedAt' =>new \DateTime("2013-06-24") ],
                            [ 'currency' => 'Real', 'quote' => 260, 'updatedAt' =>new \DateTime("2013-06-20") ],
                            [ 'currency' => 'Dolar', 'quote' => 5.38, 'updatedAt' =>new \DateTime("2013-06-25") ],
                            [ 'currency' => 'Euro', 'quote' => 7.15, 'updatedAt' =>new \DateTime("2013-06-24") ],
                            [ 'currency' => 'Real', 'quote' => 260, 'updatedAt' =>new \DateTime("2013-06-20") ],
                            [ 'currency' => 'Dolar', 'quote' => 5.39, 'updatedAt' =>new \DateTime("2013-06-25") ],
                            [ 'currency' => 'Euro', 'quote' => 7.15, 'updatedAt' =>new \DateTime("2013-06-24") ],
                            [ 'currency' => 'Real', 'quote' => 260, 'updatedAt' =>new \DateTime("2013-06-20") ],
                            [ 'currency' => 'Dolar', 'quote' => 5.40, 'updatedAt' =>new \DateTime("2013-06-25") ],
                            [ 'currency' => 'Euro', 'quote' => 7.15, 'updatedAt' =>new \DateTime("2013-06-24") ],
                            [ 'currency' => 'Lev', 'quote' => 10, 'updatedAt' =>new \DateTime("2013-07-06") ]            
                        ];

    }
    
    protected function getGridWidget()
    {
        $data = $this->getDummyData();
        
        //$gridWidget = $this->get('bluegrass.widget.grid.builder')
        $gridWidget = $this->get('bluegrass.widget.ajaxgrid.builder')
                                            ->withDataAjaxRequestRoute( new RouteBasedLocation( '_grid_ajax', array() ) )
                                            ->withDataSource( new ArrayDataSource( $data ) )
                                            ->addColumn( 'string', function ( $builder ) {
                                                    $builder->setName("currency")
                                                                    ->setLabel("Moneda");        
                                            } )
                                            ->addColumn( 'money', function ( $builder ) {
                                                    $builder->setName("quote")
                                                                    ->setLabel("Cotización");        
                                            } )
                                            ->addColumn( 'date', function ( $builder ) {
                                                    $builder->setName("updatedAt")
                                                                    ->setLabel("Última Actualización");        
                                            } )
                                            ->build();
            return $gridWidget;        
    }

    /**
     * @AnnotationRoute("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {           
        $menu = $this->get('acme.demo.menu.manager')->getMenu();
        
        $filterableMenuWidget = $this->get('bluegrass.widget.filterablemenu.builder')
                                                            ->withModel( new FilterableMenuWidgetModel( $menu->getIterator() ) )
                                                            ->build();

        $gridWidget = $this->getGridWidget();

        return array_merge( array( 
                                                    'name' => $name, 
                                                    'filterableMenuWidget' => $filterableMenuWidget->buildViewModel(),
                                                    'gridWidget' => $gridWidget->buildViewModel()
                                            ), $this->getDefaultViewParams() );       
    }

    /**
     * @AnnotationRoute("/gridAjax/", name="_grid_ajax")
     */
    public function gridAjaxAction()
    {    
        $page = $this->getRequest()->get('page');        
        $sortValues = $this->getRequest()->get( 'sort', array() );        
                
        $gridWidget = $this->getGridWidget();        
        
        foreach ( $sortValues as $sortValue ){

            $field = $sortValue['field'];
            if( $sortValue['dir'] == 'asc'  ){
                $dir = SORT_ASC;
            }else{
                $dir = SORT_DESC;
            }
            
           $gridWidget->addOrderBy( $field,  $dir ); 
        }
        
        $gridWidget->setPage( $page );
        
        /**
         * @todo Ver de migrar este metodo a otro action, posiblemente de ABM. Idem con AcmeDemoBundle:Demo:gridAjax.html.twig
         */        
        
        return $this->render( 'AcmeDemoBundle:Demo:gridAjax.html.twig', array('ajaxGridWidgetContent' => $gridWidget->buildContentViewModel()) );
    }   
}

