<?php

namespace testBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\listEmployees;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use testBundle\Form\formType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('testBundle:Default:index.html.twig');
    }

    public function testAction(Request $request)
    {
        $person=new listEmployees;

        $form = $this->createForm(formType::class, $person);

       /*$form=$this->createFormBuilder($person)
            ->add ('name',TextType::class)
            ->add ('age',NumberType::class)
            ->add ('save',SubmitType::class)
            ->getForm()
        ;*/

        $form->handleRequest($request);

        if ($form->isValid()){
            return $this->redirect($this->generateUrl('test_homepage'));
        }

        return $this->render('hr_tool_partials\test.twig', array('form'=>$form->createView()));
    }
}
