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
 *             "path"="/adminagence/compte",
 *             "method"="get",
 *              "route_name"="comptes",
 *             "security"="(is_granted('ROLE_AdminAgence') or is_granted('ROLE_UserAgence'))",
 *             "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 *        "Post_Compte"={
 *             "path"="/adminsysteme/compte",
 *             "method"="POST",
 *              "security"="(is_granted('ROLE_AdminSysteme'))",
 *             "security_message"="Vous n'avez pas access à cette Ressource",
 *            },
 *       },
 *
 *      itemOperations={
 *              "get-Compte"={
 *                  "path"="/adminagence/compte/{id}",
 *                  "method"="GET",
 *                  "security"="(is_granted('ROLE_AdminAgence'))",
 *                  "security_message"="Vous n'avez pas access à cette Ressource",
 *
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
 *                      "method"="DELETE",
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
     * @Groups({"compte:read","compte:write","user:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"compte:read","compte:write","user:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le montant est obligatoire" )
     * @Groups({"compte:read","compte:write","user:write"})
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"compte:read","compte:write","user:write"})
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
     * @ORM\OneToOne(targetEntity=Agence::class, mappedBy="compte", cascade={"persist", "remove"})
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compteDepot")
     */
    private $transactionDepot;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compteRetrait")
     */
    private $transactionRetrait;

    /**
     * @ORM\OneToMany(targetEntity=BlocTransaction::class, mappedBy="compteDepot")
     */
    private $blocTransactionDepot;

    /**
     * @ORM\OneToMany(targetEntity=BlocTransaction::class, mappedBy="compteRetrait")
     */
    private $blocTransactionRetrait;


    public function __construct()
    {

        $this->transactionDepot = new ArrayCollection();
        $this->transactionRetrait = new ArrayCollection();
        $this->blocTransactionDepot = new ArrayCollection();
        $this->blocTransactionRetrait = new ArrayCollection();

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
            $transactionDepot->setCompteDepot($this);
        }

        return $this;
    }

    public function removeTransactionDepot(Transactions $transactionDepot): self
    {
        if ($this->transactionDepot->removeElement($transactionDepot)) {
            // set the owning side to null (unless already changed)
            if ($transactionDepot->getCompteDepot() === $this) {
                $transactionDepot->setCompteDepot(null);
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
            $transactionRetrait->setCompteRetrait($this);
        }

        return $this;
    }

    public function removeTransactionRetrait(Transactions $transactionRetrait): self
    {
        if ($this->transactionRetrait->removeElement($transactionRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionRetrait->getCompteRetrait() === $this) {
                $transactionRetrait->setCompteRetrait(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlocTransaction[]
     */
    public function getBlocTransactionDepot(): Collection
    {
        return $this->blocTransactionDepot;
    }

    public function addBlocTransactionDepot(BlocTransaction $blocTransactionDepot): self
    {
        if (!$this->blocTransactionDepot->contains($blocTransactionDepot)) {
            $this->blocTransactionDepot[] = $blocTransactionDepot;
            $blocTransactionDepot->setCompteDepot($this);
        }

        return $this;
    }

    public function removeBlocTransactionDepot(BlocTransaction $blocTransactionDepot): self
    {
        if ($this->blocTransactionDepot->removeElement($blocTransactionDepot)) {
            // set the owning side to null (unless already changed)
            if ($blocTransactionDepot->getCompteDepot() === $this) {
                $blocTransactionDepot->setCompteDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlocTransaction[]
     */
    public function getBlocTransactionRetrait(): Collection
    {
        return $this->blocTransactionRetrait;
    }

    public function addBlocTransactionRetrait(BlocTransaction $blocTransactionRetrait): self
    {
        if (!$this->blocTransactionRetrait->contains($blocTransactionRetrait)) {
            $this->blocTransactionRetrait[] = $blocTransactionRetrait;
            $blocTransactionRetrait->setCompteRetrait($this);
        }

        return $this;
    }

    public function removeBlocTransactionRetrait(BlocTransaction $blocTransactionRetrait): self
    {
        if ($this->blocTransactionRetrait->removeElement($blocTransactionRetrait)) {
            // set the owning side to null (unless already changed)
            if ($blocTransactionRetrait->getCompteRetrait() === $this) {
                $blocTransactionRetrait->setCompteRetrait(null);
            }
        }

        return $this;
    }

}
