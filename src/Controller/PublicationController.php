<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Repository\PublicationRepository;

class PublicationController extends AbstractController
{
    /**
     * @Route("/newvote", name="addvote")
     */
    public function addvote(PublicationRepository $PublicationRepository,Request $request): Response
    {
        $pub = $PublicationRepository->find($request->query->get('id'));
        $vote = $request->query->get('rating') ;
        $rating =($pub->getVote()+$vote)/2;
        $pub->setVote($rating);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pub);
        $entityManager->flush();
        return $this->redirectToRoute('publication');

        
    }
    /**
     * @Route("/publication", name="publication")
     */
    public function index(PublicationRepository $PublicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'Publications' => $PublicationRepository->findAll(),
        ]);
    }
    
}
