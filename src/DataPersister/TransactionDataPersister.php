<?php

namespace App\DataPersister;



use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Transactions;
use App\Repository\TransactionsRepository;
use App\Services\ServiceTransaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;


class TransactionDataPersister implements DataPersisterInterface
{
    Private $entityManager;
    private $security;
    private $compteRepository;
    private $frais;
    private $transactionsRepository;


    public function __construct(EntityManagerInterface $entityManager,
                                Security $security, ServiceTransaction $frais,
                                CompteDataPersister $compteRepository,
                                 TransactionsRepository $transactionsRepository){
        $this->entityManager=$entityManager;
        $this->security=$security;
        $this->compteRepository=$compteRepository;
        $this->frais=$frais;
        $this->transactionsRepository=$transactionsRepository;
    }

    public function supports($data): bool
    {
        return $data instanceof Transactions;
    }

    public function persist($data,array $context = [])
    {
      /* if ($context['collection_operation_name']=== 'Recharge-Compte') {
            $compte = $data->getComptes();

           $compte->setSold($compte->getSold() + $data->getMontant());
          // dd($compte->setSold($compte->getSold() + $data->getMontant()));
           $data->setCreatAt(new \DateTime('now'));
           $data->setTypeTransaction('depot');
           $data->setUsers($this->security->getUser());

           $this->entityManager->persist($data);
           $this->entityManager->persist($compte);
           $this->entityManager->flush();
       }*/
       if ($context['collection_operation_name']=== 'Transfert-Client')
       {
          $frais= $this->frais->getFrais($data->getMontant());

           $partEtat = ($frais * 40) / 100;
           $partEntreprise = ($frais * 30) / 100;
           $partAgentDepot = ($frais * 10) / 100;
           $partAgentRetrait = ($frais * 20) / 100;

           if ($data->getTypeTransaction()==='depot')
           {
              // $client= $data->getClients();
               $data->setPartEtat($partEtat);

               $data->setCode($this->frais->createCode());
             //  $data->setClients($data->getClients());
               $data->setCreatAt(new \DateTime('now'));
               $data->setPartEntreprise($partEntreprise);
               $data->setPartAgentDepot($partAgentDepot);
               $data->setPartAgentRetrait($partAgentRetrait);
               $data->setUsers($this->security->getUser());
               //dd($data);
               $this->entityManager->persist($data);
              // $this->entityManager->persist($client);
               $this->entityManager->flush();

           }
       }else{

           if ($data->getTypeTransaction()==='retrait')
           {
              // dd($context);
               $code= $data->getCode($this->frais->createCode());
        // dd($code);
               $tranSation= $this->transactionsRepository->findOneBy(['code'=>$code]);
              //dd($tranSation);
               $client= $tranSation->getClients();
               $client->setCNIBeneficiaire($data->setClient()->getCNIBeneficiaire());
               if ($code){
                   $transations= new Transactions();
                   $transations->setUsers($this->security->getUser());
                   $transations->setCode($code);
                   $transations->setMontant($tranSation->getMontant());
                   $transations->setCreatAt($tranSation->getCreatAt());
                   $transations->setTypeTransaction('retrait');
                 //  dd($tranSation);
                   $transations->setPartEntreprise($tranSation->getPartEntreprise());
                   $transations->setPartAgentDepot($tranSation->getPartAgentDepot());
                   $transations->setPartAgentRetrait($tranSation->getPartAgentRetrait());
                   $transations->setPartEtat($tranSation->getPartEtat());
                   $transations->setClients($tranSation->getClients());
                   $transations->setCreatAt(new \DateTime('now'));
                   $this->entityManager->persist($client);
                   $this->entityManager->persist($transations);
               }
           }
           $this->entityManager->flush();
       }
    }

    public function remove($data,array $context = [])
    {
        $data->setArchivage(1);
        $this->entityManager->flush();
        return $data;
    }
}
