<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\listEmployees;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
     * @Route("/home", name="home")
     */
    public function homeAction()
    {

        $products = [
            ['id' => 1, 'category' => 'Real Estate', 'img' => '../Resources/img/products/img-add-real-estate.png', 'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.' ],
            ['id' => 2, 'category' => 'Business', 'img' => '../Resources/img/products/img-add-business.png', 'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'],
            ['id' => 3, 'category' => 'Family', 'img' => '../Resources/img/products/img-add-family.png','description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'],
            ['id' => 4, 'category' => 'Civil issues', 'img' => '../Resources/img/products/img-add-rent.png','description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'],
            ['id' => 5, 'category' => 'Charity', 'img' => '../Resources/img/products/img-add-charity.png','description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'],
            ['id' => 6, 'category' => 'Savings', 'img' => '../Resources/img/products/img-add-save.png','description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.'],
        ];

        return $this->render('hr_tool_partials\home.html.twig', array('products'=>$products));
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


    /**
     * @Route("list/create", name="create_employee")
     */
    public function createAction(Request $request)
    {
        $employee= new listEmployees;

        $form=$this->createFormBuilder($employee)
            ->add('name', TextType::class, array('attr'=>array('class'=>'f_text_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('surname', TextType::class, array('attr'=>array('class'=>'f_text_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('position', TextType::class, array('attr'=>array('class'=>'f_text_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('age', NumberType::class, array('attr'=>array('class'=>'f_number_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('salary', NumberType::class, array('attr'=>array('class'=>'f_number_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('gender', ChoiceType::class, array('choices'=>array('M'=>'M','W'=>'W','No answer'=>'No answer'),'attr'=>array('class'=>'f_text_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('grade', ChoiceType::class, array('choices'=>array('A'=>'A','B'=>'B','C'=>'C','Dismiss ASAP'=>'Dismiss ASAP'),'attr'=>array('class'=>'f_text_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('assessment', TextareaType::class, array('attr'=>array('class'=>'f_text_fields','style'=>'margin-bottom:10px; display:block')))
            ->add('Submit', SubmitType::class, array('attr'=>array('class'=>'f_text_fields','style'=>'margin:10px;','label'=>'Submit form')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){

            $name=$form['name']->getData();
            $surname=$form['surname']->getData();
            $age=$form['age']->getData();
            $position=$form['position']->getData();
            $salary=$form['salary']->getData();
            $gender=$form['gender']->getData();
            $grade=$form['grade']->getData();
            $assessment=$form['assessment']->getData();

            $employee->setName($name);
            $employee->setSurname($surname);
            $employee->setAge($age);
            $employee->setSalary($salary);
            $employee->setGender($gender);
            $employee->setGrade($grade);
            $employee->setPosition($position);
            $employee->setAssessment($assessment);

            $em=$this->getDoctrine()->getManager();

            $em->persist($employee);
            $em->flush();

            $this->addFlash(
                'notice',
                'employee Added!'
            );

            return $this->redirectToRoute('list');
        }

        return $this->render('hr_tool_partials\create_new_employee.html.twig', array('employee_form'=>$form->createView()) );
    }
}
