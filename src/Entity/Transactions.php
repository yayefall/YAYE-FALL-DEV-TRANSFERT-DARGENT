<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=100,
 *
 *         },
 *      collectionOperations={
 *                "Recharge-Compte"={
 *                       "method"="post",
 *                       "path"="/transactions/compte",
 *                       "security"="(is_granted('ROLE_AdminSysteme')|| is_granted('ROLE_Caissier'))",
 *                       "security_message"="Vous n'avez pas access à cette Ressource",
 *                       "normalization_context"={"groups"={"trans:read"}},
 *                       "denormalization_context"={"groups"={"trans:write"}},
 *                    },
 *               "GET-transaction"={
 *                          "method"="get",
 *                          "path"="/useragence/transactions",
 *                          "security"="(is_granted('ROLE_UserAgence') || is_granted('ROLE_AdminAgence'))",
 *                          "security_message"="Vous n'avez pas access à cette Ressource",
 *                      },
 *
 *                "Transfert-Client"={
 *                      "method"="post",
 *                      "path"="/transactions/client",
 *                      "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence'))",
 *                      "security_message"="Vous n'avez pas access à cette Ressource",
 *                      "normalization_context"={"groups"={"trans:read"}},
 *                      "denormalization_context"={"groups"={"trans:write"}},
 *                  },
 *
 *         },
 *      itemOperations={
 *              "Retrait-Client"={
 *                        "method"="put",
 *                        "path"="/transactions/client/{id}",
 *                        "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence') )",
 *                        "security_message"="Vous n'avez pas access à cette Ressource",
 *                     },
 *              "GET-transaction-for-UserAgence"={
 *                          "method"="get",
 *                            "defaults"={"id"=null},
 *                          "path"="/transactions/{id}",
 *                          "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence') )",
 *                          "security_message"="Vous n'avez pas access à cette Ressource",
 *                      },
 *              "DELETE-transaction-for-UserAgence"={
 *                         "method"="delete",
 *                         "path"="/transactions/{id}",
 *                         "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence') )",
 *                         "security_message"="Vous n'avez pas access à cette Ressource",
 *                     },
 *
 *
 *        },
 *
 *         normalizationContext={"groups"={"trans:read"}},
 *         denormalizationContext={"groups"={"trans:write"}},
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 */
class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"trans:read","trans:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le montant est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"trans:read","trans:write"})
     */
    private $creatAt;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"trans:read","trans:write"})
     */
    private $typeTransaction;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write"})
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write"})
     */
    private $partEntreprise;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write"})
     */
    private $partAgentRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write","user:write"})
     */
    private $partAgentDepot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     * @Groups({"trans:read","trans:write"})
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     * @Groups({"trans:read","trans:write"})
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transactions")
     * @Groups({"trans:read","trans:write"})
     */
    private $comptes;

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

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(string $typeTransaction): self
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getPartEntreprise(): ?int
    {
        return $this->partEntreprise;
    }

    public function setPartEntreprise(int $partEntreprise): self
    {
        $this->partEntreprise = $partEntreprise;

        return $this;
    }

    public function getPartAgentRetrait(): ?int
    {
        return $this->partAgentRetrait;
    }

    public function setPartAgentRetrait(int $partAgentRetrait): self
    {
        $this->partAgentRetrait = $partAgentRetrait;

        return $this;
    }

    public function getPartAgentDepot(): ?int
    {
        return $this->partAgentDepot;
    }

    public function setPartAgentDepot(int $partAgentDepot): self
    {
        $this->partAgentDepot = $partAgentDepot;

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

    public function getClients(): ?Client
    {
        return $this->clients;
    }

    public function setClients(?Client $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    public function getComptes(): ?Compte
    {
        return $this->comptes;
    }

    public function setComptes(?Compte $comptes): self
    {
        $this->comptes = $comptes;

        return $this;
    }
}
