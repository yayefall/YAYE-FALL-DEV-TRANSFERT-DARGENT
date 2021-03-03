<?php

namespace App\Services;


use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\ProfilsRepository;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateUser{

    private $encoder;
    private $serializer;
    private $validator;
    private $profilsRepository;
    private $iriConverter;
    private $manager;
    private $userService;


    /**
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ProfilsRepository $profilsRepository
     * @param IriConverterInterface $iriConverter
     * @param EntityManagerInterface $manager
     * @param \App\Services\UserService $userService
     */


    public  function __construct(UserPasswordEncoderInterface $encoder,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator,
                                 ProfilsRepository $profilsRepository,
                                 IriConverterInterface $iriConverter,
                                 EntityManagerInterface $manager,
                                 UserService $userService)

    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
        $this->manager=$manager;
        $this->userService=$userService;

    }


    public function editUser( Request $request,int $id): Response
    {

        $photo = $request->files->get("photo");
        $user = $this->manager->getRepository(User::class)->find($id);
        //dd($user);
        $requestAll = $request->request->all();
        // dd($requestAll);
        foreach ($requestAll as $key=>$value){
            if($key !="_method" || !$value ){
                // dd($key);

                $method="set".ucfirst($key);
                $user->$method($value);
                $this->manager->persist($user);
                $this->manager->flush();
                $message = 'modification succesfull';

            }
        }


       $photob = fopen($photo->getRealPath(), "rb");
       // dd($photob);
       // $photo= $this->userService->uploadImage($request);

        if($photob){
            $user->setPhoto($photob);
            $this->manager->persist($user);
            $this->manager->flush();
            $message = 'succesfull';
        }

        if (!$message){
            return new JsonResponse('erreur ngay amm fofou deee',Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($message,Response::HTTP_OK);


    }


}
