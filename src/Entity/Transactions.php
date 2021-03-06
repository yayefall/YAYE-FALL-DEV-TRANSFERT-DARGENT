<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

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
 *                       "normalization_context"={"groups"={"transaction:read"}},
 *                       "denormalization_context"={"groups"={"trans:write"}},
 *                    },
 *               "GET-myTransaction"={
 *                          "method"="get",
 *                          "path"="/useragence/mesTransactions",
 *                          "security"="(is_granted('ROLE_UserAgence') || is_granted('ROLE_AdminAgence'))",
 *                          "security_message"="Vous n'avez pas access à cette Ressource",
 *                          "normalization_context"={"groups"={"mesTrans:read"}},
 *                          "denormalization_context"={"groups"={"mesTrans:write"}},
 *                      },
 *
 *
 *                 "GET-allTransaction"={
 *                          "method"="get",
 *                          "path"="/useragence/transactions",
 *                          "security"="(is_granted('ROLE_UserAgence') || is_granted('ROLE_AdminAgence'))",
 *                          "security_message"="Vous n'avez pas access à cette Ressource",
 *
 *                      },
 *
 * "          Retrait-Client"={
 *                        "method"="post",
 *                        "path"="/transactions/client/retrait",
 *                        "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence') )",
 *                        "security_message"="Vous n'avez pas access à cette Ressource",
 *                       "normalization_context"={"groups"={"transac:read"}},
 *                       "denormalization_context"={"groups"={"transac:write"}},
 *                     },
 *                "Transfert-Client"={
 *                      "method"="post",
 *                      "path"="/transactions/client/depot",
 *                      "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence'))",
 *                      "security_message"="Vous n'avez pas access à cette Ressource",
 *                      "normalization_context"={"groups"={"trans:read"}},
 *                      "denormalization_context"={"groups"={"trans:write"}},
 *                  },
 *                  "getCommisionDepot"={
 *                          "method"="get",
 *                          "path"="/transactions/commissDepot",
 *                          "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence'))",
 *                          "security_message"="Vous n'avez pas access à cette Ressource",
 *                          "normalization_context"={"groups"={"commisDepot:read"}},
 *                          "denormalization_context"={"groups"={"commisDepot:read"}},
 *
 *            },
 *
 *
 *         "getCommisionRetrait"={
 *                          "method"="get",
 *                          "path"="/transactions/commissRetrait",
 *                          "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence'))",
 *                          "security_message"="Vous n'avez pas access à cette Ressource",
 *                          "normalization_context"={"groups"={"commisRetrait:read"}},
 *                          "denormalization_context"={"groups"={"commisRetrait:read"}},
 *
 *            },
 *
 *         },
 *      itemOperations={
 *
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
 *        },
 *
 *         normalizationContext={"groups"={"trans:read"}},
 *         denormalizationContext={"groups"={"trans:write"}},
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"dateRetrait"})
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
     * @Groups({"trans:read","trans:write","transaction:read"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write","client","transaction:read","mesTrans:read","commisRetrait:read","commisDepot:read"})
     */
    private $montant;

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
     * @Groups({"trans:read","trans:write","commisRetrait:read","mesTrans:read"})
     */
    private $partAgentRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write","commisDepot:read","mesTrans:read"})
     */
    private $partAgentDepot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     * @Groups({"trans:read","trans:write","client"})
     */
    private $clients;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactionRetrait")
     *  @Groups({"trans:read","trans:write","transaction:read","mesTrans:read"})
     */
    private $userRetrait;

    /**
     * @ORM\Column(type="date",nullable=true)
     *  @Groups({"trans:read","trans:write","client","transaction:read","commisDepot:read","mesTrans:read"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     *  @Groups({"trans:read","trans:write","commisRetrait:read","mesTrans:read"})
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactionDepot")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"trans:read","trans:write","mesTrans:read"})
     */
    private $userDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transactionDepot")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"trans:read","trans:write"})
     */
    private $compteDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transactionRetrait")
     * @Groups({"trans:read","trans:write"})
     */
    private $compteRetrait;

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

    public function getClients(): ?Client
    {
        return $this->clients;
    }

    public function setClients(?Client $clients): self
    {
        $this->clients = $clients;

        return $this;
    }



    public function getUserRetrait(): ?User
    {
        return $this->userRetrait;
    }

    public function setUserRetrait(?User $userRetrait): self
    {
        $this->userRetrait = $userRetrait;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getUserDepot(): ?User
    {
        return $this->userDepot;
    }

    public function setUserDepot(?User $userDepot): self
    {
        $this->userDepot = $userDepot;

        return $this;
    }

    public function getCompteDepot(): ?Compte
    {
        return $this->compteDepot;
    }

    public function setCompteDepot(?Compte $compteDepot): self
    {
        $this->compteDepot = $compteDepot;

        return $this;
    }

    public function getCompteRetrait(): ?Compte
    {
        return $this->compteRetrait;
    }

    public function setCompteRetrait(?Compte $compteRetrait): self
    {
        $this->compteRetrait = $compteRetrait;

        return $this;
    }
}
