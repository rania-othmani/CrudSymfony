<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use App\Repository\ClubRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    /**
     * @param ClubRepository $repository
     * @return Response
     * @Route ("/AfficheC", name="Afficher")
     */
    public function Affiche(ClassroomRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $classroom=$repository->findAll();
        return $this->render('classroom/Affiche.html.twig', ['classroom'=>$classroom]);
    }


    /**
     * @Route ("/Spprimer/{id}", name="d")
     */
    function Delete($id, ClassroomRepository $repository){
        $classroom=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($classroom);
        //mettre a jour bd
        $em->flush();
        return $this->redirectToRoute('Afficher');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("classroom/Add")
     */
    function Add(Request $request){
        $classroom=new Classroom();
        $form=$this->createForm(ClassroomType::class, $classroom);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
        }
        return $this->render('classroom/Add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route ("classroom/modify/{id}", name="m")
     */

    function Modify(ClassroomRepository $repo, $id, Request $request){
        $classroom=$repo->find($id);
        $form=$this->createForm(ClassroomType::class, $classroom);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("Afficher");
        }
        return $this->render('classroom/Update.html.twig', ['f'=>$form->createView()]);
    }
}
