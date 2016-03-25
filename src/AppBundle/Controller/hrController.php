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

    /**
     * @Route("/list/{id}", name="details", requirements={"id": "\d+"}
     *     )
     */
    public function detailAction($id)
    {
        $employee=$this->getDoctrine()
            ->getRepository("AppBundle:listEmployees")
            ->find($id);


        return $this->render('hr_tool_partials\details.html.twig', array('employee'=>$employee));
    }


    /**
     * @Route("list/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $employee = $em->getRepository('AppBundle:listEmployees')->find($id);

        $em->remove($employee);
        $em->flush();

        return $this->redirectToRoute('list');
    }
}
