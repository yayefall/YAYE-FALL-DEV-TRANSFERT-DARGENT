<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *
 *   attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=100,
 *         },
 *      collectionOperations={
 *        "get-Compte-admin"={
 *             "path"="/adminsysteme/compte",
 *             "method"="get",
 *             "security"="(is_granted('ROLE_AdminSysteme') or is_granted('ROLE_Caissier'))",
 *             "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 *        "Post_Compte"={
 *             "path"="/adminsysteme/compte",
 *             "method"="POST",
 *              "security"="(is_granted('ROLE_AdminSysteme'))",
 *             "security_message"="Vous n'avez pas access à cette Ressource",
 *            },
 *       },
 *      itemOperations={
 *              "get-Compte"={
 *                  "path"="/adminsysteme/compte/{id}",
 *                  "method"="get",
 *                  "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                   },
 *                "Recharge_Compte"={
 *                    "path"="/adminsysteme/compte/{id}",
 *                    "method"="PUT",
 *                     "deserialize"=false,
 *                    "security"="(is_granted('ROLE_AdminSysteme')|| is_granted('ROLE_Caissier'))",
 *                    "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                 },
 *               "delete-Compte"={
 *                      "path"="/adminsysteme/compte/{id}",
 *                      "method"="delete",
 *                      "security"="(is_granted('ROLE_AdminSysteme'))",
 *                      "security_message"="Vous n'avez pas access à cette Ressource",
 *                  },
 *        },
 *         normalizationContext={"groups"={"compte:read"}},
 *         denormalizationContext={"groups"={"compte:write"}}
 * )
 * @UniqueEntity(
 * fields={"code"},
 * message="Le code doit être unique"
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
     * @Groups({"compte:read","compte:write","client:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"compte:read","compte:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le montant est obligatoire" )
     * @Groups({"compte:read","compte:write"})
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"compte:read","compte:write"})
     */
    private $creatAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comptes", cascade={"persist"})
     * @Groups({"compte:read","compte:write"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="comptes")
     */
    private $transactions;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, mappedBy="compte", cascade={"persist", "remove"})
     */
    private $agence;


    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

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

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

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



    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transactions $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setComptes($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getComptes() === $this) {
                $transaction->setComptes(null);
            }
        }

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(Agence $agence): self
    {
        // set the owning side of the relation if necessary
        if ($agence->getCompte() !== $this) {
            $agence->setCompte($this);
        }

        $this->agence = $agence;

        return $this;
    }

}
