<?php


namespace App\Controller;


use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




/**
 * @Route("/mon-espace-agent")
 */
class AgentController extends AbstractController
{

    /**
     * @Route("/", name="user_agent", methods={"GET","POST"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Créer un formulaire lié à ce utilisateur
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('espace-agent/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


}