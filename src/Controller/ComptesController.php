<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ComptesController extends AbstractController
{
    private $security;
    private $entityManager;

    public  function __construct(Security $security,
                                 EntityManagerInterface $entityManager)
    {
        $this->security=$security;
        $this->entityManager=$entityManager;
    }

    /**
     * @Route(
     *    path= "/api/adminagence/compte",
     *    methods={"GET"},
     *    name="comptes")
     */
    public function getSoldes(): Response
    {
         $user = $this->security->getUser();
         $agence = $user->getAgence();
         $solde = $agence->getCompte()->getSolde();
        // dd($solde);
        return new JsonResponse($solde);

    }
}
