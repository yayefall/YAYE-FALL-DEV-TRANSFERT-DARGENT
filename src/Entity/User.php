<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *     routePrefix="/adminSysteme",
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=4,
 *           "security"="is_granted('ROLE_adminSysteme')",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *      collectionOperations={},
 *      itemOperations={},
 *         normalizationContext={"groups"={"user:read"}},
 *         denormalizationContext={"groups"={"user:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:write","user:read"})
     */
    protected $id;

    /**
     * @Assert\NotBlank( message="le username est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $username;


    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le name est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write"})
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le prenom est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="l'email est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le telephone est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write"})
     */
    protected $telephone;

    /**
     * @ORM\Column(type="blob")
     * @Assert\NotBlank( message="le photo est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write"})
     */
    protected $photo;

    /**
     * @ORM\Column(type="boolean")
     *
     */
    protected $archivage = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Profils::class, inversedBy="users")
     * @Assert\NotBlank( message="le profile est obligatoire" )
     * @Groups({"user:read","Profil:read","user:write"})
     */
    private $profil;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_' . $this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    public function getProfil(): ?Profils
    {
        return $this->profil;
    }

    public function setProfil(?Profils $profil): self
    {
        $this->profil = $profil;

        return $this;
    }
}
