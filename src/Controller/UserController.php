<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Repository\ProfilsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private  $encoder;
    private $serializer;
    private $validator;
    private $profilsRepository;
    private $iriConverter;

    /**
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ProfilsRepository $profilsRepository
     * @param IriConverterInterface $iriConverter
     */


    public  function __construct(UserPasswordEncoderInterface $encoder,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator,
                                 ProfilsRepository $profilsRepository,
                                 IriConverterInterface $iriConverter)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
    }


    /**
     * @Route(
     *     name="addAdminAgence",
     *     path="/api/adminsysteme/users",
     *     methods={"POST"},
     * )
     *
     *
     * @Route(
     *     name="addCaissier",
     *     path="/api/adminsysteme/users",
     *     methods={"POST"},
     * )
     *
     *
     * @Route(
     *     name="addUserAgence",
     *     path="/api/adminagence/users",
     *     methods={"POST"},
     * )
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     *
     * @Route(
     *     name="addAdminSysteme",
     *     path="/api/adminsysteme/users",
     *     methods={"POST"},
     * )
     * @throws ExceptionInterface
     */


    public function addUsers(Request $request,EntityManagerInterface $manager): JsonResponse
    {
        $users = $request->request->all();

        $photo = $request->files->get('photo');

        $iriProfil = $this->iriConverter->getItemFromIri($users['profil'])->getLibelle();

        if ($iriProfil === "AdminSysteme") {

            $user = $this->serializer->denormalize($users, "App\Entity\user", true);

        } elseif ($iriProfil === "Caissier" ) {

            $user = $this->serializer->denormalize($users, "App\Entity\user", true);

        } elseif ($iriProfil === "UserAgence" ) {
            $user = $this->serializer->denormalize($users, "App\Entity\user", true);

        } elseif($iriProfil === "AdminAgence") {
            $user = $this->serializer->denormalize($users, "App\Entity\user", true);


        }
        $password = ('password');

        $user->setPassword($this->encoder->encodePassword($user, $password));

        $photob = fopen($photo->getRealPath(), "rb");

        if( $photob) {
            $user->setPhoto($photob);
        }

        $manager->persist($user);
        $manager->flush();
        return $this->json('success', 200);


    }



}
