<?php

namespace App\DataPersister;



use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Transactions;
use App\Repository\TransactionsRepository;
use App\Services\ServiceTransaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;


class TransactionDataPersister implements DataPersisterInterface
{
    Private $entityManager;
    private $security;
    private $frais;
    private $transactionsRepository;
    private $requestStack;



    public function __construct(EntityManagerInterface $entityManager,
                                 Security $security, ServiceTransaction $frais,
                                 TransactionsRepository $transactionsRepository,
                                  RequestStack $requestStack){
        $this->entityManager=$entityManager;
        $this->security=$security;
        $this->frais=$frais;
        $this->transactionsRepository=$transactionsRepository;
        $this->requestStack=$requestStack;

    }

    public function supports($data): bool
    {
        return $data instanceof Transactions;
    }

    public function persist($data,array $context = [])
    {

        if(isset($context['collection_operation_name'])){
           // dd($context);

           $frais= $this->frais->getFrais($data->getMontant());

           $partEtat = ($frais * 40) / 100;
           $partEntreprise = ($frais * 30) / 100;
           $partAgentDepot = ($frais * 10) / 100;
           $partAgentRetrait = ($frais * 20) / 100;


               $data->setPartEtat($partEtat);
               $data->setCode($this->frais->createCode());
               $data->setDateDepot(new \DateTime('now'));
               $data->setPartEntreprise($partEntreprise);
               $data->setPartAgentDepot($partAgentDepot);
               $data->setPartAgentRetrait($partAgentRetrait);
               $user= $this->security->getUser();
               $data->setUserDepot($user);
               $compte= $user->getAgence()->getCompte();
             // dd($compte);
               $compte->setSolde($compte->getSolde()-$data->getMontant());
               $data->setCompteDepot($compte);
               //dd($data);
               $this->entityManager->persist($data);
               $this->frais->envoieSms($data->getMontant(), $data->getClients()->getNomClient(),$data->getCode());
               $this->entityManager->flush();


        }
            return  ($data);

    }

    public function remove($data,array $context = [])
    {
        $data->setArchivage(1);
        $this->entityManager->flush();
        return $data;
    }
}
