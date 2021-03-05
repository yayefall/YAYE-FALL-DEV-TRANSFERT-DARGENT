<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\ProfilsRepository;
use App\Repository\UserRepository;
use App\Services\AddUser;
use App\Services\UpdateUser;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;


class UserController extends AbstractController
{
    private $encoder;
    private $serializer;
    private $validator;
    private $profilsRepository;
    private $iriConverter;
    private $entityManager;
    private $userService;
    private $security;

    /**
     * @var AddUser
     */
    private $addUser;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UpdateUser
     */
    private $updateUser;
    /**
     * @var TokenInterface
     */


    /**
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ProfilsRepository $profilsRepository
     * @param IriConverterInterface $iriConverter
     * @param EntityManagerInterface $entityManager
     * @param userService $userService
     * @param Security $security
     * @param AddUser $addUser
     * @param UserRepository $userRepository
     * @param UpdateUser $updateUser
     */


    public  function __construct(UserPasswordEncoderInterface $encoder,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator,
                                 ProfilsRepository $profilsRepository,
                                 IriConverterInterface $iriConverter,
                                 EntityManagerInterface $entityManager,
                                 UserService $userService,
                                 Security $security, AddUser $addUser,
                                 UserRepository $userRepository,UpdateUser $updateUser)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
        $this->entityManager=$entityManager;
        $this->userService=$userService;
        $this->security=$security;
        $this->addUser=$addUser;
        $this->userRepository=$userRepository;
        $this->updateUser=$updateUser;

    }



/**
 * @Route(
 *     path="/api/adminsysteme/caissier",
 *     methods={"POST"},
 *     name="addCaissier",
 *       defaults={
 *          "__controller"="App\Controller\UserController::addCaissier",
 *          "__api_resource_class"=User::class,
 *          "__api_collection_operation_name"="Add-user",
 *     }
 * )
 * @param Request $request
 * @return JsonResponse
 */

    public function addCaissier(Request $request): JsonResponse
    {
  //dd($this->security->getUser()->getProfil()->getLibelle() );
        if ($this->security->getUser()->getProfil()->getLibelle() === 'AdminSysteme'){
           return $this->addUser->addUser($request, 'Caissier');

        }else{
            return new JsonResponse("Vous n'avez pas acces a cette rssource,
            seuls les AdminSystemes sont autorises");
        }

    }




    /**
     * @Route(
     *     path="/api/adminsysteme/caissier/{id}",
     *     methods={"put"},
     *     name="Edit-user",
     *     defaults={
     *          "_controller"="App\Controller\UserController::updateCaissier",
     *          "_api_resource_class"=User::class,
     *          "_api_item_operation_name"="put-caissier",
     *     }
     * )
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */

    public function updateCaissier(Request $request,int $id): Response
    {
        $user= $this->userRepository->findOneBy(['id'=>$id]);
        if ($this->security->getUser()->getProfil()->getLibelle() === 'AdminSysteme'
            & $user->getProfil()->getLibelle()=== 'Caissier'){

            return $this->updateUser->editUser($request, $id);

        }else{
            return new JsonResponse("Vous n'avez pas acces a cette rssourece,
                                              seuls les AdminAgences sont autoriseszzzzzzzzzz");
        }
    }



    /**
     * Route(
     *    path="/api/adminagence/useragence",
     *     methods={"POST"},
     *     name="user_agence",
     *     defaults={
     *          "_controller"="App\Controller\UserController::addAgence",
     *          "_api_resource_class"=User::class,
     *          "_api_collection_operation_name"="post_agence",
     *     }
     *
     *
     * )
     * @param Request $request
     * @return JsonResponse|null
     */

    public function addAgence(Request $request): ?JsonResponse
    {
      //  dd('kkkkkkkkkkkkkkkkkkkk');
        if ($this->security->getUser()->getProfil()->getLibelle() === 'AdminAgence'){

            return $this->addUser->addUser($request, 'UserAgence');

        }else{
            return new JsonResponse("Vous n'avez pas acces a cette fonctionalité,
                                           seuls les AdminAgences sont autoriseseeeeeeeeeeeeeee");
        }
    }


    /**
     * @Route(
     *     path="/api/adminagence/useragence/{id}",
     *     methods={"put"},
     * )
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */


    public function editUserAgence(Request $request,int $id): Response
    {
        $user= $this->userRepository->findOneBy(['id'=>$id]);
        if ($this->security->getUser()->getProfil()->getLibelle() === 'AdminSysteme'
            & $user->getProfil()->getLibelle()=== 'Caissier'){

            return $this->updateUser->editUser($request, $id);

        }else{
            return new JsonResponse("Vous n'avez pas acces a cette rssourece,
                                          seuls les AdminSystemes sont autorises");
        }
    }


   /* public function addUsers(Request $request,EntityManagerInterface $manager): JsonResponse
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


    }*/








  /*  public function updateUser(EntityManagerInterface $entityManager, int $id, Request $request): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        // dd($user);
        $requestAll = $request->request->all();
        // dd($requestAll);
        foreach ($requestAll as $key=>$value){
            if($key !="_method" || !$value ){
                // dd($key);

                $method="set".ucfirst($key);
                $user->$method($value);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $message = 'modification succesfull';

            }
        }
        $photo= $this->userService->uploadImage($request);
        if($photo){
            $user->setPhoto($photo);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $message = 'succesfull';
        }

        if (!$message){
            return new JsonResponse('erreur ngay amm fofou deee',Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($message,Response::HTTP_OK);


    }*/

}
