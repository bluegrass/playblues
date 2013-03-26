<?php

namespace Acme\DemoBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bluegrass\Blues\Bundle\BluesBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        /*
        $locations = array();
        
        $locations[] = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $locations[] = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $locations[] = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        
        foreach( $locations as $location ){

            echo "PATH : " . $location->getPath() . " <br> ";

            echo "QUERYSTRING : ";  
            print_r( $location->getParameters() );
            echo " <br> ";
            
            echo "URL : " . $location->getUrl() . " <br> ";
            
        }
           */     
        /*
        $this->addBreadcrumbItem("Hello", new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation( '_demo_hello', array('name' => 'colo') ) );
        $this->addBreadcrumbItem("Goodbye", new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation( '_demo_goodbye' ) );
           */             
        //return array_merge( array('name' => $name, 'breadcrumb' => $this->getBreadcrumb()->createView()), $this->getDefaultViewParams() );       
        
        return array_merge( array('name' => $name ), $this->getDefaultViewParams() );       
    }

    /**
     * @Route("/goodbye", name="_demo_goodbye")
     * @Template()
     */
    public function goodbyeAction()
    {
        die ( $this->getViewState()->get("lycho") );
    }
    
    /**
     * @Route("/contact", name="_demo_contact")
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
