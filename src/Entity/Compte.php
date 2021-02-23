<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      routePrefix="/adminsysteme",
 *   attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=4,
 *           "security"="is_granted('ROLE_AdminSysteme')",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *      collectionOperations={"get","post"},
 *      itemOperations={"get","put","delete"},
 *         normalizationContext={"groups"={"compte:read"}},
 *         denormalizationContext={"groups"={"compte:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte:read","compte:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le code est obligatoire" )
     * @Groups({"compte:read","compte:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le montant est obligatoire" )
     * @Groups({"compte:read","compte:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank( message="le date est obligatoire" )
     * @Groups({"compte:read","compte:write"})
     */
    private $creatAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, cascade={"persist", "remove"})
     * @Groups({"compte:read","compte:write"})
     */
    private $agences;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comptes")
     * @Groups({"compte:read","compte:write"})
     */
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

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

    public function getAgences(): ?Agence
    {
        return $this->agences;
    }

    public function setAgences(?Agence $agences): self
    {
        $this->agences = $agences;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }
}
