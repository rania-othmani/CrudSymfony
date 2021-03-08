<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addStudent", name="addStudent")
     */
    function Add(Request $request){
        $student=new Student();
        $form=$this->createForm(StudentType::class, $student);
        $form->add('Add',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("AfficherStudent");

        }
        return $this->render('student/AddStudent.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/AfficheS", name="AfficherStudent")
     */
    public function AfficheStudent(StudentRepository  $repo){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $student=$repo->findAll();
        return $this->render('student/AfficheS.html.twig', ['student'=>$student]);
    }


    /**
     * @Route ("student/maj/{id}", name="modify")
     */

    function Modify(StudentRepository $repo, $id, Request $request){
        $student=$repo->find($id);
        $form=$this->createForm(StudentType::class, $student);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherStudent");
        }
        return $this->render('student/MAJ.html.twig', ['f'=>$form->createView()]);
    }


    /**
     * @Route ("/delete/{id}", name="delete")
     */
    function Delete($id, StudentRepository $repository){
        $student=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($student);
        //mettre a jour bd
        $em->flush();
        return $this->redirectToRoute('AfficherStudent');
    }
}
