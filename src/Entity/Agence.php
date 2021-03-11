<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      routePrefix="/adminsysteme",
 *   attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=100,
 *           "security"="is_granted('ROLE_AdminSysteme')",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *      collectionOperations={"get","post"},
 *      itemOperations={"get","put","delete"},
 *         normalizationContext={"groups"={"agence:read"}},
 *         denormalizationContext={"groups"={"agence:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"agence:read","agence:write","compte:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank( message="le nom est obligatoire" )
     * @Groups({"agence:read","agence:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="l'adresse est obligatoire" )
     * @Groups({"agence:read","agence:write"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le telephone est obligatoire" )
     * @Groups({"agence:read","agence:write"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"agence:read","agence:write"})
     */
    private $archivage = 0;


    /**
     * @ORM\OneToOne(targetEntity=Compte::class, inversedBy="agence", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"agence:read","agence:write"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agence")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }


    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgence() === $this) {
                $user->setAgence(null);
            }
        }

        return $this;
    }


}
