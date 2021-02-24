<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Souscription;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use App\Repository\SouscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;




/**
 * @Route("/offer")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);

    }

    /**
     * @Route("/new", name="offer_new", methods={"GET","POST"})
     */
    public function new(Request $request,SluggerInterface $slugger): Response
    {


        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                
               
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

               
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

               
                $offer->setImage($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     */
    public function show(Offer $offer, OfferRepository $offerRepository): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
            'offers' => $offerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offer $offer,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                
               
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

               
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

               
                $offer->setImage($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_index');
    }


    /**
     * @Route("souscription/{id}", name="subscribe_to_offer", methods={"GET","POST"})
     */
    public function subscribeToOffer(Offer $offer, SouscriptionRepository $souscriptionRepository)
    {

        $user = $this->getUser();

        $souscriptionListe = $souscriptionRepository->findAll();

        if ($user) {

            if (($user->getTelephone() && $user->getNumSecu() && $user->getVille() && $user->getCodePostal() && $user->getPays()) != null) {

                $verif = false;
                foreach ($souscriptionListe as $souscriptions) {
                    if (($user->getId() == $souscriptions->getRelationUserSouscrip()->getId()) && ($offer->getId() == $souscriptions->getRelation()->getId())) {
                        $this->addFlash(
                            'success',
                            'Vous ne pouvez pas souscrire deux fois à la même offre'
                        );

                        $verif = true;
                        return $this->redirectToRoute('offer_show', ['id' => $offer->getId()]);
                        break;
                    }
                }

                if (!$verif) {
                    $souscrip = new Souscription($user, $offer);
                    $entityManager = $this->getDoctrine()->getManager();

                    $user->addRelation($souscrip);

                    $offer->addRelationSouscripOffer($souscrip);


                    $entityManager->persist($user);
                    $entityManager->persist($offer);
                    $entityManager->persist($souscrip);
                    $entityManager->flush();

                    $this->addFlash(
                        'success',
                        'Votre demande de souscription a bien été prise en compte, nous la traiterons dans les plus brefs délai'
                    );
                    return $this->redirectToRoute('offer_show', ['id' => $offer->getId()]);
                }
            } else {
                $this->addFlash('success', 'Vous devez saisir les informations obligatoires afin de souscrire à une offre : Tél - Num sécu - Code Postal');

                return $this->redirectToRoute('offer_show', ['id' => $offer->getId()]);
            }
        } else {
            $this->addFlash(
                'success',
                'Vous devez vous connecter afin de souscrire à une offre'
            );

            return $this->redirectToRoute('app_login');
        }
    }

}
