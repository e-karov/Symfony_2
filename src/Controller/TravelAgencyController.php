<?php

namespace App\Controller;

use App\Entity\Travel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TravelAgencyController extends AbstractController
{
    #[Route(['/', '/home'], name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $travelsArr = $doctrine
            ->getRepository(Travel::class)
            ->findAll();
            if (!$travelsArr) {
                throw $this->createNotFoundException('No travels found');
            } else {
                return $this->render('travel_agency/index.html.twig', ['travels'=>$travelsArr]);
            }

        return $this->render('travel_agency/index.html.twig', [
            'controller_name' => 'TravelAgencyController',
        ]);
    }

    #[Route('/contactForm', name:'contact_form')]
    public function contactForm(): Response
    {
        return $this->render('travel_agency/contactForm.html.twig');
    }

    #[Route('/about', name:'about_page')]
    public function aboutPage(): Response
    {
        return $this->render('travel_agency/about.html.twig');
    }

    #[Route('/news', name:'news_page')]
    public function newsPage(): Response
    {
        return $this->render('travel_agency/news.html.twig');
    }

    #[Route('/create', name:'create_action')]
    public function createAction(ManagerRegistry $doctrine): Response
    {

        $em = $doctrine->getManager();
        $travel = new Travel();
        $travel->setDestination("Venice");
        $travel->setDate('01.05.2023');
        $travel->setDuration('four days');
        $travel->setPrice(3300.00);

        $em->persist($travel);
        $em->flush();

        return new Response('Saved new travel with id '.$travel->getId());

    }
}
