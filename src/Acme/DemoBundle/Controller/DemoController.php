<?php

namespace Acme\DemoBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bluegrass\Blues\Bundle\BluesBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

use Bluegrass\Blues\Component\Widgets\FilterableMenu\FilterableMenuWidget;
use Bluegrass\Blues\Component\Widgets\FilterableMenu\Model\FilterableMenuWidgetModel;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as AnnotationRoute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Generator\UrlGenerator;

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

    /**
     * @AnnotationRoute("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {   
/*
        $baseUrl = $this->get('router')->getContext()->getBaseUrl();
        
        $url = 'http://localhost/playblues/web/app_dev.php/demo/hello/colo';
        
        $urlRelativa = substr($url,  strpos( $url, $baseUrl ) + strlen( $baseUrl ));
        
        $params = $this->get('router')->match( $urlRelativa );        
        print_r( $params );
 */
        //$this->forward('bluegrass.blues.filterable_menu.controller:filterAction', array());
        
        $menu = $this->get('acme.demo.menu.manager')->getMenu();
        
        $filterableMenuWidget = new FilterableMenuWidget( new FilterableMenuWidgetModel( $menu ) );        
        
        return array_merge( array( 
                                                    'name' => $name, 
                                                    'filterableMenuWidget' => $filterableMenuWidget->buildView(),
                                            ), $this->getDefaultViewParams() );       
    }

    /**
     * @AnnotationRoute("/goodbye", name="_demo_goodbye")
     * @Template()
     */
    public function goodbyeAction()
    {
        die ( $this->getViewState()->get("lycho") );
    }
    
    /**
     * @AnnotationRoute("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }
}
