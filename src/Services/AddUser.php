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


class AddUser {

    private $encoder;
    private $serializer;
    private $validator;
    private $profilsRepository;
    private $iriConverter;
    private $manager;



    /**
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ProfilsRepository $profilsRepository
     * @param IriConverterInterface $iriConverter
     * @param EntityManagerInterface $manager
     */


    public  function __construct(UserPasswordEncoderInterface $encoder,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator,
                                 ProfilsRepository $profilsRepository,
                                 IriConverterInterface $iriConverter,
                                 EntityManagerInterface $manager)

    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
        $this->manager=$manager;

    }



  /*  public function addUser(Request $request, $Profile): ?JsonResponse
    {
        $users = $request->request->all();
        $photo = $request->files->get('photo');
        $user = $this->serializer->denormalize($users, "App\Entity\User", true);
        $Profil = $this->profilsRepository->findOneBy(['libelle'=>$Profile]);

         if( $photo) {
             $photos = fopen($photo->getRealPath(), "rb");
             $user->setPhoto($photos);
         }

        $password = ('password');
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setProfil($Profil);
        $user->setArchivage(false);


            $this->manager->persist($user);
            $this->manager->flush();

            return new JsonResponse("succefull", 200);


    }*/


}
