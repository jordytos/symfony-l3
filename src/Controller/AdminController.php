<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ContactRepository;
use App\Repository\OfferRepository;

use App\Repository\HomepageRepository;
use App\Entity\Homepage;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserAdminType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;



class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    /**
     * @Route("/admin/article", name="article_admin", methods={"GET"})
     */
    public function indexArticle(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/adminArticle.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/offer", name="Adminoffer_index", methods={"GET"})
     */
    public function indexOffer(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/indexAdmin.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }    


    /**
     * @Route("/admin/users", name="user_index", methods={"GET"})
     */
    public function indexUser(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    /**
     * @Route("/admin/users/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



    
}
