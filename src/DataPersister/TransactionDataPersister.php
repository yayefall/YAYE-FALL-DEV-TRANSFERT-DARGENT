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
    private $compteRepository;
    private $frais;
    private $transactionsRepository;
    private $requestStack;


    public function __construct(EntityManagerInterface $entityManager,
                                Security $security, ServiceTransaction $frais,
                                CompteDataPersister $compteRepository,
                                 TransactionsRepository $transactionsRepository,
                                  RequestStack $requestStack){
        $this->entityManager=$entityManager;
        $this->security=$security;
        $this->compteRepository=$compteRepository;
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
               $compte->setSolde($compte->getSolde()-$data->getMontant());
               $data->setComptes($compte);
               $this->entityManager->persist($data);
               $this->entityManager->flush();

        }
       if(isset($context['item_operation_name'])){
           $code= json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
           $transaction= $this->transactionsRepository->findOneBy(['code'=>$code['code']]);
           if ($transaction){
               if ($data->getDateRetrait() ==null){
                   $data->setDateRetrait(new \DateTime('now'));
                   $data->setUserRetrait($this->security->getUser());
                   $client= $data->getClients();
                   $client->setCNIBeneficiaire($code['CNIBeneficiaire']);
                   $user= $this->security->getUser();
                   $compte= $user->getAgence()->getCompte();
                   $compte->setSolde($compte->getSolde()+$data->getMontant());
                   $this->entityManager->persist($data);
                   $this->entityManager->flush();
               }

           }else{
               return new JsonResponse("le Code n'est pas conforme, Veuillez saisir le bon code ",500);
           }

       }
    }

    public function remove($data,array $context = [])
    {
        $data->setArchivage(1);
        $this->entityManager->flush();
        return $data;
    }
}
