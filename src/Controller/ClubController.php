<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Student;
use App\Form\ClubType;
use App\Form\StudentType;
use App\Repository\ClubRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addClub", name="addClub")
     */
    function Add(Request $request){
        $club=new Club();
        $form=$this->createForm(ClubType::class, $club);
        $form->add('Add',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("AfficherClub");

        }
        return $this->render('club/AddClub.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/AfficheClub", name="AfficherClub")
     */
    public function AfficheStudent(ClubRepository  $repo){
        $club=$repo->findAll();
        return $this->render('club/AfficheClub.html.twig', ['club'=>$club]);
    }


    /**
     * @Route ("club/maj/{id}", name="modify")
     */

    function Modify(ClubRepository $repo, $id, Request $request){
        $club=$repo->find($id);
        $form=$this->createForm(ClubType::class, $club);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherClub");
        }
        return $this->render('club/UpdateClub.html.twig', ['f'=>$form->createView()]);
    }


    /**
     * @Route ("/delete/{id}", name="delete")
     */
    function Delete($id, ClubRepository $repository){
        $club=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($club);
        //mettre a jour bd
        $em->flush();
        return $this->redirectToRoute('AfficherStudent');
    }
}
