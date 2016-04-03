<?php

namespace AppBundle\Controller\api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\listEmployees;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;


class apiPointsController extends Controller
{

    /**
     * @Route("api/specificUser", name="specificUser")
     */
    public function apiSpecificUser(){

        $user=$this->getDoctrine()
            ->getRepository("AppBundle:listEmployees")
            ->findOneBy(array('age'=>'20'));

        if (!$user) {
            throw $this->createNotFoundException(sprintf(
                'No user found with nickname "%s"', 0
            ));
        }

        $person=array(
            'name'=>$user->getName(),
            'surname'=>$user->getSurname(),
            'age'=>$user->getAge(),
        );

        $data = [
            'data' => $person
        ];

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');


        return $response;
    }


    /**
     * @Route("api/allUsers", name="apiAllUsers")
     */
    public function apiAllUsers(){

        $allUsers=$this->getDoctrine()
            ->getRepository("AppBundle:listEmployees")
            ->findAll();

        $data = array('all_requested_users' => array());

        foreach ($allUsers as $user) {
            $data['all_requested_users'][] = $this->serializeEmployees($user);
        }

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    //function to run the loop through all matches in doctrine request
    private function serializeEmployees(listEmployees $employee)
    {
        return array(
            'name' => $employee->getName(),
            'surname' => $employee->getSurname(),
            'age' => $employee->getAge(),
            'position' => $employee->getPosition(),
            'grade' => $employee->getGrade(),
            'gender' => $employee->getGender(),
            'salary' => $employee->getSalary(),
        );
    }



    /**
     * @Route("api/customUsers", name="apiCustomUsers")
     */
    public function apiCustomUsers(){
        $age= 30;
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:listEmployees');

        $query = $repository->createQueryBuilder('user')
            ->where('user.age > :age AND user.salary < :salary')
            ->setParameter('age', $age)
            ->setParameter('salary', 40000)
            ->orderBy('user.age', 'ASC')
            ->getQuery();

        $customUsers = $query->getResult();



        $data = array('all_requested_users' => array());

        foreach ($customUsers as $user) {
            $data['all_requested_users'][] = $this->serializeEmployees($user);
        }

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
