<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class hrController extends Controller
{
    /**
     * @Route("/list", name="list")
     */
    public function listAction()
    {

        $employees=$this->getDoctrine()
            ->getRepository("AppBundle:listEmployees")
            ->findAll();


        return $this->render('hr_tool_partials\list.html.twig', array('employees'=>$employees));
    }
}
