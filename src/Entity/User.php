<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=100,
 *
 *          },
 *      collectionOperations={
 *            "Add-user"={
 *                  "method"="POST",
 *                  "path"="/adminsysteme/caissier",
 *                  "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                  },
 *                 "post_agence"={
 *                     "method"= "POST",
 *                     "path"="/adminagence/useragence",
 *                     "security"="(is_granted('ROLE_AdminAgence'))",
 *                     "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                   },
 *        "Get-caissier"={
 *                 "method"="get",
 *                 "path"="/adminsysteme/users",
 *                 "security"="(is_granted('ROLE_AdminSysteme'))",
 *                 "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 *      "Get-caissier"={
 *                 "method"="get",
 *                 "path"="/adminagence/users",
 *                 "security"="(is_granted('ROLE_AdminAgence'))",
 *                 "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *               },
 *     "Get-users"={
 *                 "method"="get",
 *                 "path"="/adminagence/useragence",
 *                 "security"="(is_granted('ROLE_AdminAgence'))",
 *                 "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *               },
 *         },
 *       itemOperations={
 *               "bloquer-userAgence"={
 *                      "method"="delete",
 *                      "path"="/adminsysteme/caissier/{id}",
 *                      "security"="(is_granted('ROLE_AdminSysteme'))",
 *                      "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                     },
 *                "get-users"={
 *                      "method"="get",
 *                      "path"="/adminsysteme/users/{id}",
 *                      "security"="(is_granted('ROLE_AdminSysteme'))",
 *                      "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                     },
 *                "put-caissier"={
 *                        "method"="put",
 *                        "path"="/adminsysteme/caissier/{id}",
 *                        "security"="(is_granted('ROLE_AdminSysteme'))",
 *                        "security_message"="Vous n'avez pas access à cette Ressource",
 *                   },
 *                "put-useragence"={
 *                        "method"="put",
 *                        "path"="/adminagence/useragence/{id}",
 *                        "security"="(is_granted('ROLE_AdminAgence'))",
 *                        "security_message"="Vous n'avez pas access à cette Ressource",
 *                   },
 *
 *            },
 *         normalizationContext={"groups"={"user:read"}},
 *         denormalizationContext={"groups"={"user:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"profil.libelle"})
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
     * @Groups({"user:write","user:read","compte:write","trans:write","agence:write"})
     */
    private $id;

    /**
     * @Assert\NotBlank( message="le username est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write","compte:write","agence:write","compte:read"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @Groups({"user:read","user:write","compte:write","compte:read","agence:write","trans:write"})
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     *
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le name est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write","compte:write","compte:read","agence:write","trans:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le prenom est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write","compte:write","compte:read","agence:write","trans:write"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email(message="l'email doit etre unique")
     * @Assert\NotBlank( message="l'email est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write","compte:write","compte:read","agence:write","trans:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le telephone est obligatoire" )
     * @Groups({"user:read","user:write","profil:read","profil:write","compte:write","compte:read","agence:write","trans:write"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="blob",nullable=true)
     *
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Profils::class, inversedBy="users")
     * @Assert\NotBlank( message="le profile est obligatoire" )
     * @Groups({"user:read","user:write","compte:write","compte:read","agence:write","trans:write"})
     */
    private $profil;

    /**
     * @ORM\OneToMany(targetEntity=Compte::class, mappedBy="users")
     *
     */
    private $comptes;


    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="userRetrait")
     *
     */
    private $transactionRetrait;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="userDepot")
     *
     */
    private $transactionDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users")
     *  @Groups({"user:read","user:write","trans:write"})
     */
    private $agence;


    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->transactionRetrait = new ArrayCollection();
        $this->transactionDepot = new ArrayCollection();
    }

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
        if($this->photo)
        {
            $data = stream_get_contents($this->photo);
            if(!$this->photo){

                fclose($this->photo);
            }
            return base64_encode($data);
        }else
        {
            return null;
        }
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

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setUsers($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getUsers() === $this) {
                $compte->setUsers(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Transactions[]
     */
    public function getTransactionRetrait(): Collection
    {
        return $this->transactionRetrait;
    }

    public function addTransactionRetrait(Transactions $transactionRetrait): self
    {
        if (!$this->transactionRetrait->contains($transactionRetrait)) {
            $this->transactionRetrait[] = $transactionRetrait;
            $transactionRetrait->setUserRetrait($this);
        }

        return $this;
    }

    public function removeTransactionRetrait(Transactions $transactionRetrait): self
    {
        if ($this->transactionRetrait->removeElement($transactionRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionRetrait->getUserRetrait() === $this) {
                $transactionRetrait->setUserRetrait(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Transactions[]
     */
    public function getTransactionDepot(): Collection
    {
        return $this->transactionDepot;
    }

    public function addTransactionDepot(Transactions $transactionDepot): self
    {
        if (!$this->transactionDepot->contains($transactionDepot)) {
            $this->transactionDepot[] = $transactionDepot;
            $transactionDepot->setUserDepot($this);
        }

        return $this;
    }

    public function removeTransactionDepot(Transactions $transactionDepot): self
    {
        if ($this->transactionDepot->removeElement($transactionDepot)) {
            // set the owning side to null (unless already changed)
            if ($transactionDepot->getUserDepot() === $this) {
                $transactionDepot->setUserDepot(null);
            }
        }

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }


}
