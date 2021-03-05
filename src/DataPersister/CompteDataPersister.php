<?php

namespace App\DataPersister;



use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Compte;
use App\Repository\CompteRepository;
use App\Services\ServiceTransaction;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;


class CompteDataPersister implements DataPersisterInterface
{
    Private $entityManager;
    private $security;
    private $frais;
    private $requestStack;
    private $compteRepository;

    /**
     *
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     * @param ServiceTransaction $frais
     * @param RequestStack $requestStack
     * @param CompteRepository $compteRepository
     */



    public function __construct(EntityManagerInterface $entityManager,
                                Security $security,
                                ServiceTransaction $frais,
                                RequestStack $requestStack,
                                 CompteRepository $compteRepository){
        $this->entityManager=$entityManager;
        $this->security=$security;
        $this->frais=$frais;
        $this->requestStack=$requestStack;
        $this->compteRepository=$compteRepository;
    }

    public function supports($data): bool
    {
        return $data instanceof Compte;
    }

    public function persist($data,array $context = [])
    {
        if ($context["item_operation_name"]=== "Recharge_Compte"){
            $soldeCompte= json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
            $data->setSolde($data->getSolde()+$soldeCompte['solde']);
            $data->setCreatAt(new \DateTime('now'));
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            return new JsonResponse('success',500);
        }

        else{
         $data->setSolde(700000);
        if ($data->getSolde() < 700000){
            return new JsonResponse('le Compte doit etre initialisé au moins 700000 FCFA',500);
        }

        $data->setCode($this->frais->generteCode());
        $data->setCreatAt(new \DateTime('now'));
        $data->setUsers($this->security->getUser());
        $data->setArchivage(0);
        $this->entityManager->persist($data);
        $this->entityManager->flush();

       }

    }

    public function remove($data,array $context = [])
    {
        $data->setArchivage(1);
        $agence = $data->getAgences();
        $agence->setArchivage(1);
        $userAgence= $data->getUser();
        foreach ($userAgence as $value){
            $value->setArchivage(1);
            $this->entityManager->persist($value);
        }
        $this->entityManager->persist($data);
        $this->entityManager->persist($userAgence);
        $this->entityManager->flush();

    }
}
