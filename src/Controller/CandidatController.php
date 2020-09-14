<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatController extends AbstractController
{
    /**
     * @Route("/", name="candidat")
     * 
     */
    public function index(Request $request,EntityManagerInterface $entityManager)
    {
         
        
        $candidat = new Candidat();
        
            $form = $this->createForm(CandidatType::class,$candidat);

                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()) {
                
                    $entityManager->persist($candidat);
                    $entityManager->flush();
                    return $this->redirectToRoute('candidat');
                }
                

                $candidats = $entityManager->getRepository(Candidat::class)->findAll();
        return $this->render('candidat/index.html.twig',[
            'formCandidat' => $form->createView(),
            'candidats' => $candidats
        ]);
    }
    
    /**
         * @Route("/{id}", name="delete")
         * 
         * @return Response
         */
        public function delete(Candidat $candidat)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidat);
            $entityManager->flush();

            
            return $this->redirectToRoute('candidat');
        }
}
