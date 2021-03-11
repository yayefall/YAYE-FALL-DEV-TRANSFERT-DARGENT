<?php

namespace App\Controller;

use App\Repository\TransactionsRepository;
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

    public function __construct(EntityManagerInterface $entityManager,
                                Security $security,
                                TransactionsRepository $transactionsRepository,
                                RequestStack $requestStack)
    {
        $this->entityManager=$entityManager;
        $this->security=$security;
        $this->transactionsRepository=$transactionsRepository;
        $this->requestStack=$requestStack;
    }


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
        $transaction= $this->transactionsRepository->findOneBy(['code'=>$code['code']]);
       // dd($transaction);
        if ($transaction){
            if ($transaction->getDateRetrait() ==null){
                $transaction->setDateRetrait(new \DateTime('now'));
                $transaction->setUserRetrait($this->security->getUser());
                $client= $transaction->getClients();
                //dd($client);
                $client->setCNIBeneficiaire($code['CNIBeneficiaire']);
                $user= $this->security->getUser();
                $compte= $user->getAgence()->getCompte();
                $compte->setSolde($compte->getSolde()+$transaction->getMontant());
              //  dd($transaction);
                $this->entityManager->flush();

            }
        }else{
            return new JsonResponse("le Code n'est pas conforme, Veuillez saisir le bon code ",500);
        }
        return  $this->json('retrait avec succes');
    }


    /**
     * @Route("/api/transactions/client",
     * methods={"GET"}
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
        if ($transaction) {
            if ($transaction->getDateRetrait() == null) {
                return $this->json($transaction, 200, [], ['groups'=> 'client']);

            }
        }
        return $this->json('Transaction deja retirée');
    }




    }

