<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *      routePrefix="/adminsysteme",
 *   attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=4,
 *           "security"="is_granted('ROLE_AdminSysteme')",
 *           "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get","put","delete"},
 *         normalizationContext={"groups"={"profil:read"}},
 *         denormalizationContext={"groups"={"profil:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ProfilsRepository::class)
 */
class Profils
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil:read","user:read","user:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     * @Groups({"profil:read","user:read","user:write","profil:write","compte:write","compte:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profil:read"})
     */
    private $archivage = 0;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Assert\NotBlank( message="le user est obligatoire" )
     * @Groups({"profil:read"})
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
