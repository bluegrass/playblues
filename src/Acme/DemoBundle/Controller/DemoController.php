<?php

namespace Acme\DemoBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bluegrass\Blues\Bundle\BluesBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


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
        $params = $this->get('router')->match('/demo/hello/colo');
        print_r( $params );            
        
        echo "<br>";
        echo "<br>";
        
        $sitemap = $this->get('acme.demo.sitemap.manager')->getSitemap();
        
        echo "SITEMAP<br>";
        
        $it = new \RecursiveIteratorIterator($sitemap->getIterator(), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ( $it as $node ) { 
            echo $node->getLabel() . " - ";
        }

        echo "<br>";
        */
        
        $currentMenuItem = $this->get('acme.demo.menu.manager')->getCurrentMenuItem( $this->getRequest() );
        if ( $currentMenuItem ){
            $currentMenuItem->setCurrent( true );
        }        
        $menu = $this->get('acme.demo.menu.manager')->getMenu();
        
        return array_merge( array( 'name' => $name, 'menu' => $menu ), $this->getDefaultViewParams() );       
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
