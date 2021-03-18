<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\TransactionsRepository;
use App\Entity\BlocTransaction;
use App\Services\ServiceTransaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TransactionsController extends AbstractController
{
    Private $entityManager;
    private $security;
    private $transactionsRepository;
    private $requestStack;
    private $frais;

    public function __construct(EntityManagerInterface $entityManager,
                                Security $security,
                                TransactionsRepository $transactionsRepository,
                                RequestStack $requestStack,
                                 ServiceTransaction $frais)
    {
        $this->entityManager=$entityManager;
        $this->security=$security;
        $this->transactionsRepository=$transactionsRepository;
        $this->requestStack=$requestStack;
        $this->frais=$frais;
    }

 // Fonction de Retrait de Transactions

    /**
     * @Route("/api/transactions/retrait_client",
     * name="retrait",
     * methods={"PUT"}
     *     )
     *
     *
     */
    public function putTrans(): Response
    {
        $code= json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
       // dd($code);
        $transaction= $this->transactionsRepository->findOneBy(['code'=>$code['code']]);
       // dd($transaction);
        if ($transaction){
            if ($transaction->getDateRetrait() ==null){
                $transaction->setDateRetrait(new \DateTime('now'));
                $transaction->setUserRetrait($this->security->getUser());
                $client= $transaction->getClients();
               // dd($client);
                $client->setCNIBeneficiaire($code['CNIBeneficiaire']);
                $user= $this->security->getUser();
                $compte= $user->getAgence()->getCompte();
                $transaction->setCompteRetrait($compte);
                $compte->setSolde($compte->getSolde()+$transaction->getMontant());
              //  dd($transaction);
                $this->entityManager->flush();

            }
        }else{
            return new JsonResponse("le Code n'est pas conforme, Veuillez saisir le bon code ",500);
        }
        return  $this->json('retrait avec succes');
    }

    // Fonction de Recuperations des clients

    /**
     * @Route("/api/transactions/client",
     * methods={"POST"}
     *     )
     *
     * @param Request $request
     * @return Response
     */

    public function getClient( Request $request): Response
    {
      $code = json_decode($request->getContent(), true);
       // dd($code);
        $transaction = $this->transactionsRepository->findOneBy(['code' => $code['code']]);
        //dd($transaction);
        if ($transaction)
        {
            if ($transaction->getDateRetrait() == null)
            {
                return $this->json($transaction, 200, [], ['groups'=> 'client']);

            }
        }
        return $this->json('Ce code nexiste pas' );
    }


// Fonction de l'annulations de Transactions

    /**
     * @Route("/api/transactions/annuler",
     * methods={"POST"}
     *     )
     *
     * @param Request $request
     * @return Response
     */

        public function deleteTrans (Request $request): Response
        {

            $code = json_decode($request->getContent(), true);
            $transaction= $this->transactionsRepository->findOneBy(['code'=>$code['code']]);
          //  dd($transaction);
            if ($transaction){
                if ($transaction->getDateRetrait() == null)
                {
                    $users = $transaction->getClients();
                    $montant = $transaction->getMontant();
                    $dateDepot = $transaction->getDateDepot();
                    $codes =  $transaction->getCode();
                    $compte = $transaction->getCompteDepot();
                    $partEtat = $transaction->getPartEtat();
                    $partEntreprise = $transaction->getPartEntreprise();
                    $partDepot = $transaction->getPartAgentDepot();
                    $partRetrait = $transaction->getPartAgentRetrait();
                    $userDepot = $transaction->getUserDepot();

                    $client = new Client();
                    $client->setNomClient($users->getNomClient());
                    $client->setCNIClient($users->getCNIClient());
                    $client->setTelephoneClient($users->getTelephoneClient());
                    $client->setNomBeneficiaire($users->getNomBeneficiaire());
                    $client->setArchivage($users->getArchivage());
                    $client->setTelephoneBeneficiaire($users->getTelephoneBeneficiaire());

                    $bloctransaction = new BlocTransaction();
                    $bloctransaction->setClients($client);
                    $bloctransaction->setCompteDepot($compte);
                    $bloctransaction->setDateDepot($dateDepot);
                    $bloctransaction->setMontant($montant);
                    $bloctransaction->setPartAgentDepot($partDepot);
                    $bloctransaction->setPartEntreprise($partEntreprise);
                    $bloctransaction->setPartAgentRetrait($partRetrait);
                    $bloctransaction->setPartEtat($partEtat);
                    $bloctransaction->setUserDepot($userDepot);
                    $bloctransaction->setCode($codes);

                    $this->entityManager->persist($bloctransaction);
                    $this->entityManager->remove($transaction);
                    $this->entityManager->flush();

                }

            }
            return $this->json('L\'annulation se fait avec success' );
        }

    // Fonction  de Lister Mes Commissions

    /**
     * @Route("/api/transactions/commissDepot",
     * methods={"GET"}
     *     )
     *
     */

    public function getCommiDepot(): Response
    {

        $user= $this->security->getUser();
        $agenceId = $user->getAgence()->getId();
        $commission = $this->transactionsRepository->getDepot($agenceId);
       // dd($commission);
        return $this->json($commission);


    }



    /**
     * @Route("/api/transactions/commissRetrait",
     * methods={"GET"}
     *     )
     *
     */

    public function getCommiRetrait(): Response
    {

        $user= $this->security->getUser();
        $agenceId = $user->getAgence()->getId();
        $commission = $this->transactionsRepository->getRetrait($agenceId);
        // dd($commission);
        return $this->json($commission);


    }

    // Fonctions de Lister Mes Transactions
    /**
     * @Route("/api/transactions/mesTransDepot",
     * methods={"GET"}
     *     )
     *
     */

    public function getTransactionD(): JsonResponse
    {

        $user= $this->security->getUser();
        // dd($user);
        $compteId = $user->getAgence()->getCompte()->getId();
        $transaction = $this->transactionsRepository->getMyTranDe($compteId);
        // dd($transaction);
        return $this->json($transaction);


    }



    /**
     * @Route("/api/transactions/mesTransRetrait",
     * methods={"GET"}
     *     )
     *
     */


    public function getTransactionR(): JsonResponse
    {
        $user= $this->security->getUser();
        // dd($user);
        $compteId = $user->getAgence()->getCompte()->getId();
        $transaction = $this->transactionsRepository->getMyTransRe($compteId);
       //  dd($transaction);
        return $this->json($transaction);

    }


    // Fonctions de Lister Toutes Mes Transactions

    /**
     * @Route("/api/transactions/toutTransRetrait",
     * methods={"GET"}
     *     )
     *
     */


    public function getTouTransactionR(): JsonResponse
    {
        $user= $this->security->getUser();
        $agenceId = $user->getAgence()->getId();
        $transaction = $this->transactionsRepository->getTouTransR($agenceId);
        // dd($transaction);
        return $this->json($transaction);

    }


    /**
     * @Route("/api/transactions/toutTransDepot",
     * methods={"GET"}
     *     )
     *
     */


    public function getTouTransactionDe(): JsonResponse
    {
        $user= $this->security->getUser();
        $agenceId = $user->getAgence()->getId();
        $transaction = $this->transactionsRepository->getTouTransD($agenceId);
        //  dd($transaction);
        return $this->json($transaction);

    }







}

